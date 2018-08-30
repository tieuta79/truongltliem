<?php

namespace Ittvn\Utility;

use InvalidArgumentException;
use RuntimeException;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Plugin;
use Cake\Core\App;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\View\View;
use Cake\ORM\TableRegistry;
use Settings\Utility\Setting;

class System {

    public $multipleLang = false;

    public function __construct() {
        if ($this->getlanguages(true) > 1) {
            $this->multipleLang = true;
        }
        $this->request = Router::getRequest();
    }

    public function plugins($fullpath = false, $type = 'all') {
        $plugins = [];
        $list_plugins = Plugin::loaded();
        foreach ($list_plugins as $k => $plugin) {
            $pathPlugin = Plugin::path($plugin);
            if (strpos($pathPlugin, 'vendor')) {
                $plugins['system'][] = [
                    'name' => $plugin,
                    'path' => $pathPlugin
                ];
            } else {
                $plugins['dev'][] = [
                    'name' => $plugin,
                    'path' => $pathPlugin
                ];
            }
        }

        $extract_path = $fullpath == false ? 'name' : 'path';
        $extract_type = $type == 'all' ? '{s}' : $type;
        $plugins = Hash::extract($plugins, $extract_type . '.{n}.' . $extract_path);

        return $plugins;
    }

    public function listPlugin($type = 'plugin') {
        $plugins = ['active' => [], 'deactive' => []];

        $plugins['active'] = $this->plugins(false, 'dev');

        $plugin_path = ROOT . DS . 'plugins';
        $dir = new Folder($plugin_path);
        $all_plugins = $dir->read(true, false, false)[0];
        foreach ($all_plugins as $all_plugin) {
            if (!in_array($all_plugin, $plugins['active'])) {
                $dir->cd($plugin_path . DS . $all_plugin);
                $json_p = $dir->findRecursive($type . '.json');
                if (count($json_p) > 0) {
                    $file_infor = new File($json_p[0]);
                    $plugins['deactive'][$all_plugin] = json_decode($file_infor->read());
                }
            }
        }

        $active = [];
        foreach ($plugins['active'] as $plugin_active) {
            $plugin_path = Plugin::path($plugin_active);
            $dir->cd($plugin_path);
            $json_p = $dir->findRecursive($type . '.json');
            if (count($json_p) > 0) {
                $file_infor = new File($json_p[0]);
                $active[$plugin_active] = json_decode($file_infor->read());
            }
            $plugins['active'] = $active;
        }
        return $plugins;
    }

    public function listModel($type = 'all') {
        $models = [];
        $prefix_file_table = 'Table.php';
        //get list tables
        $tables = $this->allTables();
        foreach ($tables as $k => $table) {
            $tables[$k] = Inflector::camelize($table) . $prefix_file_table;
        }
        //get list plugins
        $plugins = $this->plugins(false, $type);
        $dir = new Folder();
        foreach ($plugins as $plugin) {
            $pathTable = App::path('Model/Table', $plugin)[0];
            $dir->cd($pathTable);
            $files = $dir->find('^.*\Table.php');
            foreach ($files as $file) {
                //get model loaded
                if (in_array($file, $tables)) {
                    $table_name = str_replace($prefix_file_table, '', $file);
                    $models[$table_name] = $table_name;
                }
            }
        }
        return $models;
    }

    public function themes() {
        $plugins = Plugin::loaded();

        $dir = new Folder();
        $themes = ['site' => [], 'admin' => []];
        if (count($plugins) > 0) {
            foreach ($plugins as $key => $plugin) {
                $folder = Plugin::path($plugin);

                $dir->cd($folder);
                $file = $dir->findRecursive('template.json');
                if (!empty($file)) {
                    $file = new File($file[0]);
                    $theme_info = json_decode($file->read());
                    if (isset($theme_info->site) && $theme_info->site == true) {
                        $themes['site'][$plugin] = $theme_info;
                    }

                    if (isset($theme_info->admin) && $theme_info->admin == true) {
                        $themes['admin'][$plugin] = $theme_info;
                    }
                }
            }
        }

        $theme_in_folder_plugins = $this->listPlugin('template');
        foreach ($theme_in_folder_plugins as $plugins) {
            if (count($plugins) > 0) {
                foreach ($plugins as $plugin => $theme_info) {
                    //$plugin = strtolower($plugin);
                    if (isset($theme_info->site) && $theme_info->site == true) {
                        $themes['site'][$plugin] = $theme_info;
                    }

                    if (isset($theme_info->admin) && $theme_info->admin == true) {
                        $themes['admin'][$plugin] = $theme_info;
                    }
                }
            }
        }

        return $themes;
    }

    public function allTables() {
        $db = ConnectionManager::get('default');
        if (!method_exists($db, 'schemaCollection')) {
            return [];
        }
        $schema = $db->schemaCollection();
        $tables = $schema->listTables();
        if (empty($tables)) {
            return [];
        }
        sort($tables);
        return $tables;
    }

    public function modelsContentTypes() {
        $contentTypes = Configure::read('Settings.ModelsContentTypes');
        $result = $this->dispatchEvent('ContentTypes.modelsContentTypes', ['contentTypes' => $contentTypes]);
        if ($result) {
            $contentTypes = $result;
        }
        return $contentTypes;
    }

    public function modelsContentType($type = null) {
        if (!empty($type)) {
            $contentTypes = $this->modelsContentTypes();
            if (isset($contentTypes[$type])) {
                $result = $this->dispatchEvent('ContentTypes.modelsContentType', ['contentType' => $contentTypes[$type]]);
                if ($result) {
                    $contentTypes[$type] = $result;
                }
                return $contentTypes[$type];
            }
        }
        return false;
    }

    public function modelsExtraFields() {
        $extraFields = Configure::read('Settings.ModelsExtraFields');
        $result = $this->dispatchEvent('ExtraFields.modelsExtraFields', ['extraFields' => $extraFields]);
        if ($result) {
            $extraFields = $result;
        }
        return $extraFields;
    }

    public function modelsExtraField($field = null) {
        if (!empty($field)) {
            $extraFields = $this->modelsExtraFields();
            if (isset($extraFields[$field])) {
                $result = $this->dispatchEvent('ExtraFields.modelsExtraField', ['contentType' => $extraFields[$field]]);
                if ($result) {
                    $extraFields[$field] = $result;
                }
                return $extraFields[$field];
            }
        }
        return false;
    }

    public function setVarJs($vars = []) {
        $defaultJs = [];
        $defaultJs = $this->getVarJs();
        $varJs = Hash::merge($defaultJs, $vars);
        Configure::write('Js', $varJs);
    }

    public function getVarJs() {
        if (Configure::check('Js')) {
            return Configure::read('Js');
        }
        return [];
    }

    public function checkPlugin($name) {
        $all_plugins = Plugin::loaded();

        $plugin_path = ROOT . DS . 'plugins';
        $dir = new Folder($plugin_path);
        $plugin_dev = $dir->read(true, false, false)[0];

        foreach ($plugin_dev as $plugin) {
            if (!in_array($plugin, $all_plugins)) {
                $all_plugins[] = $plugin;
            }
        }

        if (in_array(ucfirst($name), $all_plugins)) {
            return true;
        }
        return false;
    }

    public function activeThemeChild($theme, $db) {
        $configDefault = ConnectionManager::get('default')->config();
        $siteDb = $configDefault['database'] . '_' . $db;         
        
        $Setttings = TableRegistry::get('Settings.Settings');
        $Setttings->connection(ConnectionManager::get($siteDb));
        $Setttings->updateAll([
            'value' => $theme
                ], [
            'name' => 'Themes.site'
        ]);
    }
    
    public function deleteThemeChild($prefix) {
        $folder = new Folder(ROOT.DS.'plugins');
        $folders = $folder->read(true,true,true);
        if(count($folders[0]) > 0){
            foreach($folders[0] as $fo){
                if(strpos($fo, ucfirst($prefix))){
                    $th = explode(DS, $fo);
                    
                    $this->modifiedComposer(end($th),false);
                    $this->modifiedCakePlugins(end($th),false);
                    $this->modifiedAutoload(end($th),false);
                    
                    $folder->delete($fo);
                }
            }
        }
    }

    public function themeChild($theme = null, $prefix) {
        if (empty($theme)) {
            $setting = new Setting();
            $theme = $setting->getOption('Sites.theme_default');
        }
        if (!Plugin::load($theme)) {
            Plugin::load($theme);
        }
        $newTheme = Inflector::camelize($prefix . '_' . $theme);
        $pathTheme = Plugin::path($theme);
        $pathThemeChild = str_replace($theme, $newTheme, $pathTheme);

        $folder = new Folder($pathTheme);
        $folder->copy([
            'to' => $pathThemeChild,
            'mode' => 0755
        ]);


        $folder->cd($pathThemeChild);
        $files = $folder->find('template.json');

        $file = new File($folder->pwd() . $files[0]);
        $info = json_decode($file->read(), true);
        $info['name'] = __d('ittvn', 'Theme Child of ') . $info['name'];
        $file->write(json_encode($info, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n");
        $file->owner();
        $file->close();

        $this->modifiedComposer($newTheme);
        $this->modifiedCakePlugins($newTheme);
        $this->modifiedAutoload($newTheme);

        return $newTheme;
    }

    public function createPlugin($pluginName, $info = [], $type = 'plugin') {
        if (!$this->checkPlugin($pluginName)) {
            return false;
        }

        $plugin_path = ROOT . DS . 'plugins';
        $dir = new Folder($plugin_path);

        $namespace = str_replace('/', '\\', $pluginName);
        $name = $pluginName;
        $vendor = 'your-name-here';
        if (strpos($pluginName, '/') !== false) {
            list($vendor, $name) = explode('/', $pluginName);
        }
        $package = $vendor . '/' . $name;
        $search = ['$package', '$namespace', '$plugin', '$routePath', '$path', '$root', '<%= '];
        $replace = [$package, $namespace, $pluginName, Inflector::dasherize($pluginName), '', ROOT, ''];

        $autoloadPath = '';
        $plugin = '';

        $path_source = ROOT . DS . 'vendor' . DS . 'cakephp' . DS . 'bake' . DS . 'src' . DS . 'Template' . DS . 'Bake' . DS . 'Plugin';

        $dir->copy([
            'to' => $plugin_path . DS . $pluginName,
            'from' => $path_source,
            'mode' => 0755,
            'skip' => ['.git', '.svn'],
            'scheme' => Folder::SKIP
        ]);

        $dir->cd($plugin_path . DS . $pluginName);
        $files = $dir->findRecursive('.*\.ctp');

        foreach ($files as $file) {
            $tmp_file = str_replace('.ctp', '', $file);
            rename($file, $tmp_file);
            $File = new File($tmp_file, true);
            $File->replaceText($search, $replace);
            $content = preg_replace("/<%(.+?)[\s]*\/?[\s]*%>/si", "", $File->read());
            $content = trim(str_replace(' %>', '', $content));
            $File->write($content);
            $File->owner();
            $File->close();
        }

        if ($type == 'template') {
            if (file_exists($plugin_path . DS . $pluginName . DS . 'plugin.json')) {
                unlink($plugin_path . DS . $pluginName . DS . 'plugin.json');
            }

            $File = new File($plugin_path . DS . $pluginName . DS . $type . '.json', true, 0755);
            $File->write(json_encode($info, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n");
            $File->owner();
            $File->close();
        }

        $this->modifiedComposer($pluginName);
        $this->modifiedCakePlugins($pluginName);
        $this->modifiedAutoload($pluginName);

        return true;
    }

    public function deletePlugin($pluginName) {
        $this->modifiedComposer($pluginName, false);
        $this->modifiedCakePlugins($pluginName, false);
        $this->modifiedAutoload($pluginName, false);

        $plugin_path = ROOT . DS . 'plugins' . DS . $pluginName;
        $dir = new Folder($plugin_path);
        $dir->delete();
    }

    public function modifiedComposer($pluginName, $add = true) {
        $path_composer = ROOT . DS . 'composer.json';
        $config = json_decode(file_get_contents($path_composer), true);

        if ($add == true) {
            $config['autoload']['psr-4'][$pluginName . '\\'] = "./plugins/" . $pluginName . "/src";
            $config['autoload-dev']['psr-4'][$pluginName . '\\Test\\'] = "./plugins/" . $pluginName . "/tests";
        } else {
            unset($config['autoload']['psr-4'][$pluginName . '\\']);
            unset($config['autoload-dev']['psr-4'][$pluginName . '\\Test\\']);
        }

        $contents = json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
        file_put_contents($path_composer, $contents);
    }

    public function modifiedCakePlugins($pluginName, $add = true) {
        $path_cakephp_plugins = ROOT . DS . 'vendor' . DS . 'cakephp-plugins.php';
        $config = include $path_cakephp_plugins;

        if ($add == true) {
            $config['plugins'][$pluginName] = ROOT . DS . '/plugins/' . $pluginName . '/';
        } else {
            unset($config['plugins'][$pluginName]);
        }
        ksort($config['plugins']);
        $data = '';
        foreach ($config['plugins'] as $name => $pluginPath) {
            $data .= sprintf("        '%s' => '%s',\n", $name, $pluginPath);
        }
        $contents = <<<PHP
<?php
\$baseDir = dirname(dirname(__FILE__));
return [
    'plugins' => [
$data
    ]
];

PHP;
        $root = str_replace('\\', '/', ROOT);
        $contents = str_replace('\'' . $root, '$baseDir . \'', $contents);
        file_put_contents($path_cakephp_plugins, $contents);
    }

    public function modifiedAutoload($pluginName, $add = true) {
        $vendorDir = ROOT . DS . 'vendor';
        $path_autoload = ROOT . DS . 'vendor' . DS . 'composer' . DS . 'autoload_psr4.php';
        $config = include $path_autoload;

        if ($add == true) {
            $config[$pluginName . '\\Test\\'] = [ROOT . '/plugins/' . $pluginName . '/tests'];
            $config[$pluginName . '\\'] = [ROOT . '/plugins/' . $pluginName . '/src'];
        } else {
            unset($config[$pluginName . '\\Test\\']);
            unset($config[$pluginName . '\\']);
        }
        krsort($config);
        $data = '';
        $i = 0;
        $count = count($config);
        foreach ($config as $namespace => $pluginPath) {
            if ($i == ($count - 1)) {
                $data .= sprintf("    '%s' => array('%s'),", $namespace, $pluginPath[0]);
            } else {
                $data .= sprintf("    '%s' => array('%s'),\n", $namespace, $pluginPath[0]);
            }
            $i++;
        }
        $contents = <<<PHP
<?php

// autoload_psr4.php @generated by Composer

\$vendorDir = dirname(dirname(__FILE__));
\$baseDir = dirname(\$vendorDir);
                
return array(
$data
);
PHP;
        $root = str_replace('\\', '/', ROOT);
        $contents = str_replace('\\', '\\\\', $contents);
        $contents = str_replace('\'' . $vendorDir, '$vendorDir . \'', $contents);
        $contents = str_replace('\'' . $root, '$baseDir . \'', $contents);
        file_put_contents($path_autoload, $contents);
    }

    public function addModule($method, $name, $params = []) {
        if (!Configure::check('modules')) {
            Configure::write('modules', []);
        }
        $modules = Hash::merge(Configure::read('modules'), [$method => ['name' => __d('ittvn', $name), 'params' => $params]]);
        Configure::write('modules', $modules);
    }

    public function modules() {
        return Configure::read('modules');
    }

    public function getModule($slug = null) {
        $blocks = [];
        if (Configure::check('Blocks')) {
            $blocks = Configure::read('Blocks');
        }
        if (!empty($slug) && in_array($slug, $blocks)) {
            $return = '';
            $block = TableRegistry::get('Blocks.Blocks')->findBySlug($slug)->find('network')->select(['id', 'name', 'slug', 'before_block', 'after_block', 'before_title', 'after_title', 'cells']);
            if ($block->count()) {
                $block = $block->first();
                $cells = json_decode($block->cells, true);
                unset($block->cells);

                $view = new View();
                if (count($cells) > 0) {
                    foreach ($cells as $cell) {
                        $cell['params']['block'] = $block;
                        if (isset($cell['params']['layout'])) {
                            $view_cell = $view->cell($cell['cell'], ['params' => $cell['params'], 'form' => false]);
                            if (strpos($cell['params']['layout'], '.') == true) {
                                $tmp = explode('.', $cell['params']['layout']);
                                $view_cell->plugin = $tmp[0];
                                $view_cell->template = $tmp[1];
                            } else {
                                $setting = new Setting();
                                $theme = $setting->getOption('Themes.site');
                                $tmp_cell = explode('::', $cell['cell']);
                                $action = $tmp_cell[1];
                                $tmp_cell = explode('.', $tmp_cell[0]);
                                $path_cells = [
                                    $theme => App::path('Template', $theme)[0],
                                    $tmp_cell[0] => App::path('Template', $tmp_cell[0])[0]
                                ];
                                foreach ($path_cells as $key => $path_cell) {
                                    if (empty($cell['params']['layout'])) {
                                        $cell['params']['layout'] = $action;
                                    }
                                    $check_path_cell = $path_cell . 'Cell' . DS . $tmp_cell[1] . DS . $cell['params']['layout'] . '.ctp';
                                    if (file_exists($check_path_cell)) {
                                        $view_cell->plugin = $key;
                                        $view_cell->template = $cell['params']['layout'];
                                        break;
                                    }
                                }
                            }
                            $return .= $view_cell;
                        } else {
                            $return .= $view->cell($cell['cell'], ['params' => $cell['params'], 'form' => false]);
                        }
                    }
                }
            }
            return $return;
        }
    }

    public function slug($str, $delimiter = '-') {
        $str = trim(mb_strtolower($str));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/([\s]+)/', $delimiter, $str);
        return $str;
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

    public function formatCurrency($currency, $symbol = '', $position = 0, $decimals = 0, $dec_point = ',', $thousands_sep = '.') {
        $currency = intval(trim($currency));
        $delimited = ' ';
        if ($position == 1) {
            $return = '<sup>' . $symbol . '</sup>' . $delimited . number_format($currency, $decimals, $dec_point, $thousands_sep);
        } else {
            $return = number_format($currency, $decimals, $dec_point, $thousands_sep) . $delimited . '<sup>' . $symbol . '</sup>';
        }
        return $return;
    }

    public function generateRandomString($length = 10, $type = 0) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($type == 1) {
            $characters = '0123456789';
        } else if ($type == 2) {
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }

        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function dispatchEvent($event, $data = []) {
        $event_result = (new EventManager())->dispatch(new Event($event, $data));
        if (!empty($event_result->result)) {
            return $event_result->result;
        }
        return false;
    }

    public function getlanguages($count = false) {
        //all language in active
        $languages = TableRegistry::get('Extensions.Languages')->find()->find('network')->where(['status' => 1]);
        if ($count == false) {
            if ($languages == false) {
                return [];
            } else {
                return $languages;
            }
        } else {
            if ($languages == false) {
                return 0;
            } else {
                return $languages->count();
            }
        }
    }

    public function getlanguage($code = 'vi') {
        $language = TableRegistry::get('Extensions.Languages')->find()->find('network')->where(['code' => $code]);
        return $language;
    }

    public function getcurentlanguage() {
        $default_lang = ini_get('intl.default_locale');
        return $default_lang;
    }

    public function setlanguage() {
        //kiem tra request url co param ko
        //if($this->request)
        ini_set('intl.default_locale', 'vi');
    }

    public function acoscover($aco = null, $length, $name = null) {
        $params = null;
        $result = [];
        $acos = explode('/', $aco);
        if (count($acos) > $length) {
            if ($length == 5) {
                $arr_aco = [
                    $acos[0], $acos[1], $acos[2], $acos[3], $acos[4]
                ];
                $aco = implode('/', $arr_aco);
            } else {
                $arr_aco = [
                    $acos[0], $acos[1], $acos[2], $acos[3]
                ];
                if ($name == 'check') {
                    $aco = 'controllers/' . implode('/', $arr_aco);
                } else {
                    $aco = implode('/', $arr_aco);
                }
            }
            for ($i = $length; $i < count($acos); $i++) {
                $params[] = $acos[$i];
            }
            $params = json_encode($params);
        }
        $result['url'] = $aco;
        $result['params'] = $params;
        return $result;
    }
    
 public function deleteAllPermissionTable($slug){
        $settings = new Setting();
        $values = json_decode($settings->getOption('Users.permission'), true);
        $arr_key = [];
        if (Configure::check('Network.db')) {
            $connection = ConnectionManager::get(Configure::read('Network.db'));
        }
        $Permissions = TableRegistry::get('Acl.Permissions');
        $aroAcos = $Permissions->find('list', ['keyField' => 'id', 'valueField' => 'id'])->find('network')->where(['params LIKE' => '%"' . $slug . '"%']);
        if ($aroAcos->count() > 0) {
            foreach ($aroAcos as $aroAco) {
                $p = $Permissions->get($aroAco);
                $Permissions->deleteNetwork($p);
            }
        }
        $setting = TableRegistry::get('Settings.Settings');
        foreach ($values['Admin'] as $key => $value) {
            $tmp = explode('/', $value[0]);
            if (end($tmp) == $slug){
                $arr_key[$key] = $key;
                unset($values['Admin'][$key]);
            }
        }
        if (count($arr_key) > 0) {
            foreach ($arr_key as $v) {
                if (count($values['Selected']) > 0) {
                    foreach ($values['Selected'] as $kv => $vs) {
                        if (count($vs) > 0) {
                            foreach ($vs as $kv_c => $vs_child) {
                                if (array_search($v, $vs_child)) {
                                    unset($values['Selected'][$kv][$kv_c][array_search($v, $vs_child)]);
                                }
                            }
                        }
                    }
                } else {
                    if (count($values['SelectedPermission']) > 0) {
                        foreach ($values['SelectedPermission']['Admin'] as $kv => $vs) {
                            if (count($vs) > 0) {
                                foreach ($vs as $kv_c => $vs_child) {
                                    if (array_search($v, $vs_child)) {
                                        unset($values['SelectedPermission']['Admin'][$kv][$kv_c][array_search($v, $vs_child)]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }        
        $setting->updateAllNetwork([
            'value' => json_encode($values)
                ], [
            'name' => 'Users.permission'
        ]);
    }    

}
