<?php
\Cake\Core\Configure::write('Admin.Forms.Locales', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'msgid'=>[
                            'label'=>'Msgid',
                                'type'=>'textarea',
                                                        ],
                'domain'=>[
                            'label'=>'Domain',
                                'type'=>'text',
                                                        ],
                'description'=>[
                            'label'=>'Description',
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
    \Cake\Core\Configure::write('Admin.Table.Locales.tabs', $tabs);    
    \Cake\Core\Configure::write('Admin.Table.Locales.associated', $associated);
}        
        
$this->assign('title', __d('ittvn', 'Edit locale'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Locales'), ['controller' => 'Locales', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn','Edit Locale'), $this->request->here);
?>
