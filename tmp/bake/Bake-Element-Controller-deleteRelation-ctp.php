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
?>

    /**
     * deleteRelation method
     *
     * @param string|null $id <?= $singularHumanName ?> id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function deleteRelation($assocTable, $relation_id, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        $associations = $this->Ittvn->findBelongsToMany($this-><?= $currentModelName ?>,['belongsToMany'=>[]]);
        $join_table = '';
        $foreignKey = '';
        $targetForeignKey = '';
        if(count($associations) > 0){
            foreach($associations['belongsToMany'] as $association){
                if($association['alias']==$assocTable){
                   $join_table = $association['joinTable'];
                   $foreignKey = $association['foreignKey'];
                   $targetForeignKey = $association['targetForeignKey'];
                   break;
                }
            }
        }
        $join_table = \Cake\Utility\Inflector::camelize($join_table);        
        $this->loadModel($join_table);
        ${$join_table} = $this->{$join_table}->find()->where([$foreignKey=>$relation_id,$targetForeignKey=>$id])->first();        
        
        ${$assocTable} = $this-><?= $currentModelName ?>->{$assocTable}->get($id);
        if ($this-><?= $currentModelName; ?>->{$assocTable}->delete(${$assocTable})) {
            $this->Flash->success(__('The '.$assocTable.' has been deleted.'));
        } else {
            $this->Flash->error(__('The '.$assocTable.' could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'addRelation',$assocTable,$relation_id]);
    }
