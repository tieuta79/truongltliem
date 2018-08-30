<?php
\Cake\Core\Configure::write('Admin.Forms.UsersLogs', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'log_id'=>[
                            'label'=>'Log',
                                'type'=>'select',
                                'options'=>'logs',
                                                        ],
                'url'=>[
                            'label'=>'Url',
                                'type'=>'text',
                                                        ],
                'params'=>[
                            'label'=>'Params',
                                'type'=>'textarea',
                                                        ],
                'query'=>[
                            'label'=>'Query',
                                'type'=>'textarea',
                                                        ],
                'data'=>[
                            'label'=>'Data',
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
    \Cake\Core\Configure::write('Admin.Table.UsersLogs.tabs', $tabs);    
    \Cake\Core\Configure::write('Admin.Table.UsersLogs.associated', $associated);
}        
        
$this->assign('title', __d('ittvn', 'Add usersLog'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Users Logs'), ['controller' => 'UsersLogs', 'action' => 'index']);
    
$this->Html->addCrumb(__d('ittvn','Add UsersLog'), ['controller' => 'UsersLogs', 'action' => 'add']);
?>
