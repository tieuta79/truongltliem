<?php

namespace Booking\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Metas\Utility\Metas;
use Cake\Routing\Router;
use Cake\View\View;
use Settings\Utility\Setting;

class BookingEventHandler implements EventListenerInterface {

    public function implementedEvents() {
        return [
            'Admin.Menus.PostType.beforeRender' => 'beforeRenderMenus',
            'Admin.Menus.PostType.afterRender' => 'afterRenderMenus',
            'Admin.View.extend' => 'extendView',
            'Admin.View.setTabs' => 'setTabs',
            //'Admin.Forms.Contents.main' => 'formMain',
            'Table.Contents' => 'TableContents',
            //'Controller.Admin.Contents.edit.get' => 'contentEditGet',
            'Admin.Tables.Bookings.row' => 'addRow',
            'Admin.Tables.Bookings.rowAction' => 'rowAction'
        ];
    }

    function rowAction(Event $event) {
        $action = $event->subject()['action'];
        $row = $event->subject()['row'];
        $helper = $event->subject()['helper'];
        $request = Router::getRequest();

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
        $setting = new Setting();
        foreach ($headers as $key => $field) {
            switch ($field) {
                case 'content_id':
                    $content = TableRegistry::get('Contents.Contents')
                            ->find()
                            ->select(['id', 'name'])
                            ->contain(['ContentMetas' => function($q) {
                                    return $q->select(['id', 'key', 'value', 'content_id'])->where(['key' => 'Price']);
                                }])
                            ->where(['id' => $row->content_id])
                            ->first();
                    $result[$key] = $content->name . '<br /><strong>Price: </strong>' . $setting->getThemeOption('symbol_currency') . $content->Price_meta;
                    break;
                case 'first_name':
                    $result[$key] = $row->first_name . ' ' . $row->last_name;
                    break;
            }
        }
        return $result;
    }

    public function extendView(Event $event) {
        $request = $event->subject()['request'];
        if ($request->params['plugin'] == 'Contents' && $request->params['controller'] == 'Contents' && $request->params['action'] == 'add' && $request->params['pass'][0] == 'roomtypes') {
            return '/Admin/Common/tab';
        } else if ($request->params['plugin'] == 'Contents' && $request->params['controller'] == 'Contents' && $request->params['action'] == 'edit' && $request->params['pass'][1] == 'roomtypes') {
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
        $request = Router::getRequest();

        if (!empty($event->result)) {
            $result = $event->result;
        }

        $posttype = '';
        if ($request->params['action'] == 'add') {
            $posttype = $request->params['pass'][0];
        } else if ($request->params['action'] == 'edit') {
            $posttype = $request->params['pass'][1];
        }

        if ($posttype == 'roomtypes') {
            // Add Extra Fields Galleries for tab Galleries
            $result['tabs'][] = __d('ittvn', 'Galleries');
            $metas = (new Metas())->parseform(['name' => 'Galleries']);
            $metas['Galleries_meta']['value'] = $form->Galleries_meta;
            $result['contentTabs'][] = $helper->inputs($metas);

            // Add Extra Fields Price for tab Price
            $result['tabs'][] = __d('ittvn', 'Rooms & Price');
            $room_price = '';
            $metas = (new Metas())->parseform(['name' => 'Price']);
            $metas['Price_meta']['value'] = $form->Price_meta;
            $room_price = $helper->inputs($metas);
            $metas = (new Metas())->parseform(['name' => 'Rooms']);
            $metas['Rooms_meta']['value'] = $form->Price_meta;
            $room_price .= $helper->inputs($metas);
            $result['contentTabs'][] = $room_price;
        }
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
        if ($posttype == 'products') {
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
        $event->subject()->hasMany('Bookings', [
            'foreignKey' => 'content_id',
            'className' => 'Booking.Bookings'
        ]);
    }

    public function beforeRenderMenus(Event $event) {
        $metaTypes = $event->subject()['metaTypes'];
        $metaType = TableRegistry::get('Metas.MetaTypes')->find()->contain(['MetaCategories'])->where(['slug' => 'roomtypes'])->first();
        if (!empty($metaType)) {
            $metaTypes = Hash::merge($metaTypes, [$metaType]);
        }
        return $metaTypes;
    }

    public function afterRenderMenus(Event $event) {
        $menus = $event->subject()['menus'];
        $metaType = $event->subject()['metaType'];

        if ($metaType->slug == 'roomtypes') {
            $menus[$metaType->name]['child']['Booking'] = [
                'icon' => 'fa fa-pied-piper',
                'title' => 'Booking',
                'url' => [
                    'plugin' => 'Booking',
                    'controller' => 'Bookings',
                    'action' => 'index',
                    'prefix' => 'admin'
                ],
            ];
            /*
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
             * 
             */
        }
        return $menus;
    }

}
