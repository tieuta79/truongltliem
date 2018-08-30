<?php

namespace Products\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Metas\Utility\Metas;
use Cake\Routing\Router;
use Cake\View\View;

class ProductsEventHandler implements EventListenerInterface {

    public function implementedEvents() {
        return [
            'Admin.Menus.PostType.beforeRender' => 'beforeRenderMenus',
            'Admin.Menus.PostType.afterRender' => 'afterRenderMenus',
            'Admin.View.extend' => 'extendView',
            'Admin.View.setTabs' => 'setTabs',
            'Admin.Forms.Contents.main' => 'formMain',
            'Table.Contents' => 'TableContents',
            'Controller.Admin.Contents.edit.get' => 'contentEditGet',
            'Admin.Tables.CategoryContents.row' => 'addRow',
            'Admin.Tables.CategoryContents.rowAction' => 'rowAction'
        ];
    }

    function rowAction(Event $event) {
        $action = $event->subject()['action'];
        $row = $event->subject()['row'];
        $helper = $event->subject()['helper'];
        $request = Router::getRequest();

        $action['Edit'] = $helper->Html->link(
                '<i class="fa fa-pencil-square-o"></i>', ['plugin' => 'Contents', 'controller' => 'Categories', 'action' => 'editRelation', $request->params['pass'][0], $row->content_id, $row->category_id], ['escape' => false, 'class' => 'btn btn-success btn-sm', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Edit')]
        );

        $action['Delete'] = $helper->Form->postLink(
                '<i class="fa fa-trash-o"></i>', ['plugin' => 'Contents', 'controller' => 'CategoryContents', 'action' => 'delete', $row->id], ['escape' => false, 'class' => 'btn btn-danger btn-sm', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Delete'), 'confirm' => __d('ittvn', 'Are you sure you want to delete # {0}?', $row->id)]
        );
        unset($action['View']);
        return $action;
    }

    public function addRow(Event $event) {
        $headers = $event->subject()['header'];
        $row = $event->subject()['row'];
        $helper = $event->subject()['helper'];

        $result = $event->subject()['data'];
        if (!empty($event->result)) {
            $result = $event->result;
        }

        foreach ($headers as $key => $field) {
            switch ($field) {
                case 'content_id':
                    $content = TableRegistry::get('Contents.Contents')
                            ->find()
                            ->select(['name'])
                            ->where(['id' => $row->content_id])
                            ->first();
                    $result[$key] = $content->name;
                    break;
                case 'category_id':
                    $category = TableRegistry::get('Contents.Categories')
                            ->find()
                            ->select(['name'])
                            ->where(['id' => $row->category_id])
                            ->first();
                    $result[$key] = $category->name;
                    break;
            }
        }
        return $result;
    }

    public function extendView(Event $event) {
        $request = $event->subject()['request'];
        if ($request->params['plugin'] == 'Contents' && $request->params['controller'] == 'Contents' && $request->params['action'] == 'add' && $request->params['pass'][0] == 'products') {
            return '/Admin/Common/tab';
        } else if ($request->params['plugin'] == 'Contents' && $request->params['controller'] == 'Contents' && $request->params['action'] == 'edit' && $request->params['pass'][1] == 'products') {
            return '/Admin/Common/tab';
        }
        return false;
    }

    public function contentEditGet(Event $event) {
        $request = Router::getRequest();
        if ($request->param('pass')[1] == 'products') {
            $subject = $event->subject();
            $result = [];
            if (!empty($subject->result)) {
                $result = $subject->result;
            }
            $result = Hash::merge($result, $subject);
            $result = Hash::merge($result, [
                        'contain' => [
                            'Attributes' => [
                                'fields' => [
                                    'AttributeProducts.content_id',
                                    'Attributes.id',
                                    'AttributeProducts.value'
                                ]
                            ]
                        ]
            ]);
            return $result;
        }
    }

    public function setTabs(Event $event) {
        $helper = $event->subject()['helper'];
        $form = $event->subject()['form'];
        $data = $event->subject()['data'];
        $tabs = $event->subject()['tabs'];
        $contentTabs = $event->subject()['contentTabs'];

        if (!empty($event->result)) {
            $result = $event->result;
        }
        $result['tabs'][] = __d('ittvn', 'Galleries');
        $result['tabs'][] = __d('ittvn', 'Price');
        $result['tabs'][] = __d('ittvn', 'Cross Products');
        $result['tabs'][] = __d('ittvn', 'Attributes');

        $metas = (new Metas())->parseform(['name' => 'Galleries']);
        $metas['Galleries_meta']['value'] = $form->Galleries_meta;
        $result['contentTabs'][] = $helper->inputs($metas);

        // Add Extra Fields Price
        $metas = (new Metas())->parseform(['name' => 'Price']);
        $metas['Price_meta']['value'] = $form->Price_meta;
        $result['contentTabs'][] = $helper->inputs($metas);

        // Add Extra Fields Cross_Products
        $products = TableRegistry::get('Contents.Contents')->find('list')->contain(['MetaTypes'])->where(['MetaTypes.slug' => 'products']);
        $metas = (new Metas())->parseform(['name' => 'Cross_Products']);
        $metas['Cross_Products_meta']['multiple'] = true;
        $metas['Cross_Products_meta']['style'] = 'width:97%';
        $metas['Cross_Products_meta']['value'] = json_decode($form->Cross_Products_meta, true);
        if ($products->count() > 0) {
            $metas['Cross_Products_meta']['options'] = $products->toArray();
        }
        $result['contentTabs'][] = $helper->inputs($metas);

        $attributes = TableRegistry::get('Products.Attributes')->find()
                ->select(['id', 'name', 'type', 'options'])
                ->where(['status' => 1]);

        $attrs = [];
        if ($attributes->count() > 0) {
            $i = 0;
            foreach ($attributes as $attribute) {
                if ($attribute->type == 'select' || $attribute->type == 'radio') {
                    $attrs['attributes.' . $i . '._joinData.value'] = [
                        'label' => $attribute->name,
                        'type' => $attribute->type,
                        'options' => Hash::combine(json_decode($attribute->options, true), '{n}.key', '{n}.value')
                    ];
                } else {
                    $attrs['attributes.' . $i . '._joinData.value'] = [
                        'label' => $attribute->name,
                        'type' => $attribute->type
                    ];
                }
                $attrs['attributes.' . $i . '.id'] = [
                    'type' => 'hidden',
                    'value' => $attribute->id
                ];

                $i++;
            }
        }
        $result['contentTabs'][] = $helper->inputs($attrs);

        return $result;
    }

    public function formMain(Event $event) {
        $blocks = $event->subject()['blocks'];
        $request = Router::getRequest();

        if (!empty($event->result)) {
            $blocks = $event->result;
        }
        $posttype = '';
        if ($request->params['action'] == 'add') {
            $posttype = $request->params['pass'][0];
        } else if ($request->params['action'] == 'edit') {
            $posttype = $request->params['pass'][1];
        }
        if($posttype=='products'){
            // Add Extra Fields Id_Products
            $metas = (new Metas())->parseform(['name' => 'Id_Products']);

            if (isset($blocks['extra_fields'])) {
                unset($blocks['extra_fields']);
            }

            $blocks['default'] = [
                'label' => $blocks['default']['label'],
                'name' => $blocks['default']['name'],
                'Id_Products_meta' => $metas['Id_Products_meta'],
                'slug' => $blocks['default']['slug'],
                'excerpt' => $blocks['default']['excerpt'],
                'description' => $blocks['default']['description'],
            ];
        }

        return $blocks;
    }

    public function TableContents(Event $event) {
        $event->subject()->belongsToMany('Products.Attributes', [
            'through' => 'Products.AttributeProducts',
        ]);
    }

    public function beforeRenderMenus(Event $event) {
        $metaTypes = $event->subject()['metaTypes'];
        $metaType = TableRegistry::get('Metas.MetaTypes')->find()->contain(['MetaCategories'])->where(['slug' => 'products'])->first();
        if (!empty($metaType)) {
            $metaTypes = Hash::merge($metaTypes, [$metaType]);
        }
        return $metaTypes;
    }

    public function afterRenderMenus(Event $event) {
        $menus = $event->subject()['menus'];
        $metaType = $event->subject()['metaType'];

        if ($metaType->slug == 'products') {
            $menus[$metaType->name]['child']['Attributes'] = [
                'icon' => 'fa fa-pied-piper',
                'title' => 'Attributes',
                'url' => [
                    'plugin' => 'Products',
                    'controller' => 'Attributes',
                    'action' => 'index',
                    'prefix' => 'admin'
                ],
            ];

            $menus[$metaType->name]['child']['Orders'] = [
                'icon' => 'fa fa-cart-plus',
                'title' => 'Orders',
                'url' => '#'
            ];

            $menus[$metaType->name]['child']['Customers'] = [
                'icon' => 'fa fa-user-secret',
                'title' => 'Customers',
                'url' => [
                    'plugin' => 'Users',
                    'controller' => 'Users',
                    'action' => 'index',
                    'prefix' => 'admin',
                    'customers'
                ]
            ];
        }
        return $menus;
    }

}
