<?php

namespace Medias\Controller\Admin;

use Medias\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
/**
 * Galleries Controller
 *
 * @property \Medias\Model\Table\GalleriesTable $Galleries
 */
class GalleriesController extends AppController {

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        
        $galleries = $this->Galleries->find('threaded')->find('network')->where(['status' => 1]);
        $tree_view = [
            'text' => 'Root',
            'id' => '',
            'icon' => 'folder',
            'children' => $this->treeView($galleries->toArray()),
            'state' => [
                'opened' => true,
            //'disabled' => true
            ]
        ];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($tree_view);
        die();
    }

    public function treeView($galleries = [], $deep = 0) {
       
        $tree = [];
        if (empty($galleries))
            return [];

        $i = 0;
        foreach ($galleries as $gallery) {

            $tree[$i]['text'] = $gallery->name;
            $tree[$i]['id'] = $gallery->id;
            $tree[$i]['icon'] = 'folder';

            if (isset($gallery->children) && count($gallery->children) > 0) {
                $deep_child = $deep + 1;
                $tree[$i]['children'] = $this->treeView($gallery->children, $deep_child);
            }

            $i++;
        }
        return $tree;
    }

    /**
     * View method
     *
     * @param string|null $id Gallery id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        header('Content-Type: application/json; charset=utf-8');
        if (empty($id)) {
            //if(isset($this->request->query['popup'])){
            $medias = $this->Galleries->Medias->find()->find('network');
            //}else{
            //$medias = $this->Galleries->Medias->find()->where(['OR'=>['gallery_id'=>0,'gallery_id'=>NULL]]);
            //}            
        } else {
            $medias = $this->Galleries->Medias->find()->find('network')->where(['gallery_id' => $id]);
        }

        echo json_encode(['type' => 'folder', 'content' => $medias->toArray()]);
        die();
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($parent_id = null) {
        $return = ['status' => false, 'message' => '', 'data' => ''];

        $gallery = $this->Galleries->newEntity();
        $parent = __d('ittvn', 'root');
        if (!empty($parent_id)) {
            $p = $this->Galleries->getNetwork($parent_id);
            if ($p) {
                $parent = $p->name;
            }
        }

        if ($this->request->is('post')) {
            if (!empty($parent_id)) {
                $this->request->data['parent_id'] = $p->id;
            }

            $gallery = $this->Galleries->patchEntity($gallery, $this->request->data);
            if ($this->Galleries->saveNetwork($gallery)) {
                $return['status'] = true;
                $return['data'] = $gallery;
                $return['message'] = sprintf(__d('ittvn', 'Folder %s created.'), $gallery->name);
            } else {
                $return['message'] = sprintf(__d('ittvn', 'Folder %s can\'t create.'), $gallery->name);
            }
        }

        $this->set(compact('gallery', 'parent', 'return'));
        $this->set('_serialize', 'return');
    }

    /**
     * Edit method
     *
     * @param string|null $id Gallery id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $return = ['status' => false, 'message' => '', 'data' => ''];
        
        $gallery = $this->Galleries->getNetwork($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $gallery = $this->Galleries->patchEntity($gallery, $this->request->data);
            if ($this->Galleries->saveNetwork($gallery)) {
                $return['status'] = true;
                $return['data'] = $gallery;
                $return['message'] = sprintf(__d('ittvn', 'Folder %s renamed.'), $gallery->name);
            } else {
                $return['message'] = sprintf(__d('ittvn', 'Folder %s can\'t rename.'), $gallery->name);
            }
        }

        $this->set(compact('gallery', 'return'));
        $this->set('_serialize', 'return');
    }

    /**
     * Move method
     *
     * @param string|null $id Gallery id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function move($id = null) {
        header('Content-Type: application/json; charset=utf-8');
        $gallery = $this->Galleries->getNetwork($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->request->data['slug'] = '';
            $gallery = $this->Galleries->patchEntity($gallery, $this->request->data);
            if ($this->Galleries->saveNetwork($gallery)) {
                echo json_encode(['id' => $gallery->id]);
            } else {
                echo json_encode([]);
            }
        }
        die();
    }

    /**
     * Move method
     *
     * @param string|null $id Gallery id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function copy($id = null) {
        header('Content-Type: application/json; charset=utf-8');
        $gallery = $this->Galleries->newEntity($this->request->data);
        $copy_gallery = $this->Galleries->getNetwork($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $gallery = $this->Galleries->patchEntity($gallery, ['name' => $copy_gallery->name, 'slug' => '']);
            if ($this->Galleries->saveNetwork($gallery)) {
                echo json_encode(['id' => $gallery->id]);
            } else {
                echo json_encode([]);
            }
        }
        die();
    }

    /**
     * Delete method
     *
     * @param string|null $id Gallery id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        if (empty($id)) {
            $id = $this->request->data['id'];
        }
        $return = ['status' => false, 'message' => '', 'data' => ''];
        $gallery = $this->Galleries->getNetwork($id);
        if ($this->Galleries->deleteNetwork($gallery)) {
            $return['status'] = true;
            $return['message'] = sprintf(__d('ittvn', 'Folder %s deleted.'), $gallery->name);
        } else {
            $return['message'] = sprintf(__d('ittvn', 'Folder %s can\'t delete.'), $gallery->name);
        }
        $return['data'] = $gallery;
        $this->set(compact('gallery', 'return'));
        $this->set('_serialize', 'return');
    }

    /**
     * update gallery
     */
    function updateGallery() {
        $gallery = $this->Galleries->get($this->request->data['id'])->find('network');

        $gallery->name = $this->request->data['name'];
        if ($this->Galleries->saveNetwork($gallery)) {

            echo json_encode(['status' => 'success', 'msg' => 'Update Gallery successfully!']);
        } else {
            echo json_encode(['status' => 'failed', 'msg' => 'Failed to update Gallery. Please try again']);
        }
    }

}
