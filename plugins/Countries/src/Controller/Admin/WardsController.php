<?php

namespace Countries\Controller\Admin;

use Countries\Controller\AppController;
use Cake\Core\Configure;
/**
 * Wards Controller
 *
 * @property \Countries\Model\Table\WardsTable $Wards
 */
class WardsController extends AppController {

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

        if ($this->request->is('post')) {
            $tableParams = $this->DataTable->tableParams('Wards');
            if (count($tableParams['search']) > 0) {
                $query = $this->Wards->find('search', $this->Wards->filterParams($tableParams['search']));
            } else {
                $query = $this->Wards->find();
            }
            $query->contain(['Countries', 'Provinces', 'Cities']);
            $this->DataTable->table('Wards', $query, $tableParams);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Ward id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null) {
        $ward = $this->Wards->get($id, [
            'contain' => ['Countries', 'Provinces', 'Cities', 'Addresses']
        ]);
        $this->set('ward', $ward);
        $this->set('_serialize', ['ward']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $ward = $this->Wards->newEntity();
        if ($this->request->is('post')) {
            $ward = $this->Wards->patchEntity($ward, $this->request->data);
            if ($this->Wards->save($ward)) {
                $this->Flash->success(__('The ward has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ward could not be saved. Please, try again.'));
            }
        }
        $countries = $this->Wards->Countries->find('list')->where(['delete' => 0]);
        $provinces = $this->Wards->Provinces->find('list')->where(['delete' => 0]);
        $cities = $this->Wards->Cities->find('list')->where(['delete' => 0]);
        $this->set(compact('ward', 'countries', 'provinces', 'cities'));
        $this->set('_serialize', ['ward']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ward id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $ward = $this->Wards->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ward = $this->Wards->patchEntity($ward, $this->request->data);
            if ($this->Wards->save($ward)) {
                $this->Flash->success(__('The ward has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ward could not be saved. Please, try again.'));
            }
        }
        $associations = $this->Ittvn->findBelongsToMany($this->Wards, ['belongsToMany' => []]);
        $this->set('belongsToMany', $associations['belongsToMany']);
        $countries = $this->Wards->Countries->find('list')->where(['delete' => 0]);
        $provinces = $this->Wards->Provinces->find('list')->where(['delete' => 0]);
        $cities = $this->Wards->Cities->find('list')->where(['delete' => 0]);
        $this->set(compact('ward', 'countries', 'provinces', 'cities'));
        $this->set('_serialize', ['ward']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ward id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $ward = $this->Wards->get($id);
        if ($this->Wards->delete($ward)) {
            $this->Flash->success(__('The ward has been deleted.'));
        } else {
            $this->Flash->error(__('The ward could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function auto() {
        set_time_limit(0);
        $this->loadModel('Countries.Provinces');
        $this->loadModel('Countries.Cities');
        $aprovinces = Configure::read('dataCountries');
        foreach($aprovinces as $ak => $aprovince){
            $province = $this->Provinces->find()->select(['id', 'name'])->where(['name' => $aprovince])->first();
            
            $acities = $this->httpPost('https://tiki.vn/customer/address/ajaxDistrict', ['region_id' => $ak]);
            $acities = json_decode($acities);
            foreach ($acities as $acity) {
                $awards = $this->httpPost('https://tiki.vn/customer/address/ajaxWard', ['city_id' => $acity->id]);
                $awards = json_decode($awards);

                $city = $this->Cities->find()->select(['id', 'name'])->where(['province_id' => $province->id, 'name' => $acity->name])->first();
                foreach ($awards as $award) {
                    $ward = $this->Wards->newEntity([
                        'name' => $award->name,
                        'country_id' => 243,
                        'province_id' => $province->id,
                        'city_id' => $city->id
                    ]);
                    $this->Wards->save($ward);
                }
                echo 'CITY: '.$city->name.'<br />';
                //sleep(3);
            }
        }
        die('DONE.');
    }

    function httpPost($url, $data) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

}
