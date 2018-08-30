<?php
use Cake\Routing\Router;

Router::plugin(
    'School',
    ['path' => '/school'],
    function ($routes) {
        $routes->fallbacks('DashedRoute');
    }
);
