<?php

use Ittvn\Utility\System;

$system = new System();
$total = 0;
?>
<div id="cart-content">
    <?php if (isset($products) && count($products) > 0): ?>
        <div data-scroll="true" data-height="300" class="items control-container">
            <?php foreach ($products as $product): ?>
                <div class="row items-wrapper">
                    <a product_id="<?= $product->id; ?>" class="cart-close" title="Remove" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                    <div class="col-md-8 cart-left">
                        <?=
                        $this->Html->link(
                                $this->Html->image($product->image, ['alt' => $product->name]), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'products', 'slug' => $product->slug], ['class' => 'cart-image', 'escape' => false]
                        );
                        ?>
                    </div>
                    <div class="col-md-16 cart-right">
                        <div class="cart-title">
                            <?=
                            $this->Html->link(
                                    $product->name, ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'products', 'slug' => $product->slug]
                            );
                            ?>
                        </div>
                        <div class="cart-price">
                            <?= $system->formatCurrency($product['Price_meta']); ?><span class="x"> x </span><?= $product['quantity']; ?>
                        </div>
                    </div>
                </div>
                <?php
                $total += intval($product->amount);
            endforeach;
            ?>
        </div>
        <div class="subtotal">
            <span><?= __d('ittvn', 'Total'); ?>:</span> <span class="cart-total-right pull-right"><?= $system->formatCurrency($total); ?></span>
        </div>
        <div class="action">
            <?=
            $this->Html->link(
                    __d('ittvn', 'Checkout'), ['plugin' => 'Products', 'controller' => 'Products', 'action' => 'checkout'], ['class' => 'btn btn-1']
            );
            ?>
            <br />
            <?=
            $this->Html->link(
                    __d('ittvn', 'View Cart'), ['plugin' => 'Products', 'controller' => 'Products', 'action' => 'cart'], ['class' => 'btn btn-1']
            );
            ?>
        </div>
    <?php endif; ?>
</div>