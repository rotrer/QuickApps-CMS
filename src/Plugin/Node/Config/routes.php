<?php
namespace QuickApps\Node\Config;
use Cake\Core\Configure;
use Cake\Routing\Router;

$node_types = implode('|', (array)Configure::read('snapshot.node_types'));

if (!empty($node_types)) {
	Router::connect(
		'/:node_type_slug/:node_slug.html',
		[
			'plugin' => 'Node',
			'controller' => 'Serve',
			'action' => 'details'
		],
		[
			'node_type_slug' => $node_types,
			'node_slug' => '[a-z0-9\-]+',
			'pass' => ['node_type_slug', 'node_slug']
		]
	);
}

Router::connect(
	'/search/:criteria/*',
	[
		'plugin' => 'Node',
		'controller' => 'Serve',
		'action' => 'search'
	],
	['pass' => ['criteria']]
);

Router::connect(
	'/search',
	[
		'plugin' => 'Node',
		'controller' => 'Serve',
		'action' => 'search'
	]
);

Router::connect(
	'/',
	[
		'plugin' => 'Node',
		'controller' => 'Serve',
		'action' => 'frontpage'
	]
);

unset($node_types);