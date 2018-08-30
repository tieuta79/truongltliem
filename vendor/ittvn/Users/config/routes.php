<?php

use Cake\Routing\Router;
use Cake\Core\Configure;

Router::plugin('Users', ['path' => '/'], function ($routes) {
    $routes->connect('/login/:role', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'login'], ['pass' => ['role']]);
    $routes->connect('/forgot/:role', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'forgot'], ['pass' => ['role']]);
    $routes->connect('/update-info/:role', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'updateInfo'], ['pass' => ['role']]);
    $routes->connect('/update-password/:role', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'updatePassword'], ['pass' => ['role']]);
    $routes->connect('/changepass/:role/:code', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'changepass'], ['pass' => ['role', 'code']]);
    $routes->connect('/register/:role', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'register'], ['pass' => ['role']]);
    $routes->connect('/verify/:role/:code', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'verify'], ['pass' => ['role', 'code']]);
    $routes->connect('/logout/:role', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'logout'], ['pass' => ['role']]);
    $routes->connect('/logs/:role', ['plugin' => 'Users', 'controller' => 'Logs', 'action' => 'index'], ['pass' => ['role']]);
    $routes->connect('/messages/:role', ['plugin' => 'Users', 'controller' => 'Messages', 'action' => 'index'], ['pass' => ['role']]);
    $routes->connect('/' . __d('ittvn', 'my-account') . '/:role', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'view'], ['pass' => ['role']]);
    $routes->connect('/' . __d('ittvn', 'edit-account') . '/:role', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'edit'], ['pass' => ['role']]);
    $routes->fallbacks('DashedRoute');
});

Router::prefix('admin', function ($routes) {
    if (!Configure::check('Network')) {
        $routes->connect('/login', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'login']);
        $routes->connect('/logout', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'logout']);

        $routes->fallbacks('DashedRoute');
    }
});
