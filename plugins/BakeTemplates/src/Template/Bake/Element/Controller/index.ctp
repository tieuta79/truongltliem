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
%>

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
<% $belongsTo = $this->Bake->aliasExtractor($modelObj, 'BelongsTo'); %>
<% if($prefix=='\Admin'): %>    
    if ($this->request->is('post')) {
        $tableParams = $this->DataTable->tableParams('<%= $currentModelName %>');
        if (count($tableParams['search']) > 0) {
            $query = $this-><%= $currentModelName %>->find('search', $this-><%= $currentModelName %>->filterParams($tableParams['search']));
        } else {
            $query = $this-><%= $currentModelName %>->find();
        }
        <% if ($belongsTo): %>
        $query->contain([<%= $this->Bake->stringifyList($belongsTo, ['indent' => false]) %>]);
        <% endif; %>
        $this->DataTable->table('<%= $currentModelName %>', $query, $tableParams);
    }
<% else: %>    
            $query = $this-><%= $currentModelName %>->find();            
    <% if ($belongsTo): %>
            $query = $query->contain([<%= $this->Bake->stringifyList($belongsTo, ['indent' => false]) %>]);
    <% endif; %>
            $this->set('<%= $pluralName %>', $this->paginate($query));
            $this->set('_serialize', ['<%= $pluralName %>']);
<% endif; %>    
    }
