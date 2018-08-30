<?php

namespace Medias\Controller\Admin;

use Medias\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Hash;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Core\Plugin;
use Settings\Utility\Setting;
/**
 * Themes Controller
 *
 * @property \Themes\Model\Table\ThemesTable $Themes
 */
class FilemanageController extends AppController {

    /**
     * Index method
     *
     * @return void
     */
    public function index($list = null) {
        
        if ($list == 'list') {
            if ($this->request->query('id') != '#') {
                $path = base64_decode($this->request->query('id'));
                $root = new Folder($path);
                //$files = $root->find('.*\.ctp');
                $files = $root->read();
                $tree_view = $this->treeView($files, $path);
            } else {
                $paththeme = Plugin::path((new Setting())->getOption('Themes.site'));
                $root = new Folder($paththeme);
                $files = $root->read();                
                $tree_view = [
                    'text' => 'Root',
                    'id' => '',
                    'icon' => 'folder',
                    'children' => $this->treeView($files, $paththeme),
                    'state' => [
                        'opened' => true,
                    //'disabled' => true
                    ]
                ];
            }
           
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($tree_view);
            die();
        }
    }

    public function treeView($files = [], $path, $deep = 0) {
        $folder = new Folder($path);
        $files[1] = $folder->find('.*\.php|.ctp|.css|.js',true);
        
        $tree = [];
        if (empty($files))
            return [];

        $i = 0;
        if (isset($files[0]) && count($files[0]) > 0) {
            foreach ($files[0] as $subfolder) {
                if (!in_array($subfolder, ['.git', '.svn'])) {
                    $folder->cd($path . DS . $subfolder);
                    $fos = $folder->read();
                    if ((isset($fos[0]) && count($fos[0]) > 0) || (isset($fos[1]) && count($fos[1]) > 0)) {
                        $deep_child = $deep + 1;
                        $tree[$i]['text'] = $subfolder;
                        $tree[$i]['id'] = base64_encode($path . DS . $subfolder);
                        $tree[$i]['icon'] = 'folder';
                        //$tree[$deep]['children'] = $this->treeView($fos, $path . $subfolder, $deep_child);
                        $tree[$i]['children'] = true;
                    } else {
                        $tree[$i]['text'] = $subfolder;
                        $tree[$i]['id'] = base64_encode($path . DS . $subfolder);
                        $tree[$i]['icon'] = 'folder';
                    }
                    $i++;
                }
            }
        }

        if (isset($files[1]) && count($files[1]) > 0) {
            foreach ($files[1] as $file) {
                $f = new File($path . DS . $file);
                if (
                        !in_array($file, ['.gitattributes', '.gitignore', 'composer.lock', 'composer.json', 'phpunit.xml.dist', '.editorconfig']) &&
                        $f->ext() &&
                        !in_array($f->ext(), ['zip', 'rar', 'bat'])
                ) {
                    $tree[$i]['text'] = $file;
                    $tree[$i]['id'] = base64_encode($path . DS . $file);
                    $tree[$i]['type'] = 'file';
                    $tree[$i]['icon'] = 'file file-' . $f->ext();
                    if ($f->perms()==0644) {
                        $tree[$i]['state']['disabled'] = true;
                    }

                    $i++;
                }
            }
        }

        return $tree;
    }

    /**
     * View method
     *
     * @param string|null $id Gallery id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($path = null) {
        $path = base64_decode($path);
        $return = [
            'type' => 'folder',
            'content' => []
        ];
        header('Content-Type: application/json; charset=utf-8');
        if (!empty($path)) {
            //$folder = new Folder($path);
            $file = new File($path);
            if (!$file->exists()) {
                
            } else {
                $return = [
                    'type' => $file->ext(),
                    'content' => $file->read()
                ];
            }
        }

        echo json_encode($return);
        die();
    }
    
    /**
     * save method
     *
     * @param string|null $path.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function save() {
        if($this->request->is('post')){
            $file = new File($this->request->data('path'));
            
            $file->write($this->request->data('content'));
            $file->close();
        }
        die();
    }    

}
