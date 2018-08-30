<?php

use Ittvn\Utility\System;

$system = new System();
$allTotal = 0;
?>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th><?= __d('ittvn', 'ID'); ?></th>
                <th><?= __d('ittvn', 'Product name'); ?></th>
                <th><?= __d('ittvn', 'Quantily'); ?></th>
                <th><?= __d('ittvn', 'Price'); ?></th>
                <th><?= __d('ittvn', 'Total'); ?></th>
                <th><?= __d('ittvn', 'Delete'); ?></th>
            </tr>                                                
        </thead>
        <tbody>
            <?php foreach ($products as $k => $product): ?>
                <tr>
                    <td class="text-center"><?= $k + 1; ?></td>
                    <td><?= $product->name; ?></td>
                    <td class="text-center">
                        <input type="number" product_id="<?= $product->id; ?>" class="update_quantity" value="<?= $product->quantity; ?>" />
                    </td>
                    <td class="text-center"><?= $system->formatCurrency($product->Price_meta); ?></td>
                    <td class="text-right"><?= $system->formatCurrency($product->amount); ?></td>
                    <td class="text-center">
                        <a href="javascript:void(0)" product_id="<?= $product->id; ?>" class="remove_cart"><i class="fa fa-times" aria-hidden="true"></i></a>
                    </td>
                </tr>
                <?php $allTotal += intval($product->amount); ?>
            <?php endforeach; ?>
            <tr>
                <td colspan="4" class="text-center"><strong><?= __d('ittvn', 'Total'); ?></strong></td>
                <td class="text-right"><strong><?= $system->formatCurrency($allTotal); ?></strong></td>
                <td class="text-center">

                </td>
            </tr>
        </tbody>
    </table>
    <?=
    $this->Html->link(
            __d('ittvn', 'Checkout'), ['plugin' => 'Products', 'controller' => 'Products', 'action' => 'checkout'], ['class' => 'btn btn-2 pull-right']
    );
    ?>
</div>