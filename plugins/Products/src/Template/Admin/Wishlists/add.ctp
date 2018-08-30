<?php
\Cake\Core\Configure::write('Admin.Forms.Wishlists', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'content_id'=>[
                            'label'=>'Content',
                                'type'=>'select',
                                'options'=>'contents',
                                                        ],
                'user_id'=>[
                            'label'=>'User',
                                'type'=>'select',
                                'options'=>'users',
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
    \Cake\Core\Configure::write('Admin.Table.Wishlists.tabs', $tabs);    
    \Cake\Core\Configure::write('Admin.Table.Wishlists.associated', $associated);
}        
        
$this->assign('title', __d('ittvn', 'Add wishlist'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Wishlists'), ['controller' => 'Wishlists', 'action' => 'index']);
    
$this->Html->addCrumb(__d('ittvn','Add Wishlist'), ['controller' => 'Wishlists', 'action' => 'add']);
?>
