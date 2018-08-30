<?php
\Cake\Core\Configure::write('Admin.Forms.Forms', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'name'=>[
                            'label'=>'Name',
                                'type'=>'text',
                                                        ],
                'slug'=>[
                            'label'=>'Slug',
                                'type'=>'text',
                                                        ],
                'menu'=>[
                            'label'=>'Menu',
                                'type'=>'checkbox',
                                                        ],
                'list'=>[
                            'label'=>'List',
                                'type'=>'checkbox',
                                                        ],
                'before_submit'=>[
                            'label'=>'Before Submit',
                                'type'=>'textarea',
                                                        ],
                'after_submit'=>[
                            'label'=>'After Submit',
                                'type'=>'textarea',
                                                        ],
                'js'=>[
                            'label'=>'Js',
                                'type'=>'textarea',
                                                        ],
                'css'=>[
                            'label'=>'Css',
                                'type'=>'textarea',
                                                        ],
                        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
                    ],
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
    \Cake\Core\Configure::write('Admin.Table.Forms.tabs', $tabs);    
    \Cake\Core\Configure::write('Admin.Table.Forms.associated', $associated);
}        
        
$this->assign('title', __d('ittvn', 'Add form'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Forms'), ['controller' => 'Forms', 'action' => 'index']);
    
$this->Html->addCrumb(__d('ittvn','Add Form'), ['controller' => 'Forms', 'action' => 'add']);
?>
