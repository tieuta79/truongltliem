<div class="home-popular-collections">
    <div class="container">
        <div class="group_home_collections row">
            <div class="col-md-24">                                    
                <div class="home_collections">
                    <h6 class="general-title"><?= isset($data['title'])?$data['title']:'' ?></h6>
                    <div class="home_collections_wrapper">												
                        <div id="home_collections">
                            <?php if ($products->count()): ?>
                                <?php foreach ($products as $product): ?>
                                    <div class="home_collections_item">
                                        <div class="home_collections_item_inner">
                                            <div class="collection-details">
                                                <?=
                                                $this->Html->link(
                                                        $this->Html->image($this->Layout->resizeImage($product->image)), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'products', 'slug' => $product->slug], ['escape' => false]
                                                );
                                                ?>
                                            </div>
                                            <div class="hover-overlay">
                                                <span class="col-name">
                                                    <?=
                                                    $this->Html->link(
                                                            $product->name, ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'products', 'slug' => $product->slug]
                                                    );
                                                    ?>                                                                    
                                                </span>
                                                <div class="collection-action">
                                                    <?=
                                                    $this->Html->link(__d('ittvn', 'Xem thêm'), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'products', 'slug' => $product->slug]);
                                                    ?>                                                                           
                                                    <a href="#"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>													
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function () {
                    $('.collection-details').hover(
                            function () {
                                $(this).parent().addClass("collection-hovered");
                            },
                            function () {
                                $(this).parent().removeClass("collection-hovered");
                            });
                });
            </script>
        </div>
    </div>
</div>