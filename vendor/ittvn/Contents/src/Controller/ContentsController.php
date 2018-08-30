<?php

namespace Contents\Controller;

use Contents\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Hash;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
/**
 * Contents Controller
 *
 * @property \Contents\Model\Table\ContentsTable $Contents
 */
class ContentsController extends AppController {

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['index', 'view']);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        //pr($this->request);die();
        $type = $this->request->type;
        $metaType = $this->Contents->MetaTypes->find()->find('Network')->select(['id', 'name', 'slug', 'icon'])->where(['slug' => $type, 'delete' => 0]);
        if($metaType->count() == 0 || $type=='pages'){
            throw new NotFoundException(sprintf(__d('ittvn','This %s not exist.'),$type));
        }
        
        $query = $this->Contents->find()
                ->find('Network')
                ->select(['Contents.id', 'Contents.name', 'Contents.slug', 'Contents.excerpt', 'Contents.image', 'Contents.hits'])
                ->matching('MetaTypes', function($q) use($type) {
                    return $q->select(['MetaTypes.id', 'MetaTypes.name', 'MetaTypes.slug'])->where(['MetaTypes.slug' => $type]);
                })
                ->contain([
                    'ContentMetas' => function($q) {
                        return $q->select(['id', 'key', 'value', 'content_id']);
                    }
                ])
                ->where(['Contents.status' => 1, 'Contents.delete' => 0]);

        $this->set('metaType', $metaType);
        $this->set('contents', $this->paginate($query));
        $this->set('_serialize', ['contents']);

        $this->renderViews([
            'index-' . $this->request->type,
            'index',
        ]);
    }

    /**
     * View method
     *
     * @param string|null $id Content id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view() {
		$this->loadModel('Contents.ContentMetas');
		$ContentMetas = $this->ContentMetas;
		$this->loadModel('Contents.Categories');
		$Categories = $this->Categories;
		$this->loadModel('Contents.CategoryContents');
		$CategoryContents = $this->CategoryContents;
		
        $content = $this->Contents->find()
                ->select(['Contents.id', 'Contents.slug', 'Contents.name', 'Contents.image', 'Contents.excerpt', 'Contents.description', 'Contents.created'])
                ->find('Network')
                ->where(['Contents.slug' => $this->request->slug, 'Contents.delete' => 0])
				->formatResults(function($result) use($ContentMetas, $Categories, $CategoryContents){
					return $result->map(function($row) use($ContentMetas, $Categories, $CategoryContents){
						$contentMetas = $ContentMetas->find()->find('network')->select(['id', 'key', 'value', 'content_id'])->where(['content_id'=>$row->id]);
						if($contentMetas->count() > 0){
							$row['content_metas'] = $contentMetas->toArray();
						}else{
							$row['content_metas'] = [];
						}
						
						$category_ids = $CategoryContents->find('list',['keyField'=>'category_id', 'valueField'=>'category_id'])->find('network')->where(['content_id'=>$row->id]);
						if($category_ids->count() > 0){
							$categories = $Categories->find()->find('network')->select(['id', 'name', 'slug', 'meta_category_id'])->where(['id IN'=>$category_ids->toArray()]);
							if($categories->count() > 0){
								$row['categories'] = $categories->toArray();
							}else{
								$row['categories'] = [];
							}
						}else{
							$row['categories'] = [];
						}
						
						return $row;
					});
				})
                ->first();

        //update hits
        $hit = $content->hits;
        $content->hits = intval($hit) + 1;
        $this->Contents->saveNetwork($content);

        $categories = [];
        if (count($content->categories) > 0) {
            $categories = Hash::extract($content->categories, '{n}.id');
        }

        $this->set(compact('content', 'categories'));
        $this->set('_serialize', ['content']);
        
        if(isset($content->layout) && !empty($content->layout)){
            $this->viewBuilder()->layout($content->layout);
        }        

        $this->renderViews([
            'view-' . $this->request->type . '-' . $this->request->slug,
            'view-' . $this->request->type,
            'view',
        ]);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $content = $this->Contents->newEntity();
        if ($this->request->is('post')) {
            $content = $this->Contents->patchEntity($content, $this->request->data);
            
            if ($this->Contents->saveNetwork($content)) {
                $this->Flash->success(__('The content has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The content could not be saved. Please, try again.'));
            }
        }
        $categoryContents = $this->Contents->CategoryContents->find('list')->find('Network');
        $metaTypes = $this->Contents->MetaTypes->find('list')->find('Network')->where(['delete'=>0]);
        $this->set(compact('content', 'categoryContents', 'metaTypes'));
        $this->set('_serialize', ['content']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Content id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $content = $this->Contents->getNetwork($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $content = $this->Contents->patchEntity($content, $this->request->data);
            if ($this->Contents->saveNetwork($content)) {
                $this->Flash->success(__('The content has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The content could not be saved. Please, try again.'));
            }
        }
        $categoryContents = $this->Contents->CategoryContents->find('list')->find('Network');
        $metaTypes = $this->Contents->MetaTypes->find('list')->find('Network')->where(['delete'=>0]);
        $this->set(compact('content', 'categoryContents', 'metaTypes'));
        $this->set('_serialize', ['content']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Content id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $content = $this->Contents->getNetwork($id);
        if ($this->Contents->deleteNetwork($content)) {
            $this->Flash->success(__('The content has been deleted.'));
        } else {
            $this->Flash->error(__('The content could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
