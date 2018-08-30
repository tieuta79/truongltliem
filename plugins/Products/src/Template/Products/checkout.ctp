<?php

use Settings\Utility\Setting;

$setting = new Setting();
$this->Html->addCrumb(__d('ittvn', 'checkout'), ['plugin' => 'Products', 'controller' => 'Products', 'action' => 'checkout']);
?>
<div class="row">
    <div id="page-header">
        <h1 id="page-title"><?= __d('ittvn', 'Checkout'); ?></h1>
    </div>
    <div id="col-main" class="col-md-24 normal-page clearfix">
        <div class="page about-us ">
            <div class="row">
                <div class="col-md-24">
                    <div class="row">
                        <?php foreach ($addresses as $address): ?>
                            <div class="col-md-12">
                                <div id="choose_address" class="info_user">
                                    <p>
                                        <strong><?= $address->name; ?> </strong>
                                        <?php if ($address->default == 1): ?>
                                            <span class="pull-right text-success">Mặc định</span>
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
                                    <a href="javascript:void(0)" address_id="<?= $address->id; ?>" class="choose_address btn <?= $address->default == 1?'btn-2':'btn-1'; ?>"><?= __d('ittvn','Assigned to this address'); ?></a>
                                    <?= $this->Html->link('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', ['plugin' => 'Products', 'controller' => 'Addresses', 'action' => 'edit', $address->id], ['class' => 'btn btn-1','escape' => false]) ?> 
                                    <?php if ($address->default != 1): ?>
                                    <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['plugin' => 'Products', 'controller' => 'Addresses', 'action' => 'delete', $address->id], ['class' => 'btn btn-1','escape' => false]) ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p><?= sprintf(__d('ittvn','You want delivery to another address? %s'),$this->Html->link(__d('ittvn','Add new shipping address'),['plugin'=>'Products','controller'=>'Addresses','action'=>'add'])); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>