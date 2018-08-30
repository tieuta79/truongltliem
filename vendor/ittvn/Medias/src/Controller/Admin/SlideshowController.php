<?php

namespace Medias\Controller\Admin;

use Medias\Controller\AppController;
use Cake\Event\Event;

/**
 * Slideshow Controller
 *
 * @property \Medias\Model\Table\SlideshowTable $Slideshow
 */
class SlideshowController extends AppController {

    /**
     * beforeFilter method
     *
     * @return void Redirects on successful beforeFilter, renders view otherwise.
     */
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        if ($this->request->is('post')) {
            $tableParams = $this->DataTable->tableParams('Slideshow');
            if (count($tableParams['search']) > 0) {
                $query = $this->Slideshow->find('search', $this->Slideshow->filterParams($tableParams['search']));
            } else {
                $query = $this->Slideshow->find();
            }
            $query->find('network');
            $query->contain(['Galleries', 'Categories']);
            $this->DataTable->table('Slideshow', $query, $tableParams);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Slideshow id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $slideshow = $this->Slideshow->getNetwork($id, [
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
    public function add() {
        $slideshow = $this->Slideshow->newEntity();
        if ($this->request->is('post')) {
            $slideshow = $this->Slideshow->patchEntity($slideshow, $this->request->data);
            if ($this->Slideshow->saveNetwork($slideshow)) {
                $this->Flash->success(__('The slideshow has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The slideshow could not be saved. Please, try again.'));
            }
        }


        $this->loadModel('Medias.Galleries');
        $this->loadModel('Contents.Contents');
        $this->loadModel('Contents.Categories');
        $galleries = $this->Galleries->find('treeList', ['spacer' => '------'])->find('network')->where(['status' => 1]);
        $categories = $this->Categories->find('list')->find('network')->where(['delete' => 0]);
        $contents = $this->Contents->find('list')->find('network')->where(['meta_type_id' => 1, 'status' => 1, 'delete' => 0]);
        $this->set(compact('slideshow', 'galleries', 'categories', 'contents'));
        $this->set('_serialize', ['slideshow']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Slideshow id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $slideshow = $this->Slideshow->getNetwork($id, [
            'contain' => []
        ]);
        if (!empty($slideshow->config)) {
            $slideshow->config = json_decode($slideshow->config, true);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            if(isset($slideshow->config['images'])){
                $this->request->data['config']['images'] = $slideshow->config['images'];
            }
            $slideshow = $this->Slideshow->patchEntity($slideshow, $this->request->data);
            if ($this->Slideshow->saveNetwork($slideshow)) {
                $this->Flash->success(__('The slideshow has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The slideshow could not be saved. Please, try again.'));
            }
        }
        $this->loadModel('Medias.Galleries');
        $this->loadModel('Contents.Contents');
        $this->loadModel('Contents.Categories');
        $galleries = $this->Galleries->find('treeList', ['spacer' => '------'])->find('network')->where(['status' => 1]);
        $categories = $this->Categories->find('list')->find('network')->where(['delete' => 0]);
        $contents = $this->Contents->find('list')->find('network')->where(['meta_type_id' => 1, 'status' => 1, 'delete' => 0]);
        $this->set(compact('slideshow', 'galleries', 'categories', 'contents'));
        $this->set('_serialize', ['slideshow']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Slideshow id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $slideshow = $this->Slideshow->getNetwork($id);
        if ($this->Slideshow->deleteNetwork($slideshow)) {
            $this->Flash->success(__('The slideshow has been deleted.'));
        } else {
            $this->Flash->error(__('The slideshow could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function slides($slide_id = null) {
        $slideshow = $this->Slideshow->getNetwork($slide_id);

        if (!empty($slideshow->config)) {
            $slideshow->config = json_decode($slideshow->config, true);
        }

        $this->set(compact('slideshow'));
    }

    public function addSlide($slide_id = null) {
        $slideshow = $this->Slideshow->getNetwork($slide_id);

        if (!empty($slideshow->config)) {
            $slideshow->config = json_decode($slideshow->config, true);
            if (!isset($slideshow->config['images'])) {
                $slideshow->config['images'] = [];
            }

            $count = count($slideshow->config['images']);
            $slideshow->config['images'][$count]['title'] = 'Slide ' . ($count + 1);
            $slideshow->config['images'][$count]['contents'] = 'Slide ' . ($count + 1);
            $slideshow->config = json_encode($slideshow->config);

            $this->Slideshow->save($slideshow);
        }
        $this->redirect($this->request->referer());
    }

}
