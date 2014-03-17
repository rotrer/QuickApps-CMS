<?php
namespace QuickApps\View;
use Cake\View\View as CakeView;
use Cake\Cache\Cache;
use Cake\Controller\Controller;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Core\Object;
use Cake\Core\Plugin;
use Cake\Error;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Routing\RequestActionTrait;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\Utility\ViewVarsTrait;

class View extends CakeView {
	public function render($view = null, $layout = null) {
		return parent::render($view, $layout);
	}

/**
 * Return all possible paths to find view files in order
 *
 * @param string $plugin Optional plugin name to scan for view files.
 * @param boolean $cached Set to false to force a refresh of view paths. Default true.
 * @return array paths
 */
	protected function _paths($plugin = null, $cached = true) {
		if ($plugin === null && $cached === true && !empty($this->_paths)) {
			return $this->_paths;
		}
		$paths = array();
		$viewPaths = App::path('Template');
		$corePaths = App::core('Template');

		if (!empty($plugin)) {
			$count = count($viewPaths);
			for ($i = 0; $i < $count; $i++) {
				if (!in_array($viewPaths[$i], $corePaths)) {
					$paths[] = $viewPaths[$i] . 'Plugin' . DS . $plugin . DS;
				}
			}
			$paths = array_merge($paths, App::path('Template', $plugin));
		}

		$paths = array_unique(array_merge($paths, $viewPaths));
		if (!empty($this->theme)) {
			$theme = Inflector::camelize($this->theme);
			$themePaths = array();
			foreach ($paths as $path) {
				if (strpos($path, DS . 'Plugin' . DS) === false) {
					if ($plugin) {
						$themePaths[] = $path . 'Themed' . DS . $theme . DS . 'Plugin' . DS . $plugin . DS;
					}
					$themePaths[] = $path . 'Themed' . DS . $theme . DS;
				}
			}
			$paths = array_merge($themePaths, $paths);
		}
		$paths = array_merge($paths, $corePaths);
		if ($plugin !== null) {
			return $paths;
		}
		return $this->_paths = $paths;
	}
}