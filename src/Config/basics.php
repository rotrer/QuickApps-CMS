<?php
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\I18n\I18n;
use Cake\Log\Log;
use Cake\Utility\Debugger;
use Cake\Utility\Folder;
use Cake\ORM\TableRegistry;

/**
 * Returns a translated string if one is found; Otherwise, the submitted message.
 *
 * @param string $singular Text to translate
 * @param mixed $args Array with arguments or multiple arguments in function
 * @return mixed translated string
 * @link http://book.cakephp.org/2.0/en/core-libraries/global-constants-and-functions.html#__
 */
function __($singular, $args = null) {
	if (!$singular) {
		return;
	}

	$translated = I18n::translate($singular);
	if ($args === null) {
		return $translated;
	} elseif (!is_array($args)) {
		$args = array_slice(func_get_args(), 1);
	}

	$translated = preg_replace('/(?<!%)%(?![%\'\-+bcdeEfFgGosuxX\d\.])/', '%%', $translated);
	return vsprintf($translated, $args);
}

/**
 * Stores some bootstrap-handy information
 * into a persistent file `SITE/tmp/snapshot.php`.
 *
 * @return void
 */
function createSnapshot() {
	$snapshot = [
		'url_language_prefix' => false,
		'active_languages' => ['en'],
		'node_types' => [],
		'active_plugins' => [],
		'disabled_plugins' => [],
		'core_plugins' => [],
		'core_themes' => []
	];

	foreach (TableRegistry::get('Plugins')->find()->select(['name', 'status'])->all() as $plugin) {
		if ($plugin->status) {
			$snapshot['active_plugins'][] = $plugin->name;
		} else {
			$snapshot['disabled_plugins'][] = $plugin->name;
		}
	}

	foreach (TableRegistry::get('NodeTypes')->find()->select(['slug'])->all() as $nodeType) {
		$snapshot['node_types'][] = $nodeType->slug;
	}

	$Folder = new Folder(APP . 'Plugin');

	foreach ($Folder->read(false, false, false)[0] as $plugin) {
		$snapshot['core_plugins'][] = $plugin;
	}

	$Folder = new Folder(APP . 'Template' . DS . 'Themed');

	foreach ($Folder->read(false, false, false)[0] as $theme) {
		$snapshot['core_themes'][] = $theme;
	}

	Configure::write('snapshot', $snapshot);
	Configure::dump('snapshot.php', 'snapshot', ['snapshot']);
}