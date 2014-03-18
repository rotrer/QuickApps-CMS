<?php
namespace QuickApps\Utility;
use Cake\Event\Event;
use Cake\Event\EventManager;

trait HooktagTrait {
	public function hooktags($text) {
		return preg_replace_callback('/(.?)\[([a-zA-Z0-9_\-]+)\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)/s', array($this, '__doHooktag'), $text);
	}

	private function __doHooktag($m) {
		$EventManager = EventManager::instance();

		// allow [[foo]] syntax for escaping a tag
		if ($m[1] == '[' && $m[6] == ']') {
			return substr($m[0], 1, -1);
		}

		$tag = $m[2];
		$atts = $this->__parseHooktagAttributes($m[3]);
		$hook = !empty($EventManager->listeners("Hooktag.{$tag}"));

		if ($hook) {
			$options = [
				'atts' => $atts,
				'content' => null,
				'tag' => $tag
			];

			if (isset($m[5])) {
				$options['content'] = $m[5];
			}

			$event = new Event("Hooktag.{$tag}", $this, $options);
			$EventManager->dispatch($event);

			return $m[1] . $event->result . $m[6];
		}

		return false;
	}

	private static function __parseHooktagAttributes($text) {
		$atts = array();
		$pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
		$text = preg_replace("/[\x{00a0}\x{200b}]+/u", " ", $text);

		if (preg_match_all($pattern, $text, $match, PREG_SET_ORDER)) {
			foreach ($match as $m) {
				if (!empty($m[1])) {
					$atts[strtolower($m[1])] = stripcslashes($m[2]);
				} elseif (!empty($m[3])) {
					$atts[strtolower($m[3])] = stripcslashes($m[4]);
				} elseif (!empty($m[5])) {
					$atts[strtolower($m[5])] = stripcslashes($m[6]);
				} elseif (isset($m[7]) and strlen($m[7])) {
					$atts[] = stripcslashes($m[7]);
				} elseif (isset($m[8])) {
					$atts[] = stripcslashes($m[8]);
				}
			}
		} else {
			$atts = ltrim($text);
		}

		return $atts;
	}
}