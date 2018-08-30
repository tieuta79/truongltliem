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
    public function editRelation($assocTable, $id, $relation_id)
    {
        $assocModel = \Cake\Utility\Inflector::camelize($assocTable);
        $assocVariable = \Cake\Utility\Inflector::variable(\Cake\Utility\Inflector::singularize($assocTable));

        $associations = [
            'belongsTo' => [],
            'hasMany' => [],
            'belongsToMany' => []
        ];
        //$associations = $this->Ittvn->findHasMany($this-><?= $currentModelName ?>,$associations);
        $associations = $this->Ittvn->findBelongsTo($this-><?= $currentModelName ?>->{$assocModel},$associations);
        $associations = $this->Ittvn->findBelongsToMany($this-><?= $currentModelName ?>,$associations);
        
        $associations['belongsToMany'] = \Cake\Utility\Hash::extract($associations, 'belongsToMany.{n}[alias='.$assocModel.']'); 

        if(count($associations['belongsToMany'])>0){            
            $joinTable = $associations['belongsToMany'][0]['joinTable'];
            $joinTableModel = \Cake\Utility\Inflector::camelize($joinTable);
            $joinTableVariable = \Cake\Utility\Inflector::variable($joinTable);

            $targetForeignKey = $associations['belongsToMany'][0]['targetForeignKey'];
            $foreignKey = $associations['belongsToMany'][0]['foreignKey'];
            
            ${$assocVariable} = $this-><?= $currentModelName ?>->{$assocModel}->get($relation_id); 
            
            if ($this->request->is(['patch', 'post', 'put'])) {
                if (!empty($this->request->data[$this-><?= $currentModelName ?>->{$assocModel}->displayField()])) {
                    ${$assocVariable} = $this-><?= $currentModelName ?>->{$assocModel}->patchEntity(${$assocVariable}, $this->request->data);
                    if ($this-><?= $currentModelName ?>->{$assocModel}->save(${$assocVariable})) {

                        return $this->redirect(['action' => 'editRelation',$assocTable,$id,${$assocVariable}->id]);
                    } else {
                        $this->Flash->error(sprintf(__('The %s could not be saved. Please, try again.'),$assocVariable));
                    }                
                }else{
                    $this->loadModel($this->request->plugin . '.' . $joinTableModel);

                    $this->DataTable->relation = true;
                    $tableParams = $this->DataTable->tableParams($joinTableModel);
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
                        $query = $this->{$joinTableModel}->find('search', $this->{$joinTableModel}->filterParams($tableParams['search']));
                    } else {
                        $query = $this->{$joinTableModel}->find();
                    }
                    $query->contain([$assocModel, '<?= $currentModelName ?>'])->where([$foreignKey => $id]);
                    if(isset($s['search']) && count($s['search']) > 0){
                        $query->andWhere($s['search']);
                    }                     

                    $this->DataTable->table($joinTableModel, $query, $tableParams);
                }                
            }

            if (!isset($this->request->data['draw'])) {
                if(count($associations['belongsTo'])>0){
                    foreach($associations['belongsTo'] as $belongsTo){
                        $var_belongsTo = strtolower($belongsTo['alias']);
                        ${$var_belongsTo} = $this-><?= $currentModelName ?>->{$assocModel}->{$belongsTo['alias']}->find('list', ['limit' => 200]);
                        $this->set(compact($var_belongsTo));
                    }
                }

                $this->set(compact($assocVariable,'associations'));
                $this->set('joinTable',$joinTableModel);
                $this->set('_serialize', [$assocVariable]);  
            }
            
        }else{
            $this->Flash->error(sprintf(__('The %s not relationship %s.',$this-><?= $currentModelName ?>->alias(),$assocModel)));
            return $this->redirect($this->request->referer());
        }
    }
