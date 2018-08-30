<?php

namespace Menus\View\Cell;

use Cake\View\Cell;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\View\View;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Settings\Utility\Setting;
use Cake\Core\App;
use Cake\View\HelperRegistry;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Event\EventManager;
use Cake\Routing\Router;
use Ittvn\Utility\System;




/**
 * Tables cell
 */
class MenusCell extends Cell {

    public $iview = null;
    public $html = null;
    public $helpers = [
        'Html',
        'Ittvn.Layout'
    ];

    public function __construct(Request $request = null, Response $response = null, EventManager $eventManager = null, array $cellOptions = array()) {
        parent::__construct($request, $response, $eventManager, $cellOptions);
        $this->iview = new View();
        $helpers = new HelperRegistry($this->iview);
        $this->html = $helpers->load('Html', []);
    }

    /**
     * 
     * @param type $menutype
     * @param type $options = [
     *      'tags' => [
     *          'prarent'=>'ul', 
     *          'child'=>'li'
     *      ],
     *      'container' => [
     *          'tag'   => 'div',
     *          'attributes' =>'attributes_for_tag'
     *      ]
     * ]
     * @return type string
     */
    public function show($menutype, $options = []) {        
        $options = Hash::merge([
                    'element' => 'menu_item',
                    'attributes' => [],
                    'tags' => [
                        'parent' => 'ul',
                        'child' => 'li'
                    ],
                    'subTags' => [
                        'parent' => 'ul',
                        'child' => 'li'
                    ],
                    'container' => [],
                    'hasChild' => '',
                    'activeClass' => 'active'
                        ], $options);

        $this->loadModel('Menus.Menus');
        $menus = $this->Menus->find('threaded')->find('Network')->where(['menutype_id' => $menutype])->order('order');
        if ($menus->count() == 0) {
            return null;
        }

        $setting = new Setting();
        $template_site = $setting->getOption('Themes.site');

        $paths = [
            App::path('Template/Element', $template_site)[0]
        ];
        $element = 'Menus.' . $options['element'];
        foreach ($paths as $path) {
            if (file_exists($path . $options['element'] . '.ctp')) {
                $element = $template_site . '.' . $options['element'];
            }
        }

        $data_menu = '';
        foreach ($menus as $menu) {
            $data_menu .= $this->childMenus($menu, $element, $options);
        }

        $parentTag = $options['tags']['parent'];
        $parentAttribute = $options['attributes'];
        $data_menu = $this->html->tag($parentTag, $data_menu, $parentAttribute);

        if (count($options['container']) > 0) {
            $containerTag = $options['container']['tag'];
            $containerAttribute = [];
            if (is_array($options['container'])) {
                $containerTag = isset($options['container']['tag']) ? $options['container']['tag'] : $containerTag;
                $containerAttribute = isset($options['container']['attribute']) ? $options['container']['attribute'] : $containerAttribute;
            }
            $data_menu = $this->html->tag($containerTag, $data_menu, $containerAttribute);
        }

        $this->set('data_menu', $data_menu);
    }

    private function childMenus($menu, $element, $options) {
        $item = '';
        $tagChild = is_array($options['tags']['child']) ? $options['tags']['child']['tag'] : $options['tags']['child'];
        $attribute = isset($options['tags']['child']['attribute']) ? $options['tags']['child']['attribute'] : [];
        if (!empty($menu->parent_id)) {
            $tagChild = is_array($options['subTags']['child']) ? $options['subTags']['child']['tag'] : $options['subTags']['child'];
            $attribute = isset($options['subTags']['child']['attribute']) ? $options['subTags']['child']['attribute'] : [];
        }

        $item = $this->iview->element($element, ['menu' => $menu]);

        if (count($menu->children) > 0) {
            $tmp_item = [];
            foreach ($menu->children as $mchild) {
                $tmp_item[] = $this->childMenus($mchild, $element, $options);
            }

            $parentTag = is_array($options['subTags']['parent']) ? $options['subTags']['parent']['tag'] : $options['subTags']['parent'];
            $parentAttribute = isset($options['subTags']['parent']['attribute']) ? $options['subTags']['parent']['attribute'] : [];

            if (!empty($options['hasChild']) && is_array($options['hasChild'])) {
                if (isset($attribute['class']) && isset($options['hasChild']['class'])) {
                    $attribute['class'] .= ' ' . $options['hasChild']['class'];
                    unset($options['hasChild']['class']);
                }
                $attribute = Hash::merge($attribute, $options['hasChild']);
            }
            $item .= $this->html->tag($parentTag, implode('', $tmp_item), $parentAttribute);
        }

        $system = new System();
        if (Router::url($system->stringToUrl($menu->url)) == $this->request->here) {
            if (isset($attribute['class'])) {
                $attribute['class'] .= ' ' . $options['activeClass'];
            }
        }

        return $this->html->tag($tagChild, $item, $attribute);
    }

    public function display($params = [], $form = true) {
        if ($form == true) {
            $this->loadModel('Menus.Menutypes');
            $menutypes = $this->Menutypes->find('list', ['keyField' => 'id', 'valueField' => 'name'])->find('network');
            $this->set('menutypes', $menutypes);
        } else {
            $this->loadModel('Menus.Menus');
            $menus = $this->Menus->find('threaded')->find('network')->select(['id', 'name', 'slug', 'url','parent_id'])->where(['menutype_id' => $params['menutype']])->order('order');
            $this->set('menus', $menus);
        }
        $languages = TableRegistry::get('Extensions.Languages')->find('list', ['keyField' => 'code', 'valueField' => 'name'])->find('network')->where(['status' => 1]);
        $this->set('languages', $languages);
        $this->set('data', $params);
    }

}
