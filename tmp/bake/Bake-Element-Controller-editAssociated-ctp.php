<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Utility\Inflector; 
use Cake\ORM\TableRegistry;

?>

    /**
     * $singularName method
     *
     * @return void.
     */
    public function editAssociated($assocTable, $joinTable, $assocId, $id)
    {
        $this->loadModel($this->request->plugin . '.' . $joinTable);
        ${$joinTable} = $this->{$joinTable}->get($id);
        if ($this->request->is('post')) {
            if (!empty($this->request->data['<?= $singularName; ?>_id'])) {
                ${$joinTable} = $this->{$joinTable}->patchEntity(${$joinTable}, $this->request->data);
                if ($this->{$joinTable}->save(${$joinTable})) {
                    $this->Flash->success(__('The ' . \Cake\Utility\Inflector::humanize($joinTable) . ' has been saved.'));
                    return $this->redirect(['action' => 'editAssociated', $assocTable, $joinTable, $assocId, $id]);
                } else {
                    $this->Flash->error(__('The ' . \Cake\Utility\Inflector::humanize($joinTable) . ' could not be saved. Please, try again.'));
                }
            } else {
                    $this->DataTable->associated = true;
                    $tableParams = $this->DataTable->tableParams($joinTable);
                    unset($tableParams['trash']);
                    unset($tableParams['search']['trash']);

                    $s = [];
                    foreach ($tableParams['search'] as $f => $v) {
                        if (strpos($f, '___') == true) {
                            $c = explode('___', $f);
                            $cm = \Cake\Utility\Inflector::camelize(\Cake\Utility\Inflector::pluralize($c[0]));
                            $s['search'][$cm . '.' . $c[1].' LIKE'] = "%".$v."%";
                        }
                    }                    
                    
                    if (count($tableParams['search']) > 0) {
                        $query = $this->{$joinTable}->find('search', $this->{$joinTable}->filterParams($tableParams['search']));
                    } else {
                        $query = $this->{$joinTable}->find();
                    }
                    $query->contain(['<?= $currentModelName ?>', $assocTable])->where(['<?= $singularName; ?>_id' => $assocId]);
                    if(isset($s['search']) && count($s['search']) > 0){
                        $query->andWhere($s['search']);
                    }                    

                    $this->DataTable->table($joinTable, $query, $tableParams);                
            }
        }
        
        if (!isset($this->request->data['draw'])) {
            $joinTableVariable = \Cake\Utility\Inflector::variable($joinTable);
            $joinTableSingularize = \Cake\Utility\Inflector::singularize($joinTableVariable);
            $assocTablevariable = \Cake\Utility\Inflector::variable($assocTable);
            ${$assocTablevariable} = $this->{$joinTable}->{$assocTable}->find('list', ['limit' => 200]);
            $this->set(compact($joinTableSingularize, $assocTablevariable, $assocTable, $joinTable));
            $this->set('joinTable', $joinTableVariable);
            $this->set('_serialize', [$joinTable]);
        }   
    }
