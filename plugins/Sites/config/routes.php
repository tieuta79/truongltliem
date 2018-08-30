<?php

use Cake\Routing\Router;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Network\Request;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Sites\ConfigNetwork;

if (Configure::check('Network')) {
    $domains = Configure::read('Sites.domains');
    if (Configure::read('Network.type') == 1) {
        if (Configure::check('Network.mainDomain') && Configure::read('Network.mainDomain') == $_SERVER['HTTP_HOST']) {
            $plugin_loaded = Plugin::loaded();
            $p_loaded = [];
            foreach ($plugin_loaded as $plugin_load) {
                if (!in_array($plugin_load, ['DebugKit', 'Migrations', 'Search'])) {
                    $p_loaded[] = $plugin_load;
                }
            }
            //Get Content for router
            $metaTypes = TableRegistry::get('Metas.MetaTypes')->find()
                    ->find('Network')
                    ->select(['MetaTypes.id', 'MetaTypes.slug', 'MetaTypes.category'])
                    ->where(['MetaTypes.model' => 'Contents', 'MetaTypes.delete' => 0]);

            $configNetwork = new ConfigNetwork();
            $scope = $configNetwork->getCurrentScope();

            //if (!empty($scope)) {
            Router::scope('/' . $scope, function($routes) use ($metaTypes, $p_loaded, $scope) {
                //all router for subfolder by fronend
                $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
                //Rouer for contents
                if ($metaTypes->count() > 0) {
                    foreach ($metaTypes as $metaType) {
                        //router content
                        if ($metaType->slug != 'pages') {
                            $routes->connect('/:type', ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'index', 'type' => $metaType->slug]);
                            $routes->connect('/:type/:page', ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'index', 'type' => $metaType->slug], ['page' => '[0-9]+']);

                            $routes->connect('/:taxonomy', ['plugin' => 'Contents', 'controller' => 'Categories', 'action' => 'index', 'type' => $metaType->slug], ['pass' => ['taxonomy']]);

                            $routes->connect('/' . __d('ittvn', $metaType->slug) . '/:slug', ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => $metaType->slug], ['pass' => ['slug']]);
                            $routes->connect('/' . __d('ittvn', $metaType->slug) . '/:taxonomy/:slug', ['plugin' => 'Contents', 'controller' => 'Categories', 'action' => 'view', 'type' => $metaType->slug], ['pass' => ['taxonomy', 'slug']]);
                        } else {
                            $contents = TableRegistry::get('Contents.Contents')->find()
                                    ->find('Network')
                                    ->select(['id', 'slug'])
                                    ->where(['delete' => 0, 'meta_type_id' => $metaType->id]);
                            foreach ($contents as $content) {
                                $routes->connect('/' . $content->slug, ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => $metaType->slug, 'slug' => $content->slug], ['pass' => ['slug']]);
                            }
                        }
                    }
                }

                $routes->fallbacks('Sites.NetworkRoute');

                //all router for subfolder by admin
                $routes->prefix('admin', function ($routes) use($p_loaded, $scope) {
                    //dashboard network
                    $routes->connect('/', ['plugin' => 'Settings', 'controller' => 'Settings', 'action' => 'dashboard']);
                    //user network
                    $routes->connect('/login', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'login']);
                    $routes->connect('/logout', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'logout']);
                    //user theme
                    $routes->connect('/themes', ['plugin' => 'Themes', 'controller' => 'Themes', 'action' => 'index']);

                    if (!empty($scope)) {
                        foreach ($p_loaded as $p_load) {
                            $routes->plugin($p_load, function ($routes) {
                                $routes->connect('/:controller/:action/*');
                            });
                        }
                    }

                    $routes->connect('/:plugin/:controller/:action/*');
                    $routes->fallbacks('Sites.NetworkRoute');
                });
            });
            //}
        }
    } else {
        Router::scope('/', function ($routes) {
            $routes->fallbacks('Sites.NetworkRoute');
        });
        Router::scope('/', ['prefix' => 'admin'], function($routes) {
            $routes->connect('/admin', ['plugin' => 'Settings', 'controller' => 'Settings', 'action' => 'dashboard']);
            $routes->connect('/:plugin/:controller/:action/*');
            $routes->fallbacks('Sites.NetworkRoute');
        });
    }
}


Router::plugin('Sites', ['path' => '/'], function ($routes) {
    $routes->connect('/' . __d('ittvn', 'website') . '/setting/:role', ['plugin' => 'Sites', 'controller' => 'Sites', 'action' => 'website'], ['pass' => ['role']]);
    $routes->connect('/' . __d('ittvn', 'website') . '/domain/:role', ['plugin' => 'Sites', 'controller' => 'Domains', 'action' => 'add'], ['pass' => ['role']]);
    $routes->fallbacks('DashedRoute');
});

Router::prefix('admin', function ($routes) {
    if (Configure::check('Network')) {
        if (Configure::read('Network.type') == 1) {
            if (Configure::check('Network.mainDomain') && Configure::read('Network.mainDomain') == $_SERVER['HTTP_HOST']) {
                $routes->connect('/', ['plugin' => 'Settings', 'controller' => 'Settings', 'action' => 'dashboard']);
            }
        } else {
            $routes->connect('/', ['plugin' => 'Settings', 'controller' => 'Settings', 'action' => 'dashboard']);
        }

        //user network
        $routes->connect('/login', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'login']);
        $routes->connect('/logout', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'logout']);

        $routes->connect('/:plugin/:controller/:action/*');
        $routes->fallbacks('Sites.NetworkRoute');
    }
});
