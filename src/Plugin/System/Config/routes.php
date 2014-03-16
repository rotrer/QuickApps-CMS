<?php
namespace QuickApps\System\Config;
use Cake\Routing\Router;

Router::connect(
	'/admin',
	[
		'plugin' => 'System',
		'controller' => 'Dashboard',
		'action' => 'index',
		'prefix' => 'admin'
	]
);