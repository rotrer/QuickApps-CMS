<?php
namespace QuickApps\Plugin\Field\Model\Table;
use Cake\ORM\Table;

class FieldDataTable extends Table {
	public function initialize(array $config) {
		$this->belongsTo(
			'FieldInstances',
			[
				'className' => 'QuickApps\Plugin\Field\Model\Table\FieldInstancesTable',
				'foreignKey' => 'field_instance_id'
			]
		);
	}
}