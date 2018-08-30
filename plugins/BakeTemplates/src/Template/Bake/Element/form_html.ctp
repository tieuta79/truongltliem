<%
use Cake\Utility\Inflector;

$fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return $schema->columnType($field) !== 'binary';
    });

if (isset($modelObject) && $modelObject->behaviors()->has('Tree')) {
    $fields = $fields->reject(function ($field) {
        return $field === 'lft' || $field === 'rght';
    });
}
%>
<?php
<%
$forms = [];
        foreach ($fields as $field) {
            if (in_array($field, $primaryKey)) {
                continue;
            }
            if (isset($keyFields[$field])) {
                $fieldData = $schema->column($field);
                if (!empty($fieldData['null'])) {
                    $forms['default'][$field] = [
                        'label' => str_replace(' Id', '', Inflector::humanize($field)),
                        'type'=>'select',
                        'options' => $keyFields[$field],
                        'empty' => true
                    ];

                } else {
                    $forms['default'][$field] = [
                        'label' => Inflector::humanize($field),
                        'type'=>'select',
                        'options' => $keyFields[$field]
                    ];                    
                }
                continue;
            }
            if (!in_array($field, ['created', 'modified', 'updated'])) {                   
                $fieldData = $schema->column($field);
                if (($fieldData['type'] === 'date') && (!empty($fieldData['null']))) {
                    $forms['default'][$field] = [
                        'label' => Inflector::humanize($field),
                        'type' => 'date',
                        'timeFormat' => 24,
                        'templates' => [
                            'select' => '<div class="col-sm-4"><select name="{{name}}" class="form-control"{{attrs}}>{{content}}</select></div>',
                            'dateWidget' => '<div class="row"><div class="col-sm-12 datetime_input">{{day}}{{month}}{{year}} {{hour}}{{minute}}{{second}} {{meridian}}</div></div>',
                        ]
                    ];                      
                } else if($fieldData['type'] === 'text'){
                    $forms['default'][$field] = [
                        'label' => Inflector::humanize($field),
                        'type'=>'textarea'
                    ];
                } else if($fieldData['type'] === 'boolean'){
                    $forms['default'][$field] = [
                        'label' => Inflector::humanize($field),
                        'type'=>'checkbox'
                    ];
                }else if($fieldData['type'] === 'integer'){
                    $forms['default'][$field] = [
                        'label' => Inflector::humanize($field),
                        'type'=>'number'
                    ];
                }else{
                    $forms['default'][$field] = [
                        'label' => Inflector::humanize($field),
                        'type'=>$field=='password'?'password':'text'
                    ];
                }
            }
        }
        /*
        if (!empty($associations['BelongsToMany'])) {
            foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
                $forms['sidebar'][$assocData['property']] = [
                    'label' => $assocName,
                    '_ids' => [
                        'label' => '',
                        'type' => 'radio',
                        'multiple' => true,
                        'options' => $assocData['variable']
                    ]
                ];                
            }
        }
         */
%>
use Cake\Utility\Hash;
use Cake\Core\Configure;
use Cake\Utility\Inflector;

Configure::write('Admin.Forms.<%= $modelClass; %>', [
    'main' => [
        'default' => [
            'label' => 'Default',
            <%
                if(isset($forms['default'])){       
                foreach($forms['default'] as $f=>$form):
                    if(!is_array($form)){
                        echo "'".$f."'"; %>=><% if(is_string($form)){echo "'".$form."'"; }else{ echo $form;} %>,
                <%                
                    }else{
                        echo "'".$f."'"; %>=>[
                            <% 
                            foreach($form as $f1=>$form1):
                                if(!is_array($form1)){
                                    echo "'".$f1."'"; %>=><% if(is_string($form1)){echo "'".$form1."'"; }else{ echo $form1;} %>,
                                <%
                                }else{
                                    echo "'".$f1."'"; %>=>[
                                    <%
                                        foreach($form1 as $f2=>$form2):
                                            echo "'".$f2."'"; %>=><% if(is_string($form2)){echo "'".$form2."'"; }else{ echo $form2;} %>,
                                            <%
                                        endforeach;
                                        %>    
                                    ],
                                <%
                                }                                                            
                            endforeach;
                            %>
                        ],
                <%                
                    }
                endforeach;     
                }
            %>
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
            <%
                if(isset($forms['action'])){
                foreach($forms['action'] as $f=>$form):
                    if(!is_array($form)){
                        echo "'".$f."'"; %>=><% if(is_string($form)){echo "'".$form."'"; }else{ echo $form;} %>,
                <%                
                    }else{
                        echo "'".$f."'"; %>=>[
                            <% 
                            foreach($form as $f1=>$form1):
                                if(!is_array($form1)){
                                    echo "'".$f1."'"; %>=><% if(is_string($form1)){echo "'".$form1."'"; }else{ echo $form1;} %>,
                                <%
                                }else{
                                    echo "'".$f1."'"; %>=>[
                                    <%
                                        foreach($form1 as $f2=>$form2):
                                            echo "'".$f2."'"; %>=><% if(is_string($form2)){echo "'".$form2."'"; }else{ echo $form2;} %>,
                                            <%
                                        endforeach;
                                        %>    
                                    ],
                                <%
                                }                                                            
                            endforeach;
                            %>
                        ],
                <%                
                    }
                endforeach;            
                }
            %>
        ],
        <%
            if(isset($forms['sidebar'])){        
            foreach($forms['sidebar'] as $f=>$form):
                    if(!is_array($form)){
                        echo "'".$f."'"; %>=><% if(is_string($form)){echo "'".$form."'"; }else{ echo $form;} %>,
                <%                
                    }else{
                        echo "'".$f."'"; %>=>[
                            <% 
                            foreach($form as $f1=>$form1):
                                if(!is_array($form1)){
                                    echo "'".$f1."'"; %>=><% if(is_string($form1)){echo "'".$form1."'"; }else{ echo $form1;} %>,
                                <%
                                }else{
                                    echo "'".$f1."'"; %>=>[
                                    <%
                                        foreach($form1 as $f2=>$form2):
                                            echo "'".$f2."'"; %>=><% if(is_string($form2)){echo "'".$form2."'"; }else{ echo $form2;} %>,
                                            <%
                                        endforeach;
                                        %>    
                                    ],
                                <%
                                }                                                            
                            endforeach;
                            %>
                        ],
                <%                
                    }
            endforeach;    
            }
        %>
    ]
]);

$this->Admin->adminScript('form');        
        
$this->assign('title', __d('ittvn', '<%= ucfirst($action); %> <%= $singularVar %>'));

$this->Html->addCrumb(__d('ittvn','<%= $pluralHumanName %>'), ['controller' => '<%= $modelClass %>', 'action' => 'index']);
<% if (strpos($action, 'add') === false): %>
$this->Html->addCrumb(__d('ittvn','Edit <%= ucfirst($singularVar) %>'), $this->request->here);
<% else: %>    
$this->Html->addCrumb(__d('ittvn','Add <%= ucfirst($singularVar) %>'), ['controller' => '<%= $modelClass %>', 'action' => 'add']);
<% endif; %>

$formCell = $this->Cell->form();
extract($formCell);

$this->viewVars = Hash::merge($this->viewVars, $form);
unset($this->viewVars['form']);
echo $this->Form->create($dataFrom);
?>
<div class="row">
    <div class="col-md-8">        
        <?php if (!empty($dataFrom->id) && count($relationship['belongsToMany']) > 0): ?>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab"><?= $singularize; ?></a></li>
                    <?php foreach ($relationship['belongsToMany'] as $belongsToMany): ?>
                        <li><?= $this->Html->link(Inflector::humanize($belongsToMany['alias']), ['controller' => $controller, 'action' => 'add_relation', Inflector::variable($belongsToMany['alias']), $dataFrom->id, 'prefix' => 'admin']); ?></li>
                    <?php endforeach; ?>
                </ul> 
                <div class="tab-content">
                <?php endif; ?>
                <div class="tab-pane active row">
                    <?php
                    if (count($positionMain) > 0):
                        foreach ($positionMain as $key => $block):
                            ?>
                            <div class="col-md-12">
                                <!-- general form elements -->
                                <div class="box box-primary box-solid">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><?= isset($block['label']) ? __d('ittvn', $block['label']) : __d('ittvn', $key); ?></h3>
                                        <div class="box-tools pull-right">
                                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        </div>
                                    </div><!-- /.box-header -->
                                    <?php $block = Hash::remove($block, 'label'); ?>
                                    <!-- form start -->
                                    <div class="box-body">
                                        <?= $this->Admin->inputs($block); ?>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </div>
                <?php if (!empty($dataFrom->id) && count($relationship['belongsToMany']) > 0): ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-md-4">
        <div class="row connectedSortable">
            <?php
            if (count($positionSidebar) > 0):
                $i = 0;
                foreach ($positionSidebar as $key => $block):
                    ?>
                    <div class="col-md-12">
                        <!-- iCheck -->
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"><?= isset($block['label']) ? __d('ittvn', $block['label']) : __d('ittvn', $key); ?></h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <?php $block = Hash::remove($block, 'label'); ?>
                            <div class="box-body">
                                <?= $this->Admin->inputs($block); ?>               
                            </div><!-- /.box-body -->
                            <?php if ($i++ == 0): ?>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-success btn-sm" data-toggle="tooltip" title="Save"><i class="fa fa-save"></i> Save</button>
                                    <?php
                                    if (isset(${$singularize}->id)):
                                        echo $this->Html->link(
                                                '<i class="fa fa-trash-o"></i> ' . __d('ittvn', 'Delete'), ['plugin' => false, 'controller' => $controller, 'action' => 'delete', ${$singularize}->id], ['class' => 'btn btn-danger btn-sm pull-right delete_ajax', 'data-toggle' => 'tooltip', 'title' => 'Delete', 'escape' => false]
                                        );
                                    endif;
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div><!-- /.box -->
                    </div>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</div>
<?= $this->Form->end(); ?>