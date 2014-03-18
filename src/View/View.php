<?php
namespace QuickApps\View;
use Cake\View\View as CakeView;
use QuickApps\Utility\HooktagTrait;
use Cake\Event\Event;
use Cake\Event\EventManager;

class View extends CakeView {
	use HooktagTrait;

	public function render($view = null, $layout = null) {
		$html = '';

		// allow to attach Renders.
		if (is_object($view)) {
			$className = get_class($view);
			$EventManager = EventManager::instance();
			$event = new Event("Render.{$className}", $this, [$view]);

			$EventManager->dispatch($event);

			$html = $event->result;
		} else {
			$html = parent::render($view, $layout);
		}

		return $html;
	}
}