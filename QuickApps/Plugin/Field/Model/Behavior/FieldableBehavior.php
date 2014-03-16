<?php
namespace QuickApps\Plugin\Field\Model\Behavior;
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

					if ($this->_table->hasField($field_name) || strtolower($entity) != strtolower($this->_table->alias())) {
						return;
					}

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
			 * Must be respored to initial value in order to avoid unexpected errors.
			 */
			if ($configBefore != $configAfter) {
				$this->_config = $configBefore;
			}
		}
	}

/**
 * The method which actually fetches field records.
 *
 * @param Entity $entity the entity to modify
 * @param integer $key entity key index from result collection.
 * @param MapReduce $mapReduce instance of the MapReduce routine it is running.
 * @return void
 */
	public function fieldableMapper($entity, $key, $mapReduce) {
		$FieldData = TableRegistry::get('Field.FieldData');
		$_fields = [];

		$entitysFieldData = $FieldData->find()
			->matching('FieldInstances', function ($q) {
				return $q->where(['FieldInstances.entity' => "{$this->_config['entity']}"]);
			});

		foreach ($entitysFieldData as $fieldData) {
			$_fields[] = $fieldData;
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