<?php

use Settings\Utility\Setting;

$setting = new Setting();
$this->assign('title', __d('ittvn', 'Wish Lists'));
$this->Html->addCrumb(__d('ittvn', 'Wish Lists'), $this->request->here);
?>
<div class="row">
    <div id="page-header" class="col-md-24">
        <h1 id="page-title"><?= __d('ittvn', 'Wish Lists'); ?></h1> 
    </div>
    <div id="col-main" class="col-md-24 register-page clearfix">
        <div class="row checkout-form">
            <?= $this->cell('Products.Customers::menu'); ?>
            <div class="col-xs-24 col-md-17 pull-right">
                <div class="row box_title">
                    <div class="col-md-24">
                        <h6 class="sb-title"><?= __d('ittvn', 'Wish Lists'); ?></h6>
                    </div>
                </div> 
                <div class="row box_content_main">
                    <div class="col-md-24">
                        <div class="row">
                            <div class="col-md-24">
                                <h5>
                                    <span><?= __d('ittvn', 'Wish Lists'); ?></span>
                                </h5>
                                <div id="box_customers" class="recent_order">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th><?= __d('ittvn', 'Product'); ?></th>
                                                    <th><?= __d('ittvn', 'Price'); ?></th>
                                                    <th style="width: 25%;"><?= __d('ittvn', 'Action'); ?></th>
                                                </tr>                                                
                                            </thead>
                                            <tbody>
                                                <?php foreach ($wishlists as $wishlist): ?>
                                                    <tr>
                                                        <td class="text-left">
                                                            <?php
                                                            if ($wishlist->has('content')) {
                                                                echo $this->Html->link(
                                                                        $wishlist->content->name, ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'products', 'slug' => $wishlist->content->slug], ['title' => $wishlist->content->name]
                                                                );
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($wishlist->has('content')) {
                                                                echo $this->Layout->formatCurrency($wishlist->content->Price_meta);
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            echo $this->Form->create('',['style'=>'float: left;']);
                                                            echo $this->Form->input('product_id', ['type' => 'hidden', 'value' => $wishlist->content->id]);
                                                            echo $this->Form->input('product_name', ['type' => 'hidden', 'value' => $wishlist->content->name]);
                                                            echo $this->Form->input('quantity', ['type' => 'hidden', 'value' => 1]);
                                                            echo $this->Form->button('<i class="fa fa-shopping-cart"></i> <span class="list-mode">' . __d('ittvn', 'Add to Cart') . '</span>', ['type' => 'submit', 'class' => 'add-to-cart btn btn-2']);
                                                            echo $this->Form->end();
                                                            ?>
                                                            <a href="javascript:void(0)" wishlist_id="<?= $wishlist->id; ?>" class="remove_wishlist btn btn-2">
                                                                <i class="fa fa-times" aria-hidden="true" style="color: #fff"></i>
                                                            </a>
                                                        </td>
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