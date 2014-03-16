<?php
/**
 * Use the DS to separate the directories in other defines
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * The full path to the directory which holds "App", WITHOUT a trailing DS.
 */
define('ROOT', dirname(dirname(__DIR__)));

/**
 * The actual directory name for the "App".
 */
define('APP_DIR', basename(dirname(__DIR__)));

/**
 * The name of the webroot dir.  Defaults to 'webroot'
 */
define('WEBROOT_DIR', 'webroot');

/**
 * Path to the quickapps application's directory.
 */
define('APP', ROOT . DS . APP_DIR . DS);

/**
 * File path to the webroot directory.
 */
define('WWW_ROOT', SITE_ROOT . DS . WEBROOT_DIR . DS);

/**
 * Path to the tests directory.
 */
define('TESTS', ROOT . DS . 'Test' . DS);

/**
 * Path to the temporary files directory.
 */
define('TMP', SITE_ROOT . DS . 'tmp' . DS);

/**
 * Path to the logs directory.
 */
define('LOGS', TMP . 'logs' . DS);

/**
 * Path to the cache files directory. It can be shared between hosts in a multi-server setup.
 */
define('CACHE', TMP . 'cache' . DS);

/**
 * The absolute path to the "cake" directory, WITHOUT a trailing DS.
 *
 * CakePHP should always be installed with composer, so look there.
 */
define('CAKE_CORE_INCLUDE_PATH', VENDOR_INCLUDE_PATH . '/cakephp/cakephp');

/**
 * Path to the cake directory.
 */
define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
define('CAKE', CORE_PATH . 'src' . DS);