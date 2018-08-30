<?php

namespace Sites\Controller;

use Sites\Controller\AppController;
use Cake\Event\Event;

/**
 * Domains Controller
 *
 * @property \Sites\Model\Table\DomainsTable $Domains
 */
class DomainsController extends AppController {

    /**
     * beforeFilter method
     *
     * @return void Redirects on successful beforeFilter, renders view otherwise.
     */
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $return = ['status' => false, 'data' => [], 'message' => ''];

        $site = $this->Domains->Sites->findByUserId($this->Auth->user('id'));
        if ($site->count() > 0) {
            $domain = $this->Domains->find()->where(['site_id' => $site->first()->id]);
            if ($domain->count() > 0) {
                $domain = $domain->first();
            } else {
                $domain = $this->Domains->newEntity();
                $domain->site_id = $site->first()->id;
            }

            if ($this->request->is(['patch', 'post', 'put']) && $this->request->header('X-IT-AUTHORIZE') == 'ITFORM') {
                $domain = $this->Domains->patchEntity($domain, $this->request->data);
                if ($this->Domains->save($domain)) {
                    $return['status'] = true;
                    $return['data'] = $domain;
                    $return['message'] = __d('ittvn', 'Đã lưu tên miền thành công.');
                } else {
                    $return['message'] = __d('ittvn', 'Lỗi không thể lưu tên miền..');
                }
            } else {
                $return['message'] = __d('ittvn', 'Có vẻ bạn đang hack tôi.');
            }
        } else {
            $return['message'] = __d('ittvn', 'Bạn phải cập nhật và kích hoạt thông tin website trước khi thêm tên miền.');
        }
        
        $this->set(compact('return'));
        $this->set('_serialize', 'return');
    }

}
