<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace QuickApps\Config;

/**
 * Configure paths required to find CakePHP + general filepath
 * constants
 */
require __DIR__ . '/paths.php';

/**
 * Load QuickApps basic functionality.
 */
require __DIR__ . '/basics.php';

// Use composer to load the autoloader.
if (file_exists(VENDOR_INCLUDE_PATH . '/autoload.php')) {
	require VENDOR_INCLUDE_PATH . '/autoload.php';
}

// If composer is not used, use CakePHP's classloader to autoload the framework
// and the application. You will also need setup autoloading for plugins by
// passing `autoload' => true for `Plugin::loadAll()` or `Plugin::load()`
//
// If you are using a custom namespace, you'll need to set it here as well.
if (!class_exists('Cake\Core\Configure')) {
	require CAKE . 'Core/ClassLoader.php';
	$loader = new \Cake\Core\ClassLoader;
	$loader->register();
	$loader->addNamespace('Cake', CAKE);
	$loader->addNamespace('QuickApps', APP);
}

/**
 * Bootstrap CakePHP.
 *
 * Does the various bits of setup that CakePHP needs to do.
 * This includes:
 *
 * - Registering the CakePHP autoloader.
 * - Setting the default application paths.
 */
require CAKE . 'bootstrap.php';

use Cake\Cache\Cache;
use Cake\Configure\Engine\IniConfig;
use Cake\Configure\Engine\PhpConfig;
use Cake\Console\ConsoleErrorHandler;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\ErrorHandler;
use Cake\Log\Log;
use Cake\Network\Email\Email;
use Cake\Utility\Inflector;
use Cake\Event\EventManager;

/**
 * Read configuration file and inject configuration into various
 * CakePHP classes.
 *
 * By default there is only one configuration file. It is often a good
 * idea to create multiple configuration files, and separate the configuration
 * that changes from configuration that does not. This makes deployment simpler.
 */
Configure::config('default', new PhpConfig());
Configure::load('app.php', 'default', false);

/**
 * Uncomment this line and correct your server timezone to fix
 * any date & time related errors.
 */
date_default_timezone_set('UTC');

/**
 * Configure the mbstring extension to use the correct encoding.
 */
mb_internal_encoding(Configure::read('App.encoding'));

/**
 * Register application error and exception handlers.
 */
if (php_sapi_name() === 'cli') {
	(new ConsoleErrorHandler(Configure::consume('Error')))->register();
} else {
	(new ErrorHandler(Configure::consume('Error')))->register();
}

/**
 * Set the full base url.
 * This URL is used as the base of all absolute links.
 *
 * If you define fullBaseUrl in your config file you can remove this.
 */
if (!Configure::read('App.fullBaseUrl')) {
	$s = null;
	if (env('HTTPS')) {
		$s = 's';
	}

	$httpHost = env('HTTP_HOST');
	if (isset($httpHost)) {
		Configure::write('App.fullBaseUrl', 'http' . $s . '://' . $httpHost);
	}
	unset($httpHost, $s);
}

Cache::config(Configure::consume('Cache'));
ConnectionManager::config(Configure::consume('Datasources'));
Email::configTransport(Configure::consume('EmailTransport'));
Email::config(Configure::consume('Email'));
Log::config(Configure::consume('Log'));

/**
 * Load some handy information for bootstrap.
 */
Configure::config('snapshot', new PhpConfig(TMP));

if (!file_exists(TMP . 'snapshot.php') && file_exists(SITE_ROOT . '/Config/settings.json')) {
	createSnapshot();
} else {
	try {
		Configure::load('snapshot.php', 'snapshot', false);
	} catch (Exception $e) {

	}
}

/**
 * Load all registered plugins.
 *
 */
foreach (App::objects('Plugin') as $plugin) {
	if (
		in_array($plugin, Configure::read('snapshot.core_plugins')) ||
		in_array($plugin, Configure::read('snapshot.active_plugins'))
		) {
		Plugin::load(
			$plugin,
			[
				'namespace' => "QuickApps\\{$plugin}",
				'autoload' => true,
				'bootstrap' => true,
				'routes' => true,
				'ignoreMissing' => true
			]
		);

		$eventClass = Plugin::getNamespace($plugin) . "\\Event\\{$plugin}Event";

		if (class_exists($eventClass)) {
			EventManager::instance()->attach(new $eventClass);
		}
	}
}

/**
 * Load site's bootstrap.php
 */
if (file_exists(ROOT . '/Config/bootstrap.php')) {
	include_once ROOT . '/Config/bootstrap.php';
}