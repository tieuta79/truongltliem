<?php

use Settings\Utility\Setting;

$setting = new Setting();
$this->Html->addCrumb(__d('ittvn', 'payment'), ['plugin' => 'Products', 'controller' => 'Products', 'action' => 'payment']);
?>
<div class="row">
    <div id="page-header">
        <h1 id="page-title"><?= __d('ittvn', 'Payment'); ?></h1>
    </div>
    <div id="col-main" class="col-md-24 normal-page clearfix">
        <div class="row checkout-form">
            <div class="col-xs-24 col-md-17">
                <div class="row box_title">
                    <div class="col-md-24">
                        <h6 class="sb-title"><?= __d('ittvn','Method payment'); ?></h6>
                    </div>
                </div> 
                <div class="row box_content_main">
                    <div class="col-md-24">
                        <div class="row">
                            <div class="col-md-24">
                                <?php 
                                foreach ($payments as $payment){
                                    echo $this->Html->link($this->Html->image($payment->image,['alt'=>$payment->name]),'javascript:void(0)',['escape' => false,'class'=>'method_payment','id'=>$payment->id]);
                                }
                                ?>
                            </div>
                        </div>
                        <?php foreach ($payments as $payment): ?>
                        <div class="row">
                            <div class="col-md-24">
                                
                            </div>
                        </div>    
                        <?php endforeach; ?>
                    </div>
                </div>
            </div> 

            <div class="col-xs-24 col-md-6 pull-right">
                <div class="row box_title">
                    <div class="col-md-24">
                        <h6 class="sb-title"><?= __d('ittvn','Order'); ?></h6>
                    </div>
                </div>       
                <div class="row box_content">
                    <div class="list-group">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>