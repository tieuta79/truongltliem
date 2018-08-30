<?php

use Ittvn\Utility\System;
use Cake\Routing\Router;
$system = new System();
?>
<div class="sidebar-center">
    <ul>
        <?= $system->getModule('right'); ?>
		<!--
        <li>
            <div id="homecategory-4" class="widget widget_homecategory">
                <div class="widget-title">
                    <h4><span><i class="icon-th-list"></i> Thư viện ảnh</span></h4>
                    <div class="side-right-line"></div>
                </div>
                <div id="slider_image_container" style="position:relative;margin:0 auto;width:250px;height:250px;left:0px;top:0px;">

                    
                    <div u="loading" style="position:absolute;top:0px;left:0px;">
                        <div style="filter:alpha(opacity=70);opacity:0.7;position:absolute;display:block;background-color:#000000;top:0px;left:0px;width:100%;height:100%;">
                        </div>
                        <div style="position:absolute;display:block;background:url(/school/img/loading.gif) no-repeat center center;top:0px;left:0px;width:100%;height:100%;">
                        </div>
                    </div>

                    
                    <div u="slides" style="cursor:move;position:absolute;left:0px;top:0px;width:250px;height:250px;overflow:hidden;">
                        <div>
                            <?=
                            $this->Html->link(
                                    $this->Html->image('slide/slide3.jpg', ['class' => 'img-responsive']), Router::url('/school/img/slide/slide3.jpg'), ['escape' => false, 'class' => 'fancybox']
                            );
                            ?>
                        </div>
                        <div>
                            <?=
                            $this->Html->link(
                                    $this->Html->image('slide/slide4.jpg', ['class' => 'img-responsive']), Router::url('/school/img/slide/slide4.jpg'), ['escape' => false, 'class' => 'fancybox']
                            );
                            ?>
                        </div>
                    </div>
                </div>
                <div class="clear"> </div>
            </div>
        </li>
		-->
        <li>
            <div id="wp_ittvn_traffic-2" class="widget widget_wp_ittvn_traffic">
                <div class="widget-title">
                    <h4><span><i class="icon-th-list"></i> Số lượt truy cập</span></h4>
                    <div class="side-right-line"></div>
                </div>
                <link rel='stylesheet' type='text/css' href='http://c1pson-nt.khanhhoa.edu.vn/wp-content/plugins/ittvn_visit_counter/styles/css/default.css' />
                <ul id='mvcwid' style='font-size:2; text-align:;color:;'>
                    <li class="counter" style="list-style-image: none!important;margin-left: 0!important;margin-top: -18px;"><img src="http://c1pson-nt.khanhhoa.edu.vn/wp-content/plugins/ittvn_visit_counter/styles/image/glass/0.gif" alt="0" /><img src="http://c1pson-nt.khanhhoa.edu.vn/wp-content/plugins/ittvn_visit_counter/styles/image/glass/0.gif" alt="1" /><img src="http://c1pson-nt.khanhhoa.edu.vn/wp-content/plugins/ittvn_visit_counter/styles/image/glass/3.gif" alt="2" /><img src="http://c1pson-nt.khanhhoa.edu.vn/wp-content/plugins/ittvn_visit_counter/styles/image/glass/3.gif" alt="3" /><img src="http://c1pson-nt.khanhhoa.edu.vn/wp-content/plugins/ittvn_visit_counter/styles/image/glass/5.gif" alt="4" /><img src="http://c1pson-nt.khanhhoa.edu.vn/wp-content/plugins/ittvn_visit_counter/styles/image/glass/3.gif" alt="5" /></li>
                    <li><img src='http://c1pson-nt.khanhhoa.edu.vn/wp-content/plugins/ittvn_visit_counter/counter/mvcvisit.png'> Hôm nay : 4</li>
                    <li><img src='http://c1pson-nt.khanhhoa.edu.vn/wp-content/plugins/ittvn_visit_counter/counter/mvcyesterday.png'> Hôm qua : 14</li>
                    <li><img src='http://c1pson-nt.khanhhoa.edu.vn/wp-content/plugins/ittvn_visit_counter/counter/mvconline.png'> Trực tuyến : 1</li>
                    <li><img src='http://c1pson-nt.khanhhoa.edu.vn/wp-content/plugins/ittvn_visit_counter/counter/mvctotal.png'> Tổng số người : 3353</li>
                </ul>
                <div class="clear"> </div>
            </div>
        </li>
    </ul>
</div> 
