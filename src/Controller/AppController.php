<?php
namespace QuickApps\Controller;
use QuickApps\Event\EventTrait;

class AppController extends \Cake\Controller\Controller {
	use EventTrait;

	public $theme = 'TwitterBootstrap';
	public $viewClass = 'QuickApps\View\View';
	public $uses = [];
	public $helpers = [
		'Html' => ['className' => 'QuickApps\View\Helper\HtmlHelper'],
		'Form' => ['className' => 'QuickApps\View\Helper\FormHelper']
	];

	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);

		if (isset($this->uses)) {
			foreach ($this->uses as $model) {
				$this->loadModel($model);
			}
		}
	}
}