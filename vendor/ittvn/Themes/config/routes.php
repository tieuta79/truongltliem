<?php

use Cake\Routing\Router;

Router::plugin('Themes', function ($routes) {
    $routes->fallbacks('DashedRoute');
});

Router::prefix('admin', function ($routes) {
    $routes->connect('/themes', ['plugin' => 'Themes', 'controller' => 'Themes', 'action' => 'index']);

    $routes->fallbacks('Sites.NetworkRoute');
});