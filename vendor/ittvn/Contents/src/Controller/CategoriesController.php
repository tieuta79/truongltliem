<?php
namespace Contents\Controller;

use Contents\Controller\AppController;
use Cake\Event\Event;
/**
 * Categories Controller
 *
 * @property \Contents\Model\Table\CategoriesTable $Categories
 */
class CategoriesController extends AppController
{

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['view']);
    }
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ParentCategories', 'MetaCategories']
        ];
        $this->set('categories', $this->paginate($this->Categories));
        $this->set('_serialize', ['categories']);
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view()
    {        
        //pr($this->request);die();
        $category = $this->Categories->find('threaded')
                ->find('network')
                ->select(['Categories.id','Categories.name','Categories.slug','Categories.description','Categories.parent_id'])
                ->contain(['MetaCategories'=>function($q){return $q->select(['id','name','slug']);}])
                ->where(['Categories.delete'=>0,'Categories.slug'=>$this->request->slug])->first();
        
        $this->loadModel('Contents.CategoryContents');       
        $listContent = $this->CategoryContents->find('list',['keyField'=>'id','valueField'=>'content_id'])->find('network')->where(['category_id'=>$category->id]);
                
        $this->loadModel('Contents.Contents');
        $contents = $this->Contents->find()
                ->find('network')
                ->select(['Contents.id', 'Contents.slug', 'Contents.name', 'Contents.image', 'Contents.excerpt', 'Contents.created'])
                ->contain(['ContentMetas' => function($q) {
                        return $q->select(['id', 'key', 'value', 'content_id']);
                    }, 'Categories' => function($q){
                        return $q->select(['Categories.id']);
                    }])
                ->where(['Contents.delete' => 0]);        

        if($listContent->count() > 0){
            $contents->andWhere(['Contents.id IN'=>$listContent->toArray()]);
        }else{
            $contents->andWhere(['Contents.id'=>0]);
        }
                    
        $this->set(compact('contents','category'));
        $this->set('_serialize', ['category']);
        
        $this->renderViews([
            'view-' . $this->request->type. '-' . $this->request->taxonomy . '-' . $this->request->slug,
            'view-' . $this->request->type. '-' . $this->request->taxonomy,
            'view-' . $this->request->type,
            'view',
        ]);        
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $category = $this->Categories->newEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->data);
            if ($this->Categories->saveNetwork($category)) {
                $this->Flash->success(__('The category has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }
        }
        $parentCategories = $this->Categories->ParentCategories->find('list', ['limit' => 200])->find('network');
        $metaCategories = $this->Categories->MetaCategories->find('list', ['limit' => 200])->find('network');
        $this->set(compact('category', 'parentCategories', 'metaCategories'));
        $this->set('_serialize', ['category']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->data);
            if ($this->Categories->saveNetwork($category)) {
                $this->Flash->success(__('The category has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }
        }
        $parentCategories = $this->Categories->ParentCategories->find('list', ['limit' => 200]);
        $metaCategories = $this->Categories->MetaCategories->find('list', ['limit' => 200]);
        $this->set(compact('category', 'parentCategories', 'metaCategories'));
        $this->set('_serialize', ['category']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->deleteNetwork($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
