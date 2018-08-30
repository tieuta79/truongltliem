<?php
\Cake\Core\Configure::write('Admin.Forms.MessagesUsers', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'user_id'=>[
                            'label'=>'User',
                                'type'=>'select',
                                'options'=>'users',
                                                        ],
                'message_id'=>[
                            'label'=>'Message',
                                'type'=>'select',
                                'options'=>'messages',
                                                        ],
                'read'=>[
                            'label'=>'Read',
                                'type'=>'checkbox',
                                                        ],
                'date'=>[
                            'label'=>'Date',
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
    \Cake\Core\Configure::write('Admin.Table.MessagesUsers.tabs', $tabs);    
    \Cake\Core\Configure::write('Admin.Table.MessagesUsers.associated', $associated);
}        
        
$this->assign('title', __d('ittvn', 'Add messagesUser'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Messages Users'), ['controller' => 'MessagesUsers', 'action' => 'index']);
    
$this->Html->addCrumb(__d('ittvn','Add MessagesUser'), ['controller' => 'MessagesUsers', 'action' => 'add']);
?>
