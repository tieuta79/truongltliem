<?php

namespace Extensions\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\Event;
use Cake\Core\Configure;

class LanguagesEventHandler implements EventListenerInterface {

    public function implementedEvents() {
        return [
            //'Settings.afterConfig' => 'afterConfig'
            'Admin.Tables.Languages.row' => 'addRow',
        ];
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
                case 'status':
                    $result[$key] = (!empty($row->{$field}) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>');
                    break;
            }
        }
        return $result;
    }

    public function afterConfig(Event $event) {
        $settings = $event->subject()['settings'];
        $group = $event->subject()['group'];
        pr($settings);
        die();
    }

}
