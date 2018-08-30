<?php
use Cake\Routing\Router;

Router::plugin('Metas', function ($routes) {
    $routes->fallbacks('DashedRoute');
});

Router::prefix('admin', function ($routes) {
    //$routes->connect('/metas', ['plugin' => 'Metas', 'controller' => 'Metas', 'action' => 'index']);
    //$routes->connect('/metatypes', ['plugin' => 'Metas', 'controller' => 'MetaTypes', 'action' => 'index']);
    
    $routes->fallbacks('DashedRoute');
});