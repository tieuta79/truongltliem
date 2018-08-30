<?php

use Settings\Utility\Setting;

$setting = new Setting();
?>
<div class="row">
    <div class="col-md-24">
        <h5>
            <span><?= __d('ittvn', 'Recent orders'); ?></span>
            <?= $this->Html->link(__d('ittvn', 'View all') . ' <i class="fa fa-angle-right" aria-hidden="true"></i>', ['plugin' => 'Products', 'controller' => 'Orders', 'action' => 'index'], ['escape' => false, 'class' => 'edit_account pull-right']); ?>
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
                                    if ($order->has('orderdetails')) {
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