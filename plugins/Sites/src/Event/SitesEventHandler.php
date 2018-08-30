<?php

namespace Sites\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\Event;
use Cake\Routing\Router;
use Metas\Utility\Metas;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Database\Connection;
use Cake\Core\Configure;
use Sites\ConfigNetwork;

class SitesEventHandler implements EventListenerInterface {

    public function implementedEvents() {
        return [
            'Admin.Tables.Sites.filterHeader' => 'filterHeader',
            'Admin.Tables.Sites.row' => 'addRow',
            'Admin.Forms.Sites.main' => 'formMain',
            //'Admin.Views.Users' => 'view'
            'Admin.Menus.beforeRender' => 'beforeRenderMenus',
        ];
    }

    public function filterHeader(Event $event) {
        $filters = $event->subject()['filter'];
        $request = Router::getRequest();
        foreach ($filters as $key => $filter) {
            if ($key == 'user_id') {
                $users = TableRegistry::get('Users.Users')->find('list')->where(['delete <>' => 1]);
                $options = '';
                foreach ($users as $kr => $vr) {
                    $options .= '<option value="' . $kr . '">' . $vr . '</option>';
                }
                $filters[$key] = [
                    '<label class="select"><select class="form-control" style="width: 100%;"><option value="">' . __d('ittvn', 'Filter user') . '</option>' . $options . '</select><i></i></label>' => [
                        'class' => 'hasinput smart-form'
                    ]
                ];
            }
        }
        return $filters;
    }

    public function addRow(Event $event) {
        $headers = $event->subject()['header'];
        $row = $event->subject()['row'];
        $helper = $event->subject()['helper'];
        $request = Router::getRequest();

        $result = $event->subject()['data'];
        if (!empty($event->result)) {
            $result = $event->result;
        }

        $username = '';
        $full_name = '';
        if (!empty($row->user_id)) {
            $Users = TableRegistry::get('Users.Users');
            $user = $Users->find()->select(['username', 'first_name', 'middle_name', 'last_name'])->where(['id' => $row->user_id])->first();
            $full_name = $user->{$Users->displayField()};
            $username = $user->username;
        }

        foreach ($headers as $key => $field) {
            switch ($field) {
                case 'user_id':
                    $result[$key] = $full_name;
                    break;
                case 'title':
                    $url = '';
                    if (Configure::check('Network') && Configure::read('Network.type') == 2) {
                        $url = $helper->Html->link($username . '.' . $request->host(), $request->scheme() . '://' . $username . '.' . $request->host(), ['target' => '_blank']);
                    } else {
                        $url = $helper->Html->link($request->host() . '/' . $username, $request->scheme() . '://' . $request->host() . '/' . $username, ['target' => '_blank']);
                    }
                    $result[$key] = $row->title . '<br />' . $url;
                    break;
            }
        }
        return $result;
    }

    public function formMain(Event $event) {
        $blocks = $event->subject()['blocks'];
        $helper = $event->subject()['helper'];
        $viewVars = $event->subject()['viewVars'];
        $request = Router::getRequest();

        if (!empty($event->result)) {
            $blocks = $event->result;
        }

        foreach ($blocks as $kb => $block) {
            foreach ($block as $kf => $field) {
                if (!empty($kf) && $kf == 'name') {
                    if ($request->action == 'edit') {
                        $blocks[$kb][$kf]['readonly'] = true;
                    }
                    $blocks[$kb][$kf]['input-group'] = true;
                    if (Configure::check('Network') && Configure::read('Network.type') == 2) {
                        $blocks[$kb][$kf]['addon']['before'] = '<strong>.' . $_SERVER['REQUEST_SCHEME'] . '://' . '</strong>';
                        $blocks[$kb][$kf]['addon']['after'] = '<strong>.' . $request->host() . '</strong>';
                    } else {
                        $blocks[$kb][$kf]['addon']['before'] = '<strong>' . $_SERVER['REQUEST_SCHEME'] . '://' . $request->host() . '/</strong>';
                    }
                }
            }
        }

        return $blocks;
    }

    public function beforeRenderMenus(Event $event) {
        if (Configure::check('Network.db') && Configure::read('Network.db') != 'default') {
            $menus = $event->subject()['menus'];
            if (!empty($event->result)) {
                $menus = $event->result['menus'];
            }
            unset($menus['Networks']);
            return ['menus' => $menus];
        }
    }

}
