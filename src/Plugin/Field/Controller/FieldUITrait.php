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
 * you must also indicate the name of the entities
 * being managed. Example:
 *
 *     uses QuickApps\Field\Controller\FieldUITrait;
 *
 *     class MyController extends <Plugin>AppController {
 *         use FieldUITrait;
 *         public $manageEntity = 'my_entity_name';
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
 * - You must define `$manageEntity` property in your controller.
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
 * - $manageEntity is not defined.
 * - trait is used in non-controller classes
 * - the controller is not a backend controller.
 */
	public function beforeFilter(Event $event) {
		$requestParams = $event->subject->request->params;

		if (!isset($this->manageEntity) || empty($this->manageEntity)) {
			throw new Error\ForbiddenException('FieldUITrait: The property $manageEntity was not found or is empty.');
		}

		if (!($this instanceof \Cake\Controller\Controller)) {
			throw new Error\ForbiddenException('FieldUITrait: This trait must be used on instances of Cake\Controller\Controller.');
		}

		if (!isset($requestParams['prefix']) || $requestParams['prefix'] !== 'admin') {
			throw new Error\ForbiddenException('FieldUITrait: This trait must be used on backend-controllers only.');
		}

		$this->manageEntity = strtolower($this->manageEntity);
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
 * But when it does not exists, `Field\Template\FieldUI\index.ctp`
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
	}

/**
 * FieldUI main action.
 *
 * @return void
 */
	public function index() {
		$instances = TableRegistry::get('Field.FieldInstances')
			->find()
			->where(['entity' => $this->manageEntity]);
		$this->set('instances', $instances);
	}
}