<?php

namespace Themes\Controller\Admin;

use Themes\Controller\AppController;
use Cake\Event\Event;
use Ittvn\Utility\System;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\Core\Plugin;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Settings\Utility\Setting;
use Cake\Core\Configure;

/**
 * Themes Controller
 *
 * @property \Themes\Model\Table\ThemesTable $Themes
 */
class ThemesController extends AppController {

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        $system = new System();
        $themes = $system->themes();
        $this->set('themes', $themes);
        $this->set('_serialize', ['themes']);
    }

    public function add() {
        if ($this->request->is('post')) {
            $info = [
                'name' => 'Template for front end',
                'version' => '1.0'
            ];
            if (count($this->request->data['type']) == 0) {
                $this->Flash->error(__('Please, choose type theme.'));
            } else {
                foreach ($this->request->data['type'] as $type) {
                    $this->request->data[$type] = [
                        'description' => $this->request->data[$type . '_description'],
                        'image' => 'screenshot.png'
                    ];
                }
                unset($this->request->data['site_description']);
                unset($this->request->data['admin_description']);
                unset($this->request->data['type']);
            }
            $info = Hash::merge($info, $this->request->data);
            ksort($info);
            $system = new System();
            if ($system->createPlugin(Inflector::camelize($info['name']), $info, 'template')) {
                //Event after create theme
            }
        }
        $this->redirect($this->referer());
    }

    public function active($type, $plugin) {
        $this->loadModel('Settings.Settings');
        $setting = $this->Settings->find()->where(['name' => 'Themes.' . $type])->find('network')->first();
        $setting->value = $plugin;
        $this->Settings->saveNetwork($setting);
        $this->Flash->success(sprintf(__('Theme %s has been actived.'), $plugin));
        $this->redirect(['action' => 'index']);
    }

    public function delete($theme = null) {
        $this->request->allowMethod(['post', 'delete']);
        $system = new System();
        if ($system->checkPlugin($theme)) {
            $system->deletePlugin($theme);
            $this->Flash->success(__('The theme has been deleted.'));
        } else {
            $this->Flash->error(__('The theme could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function options() {
        $this->loadModel('Settings.Settings');
        $utilytiSetting = new Setting();

        $theme = $utilytiSetting->getOption('Themes.site');

        $setting = $this->Settings->find()->where(['name' => 'Themes.options'])->find('network')->first();
        if ($this->request->is('post')) {
            $value = [];
            if (!empty($setting->value)) {
                $value = json_decode($setting->value, true);
            }
            $data[$theme] = $this->request->data;
            $data = Hash::merge($value, $data);
            $setting->value = json_encode($data);
            $this->Settings->saveNetwork($setting);
        }

        $themeOptions = [];
        if (file_exists(Plugin::path($theme) . 'config' . DS . 'theme_options.php')) {
            Configure::load($theme . '.theme_options', 'default');
        }

        if (Configure::check('Theme.options')) {
            $themeOptions = Configure::read('Theme.options');
        };
        $options = json_decode($setting->value, true);
        
        if (isset($options[$theme])) {
            //$system = new System();
            //$system->setVarJs($options[$theme]);
            if (count($themeOptions) > 0) {
                foreach ($themeOptions as $key => $val) {
					if(isset($val['options']) && count($val['options']) > 0){
						foreach ($val['options'] as $key1 => $opts) {
							if (isset($options[$theme][$key1])) {
								$themeOptions[$key]['options'][$key1]['value'] = $options[$theme][$key1];
							}
						}
					}
                }
                Configure::write('Theme.options', $themeOptions);
            }
        }
    }

}
