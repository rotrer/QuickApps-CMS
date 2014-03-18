<?php
namespace QuickApps\System\Event;
use Cake\Event\EventListener;

class SystemEvent implements EventListener {
    public function implementedEvents() {
        return [
        	'Hooktag.rand' => 'hooktagRand'
        ];
    }

    public function hooktagRand($event) {
    	$elements = explode(',', $event->data['content']);

    	if ($elements) {
    		return $elements[array_rand($elements)];
    	}

		return '';
    }
}