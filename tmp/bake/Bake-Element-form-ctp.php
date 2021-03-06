<?php
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

$plugin = '';
$model = '';
if(strpos($modelClass,'.')){
    list($plugin, $model) = explode('.',$modelClass);
}else{
    $model = $modelClass;
}
?>
<?php if($prefix=='Admin'){ ?>
<CakePHPBakeOpenTagphp
<?php
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
                        'options' => $keyFields[$field]
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
                }else if($fieldData['type'] === 'boolean'){
                    if($field!='delete'){
                        $forms['default'][$field] = [
                            'label' => Inflector::humanize($field),
                            'type'=>'checkbox'
                        ];
                    }
                } else if($fieldData['type'] === 'interger'){
                    $forms['default'][$field] = [
                        'label' => Inflector::humanize($field),
                        'type'=>'number'
                    ];
                }else{
                    if(strpos($field, '_file')==true){
                        $forms['default'][$field] = [
                            'label' => Inflector::humanize($field),
                            'type'=>'file'
                        ];                          
                    }else{
                        $forms['default'][$field] = [
                            'label' => Inflector::humanize($field),
                            'type'=>$field=='password'?'password':'text'
                        ];               
                    }                    
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
?>
\Cake\Core\Configure::write('Admin.Forms.<?= $model; ?>', [
    'main' => [
        'default' => [
            'label' => 'Default',
            <?php
                if(isset($forms['default'])){       
                foreach($forms['default'] as $f=>$form):
                    if(!is_array($form)){
                        echo "'".$f."'"; ?>=><?php if(is_string($form)){echo "'".$form."'"; }else{ echo $form;} ?>,
                <?php                
                    }else{
                        echo "'".$f."'"; ?>=>[
                            <?php 
                            foreach($form as $f1=>$form1):
                                if(!is_array($form1)){
                                    echo "'".$f1."'"; ?>=><?php if(is_string($form1)){echo "'".$form1."'"; }else{ echo $form1;} ?>,
                                <?php
                                }else{
                                    echo "'".$f1."'"; ?>=>[
                                    <?php
                                        foreach($form1 as $f2=>$form2):
                                            echo "'".$f2."'"; ?>=><?php if(is_string($form2)){echo "'".$form2."'"; }else{ echo $form2;} ?>,
                                            <?php
                                        endforeach;
                                        ?>    
                                    ],
                                <?php
                                }                                                            
                            endforeach;
                            ?>
                        ],
                <?php                
                    }
                endforeach;     
                }
            ?>
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
            <?php
                if(isset($forms['action'])){
                foreach($forms['action'] as $f=>$form):
                    if(!is_array($form)){
                        echo "'".$f."'"; ?>=><?php if(is_string($form)){echo "'".$form."'"; }else{ echo $form;} ?>,
                <?php                
                    }else{
                        echo "'".$f."'"; ?>=>[
                            <?php 
                            foreach($form as $f1=>$form1):
                                if(!is_array($form1)){
                                    echo "'".$f1."'"; ?>=><?php if(is_string($form1)){echo "'".$form1."'"; }else{ echo $form1;} ?>,
                                <?php
                                }else{
                                    echo "'".$f1."'"; ?>=>[
                                    <?php
                                        foreach($form1 as $f2=>$form2):
                                            echo "'".$f2."'"; ?>=><?php if(is_string($form2)){echo "'".$form2."'"; }else{ echo $form2;} ?>,
                                            <?php
                                        endforeach;
                                        ?>    
                                    ],
                                <?php
                                }                                                            
                            endforeach;
                            ?>
                        ],
                <?php                
                    }
                endforeach;            
                }
            ?>
        ],
        <?php
            if(isset($forms['sidebar'])){        
            foreach($forms['sidebar'] as $f=>$form):
                    if(!is_array($form)){
                        echo "'".$f."'"; ?>=><?php if(is_string($form)){echo "'".$form."'"; }else{ echo $form;} ?>,
                <?php                
                    }else{
                        echo "'".$f."'"; ?>=>[
                            <?php 
                            foreach($form as $f1=>$form1):
                                if(!is_array($form1)){
                                    echo "'".$f1."'"; ?>=><?php if(is_string($form1)){echo "'".$form1."'"; }else{ echo $form1;} ?>,
                                <?php
                                }else{
                                    echo "'".$f1."'"; ?>=>[
                                    <?php
                                        foreach($form1 as $f2=>$form2):
                                            echo "'".$f2."'"; ?>=><?php if(is_string($form2)){echo "'".$form2."'"; }else{ echo $form2;} ?>,
                                            <?php
                                        endforeach;
                                        ?>    
                                    ],
                                <?php
                                }                                                            
                            endforeach;
                            ?>
                        ],
                <?php                
                    }
            endforeach;    
            }
        ?>
    ]
]);
        
if(count($belongsToMany) > 0){
    $tabs = [];
    $associated = [];
    foreach($belongsToMany as $b){
        $tabs['Add'.$b['alias']]= [
            'label'=> $b['alias'],
            'url' => [
                'plugin'=>$this->request->plugin,
                'controller'=>$this->request->controller,
                'action'=>'addRelation',
                $b['alias'],
                $this->request->params['pass'][0]
            ],
            'options'=>[
                //class or id or diff attribute
            ]
        ];
        
        $modeJoinTable = Cake\Utility\Inflector::camelize($b['joinTable']);
        
        $associated[$b['joinTable']] = [
            'label' => Cake\Utility\Inflector::humanize($b['joinTable']),
            'url' => [
                'plugin' => $this->request->plugin,
                'controller' => $this->request->controller,
                'action' => 'addAssociated',
                $b['alias'],
                $modeJoinTable,
                $this->request->params['pass'][0]                
            ],
            'options' => [
            //class or id or diff attribute
            ]
        ];              
    }
    \Cake\Core\Configure::write('Admin.Table.<?= $model ?>.tabs', $tabs);    
    \Cake\Core\Configure::write('Admin.Table.<?= $model ?>.associated', $associated);
}        
        
$this->assign('title', __d('ittvn', '<?= ucfirst($action); ?> <?= $singularVar ?>'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','<?= $pluralHumanName ?>'), ['controller' => '<?= $model ?>', 'action' => 'index']);
<?php if (strpos($action, 'add') === false): ?>
$this->Html->addCrumb(__d('ittvn','Edit <?= ucfirst($singularVar) ?>'), $this->request->here);
<?php else: ?>    
$this->Html->addCrumb(__d('ittvn','Add <?= ucfirst($singularVar) ?>'), ['controller' => '<?= $model ?>', 'action' => 'add']);
<?php endif; ?>
CakePHPBakeCloseTag>
<?php }else{ ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><CakePHPBakeOpenTag= __('Actions') CakePHPBakeCloseTag></li>
<?php if (strpos($action, 'add') === false): ?>
        <li><CakePHPBakeOpenTag= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $<?= $singularVar ?>-><?= $primaryKey[0] ?>],
                ['confirm' => __('Are you sure you want to delete # {0}?', $<?= $singularVar ?>-><?= $primaryKey[0] ?>)]
            )
        CakePHPBakeCloseTag></li>
<?php endif; ?>
        <li><CakePHPBakeOpenTag= $this->Html->link(__('List <?= $pluralHumanName ?>'), ['action' => 'index']) CakePHPBakeCloseTag></li>
<?php
        $done = [];
        foreach ($associations as $type => $data) {
            foreach ($data as $alias => $details) {
                if ($details['controller'] !== $this->name && !in_array($details['controller'], $done)) {
?>
        <li><CakePHPBakeOpenTag= $this->Html->link(__('List <?= $this->_pluralHumanName($alias) ?>'), ['controller' => '<?= $details['controller'] ?>', 'action' => 'index']) ?></li>
        <li><CakePHPBakeOpenTag= $this->Html->link(__('New <?= $this->_singularHumanName($alias) ?>'), ['controller' => '<?= $details['controller'] ?>', 'action' => 'add']) ?></li>
<?php
                    $done[] = $details['controller'];
                }
            }
        }
?>
    </ul>
</nav>
<div class="<?= $pluralVar ?> form large-9 medium-8 columns content">
    <CakePHPBakeOpenTag= $this->Form->create($<?= $singularVar ?>) CakePHPBakeCloseTag>
    <fieldset>
        <legend><CakePHPBakeOpenTag= __('<?= Inflector::humanize($action) ?> <?= $singularHumanName ?>') CakePHPBakeCloseTag></legend>
        <CakePHPBakeOpenTagphp
<?php
        foreach ($fields as $field) {
            if (in_array($field, $primaryKey)) {
                continue;
            }
            if (isset($keyFields[$field])) {
                $fieldData = $schema->column($field);
                if (!empty($fieldData['null'])) {
?>
            echo $this->Form->input('<?= $field ?>', ['options' => $<?= $keyFields[$field] ?>, 'empty' => true]);
<?php
                } else {
?>
            echo $this->Form->input('<?= $field ?>', ['options' => $<?= $keyFields[$field] ?>]);
<?php
                }
                continue;
            }
            if (!in_array($field, ['created', 'modified', 'updated'])) {
                $fieldData = $schema->column($field);
                if (($fieldData['type'] === 'date') && (!empty($fieldData['null']))) {
?>
            echo $this->Form->input('<?= $field ?>', ['empty' => true]);
<?php
                } else {
?>
            echo $this->Form->input('<?= $field ?>');
<?php
                }
            }
        }
        if (!empty($associations['BelongsToMany'])) {
            foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
?>
            echo $this->Form->input('<?= $assocData['property'] ?>._ids', ['options' => $<?= $assocData['variable'] ?>]);
<?php
            }
        }
?>
        CakePHPBakeCloseTag>
    </fieldset>
    <CakePHPBakeOpenTag= $this->Form->button(__('Submit')) CakePHPBakeCloseTag>
    <CakePHPBakeOpenTag= $this->Form->end() CakePHPBakeCloseTag>
</div>
<?php } ?>