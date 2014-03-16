<?php
namespace QuickApps\Node\Controller;

class ServeController extends NodeAppController {
	public $uses = ['Node.Nodes'];

	public function index() {
		$this->frontpage();
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
			->first();

		if ($node) {
			$this->set('node', $node);
		}
	}

	public function search($criteria) {
		// TODO:
	}
}