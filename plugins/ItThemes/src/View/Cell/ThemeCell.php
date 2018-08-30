<?php

namespace ItThemes\View\Cell;

use Cake\View\Cell;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Core\Plugin;

/**
 * Theme cell
 */
class ThemeCell extends Cell {

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Default display method.
     *
     * @return void
     */
    public function menuCustomer() {
        $this->loadModel('Users.Logs');
        $log_count = $this->Logs->find()
                ->where(['Logs.user_id' => $this->request->session()->read('Auth.User.id')])
                ->count();

        $this->loadModel('Users.MessagesUsers');
        $message_count = $this->MessagesUsers->find()
                ->where(['MessagesUsers.user_id' => $this->request->session()->read('Auth.User.id')])
                ->count();

        $this->set('log_count', $log_count);
        $this->set('message_count', $message_count);
    }

    public function logCount($user_id = null) {
        $this->loadModel('Users.Logs');
        if (!empty($user_id)) {
            $log_count = $this->Logs->find()
                    ->where(['Logs.user_id' => $user_id])
                    ->count();
        } else {
            $log_count = $this->Logs->find()
                    ->count();
        }
        $this->set('log_count', $log_count);
    }

    public function school_theme($slug = null) {
        $this->loadModel('Contents.Categories');
        $category = $this->Categories->find('list', ['keyField' => 'id', 'valueField' => 'id'])
                ->where(['Categories.slug' => $slug]);

        $this->loadModel('Contents.CategoryContents');
        $contentsIds = $this->CategoryContents->find('list', ['keyField' => 'id', 'valueField' => 'content_id'])
                ->where(['category_id IN' => $category->toArray()]);

        $this->loadModel('Contents.Contents');
        $contents = $this->Contents->find()
                ->select(['Contents.id', 'Contents.name', 'Contents.slug', 'Contents.image', 'Contents.modified'])
                ->contain(['MetaTypes' => function($q) {
                        return $q->select(['id', 'name', 'slug']);
                    }])
                ->where(['Contents.id IN' => $contentsIds->toArray()]);

        $this->set('contents', $contents);
    }

    public function school_theme_detail() {
        $this->loadModel('Contents.Contents');
        $contents = $this->Contents->find()
                ->where(['Contents.slug' => $this->request->slug]);
        $this->set('contents', $contents);
    }

    public function setting_theme() {
        $this->loadModel('Contents.Contents');
        $contents = $this->Contents->find()
                        ->contain(['ContentMetas'])
                        ->where(['Contents.slug' => $this->request->query(['slug'])])->first();
        $this->set('content', $contents);
        
        $this->loadModel('Contents.ContentMetas');
        $contentmeta = $this->ContentMetas->find()
                        ->where(['ContentMetas.key' => 'Database_demo'])->first();
        $this->set('contentmeta', $contentmeta);
        
        $db = ConnectionManager::get('default');
        $siteDb = $db->config()['database'] . '_' . $this->request->session()->read('Auth.User.username');
        $this->loadModel('Settings.Settings');
        $setting = $this->Settings->find('all', array('conditions' => array('Settings.name' => 'Themes.site')))
                        ->select(['Settings.name', 'Settings.value'])
                        ->connection(ConnectionManager::get($siteDb))->first();
        $this->set('setting', $setting);
        

        if (!Plugin::loaded($setting->value)) {
            Plugin::load($setting->value);
        }
        $folder = Plugin::path($setting->value);
        $dir = new Folder();
        $dir->cd($folder);
        $file = $dir->findRecursive('template.json');
        $theme_info = [];
        if (!empty($file)) {
            $file = new File($file[0]);
            $theme_info = json_decode($file->read());
        }
        $this->set('theme_info', $theme_info);
    }

}
