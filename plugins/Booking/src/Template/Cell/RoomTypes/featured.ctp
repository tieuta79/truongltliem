<?php

use Cake\Routing\Router;
?>
<div class="main_title">
    <h2><?= isset($data['title']) ? $data['title'] : '' ?></h2>
    <p><?= isset($data['description']) ? $data['description'] : '' ?></p>
</div>
<?php if ($roomtypes->count()): ?>
    <div class="row">
        <?php foreach ($roomtypes as $k => $roomtype): ?>
            <div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.<?= $k + 1; ?>s">
                <div class="hotel_container">
                    <div class="img_container">
                        <a href="<?= Router::url(['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'roomtypes', 'slug' => $roomtype->slug]); ?>">
                            <?= $this->Html->image($this->Layout->resizeImage($roomtype->image), ['width' => 800, 'height' => 533, 'class' => 'img-responsive']); ?>
                            <div class="ribbon top_rated"></div>
                            <div class="score"><span>7.5</span>Good</div>
                            <div class="short_info hotel">
                                From/Per night<span class="price"><?= $this->Layout->formatCurrency($roomtype->Price_meta); ?></span>
                            </div>
                        </a>
                    </div>
                    <div class="hotel_title">
                        <h3><?= $roomtype->name; ?></h3>
                        <div class="rating">
                            <i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star-empty"></i>
                        </div><!-- end rating -->
                        <div class="wishlist">
                            <a class="tooltip_flip tooltip-effect-1" href="#">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                        </div><!-- End wish list-->
                    </div>
                </div><!-- End box -->
            </div><!-- End col-md-4 -->
        <?php endforeach; ?>
    </div><!-- End row -->
    <p class="text-center nopadding">
        <?= $this->Html->link(sprintf(__d('ittvn', '%s View all Room Types'), '<i class="icon-eye-7"></i>'), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'index', 'type' => 'roomtypes'], ['escape' => false, 'class' => 'btn_1 medium']); ?>
    </p>
<?php endif; ?>