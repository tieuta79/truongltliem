<?php
use Cake\Routing\Router;

Router::plugin('Settings', function ($routes) {
    $routes->fallbacks('DashedRoute');
});
