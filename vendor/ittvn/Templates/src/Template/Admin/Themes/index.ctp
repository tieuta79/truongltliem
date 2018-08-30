<?php

use Cake\Core\Configure;
use Cake\Utility\Hash;
use Cake\Core\Plugin;
use Settings\Utility\Setting;

$setting = new Setting();
$this->assign('title', __d('ittvn', 'Themes'));
$this->Html->addCrumb(__d('ittvn', 'Themes'), ['plugin' => 'Themes', 'controller' => 'Themes', 'action' => 'index']);
$temp_site_active = $setting->getOption('Themes.site') == '' ? 'Templates' : $setting->getOption('Themes.site');
$temp_admin_active = $setting->getOption('Themes.admin') == '' ? 'Templates' : $setting->getOption('Themes.admin');
$obj_temp_site_active = $themes['site'][$temp_site_active];
$obj_temp_admin_active = $themes['admin'][$temp_admin_active];
?>

<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="jarviswidget jarviswidget-color-orange" data-widget-sortable="true" data-widget-deletebutton="false" data-widget-colorbutton="false" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-sitemap"></i> </span>
                <h2><?= __d('ittvn', 'Themes'); ?></h2>
            </header>

            <div>
                <div class="widget-body">
                    <div class="tabs-container">
                        <div class="nav-tabs-custom">
                            <!-- Tabs within a box -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#frontend" data-toggle="tab"><i class="fa fa-laptop"></i> <?= __d('ittvn', 'Front end') ?></a></li>
                                <li><a href="#admin" data-toggle="tab"><i class="fa fa-desktop"></i> <?= __d('ittvn', 'Admin') ?></a></li>
                                <li class="pull-right"><a href="javascription:void(0)" data-toggle="modal" data-target="#modalAddTheme" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> <?= __d('ittvn', 'Add Theme'); ?></a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="frontend tab-pane active" id="frontend">                                                                                
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="ibox">
                                                <div class="ibox-title">
                                                    <span class="label label-primary pull-right"><?= __d('ittvn', 'Active'); ?></span>
                                                    <h5><?= $obj_temp_site_active->name; ?></h5>
                                                </div>
                                                <div class="ibox-content">
                                                    <div class="team-members">
                                                        <?= $this->Layout->screenshot($temp_site_active, $obj_temp_site_active->site->image); ?>
                                                    </div>
                                                    <p><?= $obj_temp_site_active->site->description; ?></p>
                                                    <div class="row  m-t-sm">
                                                        <div class="col-sm-6">

                                                        </div>
                                                        <div class="col-sm-6 text-right">
                                                            <div class="font-bold"><?= __d('ittvn', 'VERSION'); ?></div>
                                                            <?= isset($obj_temp_site_active->version) ? $obj_temp_site_active->version : ''; ?> <i class="fa fa-code-fork text-navy"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                
                                        </div>                            
                                        <?php if (count($themes['site']) > 0): ?>
                                            <?php foreach ($themes['site'] as $key => $theme): ?>
                                                <?php if ($temp_site_active != $key): ?>
                                                    <div class="col-md-4">
                                                        <div class="ibox">
                                                            <div class="ibox-title">
                                                                <?php if ($key != 'Templates'): ?>
                                                                    <?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['plugin' => 'Themes', 'controller' => 'Themes', 'action' => 'delete', $key], ['class' => 'btn btn-danger btn-xs pull-right', 'escape' => false, 'confirm' => sprintf(__d('ittvn', 'Are you sure you want to delete theme %s?'), $key)]) ?>
                                                                <?php endif; ?>
                                                                <h5><?= $theme->name; ?></h5>
                                                            </div>
                                                            <div class="ibox-content">
                                                                <div class="team-members">
                                                                    <?= $this->Layout->screenshot($key, $theme->site->image); ?>
                                                                </div>
                                                                <p><?= $theme->site->description; ?></p>
                                                                <div class="row  m-t-sm">
                                                                    <div class="col-sm-6">
                                                                        <?= $this->Html->link('ACTIVE', ['plugin' => 'Themes', 'controller' => 'Themes', 'action' => 'active', 'site', $key], ['class' => 'btn btn-w-m btn-primary']); ?>
                                                                    </div>
                                                                    <div class="col-sm-6 text-right">
                                                                        <div class="font-bold"><?= __d('ittvn', 'VERSION'); ?></div>
                                                                        <?= isset($theme->version) ? $theme->version : ''; ?> <i class="fa fa-code-fork text-navy"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>                                
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>                                                    
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="admin tab-pane " id="admin">                                                                       
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="ibox">
                                                <div class="ibox-title">
                                                    <span class="label label-primary pull-right"><?= __d('ittvn', 'Active'); ?></span>
                                                    <h5><?= $obj_temp_admin_active->name; ?></h5>
                                                </div>
                                                <div class="ibox-content">
                                                    <div class="team-members">
                                                        <?= $this->Layout->screenshot($temp_admin_active, $obj_temp_admin_active->admin->image); ?>
                                                    </div>
                                                    <p><?= $obj_temp_admin_active->admin->description; ?></p>
                                                    <div class="row  m-t-sm">
                                                        <div class="col-sm-6">

                                                        </div>
                                                        <div class="col-sm-6 text-right">
                                                            <div class="font-bold"><?= __d('ittvn', 'VERSION'); ?></div>
                                                            <?= isset($obj_temp_admin_active->version) ? $obj_temp_admin_active->version : ''; ?> <i class="fa fa-code-fork text-navy"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                
                                        </div>                            
                                        <?php if (count($themes['admin']) > 0): ?>
                                            <?php foreach ($themes['admin'] as $key => $theme): ?>
                                                <?php if ($temp_admin_active != $key): ?>
                                                    <div class="col-md-4">
                                                        <div class="ibox">
                                                            <div class="ibox-title">
                                                                <?php if ($key != 'Templates'): ?>
                                                                    <?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['plugin' => 'Themes', 'controller' => 'Themes', 'action' => 'delete', $key], ['class' => 'btn btn-danger btn-xs pull-right', 'escape' => false, 'confirm' => sprintf(__d('ittvn', 'Are you sure you want to delete theme %s?'), $key)]) ?>
                                                                <?php endif; ?>
                                                                <h5><?= $theme->name; ?></h5>
                                                            </div>
                                                            <div class="ibox-content">
                                                                <div class="team-members">
                                                                    <?= $this->Layout->screenshot($key, $theme->admin->image); ?>
                                                                </div>
                                                                <p><?= $theme->admin->description; ?></p>
                                                                <div class="row  m-t-sm">
                                                                    <div class="col-sm-6">                                                            
                                                                        <?= $this->Html->link('ACTIVE', ['plugin' => 'Themes', 'controller' => 'Themes', 'action' => 'active', 'admin', $key], ['class' => 'btn btn-w-m btn-primary']); ?>
                                                                    </div>
                                                                    <div class="col-sm-6 text-right">
                                                                        <div class="font-bold"><?= __d('ittvn', 'VERSION'); ?></div>
                                                                        <?= isset($theme->version) ? $theme->version : ''; ?> <i class="fa fa-code-fork text-navy"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>                                
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>                                                    
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>             
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>

<!-- Modlal add theme -->
<div class="modal inmodal" id="modalAddTheme" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <!--<i class="fa fa-laptop modal-icon"></i>-->
                <h4 class="modal-title">Add Theme</h4>
            </div>
            <?= $this->Form->create('Themes', ['url' => ['plugin' => 'Themes', 'controller' => 'Themes', 'action' => 'add']]); ?>
            <div id="add_theme_popup" class="modal-body">                
                <?= $this->Form->input('name', ['class' => 'form-control']); ?>
                <?= $this->Form->input('type', ['type' => 'select', 'multiple' => 'checkbox', 'options' => ['site' => __d('ittvn', 'Front-end'), 'admin' => __d('ittvn', 'Admin')], 'class' => 'form-control']); ?>
                <?= $this->Form->input('version', ['value' => '1.0', 'class' => 'form-control']); ?>

                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#popup_site" aria-expanded="true">Front End</a></li>
                        <li class=""><a data-toggle="tab" href="#popup_admin" aria-expanded="false">Admin</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="popup_site" class="tab-pane active">
                            <div class="panel-body">
                                <?= $this->Form->input('site_description', ['type' => 'textarea', 'class' => 'form-control']); ?>
                            </div>
                        </div>
                        <div id="popup_admin" class="tab-pane">
                            <div class="panel-body">
                                <?= $this->Form->input('admin_description', ['type' => 'textarea', 'class' => 'form-control']); ?>
                            </div>
                        </div>
                    </div>
                </div>                                       
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" aria-hidden="true">Save</button>
            </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>