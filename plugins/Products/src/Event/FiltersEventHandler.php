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

class FiltersEventHandler implements EventListenerInterface {

    public function implementedEvents() {
        return [
            'Admin.Forms.Filters.main' => 'formMain',
            'Admin.Forms.Filters.sidebar' => 'formSidebar',
            'Admin.Menus.PostType.afterRender' => 'afterRenderMenus',
        ];
    }

    public function formMain(Event $event) {
        $blocks = $event->subject()['blocks'];
        $helper = $event->subject()['helper'];
        $viewVars = $event->subject()['viewVars'];

        $request = Router::getRequest();

        if (!empty($event->result)) {
            $blocks = $event->result;
        }

        if (isset($viewVars['filter']->id)) {
            if (isset($viewVars['filter']->attributes['status'])) {
                $blocks['default']['f_attributes']['default'] = $viewVars['filter']->attributes['status'];
            }

            if (isset($viewVars['filter']->attributes['price'])) {
                $blocks['default']['price_attributes']['default'] = $viewVars['filter']->attributes['price'];
            }
        }

        return $blocks;
    }

    public function formSidebar(Event $event) {
        $blocks = $event->subject()['blocks'];
        $helper = $event->subject()['helper'];
        $viewVars = $event->subject()['viewVars'];

        $request = Router::getRequest();

        if (!empty($event->result)) {
            $blocks = $event->result;
        }


        $attributes = TableRegistry::get('Products.Attributes')->find()
                ->select(['id', 'name', 'type', 'options'])
                ->where(['status' => 1, 'delete' => 0]);

        if ($attributes->count() > 0) {
            foreach ($attributes as $attribute) {
                if (in_array($attribute->type, ['select', 'radio', 'checkbox'])) {
                    $options = json_decode($attribute->options, true);
                    if (count($options) > 0) {
                        $options = Hash::combine($options, '{n}.key', '{n}.value');
                    }

                    if ($attribute->type == 'select' || $attribute->type == 'radio') {
                        $blocks['box_attributes'][Inflector::slug($attribute->name, '_') . '_attributes'] = [
                            'type' => $attribute->type,
                            'multiple' => true,
                            'hiddenField' => false,
                            'label' => $attribute->name,
                            'name' => 'attributes[attrs][' . $attribute->name . ']',
                            'options' => $options
                        ];
                    } else {
                        $blocks['box_attributes'][Inflector::slug($attribute->name, '_') . '_attributes'] = [
                            'type' => 'select',
                            'multiple' => $attribute->type,
                            'hiddenField' => false,
                            'label' => $attribute->name,
                            'name' => 'attributes[attrs][' . $attribute->name . ']',
                            'options' => $options
                        ];
                    }
                    
                    if (isset($viewVars['filter']->id)) {
                        if (isset($viewVars['filter']->attributes['attrs']) && isset($viewVars['filter']->attributes['attrs'][$attribute->name])) {
                            if ($attribute->type == 'checkbox' || $attribute->type == 'radio') {
                                $blocks['box_attributes'][Inflector::slug($attribute->name, '_') . '_attributes']['default'] = $viewVars['filter']->attributes['attrs'][$attribute->name];
                            }else{
                                $blocks['box_attributes'][Inflector::slug($attribute->name, '_') . '_attributes']['value'] = $viewVars['filter']->attributes['attrs'][$attribute->name];
                            }                            
                        }
                    }                    
                }
            }
        }

        return $blocks;
    }

    public function afterRenderMenus(Event $event) {
        $menus = $event->subject()['menus'];
        $metaType = $event->subject()['metaType'];

        if (!empty($event->result)) {
            $menus = $event->result;
        }

        if ($metaType->slug == 'products') {
            $menus[$metaType->name]['child']['Filters'] = [
                'icon' => 'fa fa-filter',
                'title' => 'Filters',
                'url' => [
                    'plugin' => 'Products',
                    'controller' => 'Filters',
                    'action' => 'index',
                    'prefix' => 'admin'
                ],
            ];
        }
        return $menus;
    }

}
