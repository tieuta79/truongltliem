<?php

use Cake\Core\Configure;
use Cake\Utility\Hash;
use Ittvn\Utility\Language;

$this->assign('title', __d('ittvn', 'Menus'));
$this->Html->addCrumb(__d('ittvn', 'Menus'), ['plugin' => 'Menus', 'controller' => 'Menus', 'action' => 'index']);
$this->Admin->adminScript('menu');
?>
<div class="row">
    <div class="col-lg-3">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="jarviswidget jarviswidget-color-orange" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-sortable="true">
                    <header>
                        <h2><?= __d('ittvn', 'Custom link'); ?></h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div class="box_menu">
                                <?php
                                echo $this->Form->input('title_link', [
                                    'type' => 'text',
                                    'label' => __d('ittvn', 'Title'),
                                    'class' => 'input-sm form-control'
                                ]);
                                echo $this->Form->input('link', [
                                    'type' => 'text',
                                    'label' => __d('ittvn', 'Link'),
                                    'class' => 'input-sm form-control'
                                ]);
                                ?>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-sm btn-primary add_menu" posttype="link"><?= __d('ittvn', 'Add new'); ?></button>                                          
                                    </div>                                        
                                </div>
                            </div>                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>         
        <?php if (count($contents) > 0): ?>
            <?php foreach ($contents as $content): ?>
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <div class="jarviswidget jarviswidget-color-orange" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-sortable="true">
                            <header>
                                <div class="jarviswidget-ctrls" role="menu">   

                                </div>
                                <h2><?= $content['posttype']['name']; ?></h2>
                            </header>
                            <div>
                                <div class="widget-body">
                                    <div class="box_menu" data-scroll="true" data-height="125">
                                        <?php
                                        if (count($content['contents']) > 0) {
                                            echo $this->Form->input($content['posttype']['slug'], [
                                                'type' => 'select',
                                                'label' => false,
                                                'multiple' => 'checkbox',
                                                'options' => $content['contents'],
                                                'templates' => [
                                                    'nestingLabel' => '<label{{attrs}} class="checkbox">{{input}} {{text}}</label>',
                                                    'checkboxWrapper' => '<div class="form-group smart-form">{{label}}</div>',
                                                ]
                                            ]);
                                        }
                                        ?>
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-4 col-md-pull-1 smart-form">
                                                <label class="toggle">
                                                    <input type="checkbox" checked="checked" name="checkbox-toggle" class="checkall_menu" />
                                                    <i data-swchoff-text="<?= __d('ittvn', 'OFF'); ?>" data-swchon-text="<?= __d('ittvn', 'ON'); ?>"></i>
                                                </label>                                                
                                            </div>
                                            <div class="col-md-8">
                                                <button class="btn btn-sm btn-primary add_menu" posttype="Contents"><?= __d('ittvn', 'Add new'); ?></button>                                          
                                            </div>                                        
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>        

                <?php if (count($content['categories']) > 0): ?>
                    <?php foreach ($content['categories'] as $category => $list): ?>
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <div class="jarviswidget jarviswidget-color-orange" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-sortable="true">
                                    <header>
                                        <div class="jarviswidget-ctrls" role="menu">   

                                        </div>
                                        <h2><?= $category; ?></h2>
                                    </header>
                                    <div>
                                        <div class="widget-body">
                                            <div class="box_menu" data-scroll="true" data-height="125">
                                                <?php
                                                if (count($list) > 0) {
                                                    echo $this->Form->input($category, [
                                                        'type' => 'select',
                                                        'label' => false,
                                                        'multiple' => 'checkbox',
                                                        'options' => $list,
                                                        'templates' => [
                                                            'nestingLabel' => '<label{{attrs}} class="checkbox">{{input}} {{text}}</label>',
                                                            'checkboxWrapper' => '<div class="form-group smart-form">{{label}}</div>',
                                                        ]
                                                    ]);
                                                }
                                                ?>
                                            </div>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-4 col-md-pull-1 smart-form">
                                                        <label class="toggle">
                                                            <input type="checkbox" checked="checked" name="checkbox-toggle" class="checkall_menu" />
                                                            <i data-swchoff-text="<?= __d('ittvn', 'OFF'); ?>" data-swchon-text="<?= __d('ittvn', 'ON'); ?>"></i>
                                                        </label>                                                
                                                    </div>                                                    
                                                    <div class="col-md-8">
                                                        <button class="btn btn-sm btn-primary add_menu" posttype="Categories"><?= __d('ittvn', 'Add new'); ?></button>                                    
                                                    </div>                                        
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>      
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="col-lg-9">
        <div class="row">
            <?= $this->Form->create('Menus', ['url' => ['plugin' => 'Menus', 'controller' => 'Menus', 'action' => 'edit']]); ?>
            <div class="col-xs-12 col-md-12">
                <div class="jarviswidget jarviswidget-color-orange" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-sortable="true">
                    <header>
                        <h2><?= __d('ittvn', 'Menus'); ?></h2>
                    </header>
                    <div class="content">
                        <div class="widget-body">
                            <?= $this->Flash->render(); ?>
                            <div class="menutype" role="menu">   
                                <div class="col-md-5">
                                    <?= $this->Form->input('menutype_id', ['type' => 'select', 'label' => false, 'class' => 'input-sm form-control', 'options' => $menutypes, 'default' => isset($this->request->params['pass'][0]) ? intval($this->request->params['pass'][0]) : '']); ?>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal"><?= __d('ittvn', 'Add menu'); ?></button>
                                    <?php if(Language::getLanguages()->count() > 1): ?>
                                    <button type="button" class="btn btn-sm btn-success" ><?= __d('ittvn', 'Sync menu to languages'); ?></button>
                                    <?php endif; ?>
                                </div>
                            </div>                            
                            <div class="dd" id="nestable">
                                <ol class="dd-list">
                                    <?php if (count($menus) > 0): ?>
                                        <?php foreach ($menus as $menu): ?>
                                            <?= $this->element('list_menu_admin', ['menu' => $menu]); ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ol>
                            </div>

                            <div class="widget-footer text-right">
                                <button type="submit" class="btn btn-sm btn-success pull-right"><i class="fa fa-save"></i> Save Menu</button>
                                <br />
                                <div class="m-t-md" style="display:none">
                                    <h5>Serialised Output</h5>
                                </div>
                                <textarea id="nestable-output" class="form-control" style="display:none"></textarea>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->Form->end(); ?>
        </div>        
    </div>
</div>
<!-- Modlal add menutypes -->
<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-bars modal-icon"></i>
                <h4 class="modal-title">Add menu</h4>
            </div>
            <div id="menutype" class="modal-body">
                <div class="form-group">
                    <label>Name</label> 
                    <input type="text" name="menutype[name]" class="form-control">
                </div>
                <div class="form-group">
                    <label>Slug</label> 
                    <input type="text" name="menutype[slug]" class="form-control">
                </div> 
                <div class="form-group">
                    <label>Description</label> 
                    <textarea name="menutype[description]" class="form-control"></textarea>
                </div>                                        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save_menutype" data-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>