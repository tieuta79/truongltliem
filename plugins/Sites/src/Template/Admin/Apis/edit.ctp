<?php
\Cake\Core\Configure::write('Admin.Forms.Apis', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'name'=>[
                            'label'=>'Name',
                                'type'=>'text',
                                                        ],
                'description'=>[
                            'label'=>'Description',
                                'type'=>'text',
                                                        ],
                'method'=>[
                            'label'=>'Method',
                                'type'=>'text',
                                                        ],
                'status'=>[
                            'label'=>'Status',
                                'type'=>'checkbox',
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
    \Cake\Core\Configure::write('Admin.Table.Apis.tabs', $tabs);    
    \Cake\Core\Configure::write('Admin.Table.Apis.associated', $associated);
}        
        
$this->assign('title', __d('ittvn', 'Edit api'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Apis'), ['controller' => 'Apis', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn','Edit Api'), $this->request->here);
?>
