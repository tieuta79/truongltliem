<?php
\Cake\Core\Configure::write('Admin.Forms.Domains', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'name'=>[
                            'label'=>'Name',
                                'type'=>'text',
                                                        ],
                'ip'=>[
                            'label'=>'Ip',
                                'type'=>'text',
                                                        ],
                'site_id'=>[
                            'label'=>'Site',
                                'type'=>'select',
                                'options'=>'sites',
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
    \Cake\Core\Configure::write('Admin.Table.Domains.tabs', $tabs);    
    \Cake\Core\Configure::write('Admin.Table.Domains.associated', $associated);
}        
        
$this->assign('title', __d('ittvn', 'Edit domain'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Domains'), ['controller' => 'Domains', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn','Edit Domain'), $this->request->here);
?>
