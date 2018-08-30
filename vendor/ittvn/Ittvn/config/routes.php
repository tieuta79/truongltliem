<?php

use Cake\Routing\Router;
use Cake\Core\Configure;

Router::prefix('admin', function ($routes) {
    if (!Configure::check('Network')) {
        $routes->connect('/', ['plugin' => 'Settings', 'controller' => 'Settings', 'action' => 'dashboard']);
        $routes->connect('/:plugin/:controller/:action/*');
        $routes->fallbacks('InflectedRoute');
    }
});

Router::plugin('Ittvn', function ($routes) {
    $routes->fallbacks('DashedRoute');
});
