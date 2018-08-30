<?php
use Cake\Routing\Router;

Router::plugin(
    'BakeTemplates',
    ['path' => '/bake-templates'],
    function ($routes) {
        $routes->fallbacks('DashedRoute');
    }
);
