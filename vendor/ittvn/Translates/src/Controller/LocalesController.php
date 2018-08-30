<?php
namespace Translates\Controller;

use Translates\Controller\AppController;
 
/**
 * Locales Controller
 *
 * @property \Translates\Model\Table\LocalesTable $Locales
 */
class LocalesController extends AppController
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
    
            $query = $this->Locales->find();            
                $this->set('locales', $this->paginate($query));
            $this->set('_serialize', ['locales']);
    
    }

    /**
     * View method
     *
     * @param string|null $id Locale id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $locale = $this->Locales->get($id, [
            'contain' => ['Translates']
        ]);
        $this->set('locale', $locale);
        $this->set('_serialize', ['locale']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $locale = $this->Locales->newEntity();
        if ($this->request->is('post')) {
            $locale = $this->Locales->patchEntity($locale, $this->request->data);
            if ($this->Locales->save($locale)) {
                $this->Flash->success(__('The locale has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The locale could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('locale'));
        $this->set('_serialize', ['locale']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Locale id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $locale = $this->Locales->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $locale = $this->Locales->patchEntity($locale, $this->request->data);
            if ($this->Locales->save($locale)) {
                $this->Flash->success(__('The locale has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The locale could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Locales,['belongsToMany'=>[]]);
        $this->set('belongsToMany',$associations['belongsToMany']);        
        $this->set(compact('locale'));
        $this->set('_serialize', ['locale']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Locale id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $locale = $this->Locales->get($id);
        if ($this->Locales->delete($locale)) {
            $this->Flash->success(__('The locale has been deleted.'));
        } else {
            $this->Flash->error(__('The locale could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
