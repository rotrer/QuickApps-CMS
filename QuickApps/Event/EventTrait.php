<?php
namespace QuickApps\Event;
use Cake\Event\EventManager;
use Cake\Event\Event;

/**
 * Adds wrappers methods over cake's event system.
 */
trait EventTrait {
	public function event($eventName, $args = []) {
		$event = new Event($eventName, $this, $args);
		EventManager::instance()->dispatch($event);
		return $event;
	}
}
