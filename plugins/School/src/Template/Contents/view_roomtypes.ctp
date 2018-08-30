<?php
$this->assign('title', $content->name);

use Settings\Utility\Setting;

$setting = new Setting();
$this->Html->addCrumb(__d('ittvn', 'Room Types'), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'index', 'type' => 'roomtypes']);
$this->Html->addCrumb($content->name);

$this->Html->css([
    'slider-pro.min',
    'date_time_picker',
    'owl.carousel',
    'owl.theme'
        ], ['block' => true]);
$this->Html->script([
    'jquery.sliderPro.min',
    'bootstrap-datepicker',
    '//maps.googleapis.com/maps/api/js',
    'map',
    'infobox',
    'owl.carousel.min',
    'validate'
        ], ['block' => 'scriptBottom']);
//pr($content->toArray());die();
?>



<section class="parallax-window" data-parallax="scroll" data-image-src="<?= $this->Url->webroot('/img/single_hotel_bg_1.jpg'); ?>" data-natural-width="1400" data-natural-height="470">
    <div class="parallax-content-2">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-8">
                    <span class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class=" icon-star-empty"></i></span>
                    <h1><?= $content->name; ?></h1>
                    <span><?= $content->excerpt ?></span>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div id="price_single_main" class="hotel">
                        from/per night <span><?= $this->Layout->formatCurrency($content->Price_meta); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- End section -->

<?= $this->element('crumblist'); ?>


<div class="collapse" id="collapseMap">
    <div id="map" class="map"></div>
</div><!-- End Map -->

<div class="container margin_60">
    <div class="row">
        <div class="col-md-8" id="single_tour_desc">
            <?= $this->cell('Booking.RoomTypes::categories', [$content->categories]); ?>
            <p class="visible-sm visible-xs"><a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap">View on map</a></p><!-- Map button for tablets/mobiles -->
            <?= $this->cell('Booking.RoomTypes::medias', [$content->Galleries_meta]); ?>
            <hr>
            <div class="row">
                <div class="col-md-3">
                    <h3>Description</h3>
                </div>
                <div class="col-md-9">
                    <?= $content->description; ?>
                </div><!-- End col-md-9  -->
            </div><!-- End row  -->

            <hr>

            <div class="row">
                <div class="col-md-3">
                    <h3>Reviews</h3>
                    <a href="#" class="btn_1 add_bottom_30" data-toggle="modal" data-target="#myReview">Leave a review</a>
                </div>
                <div class="col-md-9">
                    <div id="score_detail"><span>7.5</span>Good <small>(Based on 34 reviews)</small></div><!-- End general_rating -->
                    <div class="row" id="rating_summary">
                        <div class="col-md-6">
                            <ul>
                                <li>Position
                                    <div class="rating">
                                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><i class="icon-smile"></i>
                                    </div>
                                </li>
                                <li>Comfort
                                    <div class="rating">
                                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul>
                                <li>Price
                                    <div class="rating">
                                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><i class="icon-smile"></i>
                                    </div>
                                </li>
                                <li>Quality
                                    <div class="rating">
                                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div><!-- End row -->
                    <hr>
                    <div class="review_strip_single">
                        <img src="<?= $this->Url->webroot('/img/avatar1.jpg'); ?>" alt="Image" class="img-circle">
                        <small> - 10 March 2015 -</small>
                        <h4>Jhon Doe</h4>
                        <p>
                            "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a lorem quis neque interdum consequat ut sed sem. Duis quis tempor nunc. Interdum et malesuada fames ac ante ipsum primis in faucibus."
                        </p>
                        <div class="rating">
                            <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><i class="icon-smile"></i>
                        </div>
                    </div><!-- End review strip -->

                    <div class="review_strip_single">
                        <img src="<?= $this->Url->webroot('/img/avatar2.jpg'); ?>" alt="Image" class="img-circle">
                        <small> - 10 March 2015 -</small>
                        <h4>Jhon Doe</h4>
                        <p>
                            "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a lorem quis neque interdum consequat ut sed sem. Duis quis tempor nunc. Interdum et malesuada fames ac ante ipsum primis in faucibus."
                        </p>
                        <div class="rating">
                            <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><i class="icon-smile"></i>
                        </div>
                    </div><!-- End review strip -->

                    <div class="review_strip_single last">
                        <img src="<?= $this->Url->webroot('/img/avatar3.jpg'); ?>" alt="Image" class="img-circle">
                        <small> - 10 March 2015 -</small>
                        <h4>Jhon Doe</h4>
                        <p>
                            "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a lorem quis neque interdum consequat ut sed sem. Duis quis tempor nunc. Interdum et malesuada fames ac ante ipsum primis in faucibus."
                        </p>
                        <div class="rating">
                            <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><i class="icon-smile"></i>
                        </div>
                    </div><!-- End review strip -->
                </div>
            </div>
        </div><!--End  single_tour_desc-->

        <aside class="col-md-4">
            <p class="hidden-sm hidden-xs">
                <a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap">View on map</a>
            </p>
            
            <?= $this->cell('Booking.RoomTypes::check',[$content->id]); ?>

            <div class="box_style_4">
                <i class="icon_set_1_icon-90"></i>
                <h4><span>Book</span> by phone</h4>
                <a href="tel://004542344599" class="phone">+45 423 445 99</a>
                <small>Monday to Friday 9.00am - 7.30pm</small>
            </div>

        </aside>
    </div><!--End row -->
</div><!--End container -->