<?php

namespace Extensions\Controller\Admin;

use Extensions\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
use Cake\Collection\Collection;
use Cake\Core\Configure;
use ZipArchive;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Ittvn\Utility\Network;
use Settings\Utility\Setting;
use Ittvn\Utility\System;

/**
 * Themes Controller
 *
 * @property \Themes\Model\Table\ThemesTable $Themes
 */
class ToolsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Ittvn.Zip');
    }

    public function exportdata($models = 'Contents') {

        $this->loadModel('Metas.MetaTypes');
        $CategoryMetas = TableRegistry::get('Contents.CategoryMetas');
        $Categories = TableRegistry::get('Contents.Categories');
        $this->loadModel('Blocks.Blocks');
        $this->loadModel('Menus.Menus');
        if ($this->request->is('post')) {
            //begin export content 
            if ($this->request->data['exportdata'] == 'Contents') {
                $contents = $this->MetaTypes->find()
                    ->select(['id', 'name', 'slug', 'icon', 'description', 'model', 'category', 'multi_category', 'menu', 'delete', 'options'])
                    ->contain([
                        'Contents' => function($qco) {
                            return $qco->contain(['ContentMetas' => function($qcom) {
                                    return $qcom->select(['id', 'content_id', 'key', 'value']);
                                },
                                'Categories' => function($qcc) {
                                    return $qcc->select(['slug']);
                                }
                            ])->select(['id', 'name', 'slug', 'excerpt', 'description', 'image', 'hits', 'meta_type_id', 'delete', 'featured', 'status']);
                        },
                        'MetaCategories' => function($qmca) use($CategoryMetas, $Categories) {
                            return $qmca->contain(['Categories' => function($qca) use($CategoryMetas, $Categories) {
                                return $qca->find('threaded')->select(['id', 'name', 'slug', 'description', 'parent_id', 'lft', 'rght', 'delete', 'meta_category_id'])->formatResults(function($result) use($CategoryMetas, $Categories) {
                                    return $result->map(function($row) use($CategoryMetas, $Categories) {
                                            if (isset($row->parent_id) && !empty($row->parent_id)) {
                                                $parent_id = $Categories->find()->select(['Categories.id', 'Categories.slug'])->where(['Categories.id' => $row->parent_id]);
                                                if ($parent_id->count() > 0) {
                                                    $row['parent_id'] = $parent_id->first()->slug;
                                                } else {
                                                    $row['parent_id'] = '';
                                                }
                                            }

                                            $categoryMeta = $CategoryMetas->find()->select(['id', 'category_id', 'key', 'value'])->where(['category_id' => $row->id]);
                                            if ($categoryMeta->count() > 0) {
                                                $row['categoryMeta'] = $categoryMeta->toArray();
                                            } else {
                                                $row['categoryMeta'] = [];
                                            }
                                            return $row;
                                        });
                                    });
                            }])->select(['id', 'name', 'slug', 'description', 'meta_type_id', 'delete']);
                        }
                    ])
                    ->where(['id IN' => $this->request->data['Contents']]);

                $folder = new Folder();
                $file = new File(TMP);
                $folder->delete(TMP . 'backup');

                $contents = (new Collection($contents))->map(function($c) use($folder, $file) {
                    if (isset($c->id)) {
                        unset($c->id);
                    }

                    if (isset($c->meta_categories) && count($c->meta_categories) > 0) {
                        foreach ($c->meta_categories as $kmc => $rmc) {

                            if (isset($rmc->id)) {
                                unset($c->meta_categories[$kmc]->id);
                            }

                            if (isset($rmc->meta_type_id)) {
                                unset($c->meta_categories[$kmc]->meta_type_id);
                            }

                            if (isset($rmc->categories) && count($rmc->categories) > 0) {
                                foreach ($rmc->categories as $kmcc => $rmcc) {
                                    if (isset($c->meta_categories[$kmc]->categories[$kmcc]->id)) {
                                        unset($c->meta_categories[$kmc]->categories[$kmcc]->id);
                                        unset($c->meta_categories[$kmc]->categories[$kmcc]->meta_category_id);
                                        
                                        if(isset($rmcc->children) && count($rmcc->children) > 0){
                                            //pr($rmcc->children); die();
                                            foreach ($rmcc->children as $kccchi => $rccchi) {
                                                if(isset($c->meta_categories[$kmc]->categories[$kmcc]->children[$kccchi]->id)){
                                                    unset($c->meta_categories[$kmc]->categories[$kmcc]->children[$kccchi]->id);
                                                }
                                                if(isset($c->meta_categories[$kmc]->categories[$kmcc]->children[$kccchi]->meta_category_id)){
                                                    unset($c->meta_categories[$kmc]->categories[$kmcc]->children[$kccchi]->meta_category_id);
                                                }
                                                if(isset($c->meta_categories[$kmc]->categories[$kmcc]->children[$kccchi]->parent_id)){
                                                    unset($c->meta_categories[$kmc]->categories[$kmcc]->children[$kccchi]->parent_id);
                                                }
                                            }
                                        }
                                        
                                        if (isset($rmcc->categoryMeta) && count($rmcc->categoryMeta) > 0) {
                                            foreach ($rmcc->categoryMeta as $kcm => $rcm) {
                                                if (isset($c->meta_categories[$kmc]->categories[$kmcc]->categoryMeta[$kcm]->id)) {
                                                    unset($c->meta_categories[$kmc]->categories[$kmcc]->categoryMeta[$kcm]->id);
                                                }

                                                if (isset($c->meta_categories[$kmc]->categories[$kmcc]->categoryMeta[$kcm]->category_id)) {
                                                    unset($c->meta_categories[$kmc]->categories[$kmcc]->categoryMeta[$kcm]->category_id);
                                                }

                                                $c->meta_categories[$kmc]->categories[$kmcc]->categoryMeta[$kcm] = $rcm->toArray();
                                            }
                                        }
                                    }
                                    $c->meta_categories[$kmc]->categories[$kmcc] = Hash::remove($rmcc->toArray(), 'parent_id');
//                                    pr($c);
//                                    die();
                                }
                            }
                            $c->meta_categories[$kmc] = $rmc->toArray();
                            $files[$kmc] = $c->meta_categories[$kmc];
                        }
                    }

                    if (isset($c->contents) && count($c->contents) > 0) {
                        foreach ($c->contents as $k => $rc) {
                            if (isset($rc->id)) {
                                unset($c->contents[$k]->id);
                            }

                            if (isset($rc->meta_type_id)) {
                                unset($c->contents[$k]->meta_type_id);
                            }

                            if (isset($rc->categories) && count($rc->categories) > 0) {
                                foreach ($rc->categories as $kc => $rca) {
                                    if (isset($c->contents[$k]->categories[$kc]->_joinData)) {
                                        unset($c->contents[$k]->categories[$kc]->_joinData);
                                        $c->contents[$k]->categories[$kc] = $rca->toArray();
                                        $c->contents[$k]->categories[$kc]['category_id'] = $c->contents[$k]->categories[$kc]['slug'];
                                        unset($c->contents[$k]->categories[$kc]['slug']);
                                        $c->contents[$k]->categories[$kc]['content_id'] = $c->contents[$k]->slug;
                                    }
                                }
                            }

                            if (isset($rc->content_metas) && count($rc->content_metas) > 0) {
                                foreach ($rc->content_metas as $kcm => $rcm) {
                                    unset($c->contents[$k]->content_metas[$kcm]->id);
                                    unset($c->contents[$k]->content_metas[$kcm]->content_id);
                                    $c->contents[$k]->content_metas[$kcm] = $rcm->toArray();
                                }
                            }

                            $c->contents[$k] = $rc->toArray();

                            if (isset($rc->image) && !empty($rc->image)) {
                                $paths = explode('/', $rc->image);
                                $filename = $paths[count($paths) - 1];
                                $path = TMP . 'backup' . str_replace($filename, '', $rc->image);
                                $file->path = ROOT . DS . 'webroot' . $rc->image;
                                $folder->create($path);
                                $folder->chmod(TMP . 'backup', 0777, true);
                                $folder->cd($path);
                                if ($file->exists()) {
                                    $file->copy($path . $filename, false);
                                    //echo ROOT.DS.'webroot' .$rc->image.'===>'.$path.$filename;
                                }
                            }
                        }
                    }

                    return $c->toArray();
                });
                //pr($contents->toArray()); die();
                $data = $contents->toArray();
                $file->path = TMP . 'backup' . DS . 'content.json';
                $file->create();
                $file->write(json_encode($data));

                $file->path = TMP . 'backup.zip';
                $file->delete();

                $this->Zip->begin(TMP . 'backup.zip');
                $this->Zip->addDir(TMP . 'backup', 'backup');
                $this->Zip->close();

                $this->response->file(TMP . 'backup.zip', [
                    'download' => true,
                    'id' => date('d-m-Y-H-i-s') . '-backup-content.zip',
                    'name' => date('d-m-Y-H-i-s') . '-backup-content.zip'
                ]);
            }
            //end export contents 
            //begin export Blocks
            if ($this->request->data['exportdata'] == 'Blocks') {
                $blocks = $this->Blocks->find()
                        ->select(['id', 'name', 'slug', 'description', 'before_block', 'after_block', 'before_title', 'after_title', 'cells'])
                        ->where(['id IN' => $this->request->data['Blocks']]);
                $blocks = (new Collection($blocks))->map(function($b) {
                    if (isset($b->id)) {
                        unset($b->id);
                    }
                    return $b->toArray();
                });
                $folder = new Folder();
                $file = new File(TMP);
                $folder->delete(TMP . 'backupblock');
                $path = TMP . 'backupblock' . DS;
                $folder->create($path);
                $data = $blocks->toArray();
                $file->path = TMP . 'backupblock' . DS . 'blocks.json';
                $file->create();
                $file->write(json_encode($data));

                $this->Zip->begin(TMP . 'backupblock.zip');
                $this->Zip->addDir(TMP . 'backupblock', 'backupblock');
                $this->Zip->close();

                $this->response->file(TMP . 'backupblock.zip', [
                    'download' => true,
                    'id' => date('d-m-Y-H-i-s') . '-backup-blocks.zip',
                    'name' => date('d-m-Y-H-i-s') . '-backup-blocks.zip'
                ]);
                //pr($blocks->toArray()); die();
            }
            //end export Blocks
            //begin export Themes
            if ($this->request->data['exportdata'] == 'Themes') {
                $settings = new Setting();
                $themes_name = $settings->getOption('Themes.site');
                $arrin = $this->request->data['Themes'];
                $system = new System();
                $themes = $system->themes();
                $themes = array_keys($themes['site']);
                $arr_name_themes = [];
                foreach ($themes as $key => $theme) {
                    if (in_array($key, $arrin)) {
                        $arr_name_themes[$key] = $theme;
                    }
                }
                foreach ($arr_name_themes as $val) {
                    if ($val == $themes_name) {
                        $themeOptions = json_decode($settings->getOption('Themes.options'), true);
                        $data = $themeOptions[$val];
                    }
                }
                $folder = new Folder();
                $file = new File(TMP);
                $folder->delete(TMP . 'backupthemes');
                $path = TMP . 'backupthemes' . DS;
                $folder->create($path);
                $file->path = TMP . 'backupthemes' . DS . 'themes.json';
                $file->create();
                $file->write(json_encode($data));

                $this->Zip->begin(TMP . 'backupthemes.zip');
                $this->Zip->addDir(TMP . 'backupthemes', 'backupthemes');
                $this->Zip->close();

                $this->response->file(TMP . 'backupthemes.zip', [
                    'download' => true,
                    'id' => date('d-m-Y-H-i-s') . '-backup-themes.zip',
                    'name' => date('d-m-Y-H-i-s') . '-backup-themes.zip'
                ]);
            }
            //End export Themes
            //Begin export Menus
            if ($this->request->data['exportdata'] == 'Menus') {
                $menutypes = $this->Menus->MenuTypes->find()
                        ->select(['id', 'slug'])
                        ->contain([
                            'Menus' => function($qmen) {
                                return $qmen->find('threaded')->contain(['Contents' => function($qmencom) {
                                                return $qmencom->select(['slug']);
                                            },
                                            'Categories' => function($qmencc) {
                                                return $qmencc->select(['slug']);
                                            }
                                        ])->select(['id', 'name', 'slug', 'description', 'image', 'url', 'is_mega', 'is_dropdown', 'category_id', 'content_id', 'menutype_id', 'attributes', 'parent_id', 'lft', 'rght', 'order']);
                            },
                        ])
                        ->where(['id IN' => $this->request->data['Menus']]);
                $menutypes = (new Collection($menutypes))->map(function($mt) {
                    if (isset($mt->id)) {
                        unset($mt->id);
                    }
                    if (isset($mt->menus) && count($mt->menus) > 0) {
                        foreach ($mt->menus as $kmtm => $rmtm) {
                            $mt->menus[$kmtm] = $rmtm->toArray();

                            if (isset($mt->menus[$kmtm]['id'])) {
                                unset($mt->menus[$kmtm]['id']);
                            }
                            $mt->menus[$kmtm] = Hash::remove($mt->menus[$kmtm], 'parent_id');
                            $mt->menus[$kmtm] = Hash::remove($mt->menus[$kmtm], 'menutype_id');

                            if (isset($rmtm->category)) {
                                $mt->menus[$kmtm]['category_id'] = $rmtm->category->slug;
                                unset($mt->menus[$kmtm]['category']);
                            } else {
                                $mt->menus[$kmtm] = Hash::remove($mt->menus[$kmtm], 'category_id');
                            }

                            if (isset($rmtm->content)) {
                                $mt->menus[$kmtm]['content_id'] = $rmtm->content->slug;
                                unset($mt->menus[$kmtm]['content']);
                            } else {
                                $mt->menus[$kmtm] = Hash::remove($mt->menus[$kmtm], 'content_id');
                            }

                            if (isset($rmtm->children) && count($rmtm->children) > 0) {
                                foreach ($rmtm->children as $krmc => $rmcm) {
                                    $mt->menus[$kmtm]['children'][$krmc] = Hash::remove($mt->menus[$kmtm]['children'][$krmc], 'id');
                                    $mt->menus[$kmtm]['children'][$krmc] = Hash::remove($mt->menus[$kmtm]['children'][$krmc], 'parent_id');
                                    $mt->menus[$kmtm]['children'][$krmc] = Hash::remove($mt->menus[$kmtm]['children'][$krmc], 'menutype_id');
                                    if (isset($rmcm->category)) {
                                        $mt->menus[$kmtm]['children'][$krmc]['category_id'] = $rmcm->category->slug;
                                        unset($mt->menus[$kmtm]['children'][$krmc]['category']);
                                    } else {
                                        $mt->menus[$kmtm]['children'][$krmc] = Hash::remove($mt->menus[$kmtm]['children'][$krmc], 'category_id');
                                    }

                                    if (isset($rmcm->content)) {
                                        $mt->menus[$kmtm]['children'][$krmc]['content_id'] = $rmcm->content->slug;
                                        unset($mt->menus[$kmtm]['children'][$krmc]['content']);
                                    } else {
                                        $mt->menus[$kmtm]['children'][$krmc] = Hash::remove($mt->menus[$kmtm]['children'][$krmc], 'content_id');
                                    }
                                }
                            }
                        }
                    }
                    return $mt;
                });
                //pr($menutypes->toArray()); die();
                $data = $menutypes->toArray();
                $folder = new Folder();
                $file = new File(TMP);
                $folder->delete(TMP . 'backupmenus');
                $path = TMP . 'backupmenus' . DS;
                $folder->create($path);
                $file->path = TMP . 'backupmenus' . DS . 'menus.json';
                $file->create();
                $file->write(json_encode($data));

                $this->Zip->begin(TMP . 'backupmenus.zip');
                $this->Zip->addDir(TMP . 'backupmenus', 'backupmenus');
                $this->Zip->close();

                $this->response->file(TMP . 'backupmenus.zip', [
                    'download' => true,
                    'id' => date('d-m-Y-H-i-s') . '-backup-menus.zip',
                    'name' => date('d-m-Y-H-i-s') . '-backup-menus.zip'
                ]);
            }
            //End export Menus
        }

        if ($models == 'Contents') {
            $metaTypes = $this->MetaTypes->find('list')
                    ->find('network')
                    ->where(['model' => 'Contents'])
                    ->order('id', 'asc');

            $this->set(compact('metaTypes'));

            $metaCategories = TableRegistry::get('Metas.MetaCategories')->find('list')
                    ->find('network')
                    ->order('id', 'asc');

            $this->set(compact('metaCategories'));

            $metas = TableRegistry::get('Metas.Metas')->find('list')
                    ->find('network')
                    ->order('id', 'asc');

            $this->set(compact('metas'));
        }
        if ($models == 'Blocks') {
            $blocks = $this->Blocks->find('list')->find('network')->order('id', 'asc');
            $this->set(compact('blocks'));
        }
        if ($models == 'Themes') {
            $system = new System();
            $themes = $system->themes();
            $themes = array_keys($themes['site']);
            $this->set(compact('themes'));
        }
        if ($models == 'Menus') {
            $menutypes = $this->Menus->MenuTypes->find('list')
                    ->find('network')
                    ->order('id', 'asc');
            $this->set(compact('menutypes'));
        }
        $this->set(compact('models'));
    }

    public function importdata($models = 'Contents') {
        if ($this->request->is('post')) {
            //begin import Contents 
            if ($this->request->data['Importdata'] == 'Contents') {
                $folder = new Folder();
                $folder->delete(TMP . 'backup');
                //unzip			
                $this->Zip->begin($this->request->data['file']['tmp_name']);
                $this->Zip->unzip(TMP);
                $this->Zip->close();
                //read file json
                $folder->cd(TMP . 'backup');
                $files = $folder->find('.*\.json');
                if (count($files) > 0) {
                    $file = new File($folder->pwd() . DS . $files[0]);
                    if ($file->name() == 'content') {
                        $data = $file->read();
                        $metaTypes = json_decode($data, true);
                        if (count($metaTypes) > 0) {
                            $this->loadModel('Metas.MetaTypes');
                            $this->loadModel('Contents.Categories');
                            $this->loadModel('Contents.CategoryMetas');
                            $this->loadModel('Contents.CategoryContents');
                            foreach ($metaTypes as $kmt => $metaType) {
                                $mt = $this->MetaTypes->newEntity($metaType);
                                if (count($mt->meta_categories) > 0) {
                                    foreach ($mt->meta_categories as $kmc => $meta_category) {
                                        if (count($meta_category->categories) > 0) {
                                            $mt->meta_categories[$kmc]->categories = $this->Categories->newEntities($meta_category->categories);
                                            foreach ($meta_category->categories as $kc => $category) {
                                                if (count($category['categoryMeta']) > 0) {
                                                    //$mt->meta_categories[$kmc]->categories[$kc]->categoryMeta = $this->CategoryMetas->newEntities($category['categoryMeta']);
                                                }
                                            }
                                        }
                                    }
                                }
                                //pr($mt); die();
                                //$this->MetaTypes->save($mt);
                                if($this->MetaTypes->save($mt)){
                                    if (count($mt->meta_categories) > 0) {
                                        foreach ($mt->meta_categories as $kmcc => $meta_category_s) {
                                            if (count($meta_category_s->categories) > 0) {
                                                foreach ($meta_category_s->categories as $kc_c => $category_s) {
                                                    if(isset($category_s->children) && count($category_s->children) > 0){
                                                        $mt->meta_categories[$kmcc]['categories'][$kc_c] = Hash::insert($mt->meta_categories[$kmcc]['categories'][$kc_c]->toArray(), 'children.{n}.meta_category_id', $category_s->meta_category_id);
                                                        $mt->meta_categories[$kmcc]['categories'][$kc_c] = Hash::insert($mt->meta_categories[$kmcc]['categories'][$kc_c], 'children.{n}.parent_id', $category_s->id);
                                                        $mt->meta_categories[$kmcc]['categories'][$kc_c]['children'] = $this->Categories->newEntities($mt->meta_categories[$kmcc]['categories'][$kc_c]['children']);
                                                        
                                                        $this->Categories->saveMany($mt->meta_categories[$kmcc]['categories'][$kc_c]['children']);
                                                        pr($mt->meta_categories[$kmcc]['categories'][$kc_c]['children']); die();
                                                    }
                                                    
                                                }
                                            }
                                        }
                                    }
                                }

                                if (count($mt->meta_categories) > 0) {
                                    foreach ($mt->meta_categories as $kmc => $meta_category) {
                                        if (count($meta_category->categories) > 0) {
                                            foreach ($meta_category->categories as $kc => $category) {
                                                if (count($category['categoryMeta']) > 0) {
                                                    $category['categoryMeta'] = Hash::insert($category['categoryMeta'], '{n}.category_id', $category->id);
                                                    $this->CategoryMetas->saveMany($this->CategoryMetas->newEntities($category['categoryMeta']));
                                                }
                                            }
                                        }
                                    }
                                }

                                foreach ($mt->contents as $kco => $content) {
                                    if (count($content->categories) > 0) {
                                        $ca_co = [];
                                        foreach ($content->categories as $kca => $category_content) {
                                            $category_id = $this->Categories->find()->select(['Categories.id', 'Categories.slug'])->where(['Categories.slug' => $category_content['category_id']])->first();
                                            if ($category_id != false) {
                                                $ca_co[] = [
                                                    'content_id' => $content->id,
                                                    'category_id' => $category_id->id
                                                ];
                                            }
                                        }

                                        if (count($ca_co) > 0) {
                                            $eca_co = $this->CategoryContents->newEntities($ca_co);
                                            $this->CategoryContents->saveManyNetwork($eca_co);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    //pr($mt);die();
                }
                pr($files);

                pr($this->request->data);
                die();
            }
            //end import Contents
            //begin import Menus
            if ($this->request->data['Importdata'] == 'Menus') {
                $folder = new Folder();
                $folder->delete(TMP . 'backupmenus');
                //unzip			
                $this->Zip->begin($this->request->data['file']['tmp_name']);
                $this->Zip->unzip(TMP);
                $this->Zip->close();
                //read file json
                $folder->cd(TMP . 'backupmenus');
                $files = $folder->find('.*\.json');
                if (count($files) > 0) {
                    $file = new File($folder->pwd() . DS . $files[0]);
                    if ($file->name() == 'menus') {
                        $data = $file->read();
                        $menuTypes = json_decode($data, true);
                        if (count($menuTypes) > 0) {
                            $this->loadModel('Menus.Menutypes');
                            $this->loadModel('Menus.Menus');
                            $this->loadModel('Contents.Contents');
                            $this->loadModel('Contents.Categories');
                            $arrchilds = [];
                            foreach ($menuTypes as $kmt => $menuType) {
                                foreach ($menuType['menus'] as $kmtm => $menu) {
                                    if (isset($menu['content_id']) && count($menu['content_id']) > 0) {
                                        $content = $this->Contents->find()->select(['Contents.id'])->where(['Contents.slug' => $menu['content_id']])->first();
                                        $menuTypes[$kmt]['menus'][$kmtm]['content_id'] = $content->id;
                                    }
                                    if (isset($menu['category_id']) && count($menu['category_id']) > 0) {
                                        $categories = $this->Categories->find()->select(['Categories.id'])->where(['Categories.slug' => $menu['category_id']])->first();
                                        $menuTypes[$kmt]['menus'][$kmtm]['category_id'] = $categories->id;
                                    }
                                    if (isset($menu['children']) && count($menu['children']) > 0) {
                                        foreach ($menu['children'] as $kmtc => $mchild) {
                                            if (isset($mchild['content_id']) && count($mchild['content_id']) > 0) {
                                                $content_id = $this->Contents->find()->select(['Contents.id'])->where(['Contents.slug' => $mchild['content_id']])->first();
                                                $menuTypes[$kmt]['menus'][$kmtm]['children'][$kmtc]['content_id'] = $content_id->id;
                                            }
                                            if (isset($mchild['category_id']) && count($mchild['category_id']) > 0) {
                                                $cat = $this->Categories->find()->select(['Categories.id'])->where(['Categories.slug' => $mchild['category_id']])->first();
                                                $menuTypes[$kmt]['menus'][$kmtm]['children'][$kmtc]['category_id'] = $cat->id;
                                            }
                                        }
                                    }
                                }
                            }
                            foreach ($menuTypes as $kmt1 => $menuType1) {
                                $mt = $this->Menutypes->newEntity($menuType1);
                                if ($this->Menutypes->save($mt)) {
                                    if (count($mt->menus) > 0) {
                                        foreach ($mt->menus as $kmtm1 => $menu1) {
                                            $mt->menus[$kmtm1] = Hash::insert($menu1->toArray(), 'children.{n}.menutype_id', $mt->id);
                                            $mt->menus[$kmtm1] = Hash::insert($mt->menus[$kmtm1], 'children.{n}.parent_id', $menu1->id);
                                            $mt->menus[$kmtm1]['children'] = $this->Menus->newEntities($mt->menus[$kmtm1]['children']);
                                            $this->Menus->saveMany($mt->menus[$kmtm1]['children']);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                //pr($menuTypes); die();
            }
            //end import Menus
            //begin import Blocks
            if ($this->request->data['Importdata'] == 'Blocks') {
                $folder = new Folder();
                $folder->delete(TMP . 'backupblock');
                //unzip			
                $this->Zip->begin($this->request->data['file']['tmp_name']);
                $this->Zip->unzip(TMP);
                $this->Zip->close();
                //read file json
                $folder->cd(TMP . 'backupblock');
                $files = $folder->find('.*\.json');
                if (count($files) > 0) {
                    $file = new File($folder->pwd() . DS . $files[0]);
                    if ($file->name() == 'blocks') {
                        $data = $file->read();
                        $blocks = json_decode($data, true);
                        $this->loadModel('Blocks.Blocks');
                        if (count($blocks) > 0) {
                            foreach ($blocks as $block) {
                                $this->Blocks->save($this->Blocks->newEntity($block));
                            }
                            //pr($blocks); die();
                        }
                    }
                }
            }
            //end import Blocks
            //begin import Themes
            if ($this->request->data['Importdata'] == 'Themes') {
                $folder = new Folder();
                $folder->delete(TMP . 'backupthemes');
                //unzip			
                $this->Zip->begin($this->request->data['file']['tmp_name']);
                $this->Zip->unzip(TMP);
                $this->Zip->close();
                //read file json
                $folder->cd(TMP . 'backupthemes');
                $files = $folder->find('.*\.json');
                if (count($files) > 0) {
                    $file = new File($folder->pwd() . DS . $files[0]);
                    if ($file->name() == 'themes') {
                        $data = $file->read();
                        $themes = json_decode($data, true);
                        $this->loadModel('Settings.Settings');
                        if (count($themes) > 0) {
                            $settings = new Setting();
                            $value[$settings->getOption('Themes.site')] = $themes;
                            $this->Settings->updateAll([
                                'value' => json_encode($value)
                                    ], [
                                'name' => 'Themes.options'
                            ]);
                            //pr($value); die();                            
                        }
                    }
                }
            }
            //end import Themes
        }
        $this->set(compact('models'));
    }

}
