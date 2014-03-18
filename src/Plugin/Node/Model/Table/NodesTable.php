<?php
namespace QuickApps\Node\Model\Table;
use Cake\ORM\Table;

class NodesTable extends Table {
	public function initialize(array $config) {
		$this->addBehavior(
			'Field.Fieldable',
			[
				'entity' => 'nodes',
				'mapper' => function ($entity, $key, $mapReduce) {
					$this->setFieldableConfig(['entity' => "nodes_{$entity->node_type_slug}"]);
					$this->fieldableMapper($entity, $key, $mapReduce);
				}
			]
		);
		$this->addBehavior('Comment.Commentable');
		$this->addBehavior('Node.Sluggable');
		$this->addBehavior('System.Serialized', ['test']);
		$this->belongsTo(
			'NodeTypes',
			[
				'className' => 'QuickApps\Node\Model\Table\NodeTypesTable',
				'foreignKey' => 'node_type_id'
			]
		);
	}
}