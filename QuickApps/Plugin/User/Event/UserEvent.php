<?php
namespace QuickApps\Plugin\User\Event;
use Cake\Event\EventListener;

class UserEvent implements EventListener {
    public function implementedEvents() {
        return array(
            'Controller.before_login' => 'before_login',
            'Controller.after_login' => 'after_login',
            'Controller.login_failed' => 'login_failed',
            'Controller.before_logout' => 'before_logout',
            'Controller.after_logout' => 'after_logout'
        );
    }

    public function before_login($event) {
		return;
    }

    public function after_login($event) {
		return;
    }

    public function login_failed($event) {
		return;
    }

    public function before_logout($event) {
		return;
    }

    public function after_logout($event) {
		return;
    }
}