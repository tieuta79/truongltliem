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
$compact = ["'" . $singularName . "'"];
%>

    /**
     * Login method
     *
     * @return void Redirects on successful login, renders view otherwise.
     */
    public function login()
    {
        <% if($currentModelName=='Users' && $prefix=='\Admin'){ %>
            $this->viewBuilder()->layout('login');
        <% } %>
        if ($this->request->is('post')) {
            $<%= $singularName %> = $this->Auth->identify();
            if ($<%= $singularName %>) {
                $this->Auth->setUser($<%= $singularName %>);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }
