<?php

namespace Translates\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Ittvn\Utility\Language;

class LocalesEventHandler implements EventListenerInterface {

    public function implementedEvents() {
        return [
            'Admin.Tables.Locales.AfterBuildHeader' => 'afterBuildHeader',
            'Admin.Tables.Locales.filterHeader' => 'filterHeader',
            'Admin.Tables.Locales.header' => 'header',
            'Admin.Tables.Locales.row' => 'addRow',
        ];
    }

    public function afterBuildHeader(Event $event) {
        $header = $event->subject()['header'];
        unset($header['Checkbox']);
        unset($header['Action']);
        return $header;
    }

    public function filterHeader(Event $event) {
        $filters = $event->subject()['filter'];
        foreach ($filters as $key => $filter) {
            if ($key == 'domain') {
                $locales = TableRegistry::get('Translates.Locales')->find('list', ['keyField' => 'domain', 'valueField' => 'domain', 'limit' => 100])->group('domain');
                $options = '';
                foreach ($locales as $kr => $vr) {
                    $options .= '<option value="' . $kr . '">' . $vr . '</option>';
                }
                $filters[$key] = [
                    '<label class="select"><select class="form-control" style="width: 100%;"><option value="">Filter ' . $key . '</option>' . $options . '</select><i></i></label>' => [
                        'class' => 'hasinput smart-form'
                    ]
                ];
            }
        }
        return $filters;
    }

    public function header(Event $event) {
        $headers = $event->subject()['header'];

        if (Language::getLanguages()->count() > 0) {
            $languages = Language::$languages;
            $header_lang = [];
            foreach ($languages as $language) {
                $header_lang[$language->code] = [
                    'label' => $language->name,
                    'sort' => false,
                    'disable_order'=>true,
                    'filter' => 'text',
                    'data-hide' => 'phone,tablet'
                ];
            }

            $h = [];
            foreach ($headers as $key => $header) {
                $h[$key] = $header;
                if ($key == 'msgid') {
                    $h = Hash::merge($h, $header_lang);
                }
            }
            return $h;
        } else {
            return $headers;
        }
    }

    public function addRow(Event $event) {
        $headers = $event->subject()['header'];
        $row = $event->subject()['row'];
        $helper = $event->subject()['helper'];

        $result = $event->subject()['data'];
        if (!empty($event->result)) {
            $result = $event->result;
        }

        $languages = TableRegistry::get('Extensions.Languages')->find('list',['keyField'=>'id','valueField'=>'code'])->where(['status' => 1, 'delete' => 0])->toArray();
        
        foreach ($headers as $key => $field) {
            
            if(in_array($field, $languages)){
                if(count($row->translates) > 0){
                    foreach($row->translates as $translate){
                        if(isset($languages[$translate->language_id]) && $languages[$translate->language_id]==$field){
                            $result[$key] = $translate->msgstr;
                            break;
                        }
                    }
                }
            }
            
            switch ($field) {
                case 'msgid':
                    $result[$key] = $helper->Html->link($row->msgid, ['plugin' => 'Translates', 'controller' => 'Translates', 'action' => 'index', $row->id], ['data-toggle' => 'modal', 'data-target' => '#modal_ajax', 'title' => __d('ittvn', 'Translate') . ': ' . $row->msgid]);
                    break;
            }
        }
        return $result;
    }

}
