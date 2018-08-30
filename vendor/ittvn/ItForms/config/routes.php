<?php

use Cake\Routing\Router;

Router::plugin(
        'ItForms', ['path' => '/it-forms'], function ($routes) {
    $routes->fallbacks('DashedRoute');
}
);
