<?php

namespace Settings\Utility;

use InvalidArgumentException;
use RuntimeException;
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
use Cake\ORM\TableRegistry;

class Setting {

    private $table = 'Settings.Settings';
    private $group = 'Settings.';

    public function __construct($table = null) {
        if (!empty($table)) {
            $this->table = $table;
        }
        $this->request = Router::getRequest();
    }

    public function config() {
        $this->domainMapping();
        $this->configNetwork();

        $this->Setting = TableRegistry::get($this->table);
        $settings = $this->Setting->find()
                ->select(['name', 'value', 'options', 'type'])
                ->find('network')
                ->where(['delete' => 0, 'global' => 0]);

        //site main
        $globals = $this->Setting->find()
                ->select(['name', 'value', 'options', 'type'])
                ->find('network', ['site' => 'default'])
                ->where(['delete' => 0, 'global' => 1]);

        $configs = $this->dispatchEvent('Settings.afterFindConfig', ['settings' => $settings, 'globals' => $globals, 'group' => $this->group]);

        if (!empty($configs->result)) {
            $settings = isset($configs->result['settings']) ? $configs->result['settings'] : $settings;
            $globals = isset($configs->result['globals']) ? $configs->result['globals'] : $globals;
        }

        if ($settings->count() > 0) {
            foreach ($settings as $setting) {
                if (!Configure::check($this->group . $setting->name)) {
                    Configure::write($this->group . $setting->name, $setting->value);
                } else {
                    Configure::delete($this->group . $setting->name);
                    Configure::write($this->group . $setting->name, $setting->value);
                }
            }
        }

        if ($globals->count() > 0) {
            foreach ($globals as $global) {
                if (!Configure::check($this->group . $global->name)) {
                    Configure::write($this->group . $global->name, $global->value);
                } else {
                    Configure::delete($this->group . $global->name);
                    Configure::write($this->group . $global->name, $global->value);
                }
            }
        }
        $this->dispatchEvent('Settings.afterConfig', ['settings' => Configure::read($this->group), 'group' => $this->group]);
    }

    public function configNetwork() {
        if (Configure::check('Network')) {
            $plugin = Configure::read('Network.plugin');
            $classNetwork = '\\' . $plugin . '\\ConfigNetwork';
            $configNetwork = new $classNetwork();
            $configNetwork->configOtherDb();
            $configNetwork->setDbNetwork();
        }
    }

    public function domainMapping() {
        if (Configure::check('Network')) {
            $plugin = Configure::read('Network.plugin');
            $maindomain = Configure::read('Network.mainDomain');

            $User = TableRegistry::get('Users.Users');
            $domains = TableRegistry::get($plugin . '.Domains')
                    ->find()
                    ->select(['id', 'name', 'site_id'])
                    ->contain([
                        'Sites' => function($q) {
                            return $q->select(['id', 'user_id']);
                        }
                    ])
                    ->formatResults(function($result) use($User, $maindomain) {
                return $result->map(function($row) use($User, $maindomain) {
                            $user = $User->find()->select(['username'])->where(['id' => $row->site->user_id])->first();
                            $row['username'] = $user->username;
                            return $row;
                        });
            });
            $domainMapping = Hash::combine($domains->toArray(), '{n}.name', '{n}.username');
            Configure::write('Network.domainMapping', $domainMapping);
        }
    }

    public function getOptions($names = []) {
        $return = [];
        if (is_array($names)) {
            foreach ($names as $name) {
                $return[$name] = $this->getOption($name);
            }
        }
        return $return;
    }

    public function getOption($name) {
        $value = '';
        if (Configure::check($this->group . $name)) {
            $value = Configure::read($this->group . $name);
        }
        return $value;
    }
    
    public function setOption($name,$value) {
        if (Configure::check($this->group . $name)) {
            return Configure::write($this->group . $value);
        }
        return false;
    }

    public function getThemeOption($name) {
        $value = '';
        if (Configure::check($this->group . 'Themes.options')) {
            $value = Configure::read($this->group . 'Themes.options');
            $value = json_decode($value);
            $currTheme = Configure::read($this->group . 'Themes.site');
            if (isset($value->{$currTheme}) && isset($value->{$currTheme}->{$name})) {
                return $value->{$currTheme}->{$name};
            }
        }
        return '';
    }

    private function dispatchEvent($event, $data = []) {
        $event_result = (new EventManager())->dispatch(new Event($event, $data));
        if (!empty($event_result->result)) {
            return $event_result->result;
        }
        return false;
    }

}
