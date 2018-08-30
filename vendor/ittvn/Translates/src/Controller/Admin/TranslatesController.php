<?php

namespace Translates\Controller\Admin;

use Translates\Controller\AppController;
use Cake\Event\Event;
/**
 * Translates Controller
 *
 * @property \Translates\Model\Table\TranslatesTable $Translates
 */
class TranslatesController extends AppController {

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
    public function index($locale_id) {
        $this->loadModel('Translates.Locales');
        $locale = $this->Locales->findById($locale_id)->select(['id','msgid'])->first();
        $this->loadModel('Extensions.Languages');
        $languages = $this->Languages->find()->select(['id', 'i18n','name'])->where(['status' => 1, 'delete' => 0]);
        $translates = $this->Translates->find('list',['keyField'=>'language_id','valueField'=>'msgstr'])->where(['locale_id'=>$locale_id])->toArray();
        $this->set(compact('locale','languages','translates'));
    }

    /**
     * View method
     *
     * @param string|null $id Translate id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $translate = $this->Translates->get($id, [
            'contain' => ['Languages', 'Locales']
        ]);
        $this->set('translate', $translate);
        $this->set('_serialize', ['translate']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $return = ['status'=>false,'data'=>''];
        if ($this->request->is('post')) {
            if(count($this->request->data['language_id']) > 0){
                $error = false;
                foreach($this->request->data['language_id'] as $language_id=>$msgstr){
                    $check = $this->Translates->find()->where(['language_id' => $language_id,'locale_id' => $this->request->data['locale_id']]);
                    if($check->count() > 0){
                        $translate = $check->first();
                        $translate->msgstr = $msgstr;
                    }else{
                        $translate = $this->Translates->newEntity([
                            'language_id' => $language_id,
                            'locale_id' => $this->request->data['locale_id'],
                            'msgstr' => $msgstr
                        ]);
                    }
                    
                    if (!$this->Translates->save($translate)) {
                        $error = true;
                    }
                }
                
                if($error == false){
                    $return['status'] = true;
                    $return['data'] = __d('ittvn','The translate has been saved.');
                }else{
                    $return['data'] = __d('ittvn','The translate could not be saved. Please, try again.');
                }
            }
        }
        $this->set('return', $return);
        $this->set('_serialize', 'return');
    }

    /**
     * Edit method
     *
     * @param string|null $id Translate id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $translate = $this->Translates->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $translate = $this->Translates->patchEntity($translate, $this->request->data);
            if ($this->Translates->save($translate)) {
                $this->Flash->success(__('The translate has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The translate could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Translates, ['belongsToMany' => []]);
        $this->set('belongsToMany', $associations['belongsToMany']);
        $languages = $this->Translates->Languages->find('list', ['limit' => 200]);
        $locales = $this->Translates->Locales->find('list', ['limit' => 200]);
        $this->set(compact('translate', 'languages', 'locales'));
        $this->set('_serialize', ['translate']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Translate id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $translate = $this->Translates->get($id);
        if ($this->Translates->delete($translate)) {
            $this->Flash->success(__('The translate has been deleted.'));
        } else {
            $this->Flash->error(__('The translate could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
