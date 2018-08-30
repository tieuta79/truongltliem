<?php

namespace Users\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\Event;
use Cake\Routing\Router;
use Metas\Utility\Metas;
use Cake\Core\Configure;
use Settings\Utility\Setting;

class MessagesEventHandler implements EventListenerInterface {

    public function implementedEvents() {
        return [
            'Admin.Tables.Messages.row' => 'addRow',
        ];
    }

    public function addRow(Event $event) {
        $request = Router::getRequest();
        $headers = $event->subject()['header'];
        $row = $event->subject()['row'];
        $helper = $event->subject()['helper'];

        $result = $event->subject()['data'];
        if (!empty($event->result)) {
            $result = $event->result;
        }

        foreach ($headers as $key => $field) {
            switch ($field) {
                case 'email':
                    if (!empty($row->email)) {
                        $result[$key] = $helper->Html->tag('i', '', ['class' => 'fa fa-check']);
                    } else {
                        $result[$key] = $helper->Html->tag('i', '', ['class' => 'fa fa-times']);
                    }
                    break;
                case 'priority':
                    $result[$key] = Configure::read('Messages.priority.' . $row->priority);
                    break;
                case 'created':
                    $setting = new Setting();
                    $result[$key] = $row->created->format($setting->getOption('Sites.format_date') . ' ' . $setting->getOption('Sites.format_time'));
                    break;
            }
        }
        return $result;
    }

}
