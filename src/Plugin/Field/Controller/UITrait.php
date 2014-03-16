<?php
namespace QuickApps\Field\Controller;
use QuickApps\Field\Error;
use Cake\Event\Event;
use Cake\Utility\Inflector;
use Cake\Core\Plugin;

/**
 * Field UI Trait.
 *
 * Other plugins may `extends` Field plugin by using this trait
 * in their controllers.
 * With this trait, Field plugin provides an user-friendly UI for manage entity's
 * custom fields.
 *
 * # Usage:
 *
 * Beside addiding `use UITrait;` to your controller
 * you must also indicate the name of the entities
 * being managed. Example:
 *
 *     uses QuickApps\Field\Controller\UITrait;
 *
 *     class MyController extends <Plugin>AppController {
 *         use UITrait;
 *         public $manageEntity = 'MyEntityName';
 *     }
 *
 * In order to avoid trait collision you should always `extends`
 * Field API using this trait over a clean controller.
 * For instance, create a `MyPlugin\Controller\FieldManagerController`
 * to handle `MyPlugin` custom fields.
 *
 * @author Christopher Castro <chris@quickapps.es>
 */
trait UITrait {
/**
 * Validation rules.
 *
 * @param  Event  $event the event instance.
 * @return void
 * @throws QuickApps\Field\Error\MissingPropertyException When $manageEntity is not defined.
 * @throws QuickApps\Field\Error\InvalidTraitUsageException When trait is used in non-controller classes
 * or when the controller is not a backend controller.
 */
	public function beforeFilter(Event $event) {
		$requestParams = $event->subject->request->params;

		if (!isset($this->manageEntity) || empty($this->manageEntity)) {
			throw new Error\MissingPropertyException('UITrait: The property $manageEntity was not found.');
		}

		if (!($this instanceof \Cake\Controller\Controller)) {
			throw new Error\InvalidTraitUsageException('UITrait: This trait must be used on instances of Cake\Controller\Controller.');
		}

		if (!isset($requestParams['prefix']) || $requestParams['prefix'] !== 'admin') {
			throw new Error\InvalidTraitUsageException('UITrait: This trait must be used on backend-controllers only.');
		}
	}

/**
 * Resolve template location when extending Field UI API.
 *
 * If controller tries to render an unexisting template under
 * its Template directory, then we try to find that view under
 * the `Field/Template/UI` directory.
 *
 * Example:
 *
 *     Node\FieldsController::index()
 *
 * The above will try to render `Node/Template/Fields/index.ctp`.
 * But when it does not exists, `Field\Template\UI\index.ctp`
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
			$alternativeTemplatePath = Plugin::path('Field') . 'Template' . DS . 'UI';

			if (file_exists($alternativeTemplatePath . DS . "{$action}.ctp")) {
				$this->view = $alternativeTemplatePath . DS . "{$action}.ctp";
			}
		}
	}

/**
 * Field UI main action.
 *
 * @return void
 */
	public function index() {
	}
}