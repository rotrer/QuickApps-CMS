<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace QuickApps\Config;

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Routing\Router;
use Cake\Routing\RouteCollection;

/**
 * Admin prefix for backend access.
 */
Configure::write('Routing.prefixes', ['admin']);

/**
 * Redirect everything to installer plugin if it is a new quickapps package.
 */
if (!file_exists(SITE_ROOT . '/Config/database.json')) {
	Router::redirect('/', '/installer/setup', ['status' => 302]);
	Router::redirect(
		'/:anything_but_installer',
		'/installer/setup',
		['anything_but_installer' => '(?!installer).*', 'status' => 302]
	);
}

/**
 * Load site routes.
 */
if (file_exists(SITE_ROOT . '/Config/routes.php')) {
	include_once SITE_ROOT . '/Config/routes.php';
}

/**
 * Load all plugin routes.
 */
Plugin::routes();

/**
 * Load the CakePHP default routes.
 */
require CAKE . 'Config/routes.php';

/**
 * Set language prefix (if enabled) on every route.
 * This will create a locale-prefixed version of all registered
 * routes.
 */
if (Configure::read('boot.url_language_prefix')) {
	$langs = implode('|', Configure::read('boot.active_languages'));
	$routes_count = Router::$_routes->count();

	for ($i = 0; $i < $routes_count; $i++) {
		$route = clone Router::$_routes->get($i);
		$route->options['locale'] = "{$langs}";
		$route->template = "/:locale{$route->template}";

		Router::$_routes->add($route);
	}

	for ($i = 0; $i < intval($routes_count / 2); $i++) {
		Router::promote(null);
	}

	Router::addUrlFilter(
		function ($params, $request) {
			if (isset($request->params['locale']) && !isset($params['locale'])) {
				$params['locale'] = $request->params['locale'];
			}

			return $params;
		}
	);

	unset($langs, $i, $routes_count);
}