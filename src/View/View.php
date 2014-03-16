<?php
namespace QuickApps\View;
use Cake\View\View as CakeView;

class View extends CakeView {
	public function render($view = null, $layout = null) {
		return parent::render($view, $layout);
	}
}