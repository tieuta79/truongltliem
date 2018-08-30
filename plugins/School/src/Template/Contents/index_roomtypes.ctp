<?php
$this->assign('title', __d('ittvn', 'Room Types'));

use Settings\Utility\Setting;
use Cake\Routing\Router;

$setting = new Setting();
$this->Html->addCrumb(__d('ittvn', 'Room Types'));

$this->Html->css([
    'skins/square/grey',
    'ion.rangeSlider',
    'ion.rangeSlider.skinFlat'
        ], ['block' => true]);
$this->Html->script([
    '//maps.googleapis.com/maps/api/js',
    'map_hotels',
    'infobox'
        ], ['block' => 'scriptBottom']);
//pr($content->toArray());die();

$layout = $this->request->query;
if (count($layout) > 0) {
    if (in_array('layout', array_keys($layout))) {
        unset($layout['layout']);
    }
}
$url_grid = ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'index', 'type' => $this->request->type] + $layout;
$layout['layout'] = 'list';
$url_list = ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'index', 'type' => $this->request->type] + $layout;
?>

<section class="parallax-window" data-parallax="scroll" data-image-src="<?= $this->Url->webroot('/img/hotels_bg.jpg'); ?>" data-natural-width="1400" data-natural-height="470">
    <div class="parallax-content-1">
        <div class="animated fadeInDown">
            <h1><?= __d('ittvn', 'Room Types'); ?></h1>
            <span><?= sprintf(__d('ittvn', 'Lias all %s'), __d('ittvn', 'Room Types')); ?></span>
        </div>
    </div>
</section>

<?= $this->element('crumblist'); ?>


<div class="collapse" id="collapseMap">
    <div id="map" class="map"></div>
</div><!-- End Map -->


<div class="container margin_60">
    <div class="row">
        <aside class="col-lg-3 col-md-3">
            <p>
                <a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap">View on map</a>
            </p>

            <div id="filters_col">
                <a data-toggle="collapse" href="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters" id="filters_col_bt"><i class="icon_set_1_icon-65"></i>Filters <i class="icon-plus-1 pull-right"></i></a>
                <div class="collapse in" id="collapseFilters">
                    <div class="filter_type">
                        <h6>Price</h6>
                        <input type="text" id="range" name="range" value="">
                    </div>
                    <div class="filter_type">
                        <h6>Star Category</h6>
                        <ul>
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <span class="rating">
                                        <i class="icon_set_1_icon-81 voted"></i><i class="icon_set_1_icon-81 voted"></i><i class="icon_set_1_icon-81 voted"></i><i class="icon_set_1_icon-81 voted"></i><i class="icon_set_1_icon-81 voted"></i>
                                    </span>(15)
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox"><span class="rating">
                                        <i class="icon_set_1_icon-81 voted"></i><i class="icon_set_1_icon-81 voted"></i><i class="icon_set_1_icon-81 voted"></i><i class="icon_set_1_icon-81 voted"></i><i class="icon_set_1_icon-81"></i>
                                    </span>(45)
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <span class="rating">
                                        <i class="icon_set_1_icon-81 voted"></i><i class="icon_set_1_icon-81 voted"></i><i class="icon_set_1_icon-81 voted"></i><i class="icon_set_1_icon-81"></i><i class="icon_set_1_icon-81"></i>
                                    </span>(35)
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <span class="rating">
                                        <i class="icon_set_1_icon-81 voted"></i><i class="icon_set_1_icon-81 voted"></i><i class="icon_set_1_icon-81"></i><i class="icon_set_1_icon-81"></i><i class="icon_set_1_icon-81"></i>
                                    </span>(25)
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox">
                                    <span class="rating">
                                        <i class="icon_set_1_icon-81 voted"></i><i class="icon_set_1_icon-81"></i><i class="icon_set_1_icon-81"></i><i class="icon_set_1_icon-81"></i><i class="icon_set_1_icon-81"></i>
                                    </span>(15)
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="filter_type">
                        <h6>Review Score</h6>
                        <ul>
                            <li><label><input type="checkbox">Superb: 9+ (77)</label></li>
                            <li><label><input type="checkbox">Very good: 8+ (552)</label></li>
                            <li><label><input type="checkbox">Good: 7+ (909)</label></li>
                            <li><label><input type="checkbox">Pleasant: 6+ (1196)</label></li>
                            <li><label><input type="checkbox">No rating (198)</label></li>
                        </ul>
                    </div>
                    <div class="filter_type">
                        <h6>Facility</h6>
                        <ul>
                            <li><label><input type="checkbox">Pet allowed</label></li>
                            <li><label><input type="checkbox">Wifi</label></li>
                            <li><label><input type="checkbox">Spa</label></li>
                            <li><label><input type="checkbox">Restaurant</label></li>
                            <li><label><input type="checkbox">Pool</label></li>
                            <li><label><input type="checkbox">Parking</label></li>
                            <li><label><input type="checkbox">Fitness center</label></li>
                        </ul>
                    </div>
                    <div class="filter_type">
                        <h6>District</h6>
                        <ul>
                            <li><label><input type="checkbox">Paris Centre</label></li>
                            <li><label><input type="checkbox">La Defance</label></li>
                            <li><label><input type="checkbox">La Marais</label></li>
                            <li><label><input type="checkbox">Latin Quarter</label></li>
                        </ul>
                    </div>
                </div><!--End collapse -->
            </div><!--End filters col-->
            <div class="box_style_2">
                <i class="icon_set_1_icon-57"></i>
                <h4>Need <span>Help?</span></h4>
                <a href="tel://004542344599" class="phone">+45 423 445 99</a>
                <small>Monday to Friday 9.00am - 7.30pm</small>
            </div>
        </aside><!--End aside -->

        <div class="col-lg-9 col-md-8">

            <div id="tools">
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="styled-select-filters">
                            <select name="sort_price" id="sort_price">
                                <option value="" selected>Sort by price</option>
                                <option value="lower">Lowest price</option>
                                <option value="higher">Highest price</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="styled-select-filters">
                            <select name="sort_rating" id="sort_rating">
                                <option value="" selected>Sort by ranking</option>
                                <option value="lower">Lowest ranking</option>
                                <option value="higher">Highest ranking</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 hidden-xs text-right">
                        <?= $this->Html->link('<i class=" icon-list"></i>', $url_grid, ['escape' => false, 'class' => 'bt_filters']); ?>
                        <?= $this->Html->link('<i class=" icon-list"></i>', $url_list, ['escape' => false, 'class' => 'bt_filters']); ?>
                    </div>
                </div>
            </div><!--End tools -->

            <?php if ($contents->count() > 0): ?>
                <div class="row">
                    <?php foreach ($contents as $k => $roomtype): ?>
                        <div class="col-md-6 col-sm-6 wow zoomIn" data-wow-delay="0.<?= $k + 1; ?>s">
                            <div class="hotel_container">
                                <div class="img_container">
                                    <a href="<?= Router::url(['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'roomtypes', 'slug' => $roomtype->slug]); ?>">
                                        <?= $this->Html->image($this->Layout->resizeImage($roomtype->image), ['width' => 800, 'height' => 533, 'class' => 'img-responsive']); ?>
                                        <div class="ribbon top_rated"></div>
                                        <div class="score"><span>8.0</span>Good</div>
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
                        </div><!-- End col-md-6 -->
                    <?php endforeach; ?>
                </div><!-- End row -->
            <?php endif; ?>
            <hr />

            <div class="text-center">
                <?= $this->element('paging', ['url' => ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'index', 'type' => $this->request->type]]); ?>
            </div><!-- end pagination-->

        </div><!-- End col lg 9 -->
    </div><!-- End row -->
</div><!-- End container -->