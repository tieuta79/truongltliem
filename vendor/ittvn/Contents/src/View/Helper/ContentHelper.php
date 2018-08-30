<?php

namespace Contents\View\Helper;

use Cake\View\Helper;
use Cake\Console\HelperRegistry;
use Cake\Utility\Hash;
use Cake\View\StringTemplateTrait;
use Cake\Utility\Inflector;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Event\EventDispatcherTrait;
use Ittvn\Utility\Shortcode;

class ContentHelper extends Helper {

    use EventDispatcherTrait;

    protected $_defaultConfig = [];
    public $helpers = ['Form', 'Html'];
    private $content = null;
    private $category = null;

    public function __call($method, $params) {
        $Method = Inflector::underscore($method);
        $methods = [];
        if (strpos($Method, '_') == true) {
            $methods = explode('_', Inflector::underscore($method), 3);
        }
        if (count($methods) > 2 && $methods[1] == 'by') {
            $this->autoSet();
            $function = $methods[0] . ucfirst($methods[1]);
            if (method_exists($this, $function) && isset($methods[2])) {
                return $this->{$function}($methods[2], $params);
            }
        }
    }

    private function autoSet() {
        if (empty($this->content) && $this->request->controller == 'Contents' && $this->request->action == 'view' && isset($this->_View->viewVars['content'])) {
            $this->content = $this->_View->viewVars['content'];
        }else if(empty($this->category) && $this->request->controller == 'Categories' && $this->request->action == 'view' && isset($this->_View->viewVars['category'])){
            $this->category = $this->_View->viewVars['category'];
        }
    }

    public function set($content) {
        $this->content = $content;
    }

    public function getBy($field = null, $options = null) {
        $return = null;
        if (!empty($field) && isset($this->content->{$field})) {
            $return = $this->content->{$field};
            if (!empty($options) && !empty($return)) {
                if (is_array($options)) {
                    $options = Hash::flatten($options);
                }
                $return = Hash::get((array) $return, $options);
            }
        }
        
        $return = Shortcode::runs($return);
        
        $event = $this->dispatchEvent('Content.Field.' . $field, ['content' => $return]);
        if ($event->result()) {
            return $event->result();
        }
        return $return;
    }

    public function getLink($title = null, $attributes = []) {
        $return = null;
        $attributes = Hash::merge($attributes, ['escape' => false]);
        $this->autoSet();
        if (!empty($this->content) && isset($this->content)) {
            if (empty($title)) {
                $title = $this->content->name;
            }
            $return = $this->Html->link($title, [
                'plugin' => 'Contents',
                'controller' => 'Contents',
                'action' => 'view',
                'type' => $this->request->type,
                'slug' => $this->content->slug], $attributes);
        }
        return $return;
    }
    
    public function getcatBy($field = null, $options = null) {
        $return = null;
        if (!empty($field) && isset($this->category->{$field})) {
            $return = $this->category->{$field};
            if (!empty($options) && !empty($return)) {
                if (is_array($options)) {
                    $options = Hash::flatten($options);
                }
                $return = Hash::get((array) $return, $options);
            }
        }

        $event = $this->dispatchEvent('Category.Field.' . $field, ['category' => $return]);
        if ($event->result()) {
            return $event->result();
        }
        return $return;
    }    

    public function getCatLink($title = null, $attributes = []) {
        $return = null;
        $attributes = Hash::merge($attributes, ['escape' => false]);
        $this->autoSet();
        if (!empty($this->category) && isset($this->category)) {
            if (empty($title)) {
                $title = $this->category->name;
            }
            $return = $this->Html->link($title, [
                'plugin' => 'Contents',
                'controller' => 'Categories',
                'action' => 'view',
                'type' => $this->request->type,
                'taxonomy' => $this->request->taxonomy,
                'slug' => $this->category->slug], $attributes);
        }
        return $return;
    }    
}
