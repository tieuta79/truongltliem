<div id="prod-related-wrapper">
    <div class="prod-related clearfix">
        <?php if (isset($products) && count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
                <div class="element no_full_width animated" data-animate="bounceIn" data-delay="0">
                    <ul class="row-container list-unstyled clearfix">
                        <li class="row-left">
                            <?=
                            $this->Html->link(
                                    $this->Html->image($this->Layout->resizeImage($product->image), ['class' => 'img-responsive']), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'products', 'slug' => $product->slug], ['escape' => false, 'class' => 'container_item']
                            );
                            ?>
                            <div class="hbw">
                                <span class="hoverBorderWrapper"></span>
                            </div>
                        </li>
                        <li class="row-right parent-fly animMix">
                            <div class="product-content-left">
                                <?=
                                $this->Html->link(
                                        $this->Text->tail($product->name, 20, ['ellipsis' => '...', 'exact' => false]), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'products', 'slug' => $product->slug], ['class' => 'title-' . $product->id, 'title' => $product->name]
                                );
                                ?>
                            </div>
                            <div class="product-content-right">
                                <div class="product-price">
                                    <span class="price_sale"><?= $this->Layout->formatCurrency($product->Price_meta); ?></span>
                                </div>
                            </div>
                            <div class="list-mode-description"><?= $product->excerpt; ?></div>          
                            <div class="hover-appear">
                                <?php
                                echo $this->Form->create();
                                echo $this->Form->input('product_id', ['type' => 'hidden', 'value' => $product->id]);
                                echo $this->Form->input('product_name', ['type' => 'hidden', 'value' => $product->name]);
                                echo $this->Form->input('quantity', ['type' => 'hidden', 'value' => 1]);
                                ?>
                                <div class="effect-ajax-cart">
                                    <?= $this->Form->button('<i class="fa fa-shopping-cart"></i><span class="list-mode">' . __d('ittvn', 'Add to Cart') . '</span>', ['type' => 'submit', 'class' => 'add-to-cart']); ?>
                                </div>
                                <?php echo $this->Form->end(); ?>
                                <div class="product-ajax-qs hidden-xs hidden-sm">
                                    <?= $this->Html->link('<i class="fa fa-eye" title="' . __d('ittvn', 'Quick View') . '"></i><span class="list-mode">' . __d('ittvn', 'Quick View') . '</span>', ['plugin' => 'Products', 'controller' => 'Products', 'action' => 'viewAjax', 'slug' => $product->slug], ['escape' => false, 'class' => 'quick_shop', 'data-toggle' => 'modal', 'data-target' => '#modal_ajax']); ?>
                                </div>
                                <a class="wish-list" href="./account.html" title="wish list"><i class="fa fa-heart"></i><span class="list-mode">Add to Wishlist</span></a>
                            </div>                                                                    
                        </li>
                    </ul>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>	
</div>