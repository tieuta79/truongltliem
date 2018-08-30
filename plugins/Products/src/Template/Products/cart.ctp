<?php

use Settings\Utility\Setting;

$setting = new Setting();
$this->Html->addCrumb(__d('ittvn', 'Cart'), ['plugin' => 'Products', 'controller' => 'Products', 'action' => 'cart']);
?>
<div class="row">
    <div id="page-header">
        <h1 id="page-title"><?= __d('ittvn', 'Cart'); ?></h1>
    </div>
    <div id="col-main" class="col-md-24 normal-page clearfix">
        <div class="page about-us ">
            <div class="row">
                <div class="col-md-24">
                    <div id="view_cart">
                        <?= $this->element('Products.view_cart', ['products' => $products]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>