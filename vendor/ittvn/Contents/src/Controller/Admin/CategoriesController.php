<?php

namespace Contents\Controller\Admin;

use Contents\Controller\AppController;
use Cake\I18n\I18n;
use Settings\Utility\Setting;

/**
 * Categories Controller
 *
 * @property \Contents\Model\Table\CategoriesTable $Categories
 */
class CategoriesController extends AppController {

    /**
     * Index method
     *
     * @return void
     */
    public function index($cat_type = null) {
        if ($this->request->is('post')) {
            $tableParams = $this->DataTable->tableParams('Categories');
            if (count($tableParams['search']) > 0) {
                $query = $this->Categories->find('search', $this->Categories->filterParams($tableParams['search']))->orderDesc('Categories.lft');
            } else {
                $query = $this->Categories->find()->orderDesc('Categories.lft');
            }

            $query->contain(['CategoryMetas', 'ChildCategories', 'MetaCategories']);
            if (!empty($cat_type)) {
                $query->where(['MetaCategories.slug' => $cat_type]);
            }
            $query->find('network');
            $this->DataTable->table('Categories', $query, $tableParams);
        }
        $this->loadModel('Metas.MetaCategories');
        $metaCategorie = $this->MetaCategories->find()->find('network')->where(['slug'=>$cat_type])->first();
        $this->set(compact('cat_type','metaCategorie'));
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null, $cat_type = null) {
        $category = $this->Categories->getNetwork($id, [
            'contain' => ['CategoryMetas', 'ChildCategories', 'CategoryContents']
        ]);
        $this->set('category', $category);
        $this->set('_serialize', ['category']);
        $this->set(compact('cat_type'));
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($cat_type = null) {
        $category = $this->Categories->newEntity();
        $this->loadModel('Metas.MetaCategories');
        $metaCategory = $this->MetaCategories->find()->find('network')->where(['slug' => $cat_type])->first();
        if ($this->request->is('post')) {
            //check meta categories
            if (empty($cat_type)) {
                $this->request->data['meta_category_id'] = 0;
            } else {
                if (!empty($metaCategory->id)) {
                    $this->request->data['meta_category_id'] = $metaCategory->id;
                } else {
                    $this->request->data['meta_category_id'] = 0;
                }
            }
            //End check meta categories
            $category = $this->Categories->patchEntity($category, $this->request->data);
            if ($this->Categories->saveNetwork($category)) {
                $this->Flash->success(__('The category has been saved.'));
                return $this->redirect(['action' => 'index', $cat_type]);
            } else {
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }
        }

        $parentCategories = $this->Categories->ParentCategories->find('treeList', ['spacer' => '------'])->find('network')->where(['meta_category_id' => $metaCategory->id]);
        $this->set(compact('category', 'parentCategories', 'cat_type'));
        $this->set('_serialize', ['category']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function addRelation($cat_type = null, $content_id = null) {
        $category = $this->Categories->newEntity();
        $this->loadModel('Metas.MetaCategories');
        $metaCategory = $this->MetaCategories->find()
                ->select(['id'])
                ->where(['slug' => $cat_type])
                ->find('network')
                ->first();
        if ($this->request->is('post')) {
            if (!empty($this->request->data['name'])) {
                //check meta categories
                if (empty($cat_type)) {
                    $this->request->data['meta_category_id'] = 0;
                } else {
                    if (!empty($metaCategory->id)) {
                        $this->request->data['meta_category_id'] = $metaCategory->id;
                    } else {
                        $this->request->data['meta_category_id'] = 0;
                    }
                }
                //End check meta categories
                $category = $this->Categories->patchEntity($category, $this->request->data);
                if ($this->Categories->saveNetwork($category)) {
                    $categoryContent = $this->Categories->CategoryContents->newEntity(['content_id' => $content_id, 'category_id' => $category->id]);
                    $this->Categories->CategoryContents->saveNetwork($categoryContent);
                    $this->Flash->success(__('The category has been saved.'));
                    return $this->redirect(['action' => 'addRelation', $cat_type, $content_id]);
                } else {
                    $this->Flash->error(__('The category could not be saved. Please, try again.'));
                }
            } else {
                $this->loadModel('Contents.CategoryContents');
                $tableParams = $this->DataTable->tableParams('CategoryContents');
                unset($tableParams['trash']);
                unset($tableParams['search']['trash']);

                if (count($tableParams['search']) > 0) {
                    $query = $this->CategoryContents->find('search', $this->CategoryContents->filterParams($tableParams['search']));
                } else {
                    $query = $this->CategoryContents->find();
                }
                $query->where(['CategoryContents.content_id' => $this->request->params['pass'][1]]);
                $query->find('network');
                $this->DataTable->table('CategoryContents', $query, $tableParams);
            }
        }
        if (!isset($this->request->data['draw'])) {
            $parentCategories = $this->Categories->ParentCategories->find('treeList', ['spacer' => '------'])->find('network')->where(['meta_category_id' => $metaCategory->id]);
            $this->set(compact('category', 'parentCategories', 'cat_type'));
            $this->set('_serialize', ['category']);
        }
    }

    /**
     * Edit method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function editRelation($cat_type = null, $content_id = null, $id = null) {
        $category = $this->Categories->getNetwork($id, [
            'contain' => ['CategoryMetas']
        ]);
        $metaCategory = $this->Categories->MetaCategories->find()->find('network')->where(['slug' => $cat_type])->first();
        if ($this->request->is('post')) {
            if (!empty($this->request->data['name'])) {
                //check meta categories
                if (empty($cat_type)) {
                    $this->request->data['meta_category_id'] = 0;
                } else {
                    if (!empty($metaCategory->id)) {
                        $this->request->data['meta_category_id'] = $metaCategory->id;
                    } else {
                        $this->request->data['meta_category_id'] = 0;
                    }
                }
                //End check meta categories
                $category = $this->Categories->patchEntity($category, $this->request->data);
                if ($this->Categories->saveNetwork($category)) {
                    $categoryContent = $this->Categories->CategoryContents->newEntity(['content_id' => $content_id, 'category_id' => $category->id]);
                    $this->Categories->CategoryContents->saveNetwork($categoryContent);
                    $this->Flash->success(__('The category has been saved.'));
                    return $this->redirect(['action' => 'index', $cat_type]);
                } else {
                    $this->Flash->error(__('The category could not be saved. Please, try again.'));
                }
            } else {
                $this->loadModel('Contents.CategoryContents');
                $tableParams = $this->DataTable->tableParams('CategoryContents');
                unset($tableParams['trash']);
                unset($tableParams['search']['trash']);

                if (count($tableParams['search']) > 0) {
                    $query = $this->CategoryContents->find('search', $this->CategoryContents->filterParams($tableParams['search']));
                } else {
                    $query = $this->CategoryContents->find();
                }
                $query->where(['CategoryContents.content_id' => $this->request->params['pass'][1]]);
                $query->find('network');
                $this->DataTable->table('CategoryContents', $query, $tableParams);
            }
        }
        if (!isset($this->request->data['draw'])) {
            $parentCategories = $this->Categories->ParentCategories->find('treeList', ['spacer' => '------'])->find('network')->where(['meta_category_id' => $metaCategory->id]);
            $this->set(compact('category', 'parentCategories', 'cat_type'));
            $this->set('_serialize', ['category']);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $cat_type = null) {
        $category = $this->Categories->getNetwork($id, [
            'contain' => ['CategoryMetas']
        ]);
        
        $this->loadModel('Metas.MetaCategories');
        $metaCategory = $this->MetaCategories->find()->find('network')->where(['slug' => $cat_type])->first();
        if ($this->request->is(['patch', 'post', 'put'])) {
            //check meta categories
            if (empty($cat_type)) {
                $this->request->data['meta_category_id'] = 0;
            } else {
                if (!empty($metaCategory->id)) {
                    $this->request->data['meta_category_id'] = $metaCategory->id;
                } else {
                    $this->request->data['meta_category_id'] = 0;
                }
            }
            //End check meta categories            
            $category = $this->Categories->patchEntity($category, $this->request->data);
            if ($this->Categories->saveNetwork($category)) {
                $this->Flash->success(__('The category has been saved.'));
                return $this->redirect(['action' => 'index', $cat_type]);
            } else {
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }
        }
        //$parentCategories = $this->Categories->ParentCategories->find('treeList', ['spacer' => '------'])->find('network')->where(['meta_category_id' => $metaCategory->id, 'id <>' => $id]);
        $parentCategories = $this->Categories->find('treeList', ['spacer' => '------'])
                                                                    ->find('network')
                                                                    ->where(['Categories.meta_category_id' => $metaCategory->id, 'Categories.id <>' => $id]);
        $this->set(compact('category', 'parentCategories', 'cat_type'));
        $this->set('_serialize', ['category']);
    }
    public function  ajax($id = null, $cat_type = null) {
        $category = $this->Categories->getNetwork($id, [
            'contain' => ['CategoryMetas', 'ChildCategories', 'CategoryContents']
        ]);       
        
        $this->set(compact('category'));
        $this->set('_serialize', ['category']);          
    }
    
    public function editLanguage($id = null, $cat_type = null) {
        $setting = new Setting();
        $fileds = json_decode($setting->getOption('Translation.Categories'),true);
        if(!empty($fileds)){
            if ($this->request->is(['patch', 'post', 'put'])) {
                $this->Categories->locale($this->request->query('lang'));
                foreach ($fileds as $value) {
                    $translate[$value] = $this->request->data[$value];
                }
                //$translate['name'] = $this->request->data['name'];
                //$translate['description'] = $this->request->data['description'];
                $category = $this->Categories->newEntity($translate);
                $category->id = $id;            
                 if ($this->Categories->saveNetwork($category)) {
                    $this->Flash->success(__('The category has been saved.'));
                    return $this->redirect(['action' => 'index', $cat_type]);
                } else {
                    $this->Flash->error(__('The category could not be saved. Please, try again.'));
                }
            }else{
                $categories = $this->Categories->find('translations');            
                $data = false;
                foreach ($categories as $categori){
                    if(!empty($categori['_translations']) && $categori['id'] == $id){
                        $data = true; 
                    }
                }            
                if($data == true){
                    //I18n::setLocale($this->request->query('lang'));
                    $this->Categories->locale($this->request->query('lang'));
                    $category = $this->Categories->getNetwork($id, [
                        'contain' => ['CategoryMetas']
                    ]);
                }else{
                    $category = '';
                }
                $this->loadModel('Metas.MetaCategories');
                $metaCategory = $this->MetaCategories->find()->find('network')->where(['slug' => $cat_type])->first();
                if (empty($cat_type)) {
                    $this->request->data['meta_category_id'] = 0;
                } else {
                    if (!empty($metaCategory->id)) {
                        $this->request->data['meta_category_id'] = $metaCategory->id;
                    } else {
                        $this->request->data['meta_category_id'] = 0;
                    }
                }

                            $this->Categories->locale($this->request->query('lang'));
                $parentCategories = $this->Categories->find('treeList', ['spacer' => '------'])
                                                                    ->find('network')
                                                                    ->find('translations')
                                                                    ->where(['Categories.meta_category_id' => $metaCategory->id, 'Categories.id <>' => $id]);
                $this->set(compact('category', 'parentCategories', 'cat_type'));
                $this->set('_serialize', ['category']);
            }
        }
    }
    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null, $cat_type = null) {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->getNetwork($id);
        if ($this->Categories->deleteNetwork($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index', $cat_type]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function trash($id = null, $cat_type = null) {
        $this->request->allowMethod(['post', 'trash']);
        $category = $this->Categories->getNetwork($id);
        if (!empty($category)) {
            $category->delete = 1;
            if ($this->Categories->saveNetwork($category)) {
                $this->Flash->success(sprintf(__d('ittvn', 'The %s has been move to trash.'), __d('ittvn', $cat_type)));
            } else {
                $this->Flash->error(sprintf(__d('ittvn', 'The %s could not be move to trash. Please, try again.'), __d('ittvn', $cat_type)));
            }
        } else {
            $this->Flash->error(sprintf(__d('ittvn', 'The %s could not be move to trash. Please, try again.'), __d('ittvn', $cat_type)));
        }
        return $this->redirect(['action' => 'index', $cat_type]);
    }

    public function listCategories($meta_category_id = null) {

        $return = ['status' => false, 'data' => ''];
        if (!empty($meta_category_id)) {
            $return['status'] = true;
            $return['data'] = $this->Categories->find('list')->find('network')->where(['meta_category_id' => $meta_category_id, 'delete' => 0]);
        }

        $this->set(compact('return'));
        $this->set('_serialize', 'return');
    }

}
