<%
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;

$tmp = array_keys($associations['BelongsToMany']);

$modelAssoc = TableRegistry::get($tmp[0]);
$schema = $modelAssoc->schema();

$fields = $schema->columns();

$fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return $schema->columnType($field) !== 'binary';
    });

if (isset($modelObject) && $modelObject->behaviors()->has('Tree')) {
    $fields = $fields->reject(function ($field) {
        return $field === 'lft' || $field === 'rght';
    });
}

$plugin = '';
$model = '';
if(strpos($modelClass,'.')){
    list($plugin, $model) = explode('.',$modelClass);
}else{
    $model = $modelClass;
}

%>
<% if($prefix=='Admin'){ %>
<?php
use Cake\Utility\Inflector;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Utility\Hash;

$assocId = $this->request->params['pass'][2];
$assocTable = $this->request->params['pass'][0];
$assocTable_singularize = Inflector::singularize($assocTable);
$assocTable_variable = Inflector::variable($assocTable_singularize);

Configure::write('Admin.Forms.' . $joinTable, [
    'main' => [
        'default' => [
            'label' => 'Default',
            '<%= $singularVar %>_id' => [
                'label' => '<%= $model; %> ID',
                'type' => 'hidden',
                'value' => $assocId,
            ],
            $assocTable_variable.'_id' => [
                'label' => $assocTable_variable,
                'type' => 'select',
                'options' => Inflector::variable($assocTable),
            ]            
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
        ],
    ]
]);

$this->assign('title', __d('ittvn', 'Add Associated ' . Inflector::humanize($joinTable)));
$this->extend('/Admin/Common/associated');
$this->Html->addCrumb(__d('ittvn', '<%= $pluralHumanName %>'), ['plugin'=>'<%= $plugin %>','controller' => '<%= $model %>', 'action' => 'index']);

$this->Html->addCrumb(__d('ittvn', 'Edit <%= ucfirst($singularVar) %>'), ['plugin'=>'<%= $plugin %>','controller' => '<%= $model %>', 'action' => 'edit', $assocId]);
$this->Html->addCrumb(__d('ittvn', 'Add Associated ' . Inflector::humanize($joinTable)), $this->request->here);
?>
<% }else{ %>
<?php
use Cake\Utility\Inflector;

$assocTable = $this->request->params['pass'][0];
$assocId = $this->request->params['pass'][1];
$assocSingularTable = Inflector::singularize($assocTable);
$assocPluralTable = Inflector::pluralize($assocTable);
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
<% if (strpos($action, 'add') === false): %>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $<%= $singularVar %>-><%= $primaryKey[0] %>],
                ['confirm' => __('Are you sure you want to delete # {0}?', $<%= $singularVar %>-><%= $primaryKey[0] %>)]
            )
        ?></li>
<% endif; %>
        <li><?= $this->Html->link(__('List <%= $pluralHumanName %>'), ['action' => 'index']) ?></li>
<%
        $done = [];
        foreach ($associations as $type => $data) {
            foreach ($data as $alias => $details) {
                if ($details['controller'] !== $this->name && !in_array($details['controller'], $done)) {
%>
        <li><?= $this->Html->link(__('List <%= $this->_pluralHumanName($alias) %>'), ['controller' => '<%= $details['controller'] %>', 'action' => 'index']) %></li>
        <li><?= $this->Html->link(__('New <%= $this->_singularHumanName($alias) %>'), ['controller' => '<%= $details['controller'] %>', 'action' => 'add']) %></li>
<%
                    $done[] = $details['controller'];
                }
            }
        }
%>
    </ul>
</nav>
<div class="<%= $pluralVar %> form large-9 medium-8 columns content">
    <?= $this->Form->create($<%= $singularVar %>) ?>
    <fieldset>
        <legend><?= __('<%= Inflector::humanize($action) %> <%= $singularHumanName %>') ?></legend>
        <?php
        echo $this->Form->input('<%= Inflector::variable(Inflector::singularize($modelClass)); %>_id', ['type' => 'hidden','value'=>$assocId]);
<%        
        foreach ($fields as $field) {
            if (in_array($field, $primaryKey)) {
                continue;
            }
            if (isset($keyFields[$field])) {
                $fieldData = $schema->column($field);
                if (!empty($fieldData['null'])) {
%>
            echo $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>, 'empty' => true]);
<%
                } else {
%>
            echo $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>]);
<%
                }
                continue;
            }
            if (!in_array($field, ['created', 'modified', 'updated'])) {
                $fieldData = $schema->column($field);
                if (($fieldData['type'] === 'date') && (!empty($fieldData['null']))) {
%>
            echo $this->Form->input('<%= $field %>', ['empty' => true]);
<%
                } else {
%>
            echo $this->Form->input('<%= $field %>');
<%
                }
            }
        }
        if (!empty($associations['BelongsToMany'])) {
            foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
%>
            echo $this->Form->input('<%= $assocData['property'] %>._ids', ['options' => $<%= $assocData['variable'] %>]);
<%
            }
        }
%>
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<% } %>