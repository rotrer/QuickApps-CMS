<?php
namespace QuickApps\Plugin\Node\Controller;

class ServeController extends NodeAppController {
	public $uses = ['Node.Nodes'];

	public function index() {
	}

	public function frontpage() {
	}

	public function details($node_type_slug, $node_slug) {
		$conditions = [
			'Nodes.slug' => $node_slug,
			'Nodes.node_type_slug' => $node_type_slug,
			'Nodes.status >' => 0
		];

		$node = $this->Nodes->find()
			->where($conditions)
			->contain(['NodeTypes'])
			->first();

		if ($node) {
			pr($node->toArray());
		}
	}
}