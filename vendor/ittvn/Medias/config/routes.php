<?php
use Cake\Routing\Router;

Router::plugin(
    'Medias',
    ['path' => '/medias'],
    function ($routes) {
        $routes->fallbacks('DashedRoute');
    }
);
