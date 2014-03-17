<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @version	 2.0
 * @since	 1.0
 * @author	 Christopher Castro <chris@quickapps.es>
 * @link	 http://www.quickappscms.org
 */
namespace QuickApps\Field\Model\Behavior;
use Cake\ORM\Behavior;
use Cake\ORM\TableRegistry;
use Cake\ORM\Query;
use Cake\Event\Event;
use Cake\ORM\Table;

/**
 * Fieldable behavior allows additional fields to be attached to Tables.
 * Any Table (Nodes, Users, etc.) can use this behavior to make itself `fieldable` and thus allow
 * fields to be attached to it.
 *
 * The Field API defines two primary data structures, FieldInstance and FieldData:
 *
 * - FieldInstance: is a Field attached to a single Table. (Schema equivalent: column)
 * - FieldData: the stored data for a particular [FieldInstance, Entity] tuple of your Table. (Schema equivalent: cell value)
 *
 * Basically, this behavior allows you to add `virtual columns` to your table schema.
 */
class FieldableBehavior extends Behavior {
	private $__entityInstancesCache = [];
	protected $_table = null;
	protected $_config = [
		'entity' => null,
		'mapper' => null,
		'enabled' => true
	];

/**
 * Constructor
 *
 * @param Table $table The table this behavior is attached to.
 * @param array $config The config for this behavior.
 */
	public function __construct(Table $table, array $config = []) {
		$this->_config['entity'] = strtolower($table->alias());
		$this->_config['mapper'] = function ($entity, $key, $mapReduce) {
			$this->fieldableMapper($entity, $key, $mapReduce);
		};

		$this->_config = array_merge($this->_config, $config);
		$this->_table = $table;
	}

/**
 * Modifies the query object in order to merge custom fields records
 * into each entity under the `_fields` key.
 *
 * It also looks for custom fields in where-conditions.
 * Custom fields must be prefixed with `:` in condition array. e.g.:
 *
 *     TableRegistry::get('Users')->where(['Users.:first_name LIKE' => 'John%'])
 *
 * `Users` table has a custom field attached (first_name), and we are looking
 * for all the users whose `first_name` starts with `John`.
 *
 * @param Event $event the beforeFind event that was fired
 * @param Query $query the original query to modify
 * @return void
 */
	public function beforeFind(Event $event, $query) {
		if ($this->_config['enabled']) {
			$query->clause('where')
				->traverse(function ($expression) {
					$field = $expression->getField();
					$value = $expression->getValue();
					$conjunction = $expression->type();
					list($entity, $field_name) = pluginSplit($field);

					if (!$field_name) {
						$field_name = $entity;
					}

					$field_name = preg_replace('/\s{2,}/', ' ', $field_name);
					list($field_name, ) = explode(' ', trim($field_name));

					if (strpos($field_name, ':') !== 0) {
						return;
					}

					$field_name = str_replace(':', '', $field_name);
					$subQuery = TableRegistry::get('Field.FieldData')->find()
						->select('entity_id')
						->where(
							[
								"FieldData.field_instance_slug" => $field_name,
								'FieldData.entity' => $this->_config['entity'],
								"FieldData.data {$conjunction}" => $value
							]
						);

					$expression->field($this->_table->alias() . '.' . $this->_table->primaryKey());
					$expression->value($subQuery);
				});

			$configBefore = $this->_config['entity'];
			$query->mapReduce($this->_config['mapper']);
			$configAfter = $this->_config['entity'];

			/**
			 * FIX: polymorphic entities (eg. Nodes) may have changed self::_config[entity]
			 * value during mapper invocation.
			 * Must be restored to it initial value in order to avoid unexpected errors.
			 */
			if ($configBefore != $configAfter) {
				$this->_config = $configBefore;
			}
		}
	}

/**
 * The method which actually fetches custom field data.
 *
 * Iterates over each entity from result set and fetches
 * custom fields data under the `_fields` key.
 *
 * Example:
 *
 *     array(
 *         [id] => 87,
 *         [name] => Peter Pan,
 *         [phone] => +56 789 123 458,
 *         [_fields] => array(
 *             [user_age] => array(
 *                 [data] => 22
 *                 ...
 *             ),
 *             [empty_field] => null,
 *             [field_instance_slug] => array(
 *                 [data] => Value for this field-entity tuple,
 *                 [label] => Human readble name of this field e.g.: `User Lastname`,
 *                 [description] => Something about this field: e.g.: `Please enter your lastname`,
 *                 [required] => 1|0
 *                 [settings] => array(
 *                     'more_info' => Extra information array
 *                 )
 *             )
 *             ...
 *         )
 *     )
 *
 * In the example above, the User entity has a custom field named `user_age`.
 * and its current value is 22.
 *
 * Note that custom fields without stored information will be null.
 *
 * @param Entity $entity the entity to modify
 * @param integer $key entity key index from result collection.
 * @param MapReduce $mapReduce instance of the MapReduce routine it is running.
 * @return void
 */
	public function fieldableMapper($entity, $key, $mapReduce) {
		$FieldData = TableRegistry::get('Field.FieldData');
		$_fields = [];

		// for each instance get the stored data for this entity
		foreach ($this->__getEntityFieldInstances($this->_config['entity']) as $instance) {
			$storedData = $FieldData->find()
			->select(['data'])
			->where(
				[
					'FieldData.field_instance_id' => $instance->id,
					'FieldData.entity' => $this->_config['entity'],
					'FieldData.entity_id' => $entity->get($this->_table->primaryKey())
				]
			)
			->first();

			if ($storedData) {
				$storedData->set(
					[
						'label' => $instance->label,
						'description' => $instance->description,
						'required' => $instance->required,
						'settings' => $instance->settings
					],
					['guard' => false]
				);
			}

			$_fields[$instance->slug] = $storedData;
		}

		$entity->set('_fields', $_fields);
		$mapReduce->emit($entity, $key);
	}

/**
 * Changes behavior's config parameters.
 *
 * Useful when using a custom mapper function, you
 * can change configuration parameters on evey mapper's iteration
 * depending on your needs.
 *
 * @param array $config a config assoc-array.
 * @return array current config array.
 */
	public function setFieldableConfig($config) {
		$this->_config = array_merge($this->_config, $config);
		$this->_config['entity'] = strtolower($this->_config['entity']);
	}

/**
 * Enables this behavior, `_fields` key will
 * be attached to entities.
 *
 * @return void
 */
	public function bindFieldable() {
		$this->_config['enabled'] = true;
	}

/**
 * Disables this behavior. No `_fields` key will
 * be attached to entities.
 *
 * @return void
 */
	public function unbindFieldable() {
		$this->_config['enabled'] = false;
	}

/**
 * Used to reduce database queries.
 *
 * @param  string|null $entity name of the entity, or null to use current value in `_config`.
 * @return Query field instances as query result.
 */
	private function __getEntityFieldInstances($entity = null) {
		$entity = $entity ? $entity : $this->_config['entity'];

		if (isset($this->__entityInstancesCache[$entity])) {
			return $this->__entityInstancesCache[$entity];
		} else {
			$FieldInstances = TableRegistry::get('Field.FieldInstances');
			$this->__entityInstancesCache[$entity] = $FieldInstances->find()
				->where(['FieldInstances.entity' => $entity]);

			return $this->__entityInstancesCache[$entity];
		}
	}
}