<?php
namespace Menus\Controller\Admin;

use Menus\Controller\AppController;

/**
 * Menutypes Controller
 *
 * @property \Menus\Model\Table\MenutypesTable $Menutypes
 */
class MenutypesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('menutypes', $this->paginate($this->Menutypes->find('network')));
        $this->set('_serialize', ['menutypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Menutype id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $menutype = $this->Menutypes->get($id, [
            'contain' => ['Menus']
        ])->find('network');
        $this->set('menutype', $menutype);
        $this->set('_serialize', ['menutype']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $message = ['success'=>false,'message'=>''];
        $menutype = $this->Menutypes->newEntity();
        if ($this->request->is('post')) {
            $menutype = $this->Menutypes->patchEntity($menutype, $this->request->data);
            if ($this->Menutypes->saveNetwork($menutype)) {
                $message['message'] = __('The menutype has been saved.');
                $message['success'] = true;
            } else {
                $message['message'] = __('The menutype could not be saved. Please, try again.');   
            }
        }
        echo json_encode($message);
        die();
    }

    /**
     * Edit method
     *
     * @param string|null $id Menutype id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $menutype = $this->Menutypes->get($id, [
            'contain' => []
        ])->find('network');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $menutype = $this->Menutypes->patchEntity($menutype, $this->request->data);
            if ($this->Menutypes->saveNetwork($menutype)) {
                $this->Flash->success(__('The menutype has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The menutype could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('menutype'));
        $this->set('_serialize', ['menutype']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Menutype id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $menutype = $this->Menutypes->get($id)->find('network');
        if ($this->Menutypes->deleteNetwork($menutype)) {
            $this->Flash->success(__('The menutype has been deleted.'));
        } else {
            $this->Flash->error(__('The menutype could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
