<?php
namespace QuickApps\TwitterBootstrap\Event;
use Cake\Event\Event;
use Cake\Event\EventListener;

/**
 * Aplies some TwitterBootstrap classes to form|html elements
 */
class TwitterBootstrapEvent implements EventListener {
	public function implementedEvents() {
		return [
			'Helper.Form.input' => 'appendClasses',
			'Helper.Form.textarea' => 'appendClasses'
		];
	}

	public function appendClasses(Event $event) {
		$prefix = '';

		if (isset($event->data['options']['class'])) {
			$prefix = $event->data['options']['class'] . ' ';
		}

		$event->data['options']['class'] = $prefix . 'form-control';

		return $event->data;
	}
}