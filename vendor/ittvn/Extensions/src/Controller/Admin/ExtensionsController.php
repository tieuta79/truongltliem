<?php

namespace Extensions\Controller\Admin;

use Extensions\Controller\AppController;
use Cake\Event\Event;
use Ittvn\Utility\System;
use Cake\Utility\Hash;
use Settings\Utility\Setting;
use Ittvn\ActivePlugin;
use Cake\Core\Plugin;
/**
 * Themes Controller
 *
 * @property \Themes\Model\Table\ThemesTable $Themes
 */
class ExtensionsController extends AppController {

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        $system = new System();
        $plugins = $system->listPlugin();
        $this->set('plugins', $plugins);
        $this->set('_serialize', ['plugins']);
    }

    public function active($plugin) {
        $plugins = [];
        $this->loadModel('Settings.Settings');
        $setting = $this->Settings->find()->where(['name' => 'Sites.plugins'])->find('network')->first();
        $before_plugin = [];
        if (!empty($setting->value)) {
            $before_plugin = json_decode($setting->value, true);
            $plugins = Hash::merge($before_plugin, [$plugin]);
            $plugins = array_values($plugins);
        } else {
            $plugins[] = $plugin;
        }
        
        $active = $this->loadActiveFile($plugin);
        $active->beforeActive($before_plugin);

        $setting->value = json_encode($plugins);
        $this->Settings->saveNetwork($setting);

        Plugin::load($plugin, ['bootstrap' => true, 'routes' => true]);
        $active->afterActived();

        $this->Flash->success(sprintf(__('Plugin %s has been actived.'), $plugin));
        $this->redirect(['action' => 'index']);
    }

    public function deactive($plugin) {
        $plugins = [];
        $this->loadModel('Settings.Settings');
        $setting = $this->Settings->find()->where(['name' => 'Sites.plugins'])->find('network')->first();
        
        $before_plugin = [];
        if (!empty($setting->value)) {
            $before_plugin = json_decode($setting->value, true);
            foreach ($before_plugin as $k => $p) {
                if ($p == $plugin) {
                    unset($before_plugin[$k]);
                }
            }
            $plugins = $before_plugin;
        }

        $deactive = $this->loadActiveFile($plugin);
        $deactive->beforeDisactive($before_plugin);

        $setting->value = json_encode(array_values($plugins));
        $this->Settings->saveNetwork($setting);
        
        $deactive->afterDisactived();
         
         
        $this->Flash->success(sprintf(__('Plugin %s has been deactived.'), $plugin));
        $this->redirect(['action' => 'index']);
    }

    private function loadActiveFile($plugin) {
        $pathPlugin = ROOT . DS . 'plugins' . DS . $plugin . DS . 'config' . DS . 'active.php';
        $active = null;
        if (file_exists($pathPlugin)) {
            require $pathPlugin;
            $active = new \Active();
        } else {
            $active = new ActivePlugin();
        }
        return $active;
    }

}
