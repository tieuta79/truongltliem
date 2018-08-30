<?php

use Cake\Routing\Router;
?>
<div class="cart-link">
    <a href="<?= Router::url(['plugin' => 'Products', 'controller' => 'Products', 'action' => 'cart']); ?>" class="dropdown-toggle dropdown-link" data-toggle="dropdown">
        <i class="sub-dropdown1"></i>
        <i class="sub-dropdown"></i>
        <div class="num-items-in-cart">
            <span class="icon">
                <?= __d('ittvn', 'Cart'); ?>
                <span class="number"><?= $this->element('Products.cart_number', ['quantity' => $quantity]); ?></span>
            </span>
        </div>
    </a>
    <div id="cart-info" class="dropdown-menu" style="display: none;">
        <?= $this->element('Products.cart_info', ['products' => $products]); ?>
    </div>
</div>