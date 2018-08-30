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

$assocTable = $this->request->params['pass'][0];
$assocId = $this->request->params['pass'][1];
$assocSingularTable = Inflector::singularize($assocTable);
$assocPluralTable = Inflector::pluralize($assocTable);

Configure::write('Admin.Forms.' . $joinTable, [
    'main' => [
        'default' => [
            'label' => 'Default',
            '<%= Inflector::variable(Inflector::singularize($modelClass)); %>_id' => [
                'label' => '<%= Inflector::singularize($modelClass); %> ID',
                'type' => 'hidden',
                'value' => $assocId,
            ]
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
        ],
    ]
]);

$schema = $associations['belongsToMany'][0]['schema'];
$fields = $associations['belongsToMany'][0]['schema']->columns();

$belongsTo_fields = \Cake\Utility\Hash::extract($associations, 'belongsTo.{n}.foreignKey');

foreach($fields as $field){
    if(!in_array($field, array('id','delete'))){
        if(in_array($field, $belongsTo_fields)){
            $tmp = explode('_', $field);
            Configure::write('Admin.Forms.' . $joinTable.'.main.default.'.$field,[
                'label'=> Inflector::humanize($tmp[0]),
                'type' => 'select',
                'options' => strtolower(Inflector::pluralize($tmp[0]))
            ]);             
        }else{
            $type = $schema->column($field);
            $t = 'text';
            if($type['type']=='integer'){
                $t='number';
            }else if($type['type']=='string'){
                $t='text';
            }else if($type['type']=='boolean'){
                $t='checkbox';
            }else if($type['type']=='text'){
                $t='textarea';
            }

            Configure::write('Admin.Forms.' . $joinTable.'.main.default.'.$field,[
                'label'=>  Inflector::humanize($field),
                'type' => $t
            ]);       

            if(in_array($type['type'], array('date','datetime','time','timestamp'))){
                Configure::write('Admin.Forms.' . $joinTable.'.main.default.'.$field,[
                    'label'=>  Inflector::humanize($field),
                    'type' => 'date',
                    'timeFormat' => 24,
                    'templates' => [
                        'select' => '<div class="col-sm-4"><select name="{{name}}" class="form-control"{{attrs}}>{{content}}</select></div>',
                        'dateWidget' => '<div class="row"><div class="col-sm-12 datetime_input">{{day}}{{month}}{{year}} {{hour}}{{minute}}{{second}} {{meridian}}</div></div>',
                    ]
                ]);    
            }            
        }       
    }
}

EventManager::instance()->on('Admin.Tables.' . $joinTable . '.rowAction', function (Event $event){
    $subject = $event->subject();
    $action = $subject['action'];
    $action['Edit'] = $subject['helper']->Html->link(
            '<i class="fa fa-pencil-square-o"></i>', ['plugin' => $this->request->plugin, 'controller' => $this->request->controller, 'action' => 'editRelation', $this->request->params['pass'][0], $this->request->params['pass'][1], $subject['row']->id], ['escape' => false, 'class' => 'btn btn-success btn-sm', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Edit')]
    );

    $action['Delete'] = $subject['helper']->Form->postLink(
            '<i class="fa fa-trash-o"></i>', ['plugin' => $this->request->plugin, 'controller' => $this->request->controller, 'action' => 'deleteRelation', $this->request->params['pass'][0], $this->request->params['pass'][1], $subject['row']->id], ['escape' => false, 'class' => 'btn btn-danger btn-sm', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Delete'), 'confirm' => __d('ittvn', 'Are you sure you want to delete # {0}?', $subject['row']->id)]
    );
    
    unset($action['View']);
    return $action;
});



$this->assign('title', __d('ittvn', '<%= Inflector::humanize($action); %> ' . $assocSingularTable));
$this->extend('/Admin/Common/relation1');
$this->Html->addCrumb(__d('ittvn', '<%= $pluralHumanName %>'), ['plugin' => '<%= $plugin %>', 'controller' => '<%= $model %>', 'action' => 'index']);

$this->Html->addCrumb(__d('ittvn', 'Edit <%= ucfirst($singularVar) %>'), ['plugin' => '<%= $plugin %>', 'controller' => '<%= $model %>', 'action' => 'edit', $assocId]);
$this->Html->addCrumb(__d('ittvn', 'Edit ' . $assocTable), $this->request->here);
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