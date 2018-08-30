<?php

namespace Templates\View\Helper;

use Cake\View\Helper\HtmlHelper;
use Cake\Utility\Hash;
use Cake\Network\Request;
use Cake\View\HelperRegistry;
use Acl\View\Helper\AclHelper;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Routing\Router;
use Ittvn\Utility\Network;
use Cake\ORM\TableRegistry;
use Ittvn\Utility\User;
use Settings\Utility\Setting;

class IttvnHtmlHelper extends HtmlHelper {

    public $helpers = ['Url', 'Acl.Acl'];

    public function nestedList(array $list, array $options = [], array $itemOptions = [], $depth = 0) {
        $options += ['tag' => 'ul'];
        $parent_options = [];
        $child_options = [];

        if ($depth == 0) {
            if (isset($options['parent'])) {
                $parent_options = $options['parent'];
                $parent_options += ['tag' => 'ul'];
                $items = $this->_nestedListItem($list, $options, $itemOptions, $depth);
                return $this->formatTemplate($parent_options['tag'], [
                            'attrs' => $this->templater()->formatAttributes($parent_options, ['tag', 'parent', 'child']),
                            'content' => $items
                ]);
            }
        } else {
            if (isset($options['child'])) {
                $child_options = $options['child'];
                $child_options += ['tag' => 'ul'];

                $items = $this->_nestedListItem($list, $options, $itemOptions, $depth);
                return $this->formatTemplate($child_options['tag'], [
                            'attrs' => $this->templater()->formatAttributes($child_options, ['tag', 'parent', 'child']),
                            'content' => $items
                ]);
            }
        }

        $items = $this->_nestedListItem($list, $options, $itemOptions, $depth);
        return $this->formatTemplate($options['tag'], [
                    'attrs' => $this->templater()->formatAttributes($options, ['tag', 'parent', 'child']),
                    'content' => $items
        ]);
    }

    /**
     * Internal function to build a nested list (UL/OL) out of an associative array.
     *
     * @param array $items Set of elements to list.
     * @param array $options Additional HTML attributes of the list (ol/ul) tag.
     * @param array $itemOptions Options and additional HTML attributes of the list item (LI) tag.
     * @return string The nested list element
     * @see HtmlHelper::nestedList()
     */
    protected function _nestedListItem($items, $options, $itemOptions, $depth = 0) {
        //pr($itemOptions);
        $out = '';

        $index = 1;
        foreach ($items as $key => $item) {
            if (is_array($item)) {
                $tmpdepth = $depth + 1;
                $item = $key . $this->nestedList($item, $options, $itemOptions, $tmpdepth);
            }
            $tmp_itemOptions = $itemOptions;
            $class = [];
            $class[] = 'depth-' . $depth;
            if (isset($itemOptions['even']) && $index % 2 === 0) {
                $class[] = $itemOptions['even'];
            } elseif (isset($itemOptions['odd']) && $index % 2 !== 0) {
                $class[] = $itemOptions['odd'];
            }

            if (isset($itemOptions['first']) && $index == 1) {
                $class[] = $itemOptions['first'];
            } else if (isset($itemOptions['last']) && $index == count($items)) {
                $class[] = $itemOptions['last'];
            }

            if (isset($itemOptions['class'])) {
                $class = array_merge((array) $itemOptions['class'], $class);
            }

            $itemOptions['class'] = implode(' ', $class);
            $out .= $this->formatTemplate('li', [
                'attrs' => $this->templater()->formatAttributes($itemOptions, ['even', 'odd', 'first', 'last']),
                'content' => $item
            ]);

            //reset Item Options
            $itemOptions = $tmp_itemOptions;
            $index++;
        }
        return $out;
    }

    public function menusAdmin($tree = null, $options = []) {
        $options = Hash::merge([
                    'ul' => [
                        'parent' => [],
                        'child' => []
                    ],
                    'li' => [
                        'hasChild' => [],
                        'noneChild' => []
                    ],
                    'a' => ['escape' => false]
                        ], $options);

        //Before Render Admin menus
        $result = $this->dispatchEvent('Admin.Menus.beforeRender', ['menus' => $tree, 'options' => $options]);

        if ($result) {
            if (isset($result['options'])) {
                $options = Hash::merge($options, $result['options']);
            }

            if (isset($result['menus'])) {
                $tree = $result['menus'];
            }
        }

        //End Before Render Admin menus
        $out = '';

        if (!empty($tree)) {
            $tree = $this->permissionMenus($tree);
            $tree = Hash::sort($tree, '{s}.priority', 'asc');
            foreach ($tree as $key => $item) {
                $icon = '';
                if (isset($item['icon'])) {
                    $icon = '<i class="' . $item['icon'] . '"></i> ';
                }
                $parent = '';

                $cout = '';
                $active = false;
                if (isset($item['child']) && count($item['child']) > 0) {
                    $parent = ' <span class="fa arrow"></span>';
                    foreach ($item['child'] as $ckey => $citem) {
                        $cicon = '';
                        if (isset($citem['icon'])) {
                            $cicon = '<i class="' . $citem['icon'] . '"></i> ';
                            $clink = $this->link($cicon . '<span class="nav-label">' . __d('ittvn', $citem['title']) . '</span>', $citem['url'], $options['a']);

                            if (Router::url($citem['url']) == $this->request->here) {
                                $active = true;
                                $li = $options['li']['noneChild'];
                                if (isset($li['class'])) {
                                    $li['class'] .= ' active';
                                } else {
                                    $li['class'] = 'active';
                                }
                                $cout .= $this->formatTemplate('li', [
                                    'attrs' => $this->templater()->formatAttributes($li, []),
                                    'content' => $clink
                                ]);
                            } else {
                                $cout .= $this->formatTemplate('li', [
                                    'attrs' => $this->templater()->formatAttributes($options['li']['noneChild'], []),
                                    'content' => $clink
                                ]);
                            }
                        }
                    }
                    if (!empty($cout)) {
                        $cout = $this->formatTemplate('ul', [
                            'attrs' => $this->templater()->formatAttributes($options['ul']['child'], []),
                            'content' => $cout
                        ]);
                    }
                }

                $beforeTitle = '';
                if (isset($item['beforeTitle'])) {
                    $beforeTitle = $item['beforeTitle'];
                }

                $afterTitle = '';
                if (isset($item['afterTitle'])) {
                    $afterTitle = $item['afterTitle'];
                }

                $link = $this->link($icon . $beforeTitle . '<span class="nav-label">' . __d('ittvn', $item['title']) . '</span>' . (!empty($afterTitle) ? $afterTitle : $parent), $item['url'], $options['a']);

                if ($active == true || Router::url($item['url']) == $this->request->here) {
                    if (!empty($cout)) {
                        $li = $options['li']['hasChild'];
                    } else {
                        $li = $options['li']['noneChild'];
                    }

                    if (isset($li['class'])) {
                        $li['class'] .= ' active';
                    } else {
                        $li['class'] = 'active';
                    }

                    $out .= $this->formatTemplate('li', [
                        'attrs' => $this->templater()->formatAttributes($li, []),
                        'content' => $link . (!empty($cout) ? $cout : '')
                    ]);
                } else {
                    $out .= $this->formatTemplate('li', [
                        'attrs' => $this->templater()->formatAttributes((!empty($cout) ? $options['li']['hasChild'] : $options['li']['noneChild']), []),
                        'content' => $link . (!empty($cout) ? $cout : '')
                    ]);
                }
            }
        }
        $out = $this->formatTemplate('ul', [
            'attrs' => $this->templater()->formatAttributes($options['ul']['parent'], []),
            'content' => $out
        ]);

        //After Render Admin menus
        $result = $this->dispatchEvent('Admin.Menus.afterRender', ['menus' => $out]);
        if ($result) {
            if (isset($result['menus'])) {
                $out = Hash::merge($options, $result['menus']);
            }
        }
        //End After Render Admin menus

        return $out;
    }

    public function urlToString($url = []) {
        $string = [];
        if (is_array($url)) {
            if (isset($url['plugin'])) {
                $string[] = $url['plugin'];
            }

            if (isset($url['prefix'])) {
                $string[] = $url['prefix'];
            }

            $string[] = $url['controller'];
            $string[] = $url['action'];
            if (isset($url[0])) {
                $string[] = $url[0];
            }
            return implode('/', $string);
        }
        return $url;
    }

    public function checkPermission($url) {
        if (!empty($url) && $url != '#') {
            $setting = new Setting();
            $role = User::get('role.slug');
            if (!User::checkLoginMainDomain()) {       
                return true;
            }
            
            if ($role != $setting->getOption('Users.fullPermission')) {
                $urlToString = $this->urlToString($url);
                $user = User::get('username');
                if (!$this->Acl->check($user, $urlToString)) {
                    if (!$this->Acl->check($role, $urlToString)) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    public function permissionMenus($menus = []) {
        foreach ($menus as $key => $item) {
            if (isset($item['child']) && count($item['child']) > 0) {
                foreach ($item['child'] as $ckey => $citem) {
                    //Check ACL link
                    if (!$this->checkPermission($citem['url'])) {
                        //pr($menus[$key]['child'][$ckey]);
                        unset($menus[$key]['child'][$ckey]);
                    }
                }
            } else {
                //Check ACL link
                if (!$this->checkPermission($item['url'])) {
                    unset($menus[$key]);
                }
            }
        }

        foreach ($menus as $key => $menu) {
            if (isset($menu['child']) && count($menu['child']) == 0) {
                unset($menus[$key]);
            }
        }

        return $menus;
    }

    public function dispatchEvent($event, $data = []) {
        $eventManager = new EventManager();
        $result = $eventManager->dispatch(new Event($event, $data));
        if ($result) {
            return $result->result;
        }
        return false;
    }

}
