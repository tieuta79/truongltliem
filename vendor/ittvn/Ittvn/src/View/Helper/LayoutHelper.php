<?php

namespace Ittvn\View\Helper;

use Cake\View\Helper;
use Cake\Console\HelperRegistry;
use Cake\Utility\Hash;
use Cake\View\StringTemplateTrait;
use Cake\Utility\Inflector;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Ittvn\Utility\Upload;
use Settings\Utility\Setting;
use Ittvn\Utility\System;
use Sites\ConfigNetwork;
use Ittvn\Utility\Resize;

class LayoutHelper extends Helper {

    protected $_defaultConfig = [];
    public $helpers = ['Form', 'Html'];
    public $mapHelpers = [
        //Cake Helper
        'Flash', 'Form', 'Html', 'Number', 'Paginator', 'Rss', 'Session', 'Text', 'Time', 'Url',
        //Ittvn Helper
        'Js'
    ];

    public function __call($method, $params) {
        $mapMethods = [
            'meta' => ['Meta.Meta', 'meta'],
        ];

        if (!isset($mapMethods[$method])) {
            trigger_error(__d('ittvn', 'Method %1$s::%2$s does not exist', get_class($this), $method), E_USER_WARNING);
            return;
        }

        $mapped = $mapMethods[$method];
        list($helper, $method) = $mapped;
        list($plugin, $helper) = pluginSplit($helper, true);
        if (!$this->{$helper}) {
            $helpers = new HelperRegistry();
            if (!$helpers->has($helper)) {
                $helpers->load($helper);
            }
            $this->{$helper} = $this->_View->{$helper};
        }
        return call_user_func_array(array($this->{$helper}, $method), $params);
    }

    /**
     * Javascript variables
     *
     * Shows ittvn.js file along with useful information like the applications's basePath, etc.
     *
     * Also merges Configure::read('Js') with the ITTVN js variable.
     * So you can set javascript info anywhere like Configure::write('Js.my_var', 'my value'),
     * and you can access it like 'ITTVN.my_var' in your javascript.
     *
     * @return string
     */
    public function js() {
        //$ittvn = $this->_mergeThemeSettings();
        $configNetwork = new ConfigNetwork();
        $scope = $configNetwork->getCurrentScope();

        $ittvn = [];
        if (!empty($scope)) {
            $ittvn['base_url'] = Router::url('/' . $scope . '/');
        } else {
            $ittvn['base_url'] = Router::url('/');
        }
        $validKeys = array(
            'plugin' => null,
            'controller' => null,
            'action' => null,
            'pass' => null,
            'prefix' => null,
            'query' => null,
        );
        $ittvn['params'] = array_intersect_key(
                array_merge($validKeys, $this->request->params), $validKeys
        );

        $system = new System();
        $system->setVarJs($ittvn);
        //set themeOptions
        $system->setVarJs($this->__mergeThemeOptions());

        return $this->Html->scriptBlock('var ittvn = ' . json_encode(['config' => $system->getVarJs()]) . ';', ['block' => true]);
    }

    public function __mergeThemeOptions() {
        $setting = new Setting();
        $themeOptions = $setting->getOption('Themes.options');
        if (!empty($themeOptions)) {
            $themeOptions = json_decode($themeOptions, true);
            if (isset($themeOptions[$this->theme])) {
                return $themeOptions[$this->theme];
            }
        }
        return [];
    }

    /**
     * Merge helper and prefix specific settings
     *
     * @param array $croogoSetting Croogo JS settings
     * @return array Merged settings
     */
    protected function _mergeThemeOptions($croogoSetting = array()) {
        $themeSettings = $this->Theme->settings();
        if (empty($themeSettings)) {
            return $croogoSetting;
        }
        $validKeys = array(
            'css' => null,
            'icons' => null,
            'iconDefaults' => null,
        );
        $croogoSetting['themeSettings'] = array_intersect_key(
                array_merge($validKeys, $themeSettings), $validKeys
        );

        if ($this->_View->Helpers->loaded('Html')) {
            unset($validKeys['css']);
            $croogoSetting['themeSettings'] = Hash::merge(
                            $croogoSetting['themeSettings'], array_intersect_key(
                                    array_merge($validKeys, $this->_View->Html->settings), $validKeys
                            )
            );
        }
        return $croogoSetting;
    }

    public function screenshot($plugin, $image) {
        $return = '';
        if ($plugin == 'Templates'):
            $return = $this->Html->image('/' . $plugin . '/img/' . $image, ['class' => 'img-responsive thumbnail', 'style' => 'height:185px;']);
        else:
            $path = ROOT . DS . 'plugins' . DS . ucfirst($plugin) . DS . 'webroot' . DS . 'img' . DS . $image;
            if (file_exists($path)) {
                $src = imagecreatefromstring(file_get_contents($path));
                // start buffering
                ob_start();
                imagepng($src);
                $src = ob_get_contents();
                ob_end_clean();
                $return = '<img src="data:image/png;base64,' . base64_encode($src) . '" alt="" class="img-responsive thumbnail" style="height:185px;" />';
            }
        endif;
        return $return;
    }

    public function formatCurrency($currency, $decimals = 0, $dec_point = ',', $thousands_sep = '.') {
        $system = new System();
        $setting = new Setting();
        return $system->formatCurrency($currency, $setting->getThemeOption('symbol_currency'), $setting->getThemeOption('position_symbol_currency'), $decimals, $dec_point, $thousands_sep);
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

    public function stringToUrl($string = null) {
        $url = [];
        if ($string == '#')
            return $string;

        if (!empty($string)) {
            $tmp_urls = explode('/', $string);
            foreach ($tmp_urls as $tmp_url) {
                if (strpos($tmp_url, ':') == true) {
                    $u = explode(':', $tmp_url);
                    if ($u[1] == 'false') {
                        $url[$u[0]] = false;
                    } else {
                        $url[$u[0]] = $u[1];
                    }
                } else {
                    $url[] = $tmp_url;
                }
            }
        }
        return $url;
    }

    public function resizeImage($image, $size = null) {
        $path_file = substr(WWW_ROOT, 0, strlen(WWW_ROOT) - 1) . $image;
        $filename = substr(WWW_ROOT, 0, strlen(WWW_ROOT) - 1) . $image;
        $info_image = pathinfo($path_file);
        $setting = new Setting();
        $upload = new Upload();
        if (empty($size)) {
            $size = $setting->getOption('Images.sizes');
        }

        if (!file_exists($info_image['dirname'] . DS . $upload->pathResize . DS . $info_image['filename'] . '_' . $size . '.' . $info_image['extension'])) {
            return $upload->resizeImage($info_image['dirname'] . DS . $upload->pathResize, $path_file, $filename, $size);
        }

        return str_replace(substr(WWW_ROOT, 0, strlen(WWW_ROOT) - 1), '', $info_image['dirname']) . DS . $upload->pathResize . DS . $info_image['filename'] . '_' . $size . '.' . $info_image['extension'];
    }

    public function Prdashboard() {
        $dashboard = Configure::read('dashboard');
        if (isset($dashboard['left']) && !empty($dashboard['left'])) {
            foreach ($dashboard['left'] as $kl => $left) {
                foreach ($left['links'] as $k => $link) {
                    $result = $this->Html->urlToString($link['url']);
                    if (!$this->Html->checkPermission($link['url'])) {
                        unset($dashboard['left'][$kl]['links'][$k]);
                    }
                }
            }
        }
        //pr($dashboard); die();
        return $dashboard;
    }

}
