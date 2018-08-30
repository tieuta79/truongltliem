<?php

namespace Menus\Controller\Admin;

use Menus\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Hash;

/**
 * Menus Controller
 *
 * @property \Menus\Model\Table\MenusTable $Menus
 */
class MenusController extends AppController {

    /**
     * Index method
     *
     * @return void
     */
    public function index($menutype_id = null) {
        $contents = [];
        $this->loadModel('Metas.MetaTypes');
        $this->loadModel('Contents.Categories');

        $metaTypes = $this->MetaTypes->find()->select(['id', 'name', 'slug'])->find('network')->orderAsc('name');
        $metatype_list = [];
        $metacategory_list = [];
        foreach ($metaTypes as $metaType) {
            $content = $this->MetaTypes->Contents->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['meta_type_id' => $metaType->id])->find('network')->toArray();
            $metaCategories = $this->MetaTypes->MetaCategories->find()->select(['id', 'name', 'slug'])->find('network')->where(['meta_type_id' => $metaType->id]);
            $categories = [];
            foreach ($metaCategories as $metaCategory) {
                $categories[$metaCategory->name] = $this->Categories->find('treeList', ['spacer' => '------'])->where(['meta_category_id' => $metaCategory->id])->find('network')->toArray();
                $metacategory_list[$metaCategory->id] = $metaCategory->name;
            }

            if ($metaType->slug == 'pages') {
                $content = Hash::merge([__d('ittvn', 'Home Page')], $content);
            }

            $contents[] = [
                'posttype' => $metaType->toArray(),
                'contents' => $content,
                'categories' => $categories
            ];
            $metatype_list[$metaType->id] = $metaType->name;
        }

        //menutypes
        $menutypes = $this->Menus->Menutypes->find('list', ['limit' => 200])->find('network');
        //menus

        $menus = $this->Menus->find('threaded')
                ->contain([
                    'Categories' => function($q) {
                        return $q->select(['meta_category_id']);
                    },
                    'Contents' => function($q) {
                        return $q->select(['meta_type_id']);
                    }
                ])
                ->find('network')
                ->orderAsc('order');
        if (empty($menutype_id)) {
            if ($menutypes->count() > 0) {
                $mk = array_keys($menutypes->toArray());
                $menutype_id = $mk[0];
            } else {
                $menutype_id = 0;
            }
        }

        $menus->where(['menutype_id' => $menutype_id]);

        $menus->formatResults(function ($results) use($metatype_list, $metacategory_list) {
            return $results->map(function ($row) use($metatype_list, $metacategory_list) {
                        if (isset($row->content) && count($row->content) > 0) {
                            $row->metaContent = $metatype_list[$row->content->meta_type_id];
                        } else if (isset($row->category) && count($row->category) > 0) {
                            $row->metaCategory = $metacategory_list[$row->category->meta_category_id];
                        }

                        if (isset($row->children) && count($row->children) > 0) {
                            foreach ($row->children as $k => $child) {
                                if (isset($child->content) && count($child->content) > 0) {
                                    $row->children[$k]->metaContent = $metatype_list[$child->content->meta_type_id];
                                } else if (isset($child->category) && count($child->category) > 0) {
                                    $row->children[$k]->metaCategory = $metacategory_list[$child->category->meta_category_id];
                                }
                            }
                        }
                        return $row;
                    });
        });


        $this->set(compact('menus', 'menutypes', 'contents', 'metatype_list'));
        $this->set('_serialize', ['menus']);
    }

    /**
     * View method
     *
     * @param string|null $id Menu id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $this->Menus->locale('en');
        $menu = $this->Menus->getNetwork($id, [
            'contain' => ['Categories', 'Contents', 'Menutypes']
        ]);
        $this->set('menu', $menu);
        $this->set('_serialize', ['menu']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $return = ['status' => false, 'data' => ''];
        $menu = $this->Menus->newEntity();
        if ($this->request->is(['post', 'put']) &&
                (
                (isset($this->request->data['content_id']) && $this->request->data['content_id'] != '') ||
                (isset($this->request->data['category_id']) && !empty($this->request->data['category_id'])) ||
                (isset($this->request->data['url']) && !empty($this->request->data['url']))
                )
        ) {
            $order = $this->Menus->find()->find('network')->where(['menutype_id' => $this->request->data['menutype_id']])->count();
            $this->request->data['name'] = str_replace('--', '', $this->request->data['name']);
            $this->request->data['order'] = ++$order;
            $data_menu = $this->request->data;
            if (isset($data_menu['content_id']) && $data_menu['content_id'] == 0) {
                unset($data_menu['content_id']);
                $data_menu['url'] = 'plugin:false/controller:Pages/action:display/home';
            }

            $menu = $this->Menus->patchEntity($menu, $data_menu);
            if ($this->Menus->saveNetwork($menu)) {
                if (!empty($menu->content_id)) {
                    $this->loadModel('Contents.Contents');
                    $content = $this->Contents->findById($menu->content_id)->find('network')->contain(['MetaTypes' => function($q) {
                                    return $q->select(['id', 'name', 'slug']);
                                }])->first();
                    $menu->metaContent = $content->meta_type->name;
                    $menu->url = 'plugin:Contents/controller:Contents/action:view/type:' . $content->meta_type->slug . '/slug:' . $content->slug;
                } else if (!empty($menu->category_id)) {
                    $this->loadModel('Contents.Categories');
                    $category = $this->Categories->findById($menu->category_id)->find('network')->contain(['MetaCategories' => function($q) {
                                    return $q->select(['id', 'name', 'slug', 'meta_type_id']);
                                }])->first();
                    $this->loadModel('Metas.MetaTypes');
                    $metaType = $this->MetaTypes->findById($category->meta_category->meta_type_id)->select(['id', 'name', 'slug'])->find('network')->first();
                    $menu->metaCategory = $category->meta_category->name;
                    $menu->url = 'plugin:Contents/controller:Categories/action:view/type:' . $metaType->slug . '/taxonomy:' . $category->meta_category->slug . '/slug:' . $category->slug;
                }
                //Update Url
                $this->Menus->saveNetwork($menu);

                $return['status'] = true;
                $event = new Event('Menus.Admin.addItem', [
                    'item' => $menu
                ]);
                $result = $this->eventManager()->dispatch($event);
                if (!empty($result->result)) {
                    $return['data'] = $result->result;
                }
            }
        }
        $this->set('return', $return);
        $this->set('_serialize', 'return');
    }

    /**
     * Edit method
     *
     * @param string|null $id Menu id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit() {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $menus = $this->Menus->find('list', ['keyField' => 'slug', 'valueField' => 'slug'])->find('network')
                            ->where(['menutype_id' => $this->request->data['menutype_id']])->toArray();

            if (isset($this->request->data['menus']) && count($this->request->data['menus']) > 0) {
                $i = 1;
                foreach ($this->request->data['menus'] as $id => $data) {
                    if (in_array($data['slug'], $menus) || empty($data['slug'])) {
                        $menu = $this->Menus->getNetwork($id);
                        $menu->order = $i;
                        $menu = $this->Menus->patchEntity($menu, $data);
                        $this->Menus->saveNetwork($menu);

                        if (!empty($data['slug'])) {
                            unset($menus[$data['slug']]);
                        }
                        $i++;
                    }
                }
            }

            if (count($menus) > 0) {
                $this->Menus->deleteAllNetwork(['Menus.slug IN' => $menus]);
            }

            $this->Flash->success(__('The menu has been saved.'));
            return $this->redirect($this->referer());
        }
        $this->Flash->error(__('The menu could not be saved. Please, try again.'));
        return $this->redirect($this->referer());
    }

    /**
     * Delete method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $menu = $this->Menus->getNetwork($id)->find('network');
        if ($this->Menus->deleteNetwork($menu)) {
            $this->Flash->success(__('The menu has been deleted.'));
        } else {
            $this->Flash->error(__('The menu could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
