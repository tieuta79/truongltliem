<?php
use Cake\Routing\Router;

Router::plugin(
    'NewThemes',
    ['path' => '/new-themes'],
    function ($routes) {
        $routes->fallbacks('DashedRoute');
    }
);
