<?php
namespace handler\Listener;

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Mvc\Application;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Di\Injectable;

class Listener extends injectable
{
    public function beforeHandleRequest(Event $event, Application $app, Dispatcher $dis)
    {
        $acl = new Memory();
        $acl->addRole('guest');
        $acl->addRole('user');

        $acl->addComponent(
            'index',
            [
                'index',
                'login',
                'doLogin'
            ]
        );

        $acl->addComponent(
            'products',
            [
                'index',
            ]
        );
        $acl->allow('guest', 'index', '*');
        $acl->allow('user', '*', '*');

        $role = "guest";
        $controller = "index";
        $action = "index";
        if (!empty($dis->getControllerName())) {
            $controller = $dis->getControllerName();
        }
        if (!empty($dis->getActionName())) {
            $action = $dis->getActionName();
        }
        if (!empty($this->request->get('role'))) {
            $role = $this->request->get('role');
        }
        if (false === $acl->isAllowed($role, $controller, $action)) {
            echo '<h3>Access denied !</h3>';
            echo 'Go to login page';
            echo '<a href = "/index/login">Login</a>';
            die;
        }
    }
}
