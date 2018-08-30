<?php

use Settings\Utility\Setting;

$setting = new Setting();
$this->assign('title', __d('ittvn', 'Detail order #' . $this->request->order));
$this->Html->addCrumb(__d('ittvn', 'Detail order #') . $this->request->order, $this->request->here);
?>
<div class="row">
    <div id="col-main" class="col-md-24 register-page clearfix">
        <div class="row checkout-form">
            <?= $this->cell('Products.Customers::menu'); ?>
            <div class="col-xs-24 col-md-17 pull-right">
                <div class="row box_title">
                    <div class="col-md-24">
                        <h6 class="sb-title"><?= __d('ittvn', 'Detail order #') . $this->request->order; ?></h6>
                    </div>
                </div> 
                <div class="row box_content_main">
                    <div class="col-md-24">
                        <div class="row">
                            <div class="col-md-24">
                                <p><?= __d('ittvn', 'Order date'); ?>: <?= $order->created->format($setting->getOption('Sites.format_date')); ?></p>
                                <br />
                                <h5><span><?= __d('ittvn', 'Address people receiver'); ?></span></h5>
                                <p><?= $order->receiver; ?></p>
                                <p><?= $order->address; ?></p>
                                <p><?= sprintf(__d('ittvn', 'Phone: %s'), $order->phone); ?></p>
                                <br />
                                
                                <h5><span><?= __d('ittvn', 'Method payment'); ?></span></h5>
                                <p><?= sprintf(__d('ittvn', 'Payment by %s'), $order->payment->name); ?></p>
                                
                                <div id="box_customers" class="recent_order">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th><?= __d('ittvn', 'ID'); ?></th>
                                                    <th><?= __d('ittvn', 'Product'); ?></th>
                                                    <th><?= __d('ittvn', 'Product'); ?></th>
                                                    <th><?= __d('ittvn', 'Quantily'); ?></th>
                                                    <th><?= __d('ittvn', 'Total amount'); ?></th>
                                                </tr>                                                
                                            </thead>
                                            <tbody>
                                                <?php $total = 0; ?>
                                                <?php foreach ($orderdetails as $k => $orderdetail): ?>
                                                    <tr>
                                                        <td><?= $k + 1; ?></td>
                                                        <td>
                                                            <?php
                                                            if ($orderdetail->has('content')) {
                                                                echo $this->Html->link(
                                                                        $orderdetail->content->name, ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'products', 'slug' => $orderdetail->content->slug], ['title' => $orderdetail->content->name]
                                                                );
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?= $orderdetail->quantity; ?></td>
                                                        <td><?= $this->Layout->formatCurrency($orderdetail->price); ?></td>
                                                        <td><?= $this->Layout->formatCurrency($orderdetail->total); ?></td>
                                                    </tr>
                                                    <?php $total += $orderdetail->total; ?>
                                                <?php endforeach; ?>
                                                <tr>
                                                    <td colspan="4"><strong><?= __d('ittvn', 'Total'); ?></strong></td>
                                                    <td><strong><?= $this->Layout->formatCurrency($total); ?></strong></td>
                                                </tr>
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