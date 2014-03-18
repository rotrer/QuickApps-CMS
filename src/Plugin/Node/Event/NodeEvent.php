<?php
namespace QuickApps\Node\Event;
use Cake\Event\EventListener;
use Cake\Event\Event;

class NodeEvent implements EventListener {
    public function implementedEvents() {
        return [
        	'Render.QuickApps\Node\Model\Entity\Node' => 'renderNode'
        ];
    }

    public function renderNode(Event $event, $node) {
    	$View = $event->subject;

        if ($View->elementExists("theme_node_{$node->node_type_slug}")) {
            $html = $View->element("theme_node_{$node->node_type_slug}");
        } else {
            $html = $View->element('theme_node', ['node' => $node]);
        }

		return $View->hooktags($html);
    }
}