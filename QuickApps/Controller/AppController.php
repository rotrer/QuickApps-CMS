<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace QuickApps\Controller;
use QuickApps\Event\EventTrait;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Core\App;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends \Cake\Controller\Controller {
	use EventTrait;

	public $viewClass = 'QuickApps\View\View';
	public $uses = [];
	public $helpers = [
		'Html', //=> ['className' => 'QuickApps\View\Helper\HtmlHelper'],
		'Form' //=> ['className' => 'QuickApps\View\Helper\FormHelper'],
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
