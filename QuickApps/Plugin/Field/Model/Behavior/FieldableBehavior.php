<?php
namespace QuickApps\Plugin\Field\Model\Behavior;
use Cake\ORM\Behavior;
use Cake\ORM\TableRegistry;

class FieldableBehavior extends Behavior {
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
	public function __construct($table, array $config = []) {
		$this->_config['entity'] = strtolower($table->alias());
		$this->_config['mapper'] = function ($entity, $key, $mapReduce) {
			$this->fieldableMapper($entity, $key, $mapReduce);
		};

		$this->_config = array_merge($this->_config, $config);
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

					list($entity, $field_name) = pluginSplit($field);
					//pr($entity); 
					//pr($field_name); 
					// TODO: field api search
				});

			$query->mapReduce($this->_config['mapper']);
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