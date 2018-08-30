<?php
use Cake\Core\Configure;
use Cake\Utility\Hash;
$this->assign('title', __d('ittvn', 'Themes'));
$this->Html->addCrumb(__d('ittvn', 'Themes'), ['plugin' => 'Themes', 'controller' => 'Themes', 'action' => 'index']);
$temp_site_active = Configure::read('Settings.Themes.site')==''?'Templates':Configure::read('Settings.Themes.site');
$temp_admin_active = Configure::read('Settings.Themes.admin');
$obj_temp_site_active = $themes['site'][$temp_site_active];
$obj_temp_admin_active = $themes['admin'][$temp_admin_active];
?>
<div class="row">
    <div class="col-md-12">
        <div class="tabs-container">
            <div class="nav-tabs-custom">
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#frontend" data-toggle="tab"><i class="fa fa-desktop"></i> <?= __d('ittvn', 'Front end') ?></a></li>
                    <li><a href="#admin" data-toggle="tab"><i class="fa fa-desktop"></i> <?= __d('ittvn', 'Admin') ?></a></li>
                    <li class="pull-right"><a href="#" class="btn btn-success"><i class="fa fa-plus"></i> <?= __d('ittvn', 'Add Theme'); ?></a></li>
                </ul>
                <div class="tab-content">
                    <div class="frontend tab-pane active" id="frontend">                                                                                
                        <div class="row">
                            <div class="col-md-4">
                                <div class="ibox">
                                    <div class="ibox-title">
                                        <span class="label label-primary pull-right"><?= __d('ittvn','Active'); ?></span>
                                        <h5><?= $obj_temp_site_active->name; ?></h5>
                                    </div>
                                    <div class="ibox-content">
                                        <div class="team-members">
                                            <?= $this->Html->image('/'.$temp_site_active.'/img/'.$obj_temp_site_active->site->image,['class'=>'img-responsive thumbnail','style'=>'height:185px;']) ?>
                                        </div>
                                        <p><?= $obj_temp_site_active->site->description; ?></p>
                                        <div class="row  m-t-sm">
                                            <div class="col-sm-6">
                                                <?= $this->Html->link('DEACTIVE',['plugin'=>'Themes','controller'=>'Themes','action'=>'deactive','site',$temp_site_active],['class'=>'btn btn-w-m btn-primary']);?>
                                            </div>
                                            <div class="col-sm-6 text-right">
                                                <div class="font-bold"><?= __d('ittvn','VERSION');?></div>
                                                <?= isset($obj_temp_site_active->version)?$obj_temp_site_active->version:''; ?> <i class="fa fa-code-fork text-navy"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>                            
                            
                            <?php if(count($themes['site']) > 0): ?>
                            <?php foreach($themes['site'] as $key=>$theme): ?>
                                <?php if($temp_site_active!=$key): ?>
                                    <div class="col-md-4">
                                        <div class="ibox">
                                            <div class="ibox-title">
                                                <h5><?= $theme->name; ?></h5>
                                            </div>
                                            <div class="ibox-content">
                                                <div class="team-members">
                                                    <?= $this->Html->image('/'.$key.'/img/'.$theme->site->image,['class'=>'img-responsive thumbnail','style'=>'height:185px;']) ?>
                                                </div>
                                                <p><?= $theme->site->description; ?></p>
                                                <div class="row  m-t-sm">
                                                    <div class="col-sm-6">
                                                        <?= $this->Html->link('ACTIVE',['plugin'=>'Themes','controller'=>'Themes','action'=>'active','site',$key],['class'=>'btn btn-w-m btn-primary']);?>
                                                    </div>
                                                    <div class="col-sm-6 text-right">
                                                        <div class="font-bold"><?= __d('ittvn','VERSION');?></div>
                                                        <?= isset($theme->version)?$theme->version:''; ?> <i class="fa fa-code-fork text-navy"></i>
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
                                        <span class="label label-primary pull-right"><?= __d('ittvn','Active'); ?></span>
                                        <h5><?= $obj_temp_admin_active->name; ?></h5>
                                    </div>
                                    <div class="ibox-content">
                                        <div class="team-members">
                                            <?= $this->Html->image('/'.$temp_admin_active.'/img/'.$obj_temp_admin_active->admin->image,['class'=>'img-responsive thumbnail','style'=>'height:185px;']) ?>
                                        </div>
                                        <p><?= $obj_temp_admin_active->admin->description; ?></p>
                                        <div class="row  m-t-sm">
                                            <div class="col-sm-6">
                                                <?= $this->Html->link('DEACTIVE',['plugin'=>'Themes','controller'=>'Themes','action'=>'deactive','admin',$temp_admin_active],['class'=>'btn btn-w-m btn-primary']);?>
                                            </div>
                                            <div class="col-sm-6 text-right">
                                                <div class="font-bold"><?= __d('ittvn','VERSION');?></div>
                                                <?= isset($obj_temp_admin_active->version)?$obj_temp_admin_active->version:''; ?> <i class="fa fa-code-fork text-navy"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>                            
                            
                            <?php if(count($themes['admin']) > 0): ?>
                            <?php foreach($themes['admin'] as $key=>$theme): ?>
                                <?php if($temp_admin_active!=$key): ?>
                                    <div class="col-md-4">
                                        <div class="ibox">
                                            <div class="ibox-title">
                                                <h5><?= $theme->name; ?></h5>
                                            </div>
                                            <div class="ibox-content">
                                                <div class="team-members">
                                                    <?= $this->Html->image('/'.$key.'/img/'.$theme->admin->image,['class'=>'img-responsive thumbnail','style'=>'height:185px;']) ?>
                                                </div>
                                                <p><?= $theme->admin->description; ?></p>
                                                <div class="row  m-t-sm">
                                                    <div class="col-sm-6">
                                                        <?= $this->Html->link('ACTIVE',['plugin'=>'Themes','controller'=>'Themes','action'=>'active','site',$key],['class'=>'btn btn-w-m btn-primary']);?>
                                                    </div>
                                                    <div class="col-sm-6 text-right">
                                                        <div class="font-bold"><?= __d('ittvn','VERSION');?></div>
                                                        <?= isset($theme->version)?$theme->version:''; ?> <i class="fa fa-code-fork text-navy"></i>
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