<?php

use Cake\Routing\Router;
use Ittvn\Utility\System;

$system = new System();

Router::plugin('Products', ['path' => '/'], function ($routes) use($system) {
    $routes->connect('/' . $system->slug(__d('ittvn', 'filters')) . '/:type/:category', ['plugin' => 'Products', 'controller' => 'Filters', 'action' => 'view'], ['pass' => ['type', 'category']]);
    $routes->connect('/' . $system->slug(__d('ittvn', 'detail-description')) . '/:slug', ['plugin' => 'Products', 'controller' => 'Products', 'action' => 'viewDescriptionAjax'], ['pass' => ['slug']]);
    $routes->connect('/' . $system->slug(__d('ittvn', 'details')) . '/:slug', ['plugin' => 'Products', 'controller' => 'Products', 'action' => 'viewAjax'], ['pass' => ['slug']]);

    $routes->connect('/' . $system->slug(__d('ittvn', 'address')), ['plugin' => 'Products', 'controller' => 'Addresses', 'action' => 'index']);
    $routes->connect('/' . $system->slug(__d('ittvn', 'address')) . '/' . $system->slug(__d('ittvn', 'add')), ['plugin' => 'Products', 'controller' => 'Addresses', 'action' => 'add']);
    $routes->connect('/' . $system->slug(__d('ittvn', 'address')) . '/' . $system->slug(__d('ittvn', 'edit')) . '/:id', ['plugin' => 'Products', 'controller' => 'Addresses', 'action' => 'edit'], ['pass' => ['id']]);
    
    $routes->connect('/' . $system->slug(__d('ittvn', 'order')), ['plugin' => 'Products', 'controller' => 'Orders', 'action' => 'index']);
    $routes->connect('/' . $system->slug(__d('ittvn', 'order detail')).'/:order', ['plugin' => 'Products', 'controller' => 'Orderdetails', 'action' => 'index'],['pass'=>['order']]);
    
    $routes->connect('/' . $system->slug(__d('ittvn', 'wishlist')), ['plugin' => 'Products', 'controller' => 'Wishlists', 'action' => 'index']);
    $routes->connect('/' . $system->slug(__d('ittvn', 'wishlist')).'/'.$system->slug(__d('ittvn', 'add')), ['plugin' => 'Products', 'controller' => 'Wishlists', 'action' => 'add']);
    $routes->connect('/' . $system->slug(__d('ittvn', 'wishlist')).'/'.$system->slug(__d('ittvn', 'delete')), ['plugin' => 'Products', 'controller' => 'Wishlists', 'action' => 'delete']);
    
    $routes->connect('/' . $system->slug(__d('ittvn', 'add cart')), ['plugin' => 'Products', 'controller' => 'Products', 'action' => 'addCart']);
    $routes->connect('/' . $system->slug(__d('ittvn', 'view cart')), ['plugin' => 'Products', 'controller' => 'Products', 'action' => 'cart']);
    $routes->connect('/' . $system->slug(__d('ittvn', 'checkout')), ['plugin' => 'Products', 'controller' => 'Products', 'action' => 'checkout']);
    $routes->connect('/' . $system->slug(__d('ittvn', 'payment')), ['plugin' => 'Products', 'controller' => 'Products', 'action' => 'payment']);
    $routes->connect('/:plugin/:controller/:action/*');
    $routes->fallbacks('DashedRoute');
});
