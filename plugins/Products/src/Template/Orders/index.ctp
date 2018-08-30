<?php

use Settings\Utility\Setting;

$setting = new Setting();
$this->assign('title', __d('ittvn', 'My orders'));
$this->Html->addCrumb(__d('ittvn', 'My orders'), $this->request->here);
?>
<div class="row">
    <div id="page-header" class="col-md-24">
        <h1 id="page-title"><?= __d('ittvn', 'My orders'); ?></h1> 
    </div>
    <div id="col-main" class="col-md-24 register-page clearfix">
        <div class="row checkout-form">
            <?= $this->cell('Products.Customers::menu'); ?>
            <div class="col-xs-24 col-md-17 pull-right">
                <div class="row box_title">
                    <div class="col-md-24">
                        <h6 class="sb-title"><?= __d('ittvn', 'My orders'); ?></h6>
                    </div>
                </div> 
                <div class="row box_content_main">
                    <div class="col-md-24">
                        <div class="row">
                            <div class="col-md-24">
                                <h5>
                                    <span><?= __d('ittvn', 'My orders'); ?></span>
                                </h5>
                                <div id="box_customers" class="recent_order">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th><?= __d('ittvn', 'Order'); ?></th>
                                                    <th><?= __d('ittvn', 'Date'); ?></th>
                                                    <th><?= __d('ittvn', 'Product'); ?></th>
                                                    <th><?= __d('ittvn', 'Total amount'); ?></th>
                                                    <th><?= __d('ittvn', 'Status'); ?></th>
                                                </tr>                                                
                                            </thead>
                                            <tbody>
                                                <?php foreach ($orders as $order): ?>
                                                    <tr>
                                                        <td>
                                                            <?= $this->Html->link($order->name, ['plugin' => 'Products', 'controller' => 'Orderdetails', 'action' => 'index', 'order' => $order->name]); ?>
                                                        </td>
                                                        <td><?= $order->created->format($setting->getOption('Sites.format_date')); ?></td>
                                                        <td>
                                                            <?php
                                                                if($order->has('orderdetails')){
                                                                    echo $products[$order->orderdetails[0]->content_id];
                                                                }
                                                            ?>
                                                        </td>
                                                        <td><?= $this->Layout->formatCurrency($order->price); ?></td>
                                                        <td><?= $order->price == 1 ? __d('ittvn', 'Delivery') : __d('ittvn', 'Waiting'); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
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