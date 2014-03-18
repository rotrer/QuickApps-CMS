<?php
namespace QuickApps\System\Controller\Admin;
use QuickApps\System\Controller\SystemAppController;
use Cake\Core\App;
use QuickApps\Utility\Plugin;
use Cake\Error;

class HelpController extends SystemAppController {
	public function index() {
		$plugins = [];

		foreach (App::objects('Plugin') as $plugin) {
			if (Plugin::loaded($plugin)) {
				$helpElement = App::path('Template', $plugin)[0] . 'Element' . DS;

				if (file_exists($helpElement)) {
					$plugins[] = $plugin;
				}
			}
		}

		$this->set('plugins', $plugins);
	}

	public function about($pluginName) {
		$about = false;

		foreach (App::objects('Plugin') as $plugin) {
			if (Plugin::loaded($plugin) && $plugin == $pluginName) {
				$helpElement = App::path('Template', $plugin)[0] . 'Element' . DS;

				if (file_exists($helpElement)) {
					$about = "{$plugin}.help";
					break;
				}
			}
		}

		if ($about) {
			$this->set('about', $about);
		} else {
			throw new Error\NotFoundException(__('No help was found.'));
		}
	}
}