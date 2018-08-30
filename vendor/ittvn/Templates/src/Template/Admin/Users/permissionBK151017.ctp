<?php

use Cake\Utility\Inflector;
use Cake\Utility\Hash;

$this->assign('title', __d('ittvn', 'Permission'));
$this->Html->addCrumb(__d('ittvn', 'Users'), ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'Permission'), $this->request->here);
?>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="jarviswidget jarviswidget-color-orange" data-widget-sortable="true" data-widget-deletebutton="false" data-widget-colorbutton="false" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-sitemap"></i> </span>
                <h2><?= __d('ittvn', 'Permission user by role'); ?></h2>
            </header>

            <div>
                <div class="widget-body">
                    <?= $this->Form->create('Permission'); ?>
                    <div class="widget-body-toolbar bg-color-white">
                        <div class="row">
                            <div class="col-sm-12 col-md-9">
                                <?= $this->Form->input('role', ['type' => 'select', 'id' => 'change_permission_role', 'label' => 'Choose a role change permission', 'class' => 'form-control', 'options' => $roles, 'default' => $user_slug]); ?>
                            </div>
                            <div class="col-sm-12 col-md-3 text-align-right" style="padding-top: 21px;">
                                <?= $this->Html->link('<i class="fa fa-cogs fa-spin"></i> ' . __d('ittvn', 'Rebuild Actions'), ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'buildAcl'], ['escape' => false, 'class' => 'btn btn-success btn-sm', 'data-toggle' => 'tooltip', 'title' => 'Rebuild ACO all controllers']); ?>
                                <?php echo str_repeat('&nbsp;', 3); ?>
                                <?= $this->Html->link('Update Actions', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'buildAcl', 'update'], ['class' => 'btn btn-info btn-sm', 'data-toggle' => 'tooltip', 'title' => 'Update ACO']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?= $this->Flash->render(); ?>
                    </div>
                    <!-- tab boostrap  -->
                    <?php
                    //pr($plugins);
                        $arraySite = array();
                        foreach ($plugins as $key => $values) {
                            foreach ($values as $key1 => $value1) {
                                if($key1 == 'Admin'){
                                   $arraySite['PluginA'][$key][$key1] = $values[$key1];
                                }else{
                                    $arraySite['Plugin'][$key][$key1] = $values[$key1];
                                }
                            }
                        }
                    ?>
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#permiss">Permission site</a></li>
                        <li><a data-toggle="tab" href="#permissAdmin">Permission admin</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="permiss" class="tab-pane fade in active">
                        <?php foreach ($arraySite['Plugin'] as $title => $controllers): ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="text-danger"><?= $title; ?></h4>
                                    <div class="hr-line-dashed"></div>
                                        <?php foreach ($controllers as $title1 => $action): ?>
                                                <div class="col-md-2">
                                                    <?=
                                                    $this->Form->input(Inflector::singularize($title1), Hash::merge($action, ['type' => 'select', 'multiple' => 'checkbox', 'name' => $title . '/' . $title1, 'label' => ['class' => 'text-navy', 'text' => $title1]]));
                                                    ?>
                                                </div>
                                        <?php  endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </div>
                        <div id="permissAdmin" class="tab-pane fade">
                        <?php foreach ($arraySite['PluginA'] as $title => $controllers): ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="text-danger"><?= $title; ?></h4>
                                    <div class="hr-line-dashed"></div>
                                        <?php foreach ($controllers as $title1 => $action): ?>
                                                <?php foreach ($action as $prefix => $ac): ?>
                                                <div class="col-md-2">
                                                    <?= $this->Form->input(Inflector::singularize($title1 . '-' . $prefix), Hash::merge($ac, ['type' => 'select', 'multiple' => 'checkbox', 'name' => $title . '/' . $title1 . '/' . $prefix, 'label' => ['class' => 'text-navy', 'text' => $title1 . ' - ' . $prefix]])); ?>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php  endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>


                    <?php /*foreach ($plugins as $title => $controllers): ?>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-danger"><?= $title; ?></h4>
                                <div class="hr-line-dashed"></div>
                                <div class="row">
                                    <?php foreach ($controllers as $title1 => $action): ?>
                                        <?php if ($title1 != 'Admin'): ?>
                                            <div class="col-md-4">
                                                <?=
                                                $this->Form->input(Inflector::singularize($title1), Hash::merge($action, ['type' => 'select', 'multiple' => 'checkbox', 'name' => $title . '/' . $title1, 'label' => ['class' => 'text-navy', 'text' => $title1]]));
                                                ?>
                                            </div>
                                        <?php else: ?>
                                            <?php foreach ($action as $prefix => $ac): ?>
                                                <div class="col-md-4">
                                                    <?= $this->Form->input(Inflector::singularize($title1 . '-' . $prefix), Hash::merge($ac, ['type' => 'select', 'multiple' => 'checkbox', 'name' => $title . '/' . $title1 . '/' . $prefix, 'label' => ['class' => 'text-navy', 'text' => $title1 . ' - ' . $prefix]])); ?>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;*/ ?>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-left">
                                <button type="submit" class="btn btn-success btn-sm" data-toggle="tooltip" title="<?= __d('ittvn', 'Save'); ?>"><i class="fa fa-save"></i> <?= __d('ittvn', 'Save'); ?></button>
                            </div>
                        </div>
                    </div>
                    <?= $this->Form->end(); ?>
                </div>
            </div>
        </div>    
    </div>
</div>