<?php

use Cake\Core\Configure;
use Cake\Utility\Hash;
use Ittvn\Utility\System;

$system = new System();
$modules = $system->modules();

$this->assign('title', __d('ittvn', 'Blocks'));
$this->Html->addCrumb(__d('ittvn', 'Blocks'), ['plugin' => 'Blocks', 'controller' => 'Blocks', 'action' => 'index']);
$this->Admin->adminScript('block');

$this->start('title-bar');
echo $this->Html->link(
        '<i class="fa fa-plus"></i> ' . __d('ittvn', 'Add new'), 'javascript:void(0):', ['escape' => false, 'class' => 'btn btn-success', 'data-toggle' => 'modal', 'data-target' => '#add_block']
);
$this->end();
?>
<div class="row">
    <div class="col-lg-4">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="jarviswidget jarviswidget-color-orange" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-sortable="true">
                    <header>
                        <div class="jarviswidget-ctrls" role="menu">   
                            <?php
                            echo $this->Html->link(
                                    '<i class="fa fa-plus"></i> ' . __d('ittvn', 'Add block'), 'javascript:void(0):', ['escape' => false, 'class' => 'btn', 'data-toggle' => 'modal', 'data-target' => '#add_block', 'style' => 'margin-top: -10px;
    padding-right: 10px;']
                            );
                            ?>
                        </div>
                        <h2><?= __d('ittvn', 'Cells'); ?></h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div class="dd" id="cells">
                                <?php if (count($modules) > 0): ?>
                                    <ul class="dd-list">
                                        <?php foreach ($modules as $key => $module): ?>
                                            <li id="<?= base64_encode($key); ?>" class="dd-item">
                                                <div cell="<?= base64_encode($key); ?>" class="dd-handle">
                                                    <span class="title_block"><?= $module['name']; ?></span>                           
                                                    <div class="toolbar-widget pull-right">
                                                        <i data-target="#[!block_id!]" data-toggle="collapse" class="fa fa-pencil-square-o"></i> &nbsp;&nbsp;
                                                        <i class="fa fa-trash text-danger remove_cell"></i>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>         
    </div>
    <div class="col-lg-8">
        <?php if (!empty($blocks) && $blocks->count() > 0): ?>
            <?php foreach ($blocks as $block): ?>
                <div class="col-lg-6 blocks">
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <div class="jarviswidget jarviswidget-color-orange" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-sortable="true">
                                <header>
                                    <div class="jarviswidget-ctrls" role="menu">   

                                    </div>
                                    <h2><?= $block->name; ?></h2>
                                </header>
                                <div>
                                    <div block_id="<?= $block->id; ?>" class="widget-body">
                                        <div id="block<?= $block->id; ?>" class="block">
                                            <?= $block->description; ?>       
                                            <?php
                                            $cells = json_decode($block->cells, true);
                                            if (count($cells) > 0):
                                                foreach ($cells as $k => $cell):
                                                    $uuid = $this->Text->uuid();
                                                    ?>
                                                    <div class="block-item">
                                                        <div cell="<?= base64_encode($cell['cell']); ?>" class="dd-handle">
                                                            <span class="title_block">
                                                                <?php
                                                                if (isset($cell['params']['title']) && !empty($cell['params']['title'])) {
                                                                    echo $cell['params']['title'];
                                                                } else {
                                                                    echo $modules[$cell['cell']]['name'];
                                                                }
                                                                echo '<br /><b><i>(' . Configure::read('modules')[$cell['cell']]['name'] . ')</i></b>';
                                                                $cell['params']['id'] = $k;
                                                                ?>
                                                            </span>                                    
                                                            <div class="toolbar-widget pull-right">
                                                                <i data-target="#<?= $uuid; ?>" data-toggle="collapse" class="fa fa-pencil-square-o"></i> &nbsp;&nbsp;
                                                                <i class="fa fa-trash text-danger remove_cell"></i>
                                                            </div>
                                                        </div>        
                                                        <div class="collapse box_widget_cell form-horizontal" id="<?= $uuid; ?>">
                                                            <?= $this->Form->create('Module'); ?>
                                                            <?php $method = explode('::', $cell['cell']); ?>
                                                            <?= $this->cell($cell['cell'], ['params' => $cell['params']])->render($method[1] . '-form'); ?>
                                                            <div class="form-group cell_button">                                            
                                                                <div class="col-sm-12">
                                                                    <?= $this->Form->button('<i class="fa fa-save"></i> ' . __d('ittvn', 'Save'), ['type' => 'button', 'class' => 'btn btn-sm btn-primary', 'button-type' => 'loading', 'data-style' => 'expand-right']); ?>
                                                                </div>
                                                            </div>
                                                            <?= $this->Form->end(); ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            <?php endforeach; ?>
        <?php endif; ?>      
    </div>
</div>

<!-- Modlal add blocks -->
<div class="modal inmodal" id="add_block" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-bars modal-icon"></i>
                <h4 class="modal-title">Add block</h4>
            </div>
            <div id="menutype" class="modal-body">
                <div class="form-group">
                    <label>Name</label> 
                    <input type="text" name="block[name]" class="form-control">
                </div>
                <div class="form-group">
                    <label>Slug</label> 
                    <input type="text" name="block[slug]" class="form-control">
                </div> 
                <div class="form-group">
                    <label>Description</label> 
                    <textarea name="block[description]" class="form-control"></textarea>
                </div>                                        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save_block" data-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>