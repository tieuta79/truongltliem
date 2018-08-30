<?php
use Cake\Routing\Router;

Router::plugin(
    'Countries',
    ['path' => '/countries'],
    function ($routes) {
        $routes->fallbacks('DashedRoute');
    }
);
