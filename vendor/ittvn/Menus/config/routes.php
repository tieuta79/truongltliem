<?php
use Cake\Routing\Router;

Router::plugin(
    'Menus',
    ['path' => '/menus'],
    function ($routes) {
        $routes->fallbacks('DashedRoute');
    }
);
