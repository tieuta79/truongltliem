<?php
namespace Medias\Controller;

use Medias\Controller\AppController;
 
/**
 * Slideshow Controller
 *
 * @property \Medias\Model\Table\SlideshowTable $Slideshow
 */
class SlideshowController extends AppController
{

    /**
     * beforeFilter method
     *
     * @return void Redirects on successful beforeFilter, renders view otherwise.
     */
    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);
            }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
    
            $query = $this->Slideshow->find();            
                $query = $query->contain(['Galleries', 'Categories']);
                $this->set('slideshow', $this->paginate($query));
            $this->set('_serialize', ['slideshow']);
    
    }

    /**
     * View method
     *
     * @param string|null $id Slideshow id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $slideshow = $this->Slideshow->get($id, [
            'contain' => ['Galleries', 'Categories']
        ]);
        $this->set('slideshow', $slideshow);
        $this->set('_serialize', ['slideshow']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $slideshow = $this->Slideshow->newEntity();
        if ($this->request->is('post')) {
            $slideshow = $this->Slideshow->patchEntity($slideshow, $this->request->data);
            if ($this->Slideshow->save($slideshow)) {
                $this->Flash->success(__('The slideshow has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The slideshow could not be saved. Please, try again.'));
            }
        }
        $galleries = $this->Slideshow->Galleries->find('list', ['limit' => 200]);
        $categories = $this->Slideshow->Categories->find('list', ['limit' => 200]);
        $this->set(compact('slideshow', 'galleries', 'categories'));
        $this->set('_serialize', ['slideshow']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Slideshow id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $slideshow = $this->Slideshow->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $slideshow = $this->Slideshow->patchEntity($slideshow, $this->request->data);
            if ($this->Slideshow->save($slideshow)) {
                $this->Flash->success(__('The slideshow has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The slideshow could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Slideshow,['belongsToMany'=>[]]);
        $this->set('belongsToMany',$associations['belongsToMany']);        
        $galleries = $this->Slideshow->Galleries->find('list', ['limit' => 200]);
        $categories = $this->Slideshow->Categories->find('list', ['limit' => 200]);
        $this->set(compact('slideshow', 'galleries', 'categories'));
        $this->set('_serialize', ['slideshow']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Slideshow id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $slideshow = $this->Slideshow->get($id);
        if ($this->Slideshow->delete($slideshow)) {
            $this->Flash->success(__('The slideshow has been deleted.'));
        } else {
            $this->Flash->error(__('The slideshow could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
