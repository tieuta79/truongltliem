<?php

use Cake\Routing\Router;

Router::plugin('Booking', ['path' => '/booking'], function ($routes) {
			//$routes->connect('/bookings/index',['controller'=>'Bookings','action'=>'index']);
    $routes->fallbacks('DashedRoute');
}
);
