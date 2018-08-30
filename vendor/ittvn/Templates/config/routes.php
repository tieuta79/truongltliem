<?php
use Cake\Routing\Router;

Router::plugin('Templates', function ($routes) {
    $routes->fallbacks('DashedRoute');
});
