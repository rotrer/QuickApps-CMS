<?php
namespace QuickApps\Node\Model\Behavior;
use Cake\ORM\Behavior;

class SluggableBehavior extends Behavior {
/**
 * Run before a model is saved, used to set up slug for model.
 *
 * @param Model $Model Model about to be saved.
 * @return boolean true if save should proceed, false otherwise
 */
	public function beforeSave() {     
	}

/**
 * Generate a slug for the given string using specified settings.
 *
 * @param string $string string from where to generate slug
 * @param array $config settings to use (looks for 'separator' and 'length')
 * @return string slug for given string
 */
	private function __slug($string, $config) {
		$string = Inflector::slug(strtolower($string), $config['separator']);

		if (strlen($string) > $config['length']) {
			$string = substr($string, 0, $config['length']);
		}

		return $string;
	}
}