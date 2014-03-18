<?php
namespace QuickApps\Node\Controller\Admin;
use QuickApps\Node\Controller\NodeAppController;
use QuickApps\Field\Controller\FieldUITrait;
use Cake\Core\Configure;
use Cake\Routing\Router;

class FieldsController extends NodeAppController {
	use FieldUITrait;
	public $manageTable = 'nodes_article';

	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);

		$validTypes = Configure::read('snapshot.node_types');

		if (
			!isset($request->query['type']) ||
			!in_array($request->query['type'], $validTypes)
		) {
			$this->redirect(['plugin' => 'system', 'controller' => 'dashboard', 'prefix' => 'admin']);
		}

		// Make $_GET['type'] persistent
		Router::addUrlFilter(function ($params, $request) {
			if (isset($request->query['type'])) {
				$params['type'] = $request->query['type'];
			}

			return $params;
		});
	}
}