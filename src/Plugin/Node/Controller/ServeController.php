<?php
namespace QuickApps\Node\Controller;

class ServeController extends NodeAppController {
	public $uses = ['Node.Nodes'];

	public function index() {
		$this->frontpage();
	}

	public function frontpage() {
		$node = $this->Nodes->find()->first();
		$this->set('node', $node);
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

		$this->set('node', $node);
	}

	public function search($criteria) {
		// TODO:
	}
}