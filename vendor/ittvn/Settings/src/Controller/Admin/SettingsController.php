<?php

namespace Settings\Controller\Admin;

use Settings\Controller\AppController;
use Cake\View\HelperRegistry;
use Cake\View\View;
use Cake\Event\EventManager;
use Cake\Event\Event;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;

/**
 * Settings Controller
 *
 * @property \Settings\Model\Table\SettingsTable $Settings
 */
class SettingsController extends AppController {

    /**
     * Dashboard method
     *
     * @return void
     */
    public function dashboard() {
        
    }

    /**
     * General method
     *
     * @return void
     */
    public function general($prefix = null, $global = 0) {

        if (is_numeric($prefix)) {
            $global = $prefix;
            $prefix = null;
        }

        if ($this->request->is('post')) {
            //pr($this->request->data); die();
            if (count($this->request->data) > 0) {
                foreach ($this->request->data as $id => $s) {
                    if (is_array($s)) {
                        $s = json_encode($s);
                    }
                    $this->Settings->updateAllNetwork(['value' => $s], ['id' => $id]);
                }
            }
            if (!empty($global)) {
                $this->redirect(['action' => 'general', $prefix, $global]);
            } else {
                $this->redirect(['action' => 'general', $prefix]);
            }
        }

        $settings = $this->Settings->find()
                ->find('network')
                ->where(['editable' => 1, 'global' => $global, 'delete' => 0])
                ->order('id');

        if (!empty($prefix)) {
            $settings->andWhere(['name LIKE' => $prefix . '.%']);
        }

        $box_settings = [];
        if ($settings->count() > 0) {
            foreach ($settings as $setting) {
                $b = [
                    $setting->name => [
                        'name' => $setting->id,
                        'label' => __d('ittvn', $setting->description),
                        'type' => $setting->type,
                        'class' => 'form-control'
                    ]
                ];

                if (!empty($setting->value)) {
                    $tmp = json_decode(stripslashes($setting->value));
                    if ($tmp == null) {
                        $b[$setting->name]['value'] = $setting->value;
                    } else {
                        $b[$setting->name]['value'] = $tmp;
                    }
                }

                if ($setting->type == 'checkbox') {
                    $options = json_decode($setting->options, true);
                    if (!empty($options)) {
                        $b[$setting->name]['options'] = Hash::combine($options, '{n}.key', '{n}.value');
                        if (isset($b[$setting->name]['value'])) {
                            $b[$setting->name]['value'] = json_decode($b[$setting->name]['value'], true);
                        }
                        $b[$setting->name]['type'] = 'select';
                        $b[$setting->name]['multiple'] = 'checkbox';
                    } else {
                        if (!empty($setting->value)) {
                            $b[$setting->name]['value'] = $setting->value;
                            $b[$setting->name]['checked'] = true;
                        }
                    }
                }

                if ($setting->type == 'radio' || $setting->type == 'select') {
                    $options = json_decode($setting->options, true);
                    if (!empty($options)) {
                        $b[$setting->name]['options'] = Hash::combine($options, '{n}.key', '{n}.value');
                    } else {
                        $b[$setting->name]['options'] = [];
                    }
                }


                if (!empty($setting->method)) {
                    $setting_method = json_decode($setting->method, true);
                    if (empty($setting_method)) {
                        $method = explode('::', $setting->method);
                        $data_value = TableRegistry::get($method[0])->{$method[1]}();
                    } else {
                        $method = explode('::', $setting_method[0]);
                        $data_value = TableRegistry::get($method[0])->{$method[1]}($setting_method[1]);
                    }


                    if (in_array($b[$setting->name]['type'], ['select', 'radio', 'multipleSelect', 'multipleCheckbox', 'radio'])) {
                        $b[$setting->name]['options'] = $data_value;
                        if ($b[$setting->name]['type'] == 'multipleSelect') {
                            $b[$setting->name]['type'] = 'select';
                            $b[$setting->name]['multiple'] = true;
                        } else if ($b[$setting->name]['type'] == 'multipleCheckbox') {
;
                            $b[$setting->name]['type'] = 'select';
                            $b[$setting->name]['multiple'] = 'checkbox';
                            $b[$setting->name]['templates'] = [
                                'inputContainer' => '<div class="form-group smart-form col-md-3 {{required}}">{{content}}</div>',
                                'nestingLabel' => '<label class="checkbox"{{attrs}}>{{hidden}}{{input}} {{text}}</label>'
                            ];
                        }
                    } else {
                        $b[$setting->name]['value'] = $data_value;
                    }
                }

                $box_settings = Hash::merge($box_settings, Hash::expand($b));
            }
            $box_settings = Hash::sort($box_settings, '{n}', 'asc');
            //pr($box_settings);die();
            $this->set('settings', $box_settings);
        }
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        if ($this->request->is('post')) {
            $tableParams = $this->DataTable->tableParams('Settings');
            if (count($tableParams['search']) > 0) {
                $query = $this->Settings->find('search', $this->Settings->filterParams($tableParams['search']));
            } else {
                $query = $this->Settings->find();
            }
            $query->find('network');
            $this->DataTable->table('Settings', $query, $tableParams);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Setting id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $setting = $this->Settings->get($id, [
                    'contain' => []
                ])->find('network');
        $this->set('setting', $setting);
        $this->set('_serialize', ['setting']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $setting = $this->Settings->newEntity();
        if ($this->request->is('post')) {
            $setting = $this->Settings->patchEntity($setting, $this->request->data);
            if ($this->Settings->saveNetwork($setting)) {
                $this->Flash->success(__('The setting has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The setting could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('setting'));
        $this->set('_serialize', ['setting']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Setting id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $setting = $this->Settings->getNetwork($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $setting = $this->Settings->patchEntity($setting, $this->request->data);
            if ($this->Settings->saveNetwork($setting)) {
                $this->Flash->success(__('The setting has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The setting could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('setting'));
        $this->set('_serialize', ['setting']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Setting id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $setting = $this->Settings->getNetwork($id);
        if ($this->Settings->deleteNetwork($setting)) {
            $this->Flash->success(__('The setting has been deleted.'));
        } else {
            $this->Flash->error(__('The setting could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Trash method
     *
     * @param string|null $id Setting id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function trash($id = null) {
        $this->request->allowMethod(['post', 'trash']);
        $setting = $this->Settings->getNetwork($id);
        if (!empty($setting)) {
            $setting->delete = 1;
            if ($this->Settings->saveNetwork($setting)) {
                $this->Flash->success(__('The setting has been move to trash.'));
            } else {
                $this->Flash->error(__('The setting could not be move to trash. Please, try again.'));
            }
        } else {
            $this->Flash->error(__('The setting could not be move to trash. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
