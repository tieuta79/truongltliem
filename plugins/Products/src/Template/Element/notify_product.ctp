<div class="row">
    <div class="col-md-8">
        <?=
        $this->Html->link(
                $this->Html->image($product->image, ['alt' => $product->name]), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'products', 'slug' => $product->slug], ['escape' => false]
        );
        ?>
    </div>
    <div class="col-md-16">
        <div class="jGrowl-note">
            <?= sprintf(__d('ittvn', 'Product Added To %s'), $this->Html->link(__d('ittvn', 'Shopping Cart'), [], ['class' => 'your_cart'])); ?>
        </div>
        <?=
        $this->Html->link(
                $product->name, ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'products', 'slug' => $product->slug], ['class' => 'jGrowl-title']
        );
        ?>
    </div>
</div>