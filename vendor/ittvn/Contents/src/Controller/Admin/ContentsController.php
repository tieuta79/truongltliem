<?php

namespace Contents\Controller\Admin;

use Contents\Controller\AppController;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\I18n;
use Settings\Utility\Setting;
use Ittvn\Utility\Language;
/**
 * Contents Controller
 *
 * @property \Contents\Model\Table\ContentsTable $Contents
 */
class ContentsController extends AppController {

    /**
     * Index method
     *
     * @return void
     */
    public function index($content_type = null) {
        
        if ($this->request->is('post')) {

            $tableParams = $this->DataTable->tableParams('Contents');
            if (count($tableParams['search']) > 0) {
                $ids = [];
                $flag_search = false;
                if (!empty($content_type)) {
                    $this->loadModel('Metas.MetaTypes');
                    $this->loadModel('Metas.MetaCategories');
                    $this->loadModel('Contents.Categories');
                    $this->loadModel('Contents.CategoryContents');
                    $metaType = $this->MetaTypes->find()->where(['slug' => $content_type])->find('network')->first();
                    if ($metaType->category == 1) {
                        $metaCategories = $this->MetaCategories->findByMetaTypeId($metaType->id)->select(['id', 'name', 'slug'])->find('network');
                        foreach ($metaCategories as $metaCategory) {
                            $cat = Inflector::variable($metaCategory->name);
                            if (isset($tableParams['search'][$cat])) {
                                $ids1 = $this->CategoryContents->find('list', ['keyField' => 'content_id', 'valueField' => 'content_id'])->find('network')->where(['category_id' => $tableParams['search'][$cat]]);
                                if ($ids1->count() > 0) {
                                    $ids = Hash::merge($ids, $ids1->toArray());
                                }
                                $flag_search = true;
                            }
                        }
                    }
                }
                $query = $this->Contents->find('search', $this->Contents->filterParams($tableParams['search']));
                if ($flag_search == true) {
                    if (count($ids) > 0) {
                        $query->where(['Contents.id IN' => $ids]);
                    } else {
                        $query->where(['Contents.id' => -1]);
                    }
                }
            } else {
                $query = $this->Contents->find();
            }

            if (!empty($content_type)) {
                $query->contain(['MetaTypes', 'ContentMetas'])->where(['MetaTypes.slug' => $content_type]);
            }
            $query->find('network');

            $this->DataTable->table('Contents', $query, $tableParams);
            
        }
        
        $this->loadModel('Metas.MetaTypes');
        $metaType = $this->MetaTypes->find()->find('network')->where(['slug'=>$content_type])->first();
        
        $this->set(compact('content_type','metaType'));
    }

    /**
     * View method
     *
     * @param string|null $id Content id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null, $content_type = null) {
        $content = $this->Contents->getNetwork($id, [
            'contain' => ['MetaTypes']
        ]);        
        $this->set('content', $content);
        $this->set('_serialize', ['content']);
        $this->set(compact('content_type'));
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($content_type = null) {
        $content = $this->Contents->newEntity();
        $this->loadModel('Metas.MetaTypes');
        $metaType = $this->MetaTypes->find()->where(['slug' => $content_type])->find('network')->first();
        if ($this->request->is('post')) {
            //check meta contents type
            if (empty($content_type)) {
                $this->request->data['meta_type_id'] = 0;
            } else {
                if (!empty($metaType->id)) {
                    $this->request->data['meta_type_id'] = $metaType->id;
                } else {
                    $this->request->data['meta_type_id'] = 0;
                }
            }
            //End check meta contents type            
            $content = $this->Contents->patchEntity($content, $this->request->data);
            
            if ($this->Contents->saveNetwork($content)) {
                $this->loadModel('Contents.CategoryContents');
//                if(count($content->categories) > 0){
//                    foreach ($content->categories as $cat_id){
//                        $cc = $this->CategoryContents->newEntity([
//                            'content_id' => $content->id,
//                            'category_id' => $cat_id['id']
//                        ]);
//                        $this->CategoryContents->saveNetwork($cc);
//                    }
//                }
                $this->Flash->success(__('The content has been saved.'));
                return $this->redirect(['action' => 'index', $content_type]);
            } else {
                $this->Flash->error(__('The content could not be saved. Please, try again.'));
            }
        }

        $this->loadModel('Metas.MetaCategories');
        $this->loadModel('Contents.Categories');
        $metaCategories = $this->MetaCategories->findByMetaTypeId($metaType->id)->select(['id', 'name'])->find('network');
        foreach ($metaCategories as $metaCategory) {
            $metaCatVariable = Inflector::variable($metaCategory->name);
            ${$metaCatVariable} = $this->Categories->find('treeList', ['spacer' => '------'])->where(['meta_category_id' => $metaCategory->id])->find('network');
            $this->set(compact($metaCatVariable));
        }

        $this->set(compact('content', 'content_type','metaType'));
        $this->set('_serialize', ['content']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Content id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $content_type = null) {        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data_get = [];
        } else {
            $data_get = [
                'contain' => [
                    'ContentMetas',
                    'Categories' => [
                        'fields' => [
                            'CategoryContents.content_id',
                            'Categories.id',
                            'Categories.meta_category_id'
                        ]
                    ]
                ]
            ];
        }

        $result = $this->eventManager()->dispatch(new Event('Controller.Admin.Contents.edit.get', $data_get));

        if (!empty($result->result)) {
            $data_get = $result->result;
        }

        $content = $this->Contents->getNetwork($id, $data_get);

        $this->loadModel('Metas.MetaTypes');
        $metaType = $this->MetaTypes->find()->find('network')->where(['slug' => $content_type])->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {            
            $content = $this->Contents->patchEntity($content, $this->request->data);
            //pr($this->request->data); die();
            if ($this->Contents->saveNetwork($content)) {
                $this->loadModel('Contents.CategoryContents');
                if(count($content->categories) > 0){
                    foreach ($content->categories as $cat_id){
                        $check_cc = $this->CategoryContents->find()
                                ->find('network')
                                ->where(['content_id'=>$content->id,'category_id'=>$cat_id['id']]);

                        if($check_cc->count() == 0){
                            $cc = $this->CategoryContents->newEntity([
                                'content_id' => $content->id,
                                'category_id' => $cat_id['id']
                            ]);
                            
                            $this->CategoryContents->saveNetwork($cc);             
                        }
                    }
                }
                $this->Flash->success(__('The content has been saved.'));
                return $this->redirect(['action' => 'index', $content_type]);
            } else {
                $this->Flash->error(__('The content could not be saved. Please, try again.'));
            }
        }
        //show category for checkbox
        $this->loadModel('Contents.CategoryContents');
        $categoryContents = $this->CategoryContents->findByContentId($id)->find('network')->toArray();
        //$content = $this->Contents->patchEntity($content, ['categories' => ['id'=>[]]]);
        //$content->categories = ['id' => Hash::extract($categoryContents, '{n}.category_id')];
        //End show category for checkbox

        $this->loadModel('Metas.MetaCategories');
        $this->loadModel('Contents.Categories');
        $metaCategories = $this->MetaCategories->findByMetaTypeId($metaType->id)->select(['id', 'name'])->find('network');
        foreach ($metaCategories as $metaCategory) {
            $metaCatVariable = Inflector::variable($metaCategory->name);
            ${$metaCatVariable} = $this->Categories->find('treeList', ['spacer' => '------'])->where(['meta_category_id' => $metaCategory->id])->find('network');
            $this->set(compact($metaCatVariable));
        }
        
        $this->set(compact('content', 'content_type'));
        $this->set('_serialize', ['content']);
    }
    
    public function  ajax($id = null, $content_type = null) {
        $content = $this->Contents->getNetwork($id, [
            'contain' => ['MetaTypes']
        ]);
        
        $this->set(compact('content'));
        $this->set('_serialize', ['content']);          
    }

    public function editLanguage($id = null, $content_type = null)
    {   
        if($this->request->is(['patch', 'post', 'put'])){            
            $this->Contents->locale($this->request->query('lang'));
            $setting = new Setting();
            $fileds = json_decode($setting->getOption('Translation.Contents'),true);
            //$filed_meta = json_decode($setting->getOption('Translation.ExtraFields'),true);
            //pr($this->request->data); die();
            if(!empty($fileds)){
                //$filed = Hash::merge($fileds, $filed_meta);                
                foreach ($fileds as $value) {
                    if(!empty($this->request->data[$value])){
                        $translate[$value] = $this->request->data[$value];
                    }
                }
            }
            //pr($translate); die();
            //$translate['name'] = $this->request->data['name'];
            //$translate['description'] = $this->request->data['description'];
            $content = $this->Contents->newEntity($translate);
            $content->id = $id;            
            if ($this->Contents->saveNetwork($content)) {
                $this->Flash->success(__('The content has been saved.'));
                return $this->redirect(['action' => 'index', $content_type]);
            }else {
                $this->Flash->error(__('The content could not be saved. Please, try again.'));
            }
        }else{
//            if(Language::getLanguages()->count() > 1){
                $contents = $this->Contents->find('translations',['locales' => $this->request->query('lang')])->where(['Contents.id' => $id]);
                
//            }else{
 //               $contents = $this->Contents->find()->where(['Contents.id' => $id]);
            //}
            
            //I18n::setLocale($this->request->query('lang'));
            //pr($contents->toArray());die();
            $data_get = [
                'contain' => [
                    'ContentMetas',
                    'Categories' => [
                        'fields' => [
                            'CategoryContents.content_id',
                            'Categories.id',
                            'Categories.meta_category_id'
                        ]
                    ]
                ]
            ];
            $result = $this->eventManager()->dispatch(new Event('Controller.Admin.Contents.edit.get', $data_get));

            if (!empty($result->result)) {
                $data_get = $result->result;
            }
            //pr($contents->first()->_translations); die();
            if($contents->count() > 0){
                if(isset($contents->first()->_translations[$this->request->query('lang')]) && count($contents->first()->_translations[$this->request->query('lang')]) > 0){
                        $this->Contents->locale($this->request->query('lang'));
                        $content = $this->Contents->getNetwork($id, $data_get);
                }else{
                        $content = $this->Contents->find()->find('network')->select(['Contents.id','Contents.image'])->where(['Contents.id' => $id])->first();
                }
            }else{
                $content = $this->Contents->find()->find('network')->select(['Contents.id','Contents.image'])->where(['Contents.id' => $id])->first();
            }            
            $this->loadModel('Metas.MetaTypes');
            $metaType = $this->MetaTypes->find()->find('network')->where(['slug' => $content_type])->first();            
            $this->loadModel('Contents.CategoryContents');
            $categoryContents = $this->CategoryContents->findByContentId($id)->find('network')->toArray();
            $this->loadModel('Metas.MetaCategories');
            $this->loadModel('Contents.Categories');
            $metaCategories = $this->MetaCategories->findByMetaTypeId($metaType->id)->select(['id', 'name'])->find('network');
            foreach ($metaCategories as $metaCategory) {
                $metaCatVariable = Inflector::variable($metaCategory->name);
                ${$metaCatVariable} = $this->Categories->find('treeList', ['spacer' => '------'])->where(['meta_category_id' => $metaCategory->id])->find('network');
                $this->set(compact($metaCatVariable));
            }
            $this->set(compact('content', 'content_type'));
            $this->set('_serialize', ['content']);            
        }
    }
    /**
     * Delete method
     *
     * @param string|null $id Content id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null, $content_type = null) {
        $this->request->allowMethod(['post', 'delete']);
        $content = $this->Contents->getNetwork($id);
        if ($this->Contents->deleteNetwork($content)) {
            $this->Flash->success(__('The ' . $content_type . ' has been deleted.'));
        } else {
            $this->Flash->error(__('The ' . $content_type . ' could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index', $content_type]);
    }

    /**
     * Trash method
     *
     * @param string|null $id Content id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function trash($id = null, $content_type = null) {
        $this->request->allowMethod(['post', 'trash']);
        $content = $this->Contents->getNetwork($id);
        if (!empty($content)) {
            $content->delete = 1;
            if ($this->Contents->saveNetwork($content)) {
                $this->Flash->success(__('The ' . $content_type . ' has been move to trash.'));
            } else {
                $this->Flash->error(__('The ' . $content_type . ' could not be move to trash. Please, try again.'));
            }
        } else {
            $this->Flash->error(__('The ' . $content_type . ' could not be move to trash. Please, try again.'));
        }
        return $this->redirect(['action' => 'index', $content_type]);
    }

    public function listContents($category_id = null) {

        $return = ['status' => false, 'data' => ''];
        if (!empty($category_id)) {
            $this->loadModel('Contents.CategoryContents');
            $categoryContents = $this->CategoryContents->find('list', ['keyField' => 'content_id', 'valueField' => 'content_id'])->find('network')->where(['category_id' => $category_id]);
            if ($categoryContents->count() > 0) {
                $return['status'] = true;
                $return['data'] = $this->Contents->find('list')->find('network')->where(['id IN' => $categoryContents->toArray(), 'delete' => 0]);
            }
        } else {
            if (isset($this->request->data['meta_type_id']) && !empty($this->request->data['meta_type_id'])) {
                $return['status'] = true;
                $return['data'] = $this->Contents->find('list')->find('network')->where(['meta_type_id' => $this->request->data['meta_type_id'], 'delete' => 0]);
            }
        }

        $this->set(compact('return'));
        $this->set('_serialize', 'return');
    }

}
