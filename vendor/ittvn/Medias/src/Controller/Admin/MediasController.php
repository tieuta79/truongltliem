<?php

namespace Medias\Controller\Admin;

use Medias\Controller\AppController;
use Ittvn\Utility\Upload;
use Cake\View\HelperRegistry;
use Cake\View\View;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\View\Helper\UrlHelper;
use Cake\Event\Event;

/**
 * Medias Controller
 *
 * @property \Medias\Model\Table\MediasTable $Medias
 */
class MediasController extends AppController {

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['getMedias']);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index() {        
        $this->loadModel('Medias.Galleries');
        $galleries = $this->Galleries->find('threaded')->find('network')->where(['status' => 1]);
        $this->set(compact('galleries'));
    }

    /**
     * Gallery method
     */
    public function getMedias() {
        $return = ['status' => false, 'data' => []];
        if ($this->request->is(['post', 'put'])) {
            $return['status'] = true;
            if (!empty($this->request->data['gallery_id'])) {
                $return['data'] = $this->Medias->find()->find('network')->where(['gallery_id' => $this->request->data['gallery_id']])->orderDesc('id');
            } else {
                $return['data'] = $this->Medias->find()->find('network')->orderDesc('id');
            }
        }
        $this->set('medias', $return);
        $this->set('_serialize', 'medias');
    }

    public function filterMedias() {
        $return = ['status' => false, 'data' => []];
        if ($this->request->is(['post', 'put'])) {
            $return['status'] = true;
            $return['data'] = $this->Medias->find()->find('network')->where(['gallery_id' => $this->request->data['gallery_id']])->orderDesc('id');
            if (!empty($this->request->data['q'])) {
                $return['data']->andWhere(['OR' => ['title LIKE' => '%' . mb_strtolower($this->request->data['q'], 'UTF-8') . '%', 'description LIKE' => '%' . mb_strtolower($this->request->data['q'], 'UTF-8') . '%']]);
            }

            if (!empty($this->request->data['month'])) {
                $return['data']->andWhere(['month(created)' => $this->request->data['month']]);
            }

            if (!empty($this->request->data['year'])) {
                $return['data']->andWhere(['year(created)' => $this->request->data['year']]);
            }
        }
        $this->set('medias', $return);
        $this->set('_serialize', 'medias');
    }

    /**
     * Edit method
     *
     * @param string|null $id Media id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $media = $this->Medias->getNetwork($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $media = $this->Medias->patchEntity($media, $this->request->data);
            if ($this->Medias->saveNetwork($media)) {
                $this->Flash->success(__('The media has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The media could not be saved. Please, try again.'));
            }
        }
        $this->loadModel('Medias.Galleries');
        $galleries = $this->Galleries->find('list')->find('network');
        $this->set(compact('media', 'galleries'));
        $this->set('_serialize', ['media']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Media id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete() {
        $return = ['status'=>false,'data'=>[]];
        $id = $this->request->data['id'];
        $this->request->allowMethod(['post', 'delete']);
        $media = $this->Medias->getNetwork($id);
        
        if ($this->Medias->deleteNetwork($media)){
            $return = [
                'status'=>true,
                'data'=>$media->toArray()
            ];
        }
        $this->set(compact('return', 'galleries'));
        $this->set('_serialize', 'return');
    }

    public function upload() {
        $success = [];
        if ($this->request->is('post')) {
            $uploads = new Upload();
            // if (!empty($this->request->data['gallery_id'])) {
            //     $gallery = $this->Medias->Galleries->get($this->request->data['gallery_id']);
            //     $uploads->path = $uploads->path . DS . $gallery->slug;
            // }
            //pr($this->request->data['file']); die();
            $files = $uploads->medias($this->request->data['file']);
            if (count($files) > 0) {
                foreach ($files as $file) {
                    $media = $this->Medias->newEntity([
                        'name' => $file['filename'],
                        'title' => $file['filename'],
                        'url' => $file['url'],
                        'type' => $file['mime'],
                        'size' => $file['size_in_bytes'],
                        'gallery_id' => $this->request->data['gallery_id']
                    ]);
                    $this->Medias->saveNetwork($media);

                    $success[] = [
                        'description' => '',
                        'title' => $file['filename'],
                        'url' => $file['url']
                    ];
                }
            }
        }
        $this->set(compact('success'));
        $this->set('_serialize', 'success');
    }

    public function popup() {
        $galleries = $this->Medias->Galleries->find('treeList')->find('network')->where(['status' => 1])->toArray();
        $this->set(compact('galleries'));
        $this->set('_serialize', ['galleries']);
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $media = $this->Medias->getNetwork($id);
        $this->set('media', $media);
        $this->set('_serialize', ['media']);
    }

    public function uploadFile() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $uploads = new Upload();
            $file = $uploads->media($this->request->data['file']);

            $media = $this->Medias->newEntity([
                'name' => $file['filename'],
                'title' => $file['filename'],
                'url' => $file['url'],
                'type' => $file['mime'],
                'size' => $file['size_in_bytes']
            ]);
            $this->Medias->saveNetwork($media);

            echo $this->__rowItem($this->request->data['field'], [
                'id' => $media->id,
                'url' => $file['url'],
                'title' => $file['filename'],
                'order' => '{{order}}'
            ]);
        }
        die();
    }

    public function showFile() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $table = [];
            $files = json_decode($this->request->data['files'], true);
            foreach ($files as $k => $file) {
                $file['order'] = $k + 1;
                $table[] = $this->__rowItem($this->request->data['name'], $file);
            }
            echo implode('', $table);
        }
        die();
    }

    private function __rowItem($name, $media) {
        $helpers = new HelperRegistry(new View());
        $this->Html = $helpers->load('Html', []);
        return $this->Html->tableCells([
                    $this->Html->image($media['url'], ['width' => 50]) .
                    '<input type="hidden" name="' . $name . '[' . $media['order'] . '][id]" value="' . $media['id'] . '" class="form-control" />' .
                    '<input type="hidden" name="' . $name . '[' . $media['order'] . '][url]" value="' . $media['url'] . '" class="form-control" />',
                    '<input type="text" name="' . $name . '[' . $media['order'] . '][title]" value="' . $media['title'] . '" class="form-control" />',
                    '<input type="text" name="' . $name . '[' . $media['order'] . '][order]" value="' . $media['order'] . '" class="form-control" size="3" />',
                        [
                        '<a href="javascript:void(0)" class="btn btn-danger btn-sm" data-toggle="tooltip" delete-item-file="true" title="Delete File"><i class="fa fa-trash-o"></i></a>',
                            [
                            'class' => 'text-center'
                        ]
                    ]
                        ], ['it_id' => $media['id']]);
    }

}
