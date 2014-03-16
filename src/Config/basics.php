<?php
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\I18n\I18n;
use Cake\Log\Log;
use Cake\Utility\Debugger;

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