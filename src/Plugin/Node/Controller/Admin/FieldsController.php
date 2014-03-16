<?php
namespace QuickApps\Node\Controller\Admin;
use QuickApps\Node\Controller\NodeAppController;
use QuickApps\Field\Controller\FieldUITrait;
use Cake\Core\Configure;

class FieldsController extends NodeAppController {
	use FieldUITrait;
	public $manageEntity = 'nodes_article';

	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);

		$validTypes = Configure::read('boot.node_types');

		if (
			!isset($request->query['type']) ||
			!in_array($request->query['type'], $validTypes)
		) {
			$this->redirect(['plugin' => 'system', 'controller' => 'dashboard', 'prefix' => 'admin']);
		}
	}
}