<?php
\Cake\Core\Configure::write('Admin.Forms.Translates', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'language_id'=>[
                            'label'=>'Language',
                                'type'=>'select',
                                'options'=>'languages',
                                                        ],
                'locale_id'=>[
                            'label'=>'Locale',
                                'type'=>'select',
                                'options'=>'locales',
                                                        ],
                'msgstr'=>[
                            'label'=>'Msgstr',
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
    \Cake\Core\Configure::write('Admin.Table.Translates.tabs', $tabs);    
    \Cake\Core\Configure::write('Admin.Table.Translates.associated', $associated);
}        
        
$this->assign('title', __d('ittvn', 'Edit translate'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Translates'), ['controller' => 'Translates', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn','Edit Translate'), $this->request->here);
?>
