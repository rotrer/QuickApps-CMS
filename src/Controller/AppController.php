<?php
namespace QuickApps\Controller;
use QuickApps\Event\EventTrait;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Core\App;

class AppController extends \Cake\Controller\Controller {
	use EventTrait;

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

		foreach (App::objects('Plugin') as $plugin) {
			$eventClass = "QuickApps\\Plugin\\{$plugin}\\Event\\{$plugin}Event";

			if (class_exists($eventClass)) {
				EventManager::instance()->attach(new $eventClass);
			}
		}

		return;
	}
}