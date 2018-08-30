<?php

namespace Products\Controller;

use Products\Controller\AppController;
use Cake\Event\Event;

/**
 * Filters Controller
 *
 * @property \Products\Model\Table\FiltersTable $Filters
 */
class FiltersController extends AppController {

    /**
     * beforeFilter method
     *
     * @return void Redirects on successful beforeFilter, renders view otherwise.
     */
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['view']);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        $query = $this->Filters->find();
        $this->set('filters', $this->paginate($query));
        $this->set('_serialize', ['filters']);
    }

    /**
     * View method
     *
     * @param string|null $id Filter id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view() {
        //pr($this->request);die();
        $this->loadModel('Contents.Categories');
        $category = $this->Categories->find('threaded')
                ->select(['Categories.id','Categories.name','Categories.slug','Categories.description','Categories.parent_id'])
                ->contain(['MetaCategories'=>function($q){return $q->select(['id','name','slug']);}])
                ->where(['Categories.delete'=>0,'Categories.slug'=>$this->request->category])->first();
                
       $list = $this->Categories->find('list',['keyField'=>'id','valueField'=>'id'])->find('children', ['for' => $category->id]);
       $list = $list->toArray();
       $list[$category->id] = $category->id;
                
        $this->loadModel('Contents.CategoryContents');       
        $listContent = $this->CategoryContents->find('list',['keyField'=>'id','valueField'=>'content_id'])->where(['category_id IN'=>$list]);
        
        $filter = $this->Filters->find()->select(['id','name','slug','attributes'])->where(['slug'=>$this->request->type,'delete'=>0])->first();
        
        if(isset($filter->attributes['price']) && !empty($filter->attributes['price'])){
            $filter_price = [];
            $this->loadModel('Contents.ContentMetas');
            if(strpos($filter->attributes['price'],'-')==true){
                $price = explode('-',$filter->attributes['price']);
                $filter_price = $this->ContentMetas->find('list',['keyField'=>'id','valueField'=>'content_id'])->where(['key'=>'Price'])->andWhere(function($q) use($price){
                    return $q->between('value', trim($price[0]), trim($price[1]));
                });
            }else{
                $price = $filter->attributes['price'];                               
                if($price=='1000000'){
                    $filter_price = $this->ContentMetas->find('list',['keyField'=>'id','valueField'=>'content_id'])->where(['key'=>'Price','value <='=>$price]);
                }else if($price=='5000000'){
                    $filter_price = $this->ContentMetas->find('list',['keyField'=>'id','valueField'=>'content_id'])->where(['key'=>'Price','value >='=>$price]);
                }
            }
        }        
                //pr($filter_price->toArray());die();
        
        $this->loadModel('Contents.Contents');
        $contents = $this->Contents->find()
                ->select(['Contents.id', 'Contents.slug', 'Contents.name', 'Contents.image', 'Contents.excerpt'])
                ->contain(['ContentMetas' => function($q){
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
        
        if(isset($filter_price)){
            if($filter_price->count() > 0){
                $contents->andWhere(['Contents.id IN'=>$filter_price->toArray()]);
            }else{
                $contents->andWhere(['Contents.id'=>0]);
            }
        }      
        
        if(isset($filter->attributes['status']) && count($filter->attributes['status']) > 0){
            foreach ($filter->attributes['status'] as $status){
                if($status == 'new'){
                    $contents->limit(20);
                }else if($status == 'featured'){
                    $contents->andWhere(['Contents.featured'=>1]);
                }
            }
        }       

        $contents->orderDesc('Contents.id');       
                    //pr($contents->toArray());die();
        $this->set(compact('contents','category','filter'));
        $this->set('_serialize', ['category']);       
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $filter = $this->Filters->newEntity();
        if ($this->request->is('post')) {
            $filter = $this->Filters->patchEntity($filter, $this->request->data);
            if ($this->Filters->save($filter)) {
                $this->Flash->success(__('The filter has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The filter could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('filter'));
        $this->set('_serialize', ['filter']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Filter id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $filter = $this->Filters->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $filter = $this->Filters->patchEntity($filter, $this->request->data);
            if ($this->Filters->save($filter)) {
                $this->Flash->success(__('The filter has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The filter could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Filters, ['belongsToMany' => []]);
        $this->set('belongsToMany', $associations['belongsToMany']);
        $this->set(compact('filter'));
        $this->set('_serialize', ['filter']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Filter id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $filter = $this->Filters->get($id);
        if ($this->Filters->delete($filter)) {
            $this->Flash->success(__('The filter has been deleted.'));
        } else {
            $this->Flash->error(__('The filter could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
