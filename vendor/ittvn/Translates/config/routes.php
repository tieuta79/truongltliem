<?php
use Cake\Routing\Router;

Router::plugin(
    'Translates',
    ['path' => '/translates'],
    function ($routes) {
        $routes->fallbacks('DashedRoute');
    }
);
