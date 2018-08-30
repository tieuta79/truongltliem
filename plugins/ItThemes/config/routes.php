<?php
use Cake\Routing\Router;

Router::plugin(
    'ItThemes',
    ['path' => '/it-themes'],
    function ($routes) {
        $routes->fallbacks('DashedRoute');
    }
);
