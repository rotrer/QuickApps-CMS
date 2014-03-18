<?php
namespace QuickApps\Field\Controller;
use Cake\Event\Event;
use Cake\Utility\Inflector;
use Cake\Core\Plugin;
use Cake\ORM\TableRegistry;
use Cake\Error;

/**
 * Field UI Trait.
 *
 * Other plugins may `extends` Field plugin by using this trait
 * in their controllers.
 * With this trait, Field plugin provides an user-friendly UI for manage entity's
 * custom fields.
 * It provices a field-manager-user-interface by attaching a series of
 * actions over a `clean` controller.
 *
 * # Usage:
 *
 * Beside addiding `use FieldUITrait;` to your controller
 * you must also indicate the name of the Table
 * being managed. Example:
 *
 *     uses QuickApps\Field\Controller\FieldUITrait;
 *
 *     class MyController extends <Plugin>AppController {
 *         use FieldUITrait;
 *         public $manageTable = 'Nodes';
 *     }
 *
 * In order to avoid trait collision you should always `extends`
 * Field API using this trait over a `clean` controller.
 * For instance, create a `MyPlugin\Controller\FieldManagerController`
 * and use this trait to handle `MyPlugin` custom fields.
 *
 * # Requirements
 *
 * - This trait should only be used over a clean controller.
 * - You must define `$manageTable` property in your controller.
 * - Your Controller must be a backend-controller (under `Controller\Admin` namespace).
 *
 * @author Christopher Castro <chris@quickapps.es>
 */
trait FieldUITrait {
/**
 * Validation rules.
 *
 * @param  Event  $event the event instance.
 * @return void
 * @throws Cake\Error\ForbiddenException When
 * - $manageTable is not defined.
 * - trait is used in non-controller classes
 * - the controller is not a backend controller.
 */
	public function beforeFilter(Event $event) {
		$requestParams = $event->subject->request->params;

		if (!isset($this->manageTable) || empty($this->manageTable)) {
			throw new Error\ForbiddenException('FieldUITrait: The property $manageTable was not found or is empty.');
		}

		if (!($this instanceof \Cake\Controller\Controller)) {
			throw new Error\ForbiddenException('FieldUITrait: This trait must be used on instances of Cake\Controller\Controller.');
		}

		if (!isset($requestParams['prefix']) || $requestParams['prefix'] !== 'admin') {
			throw new Error\ForbiddenException('FieldUITrait: This trait must be used on backend-controllers only.');
		}

		$this->manageTable = strtolower($this->manageTable);
	}

/**
 * Resolve template location when extending Field UI API.
 *
 * If controller tries to render an unexisting template under
 * its Template directory, then we try to find that view under
 * the `Field/Template/FieldUI` directory.
 *
 * Example:
 *
 *     Node\FieldsController::index()
 *
 * The above will try to render `Node/Template/Fields/index.ctp`.
 * But when it does not exists, `Field/Template/FieldUI/index.ctp`
 * will be used instead (if exists).
 *
 * @param  Event $event the event instance.
 * @return void
 */
	public function beforeRender(Event $event) {
		$plugin = Inflector::camelize($event->subject->request->params['plugin']);
		$controller = Inflector::camelize($event->subject->request->params['controller']);
		$action = $event->subject->request->params['action'];
		$pluginPath = Plugin::path($plugin);
		$templatePath = $pluginPath . 'Template' . DS . $controller . DS . "{$action}.ctp";

		if (!file_exists($templatePath)) {
			$alternativeTemplatePath = Plugin::path('Field') . 'Template' . DS . 'FieldUI';

			if (file_exists($alternativeTemplatePath . DS . "{$action}.ctp")) {
				$this->view = $alternativeTemplatePath . DS . "{$action}.ctp";
			}
		}

		parent::beforeRender($event);
	}

/**
 * FieldUI main action.
 *
 * Shows all the fields attached to the Table being managed.
 *
 * @return void
 */
	public function index() {
		$instances = TableRegistry::get('Field.FieldInstances')
			->find()
			->where(['entity' => $this->manageTable]);
		$this->set('instances', $instances);
	}

/**
 * Handles a single field instance configuration parameters.
 *
 * @param integer $id The field instance ID to manage
 * @return void
 * @throws Error\NotFoundException When no field instance was found
 */
	public function configure($id) {
		$this->loadModel('Field.FieldInstances');
		$instance = $this->FieldInstances->get($id);

		if (!$instance) {
			throw new Error\NotFoundException(__('The requested field does not exists.'));
		}

		$this->set('instance', $instance);
	}
}