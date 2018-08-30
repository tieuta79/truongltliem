<?php

use Settings\Utility\Setting;

$setting = new Setting();
$this->assign('title', __d('ittvn', 'Address'));
$this->Html->addCrumb(__d('ittvn', 'Address'), $this->request->here);
?>
<div class="row">
    <div id="page-header" class="col-md-24">
        <h1 id="page-title"><?= __d('ittvn', 'Address'); ?></h1> 
    </div>
    <div id="col-main" class="col-md-24 register-page clearfix">
        <div class="row checkout-form">
            <?= $this->cell('Products.Customers::menu'); ?>
            <div class="col-xs-24 col-md-17 pull-right">
                <div class="row box_title">
                    <div class="col-md-24">
                        <h6 class="sb-title"><?= __d('ittvn', 'Address'); ?></h6>
                    </div>
                </div> 
                <div class="row box_content_main">
                    <div class="col-md-24">
                        <div class="row">
                            <div class="col-md-24">
                                <h5>
                                    <span><?= __d('ittvn', 'Address book'); ?></span>
                                    <?= $this->Html->link(__d('ittvn', 'Add address') . ' <i class="fa fa-angle-right" aria-hidden="true"></i>', ['plugin' => 'Products', 'controller' => 'Addresses', 'action' => 'add'], ['escape' => false, 'class' => 'edit_account pull-right']); ?>
                                </h5>
                                <div class="row">
                                    <?php foreach ($addresses as $address): ?>
                                        <div class="col-md-12">
                                            <div class="info_user">
                                                <p>
                                                    <strong><?= $address->name; ?> </strong>
                                                    <?php if ($address->default == 1): ?>
                                                        <span class="pull-right text-success"><?= __d('ittvn', 'Default'); ?></span>
                                                    <?php endif; ?>
                                                </p>
                                                <p>
                                                    <span><?= sprintf(__d('ittvn', 'Address')); ?>: </span>
                                                    <span><?= sprintf(__d('ittvn', '%s, %s, %s, %s'), $address->address, $address->ward->name, $address->city->name, $address->province->name); ?></span>
                                                </p>
                                                <p>
                                                    <span><?= sprintf(__d('ittvn', 'Phone')); ?>: </span>
                                                    <span><?= $this->request->session()->read('Auth.Registered.phone'); ?></span>
                                                </p>
                                                <?= $this->Html->link('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', ['plugin' => 'Products', 'controller' => 'Addresses', 'action' => 'edit', $address->id], ['class' => 'btn btn-2', 'escape' => false]) ?>
                                                <?php if ($address->default != 1): ?>
                                                    <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['plugin' => 'Products', 'controller' => 'Addresses', 'action' => 'delete', $address->id], ['class' => 'btn btn-2', 'escape' => false]) ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>            
        </div>
    </div>   
</div>