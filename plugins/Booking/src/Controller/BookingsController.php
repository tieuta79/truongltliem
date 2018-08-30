<?php

namespace Booking\Controller;

use Booking\Controller\AppController;

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
    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index() {

        $query = $this->Bookings->find();
        $query = $query->contain(['Contents']);
        $this->set('bookings', $this->paginate($query));
        $this->set('_serialize', ['bookings']);
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
        ]);
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
            if ($this->Bookings->save($booking)) {
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
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $booking = $this->Bookings->patchEntity($booking, $this->request->data);
            if ($this->Bookings->save($booking)) {
                $this->Flash->success(__('The booking has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The booking could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Bookings, ['belongsToMany' => []]);
        $this->set('belongsToMany', $associations['belongsToMany']);
        $contents = $this->Bookings->Contents->find('list', ['limit' => 200]);
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
        $booking = $this->Bookings->get($id);
        if ($this->Bookings->delete($booking)) {
            $this->Flash->success(__('The booking has been deleted.'));
        } else {
            $this->Flash->error(__('The booking could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
