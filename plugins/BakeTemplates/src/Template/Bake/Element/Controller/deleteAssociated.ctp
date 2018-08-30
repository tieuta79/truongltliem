<%
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

%>

    /**
     * $singularName method
     *
     * @return void.
     */
    public function deleteAssociated($assocTable, $joinTable, $assocId, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $this->loadModel($this->request->plugin . '.' . $joinTable);
        ${$joinTable} = $this->{$joinTable}->get($id);

        if ($this->{$joinTable}->delete(${$joinTable})) {
            $this->Flash->success(__('The ' . \Cake\Utility\Inflector::humanize($joinTable) . ' has been deleted.'));
        } else {
            $this->Flash->error(__('The ' . \Cake\Utility\Inflector::humanize($joinTable) . ' could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'addAssociated', $assocTable, $joinTable, $assocId]);
    }
