<?php

use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;

Router::prefix('admin', function ($routes) {
	$routes->connect('/contents/contents/index',['plugin'=>'Contents','controller'=>'Contents','action'=>'index']);
});


if (!Configure::check('Network') || (Configure::check('Network') && Configure::read('Network.type') == 2)) {
    $metaTypes = TableRegistry::get('Metas.MetaTypes')->find()
            ->find('Network')
            ->select(['MetaTypes.id', 'MetaTypes.slug', 'MetaTypes.category'])
            //->contain(['MetaCategories' => function($q) {
            //        return $q->select(['id', 'slug', 'meta_type_id'])->where(['delete' => 0]);
            //    }])
            ->where(['MetaTypes.model' => 'Contents', 'MetaTypes.delete' => 0]);

    Router::plugin('Contents', ['path' => '/'], function ($routes) use ($metaTypes) {
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
        $routes->fallbacks('DashedRoute');
    });
}