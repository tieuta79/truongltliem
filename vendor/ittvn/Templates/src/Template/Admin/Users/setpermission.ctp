<?php

use Cake\Utility\Inflector;
use Cake\Utility\Hash;

$this->assign('title', __d('ittvn', 'Set Permission'));
$this->Html->addCrumb(__d('ittvn', 'Users'), ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'Set Permission'), $this->request->here);
?>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="jarviswidget jarviswidget-color-orange" data-widget-sortable="true" data-widget-deletebutton="false" data-widget-colorbutton="false" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-sitemap"></i> </span>
                <h2><?= __d('ittvn', 'Set Permission user'); ?></h2>
            </header>
            <div>
                <div class="widget-body">
                    <?= $this->Form->create('setPermission'); ?>
                    <div class="row">
                        <?= $this->Flash->render(); ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#permiss">Set Permission site</a></li>
                                <li><a data-toggle="tab" href="#permissAdmin">Set Permission admin</a></li>
                            </ul>
                            <div class="tab-content pd-top">
                                <div id="permiss" class="tab-pane fade in active">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-sm-4">Multiple select permission </label>
                                                <div class="col-sm-8">
                                                    <?php
                                                    echo $this->Form->input('selectSite', ['type' => 'select', 'id' => 'multipleSelectSite', 'multiple' => true, 'name' => 'selectSite', 'class' => 'populate', 'label' => false,
                                                        'options' => $plugins['Plugin']
                                                    ]);
                                                    ?> 
                                                </div>
                                            </div>
                                            <br>
                                            <div class="form-group"> 
                                                <label class="control-label col-sm-4">Name input </label>
                                                <div class="col-sm-8">
                                                    <input value="" name="sitenameAction" class="form-control"> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group select">
                                                <label class="text-navy" for="block">Select permission </label>
                                                <?php if (isset($setpermission['Sites'])): ?>
                                                    <?php
                                                    $i = 0;
                                                    foreach ($setpermission['Sites'] as $k => $permission):
                                                        ?>
                                                        <div class="">
                                                            <label for="<?= $k . '-' . $i; ?>" class="selected">
                                                                <input type="checkbox" name="SellectedSite[]" value="<?= $k; ?>" id="<?= $k . '-' . $i; ?>"> <i></i> <?= $k; ?>
                                                            </label>
                                                            <div class="pl-2" style="padding-left:10px;">
                                                                <?php foreach ($permission as $p): ?>
                                                                    <span><?= $p; ?> </span></br>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $i++;
                                                    endforeach;
                                                    ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div id="permissAdmin" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-sm-4">Multiple select Admin permission </label>                                                
                                                <div class="col-sm-8">
                                                    <?php
                                                    echo $this->Form->input('selectAdmin', ['type' => 'select', 'id' => 'multipleSelectAdmin', 'multiple' => true, 'name' => 'selectAdmin', 'class' => 'populate', 'label' => false,
                                                        'options' => $plugins['PluginA']
                                                    ]);
                                                    ?> 
                                                    
                                                </div>
                                            </div>
                                            <br>
                                            <div class="form-group"> 
                                                <label class="control-label col-sm-4">Name input </label>
                                                <div class="col-sm-8">
                                                    <input value="" name="adminnameAction" class="form-control"> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group select">
                                            <label class="text-navy" for="block">Select permission </label>
                                            <?php if (isset($setpermission['Admin'])): ?>
                                                <?php
                                                $i = 0;
                                                foreach ($setpermission['Admin'] as $k => $permission):
                                                    ?>
                                                    <div class="">
                                                        <label for="<?= $k . '-' . $i; ?>" class="selected">
                                                            <input type="checkbox" name="SellectedAdmin[]" value="<?= $k; ?>" id="<?= $k . '-' . $i; ?>"> <i></i> <?= $k; ?>
                                                        </label>
                                                        <div class="pl-2" style="padding-left:10px;">
                                                            <?php foreach ($permission as $p): ?>
                                                                <span><?= $p; ?> </span></br>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $i++;
                                                endforeach;
                                                ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>    


                        </div>
                        <div class="col-md-12">
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-6 text-left">
                                        <button type="submit" class="btn btn-success btn-sm" data-toggle="tooltip" title="<?= __d('ittvn', 'Save'); ?>"><i class="fa fa-save"></i> <?= __d('ittvn', 'Save'); ?></button>
                                    </div>
                                    <div class="col-md-6">
                                        <button id="DeleteSet" class="btn btn-danger btn-sm" data-toggle="tooltip"><i class="fa fa-trash-o"></i> <?= __d('ittvn', 'Delete'); ?> </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?= $this->Form->end(); ?>
                        <style>
                            .selectRow {
                                display : block;
                                padding : 20px;
                            }
                            .select2-container {
                                width: 300px;
                            }
                        </style>
                        <script>
                            $(document).ready(
                                function () {
                                    $("#multipleSelectSite").select2();
                                    $("#multipleSelectAdmin").select2();
                                }
                            );
                        </script>

                    </div>
                </div>
            </div>    
        </div>
    </div>