<?php

namespace Booking\Controller\Admin;

use Booking\Controller\AppController;
use Cake\Event\Event;

/**
 * Bookings Controller
 *
 * @property \Booking\Model\Table\BookingsTable $Bookings
 */
class BookingsController extends AppController {

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
            $search_content = false;
            $tableParams = $this->DataTable->tableParams('Bookings');
            if (count($tableParams['search']) > 0) {
                if (isset($tableParams['search']['content_id']) && !empty($tableParams['search']['content_id'])) {
                    $this->loadModel('Contents.Contents');
                    $contents = $this->Contents->find('list', ['keyField' => 'id', 'valueField' => 'id'])
                            ->where([
                        'name LIKE' => '%' . mb_strtolower($tableParams['search']['content_id']) . '%',
                        'status' => 1,
                        'delete' => 0
                    ]);
                    $search_content = true;
                    unset($tableParams['search']['content_id']);
                }

                $query = $this->Bookings->find('search', $this->Bookings->filterParams($tableParams['search']));
            } else {
                $query = $this->Bookings->find();
            }

            if ($search_content == true) {
                if ($contents->count() > 0) {
                    $query->andWhere(['content_id IN' => $contents->toArray()]);
                } else {
                    $query->andWhere(['content_id' => 0]);
                }
            }
            //$query->contain(['Contents']);
            $query->find('network');
            $this->DataTable->table('Bookings', $query, $tableParams);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Booking id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $booking = $this->Bookings->get($id, [
            'contain' => ['Contents']
        ])->find('network');
        $this->set('booking', $booking);
        $this->set('_serialize', ['booking']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $booking = $this->Bookings->newEntity();
        if ($this->request->is('post')) {
            $booking = $this->Bookings->patchEntity($booking, $this->request->data);
            if ($this->Bookings->saveNetwork($booking)) {
                $this->Flash->success(__('The booking has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The booking could not be saved. Please, try again.'));
            }
        }
        $contents = $this->Bookings->Contents->find('list', ['limit' => 200]);
        $this->set(compact('booking', 'contents'));
        $this->set('_serialize', ['booking']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Booking id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $booking = $this->Bookings->get($id, [
            'contain' => []
        ])->find('network');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $booking = $this->Bookings->patchEntity($booking, $this->request->data);
            if ($this->Bookings->saveNetwork($booking)) {
                $this->Flash->success(__('The booking has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The booking could not be saved. Please, try again.'));
            }
        }
        $contents = $this->Bookings->Contents->find('list')->find('network');
        $this->set(compact('booking', 'contents'));
        $this->set('_serialize', ['booking']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Booking id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $booking = $this->Bookings->get($id)->find('network');
        if ($this->Bookings->deleteNetwork($booking)) {
            $this->Flash->success(__('The booking has been deleted.'));
        } else {
            $this->Flash->error(__('The booking could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
