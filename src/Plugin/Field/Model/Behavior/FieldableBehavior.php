<?php
namespace QuickApps\Field\Model\Behavior;
use Cake\ORM\Behavior;
use Cake\ORM\TableRegistry;
use Cake\ORM\Query;

class FieldableBehavior extends Behavior {
	protected $_config = [
		'entity' => null,
		'mapper' => null,
		'enabled' => true
	];

	protected $_table = null;

/**
 * Constructor
 *
 * @param Table $table The table this behavior is attached to.
 * @param array $config The config for this behavior.
 */
	public function __construct($table, array $config = []) {
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
	public function beforeFind($event, $query) {
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
 * custom fields data under de `_fields` key.
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
 *             [other_custom_field] => array(
 *                 [data] => stored data
 *                 ...
 *             ),
 *             ...
 *         )
 *     )
 *
 * In the example above, the User entity has custom field named `user_age`.
 * and its current value is 22.
 *
 * @param Entity $entity the entity to modify
 * @param integer $key entity key index from result collection.
 * @param MapReduce $mapReduce instance of the MapReduce routine it is running.
 * @return void
 */
	public function fieldableMapper($entity, $key, $mapReduce) {
		$FieldData = TableRegistry::get('Field.FieldData');
		$FieldInstances = TableRegistry::get('Field.FieldInstances');
		$_fields = [];

		// get attached field instances for this entity
		$entitieAttachedFields = $FieldInstances->find()
			->where(['FieldInstances.entity' => "{$this->_config['entity']}"]);

		// for each instance get the stored data for this entity
		foreach ($entitieAttachedFields as $instance) {
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

			$storedData->set(
				[
					'label' => $instance->label,
					'description' => $instance->description,
					'required' => $instance->required,
					'settings' => $instance->settings
				],
				['guard' => false]
			);

			$_fields[$instance->slug] = $storedData;
		}

		$entity->set('_fields', $_fields);
		$mapReduce->emit($entity, $key);
	}

/**
 * Changes behavior's config parameters.
 * Useful when using a custom mapper function.
 *
 * @param array $config a config assoc-array.
 * @return array current config array.
 */
	public function setFieldableConfig($config) {
		$this->_config = array_merge($this->_config, $config);
		$this->_config['entity'] = strtolower($this->_config['entity']);
	}

	public function bindFieldable() {
		$this->_config['enabled'] = true;
	}

	public function unbindFieldable() {
		$this->_config['enabled'] = false;
	}
}