<?php
\Cake\Core\Configure::write('Admin.Forms.Bookings', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'content_id'=>[
                            'label'=>'Content',
                                'type'=>'select',
                                'options'=>'contents',
                                                        ],
                'first_name'=>[
                            'label'=>'First Name',
                                'type'=>'text',
                                                        ],
                'last_name'=>[
                            'label'=>'Last Name',
                                'type'=>'text',
                                                        ],
                'email'=>[
                            'label'=>'Email',
                                'type'=>'text',
                                                        ],
                'phone'=>[
                            'label'=>'Phone',
                                'type'=>'text',
                                                        ],
                'adults'=>[
                            'label'=>'Adults',
                                'type'=>'text',
                                                        ],
                'children'=>[
                            'label'=>'Children',
                                'type'=>'text',
                                                        ],
                'checkin'=>[
                            'label'=>'Checkin',
                                'type'=>'date',
                                'timeFormat'=>24,
                                'templates'=>[
                                    'select'=>'<div class="col-sm-4"><select name="{{name}}" class="form-control"{{attrs}}>{{content}}</select></div>',
                                            'dateWidget'=>'<div class="row"><div class="col-sm-12 datetime_input">{{day}}{{month}}{{year}} {{hour}}{{minute}}{{second}} {{meridian}}</div></div>',
                                                
                                    ],
                                                        ],
                'checkout'=>[
                            'label'=>'Checkout',
                                'type'=>'date',
                                'timeFormat'=>24,
                                'templates'=>[
                                    'select'=>'<div class="col-sm-4"><select name="{{name}}" class="form-control"{{attrs}}>{{content}}</select></div>',
                                            'dateWidget'=>'<div class="row"><div class="col-sm-12 datetime_input">{{day}}{{month}}{{year}} {{hour}}{{minute}}{{second}} {{meridian}}</div></div>',
                                                
                                    ],
                                                        ],
                'status'=>[
                            'label'=>'Status',
                                'type'=>'checkbox',
                                                        ],
                'delete'=>[
                            'label'=>'Delete',
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
    \Cake\Core\Configure::write('Admin.Table.Bookings.tabs', $tabs);    
    \Cake\Core\Configure::write('Admin.Table.Bookings.associated', $associated);
}        
        
$this->assign('title', __d('ittvn', 'Edit booking'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Bookings'), ['controller' => 'Bookings', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn','Edit Booking'), $this->request->here);
?>
