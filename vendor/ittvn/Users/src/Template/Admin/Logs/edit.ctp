<?php
\Cake\Core\Configure::write('Admin.Forms.Logs', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'user_id'=>[
                            'label'=>'User',
                                'type'=>'select',
                                'options'=>'users',
                                                        ],
                'ip'=>[
                            'label'=>'Ip',
                                'type'=>'text',
                                                        ],
                'browser'=>[
                            'label'=>'Browser',
                                'type'=>'text',
                                                        ],
                'create'=>[
                            'label'=>'Create',
                                'type'=>'text',
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
    \Cake\Core\Configure::write('Admin.Table.Logs.tabs', $tabs);    
    \Cake\Core\Configure::write('Admin.Table.Logs.associated', $associated);
}        
        
$this->assign('title', __d('ittvn', 'Edit log'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Logs'), ['controller' => 'Logs', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn','Edit Log'), $this->request->here);
?>
