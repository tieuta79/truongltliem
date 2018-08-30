<?php

use Cake\Utility\Inflector;
use Cake\Utility\Hash;

$this->assign('title', __d('ittvn', 'User Permission'));
$this->Html->addCrumb(__d('ittvn', 'Users'), ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'roles']);
$this->Html->addCrumb(__d('ittvn', 'User Permission'), $this->request->here);



?>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="jarviswidget jarviswidget-color-orange" data-widget-sortable="true" data-widget-deletebutton="false" data-widget-colorbutton="false" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-sitemap"></i> </span>
                <h2><?= __d('ittvn', 'User Permission'); ?></h2>
            </header>

            <div class="widget-body">
                <?= $this->Form->create('roles'); ?>

                <div class="row">
                    <?= $this->Flash->render(); ?>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php //pr($data); die(); ?>
                        <?php if(isset($data['Admin'])):  $i=0; foreach ($data['Admin'] as $key => $value): ?>
                        <label for="<?= $key . '-' . $i; ?>" class="selected">
                                <input type="checkbox" name="SelectedPermission[]" value="<?= $key; ?>" <?php if(in_array($key, $select_per)) echo 'checked="checked"';?> id="<?= $key . '-' . $i; ?>"> <i></i> <?= $key; ?>
                        </label>
                        <?php $i++; endforeach; endif; ?> 
                    </div>
                    <div class="col-md-12">
                        <div class="form-actions">
                            <div class="row">
                                <div class="text-left">
                                    <button type="submit" class="btn btn-success btn-sm" data-toggle="tooltip" title="<?= __d('ittvn', 'Save'); ?>"><i class="fa fa-save"></i> <?= __d('ittvn', 'Save'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
       
    </div>
</div>