<?php

use Cake\Core\Configure;
use Ittvn\Utility\System;

$system = new System();

$home = false;
if ($this->request->action == 'display' && $this->request->pass[0] == 'home') {
    $home = true;
}
?>
<!DOCTYPE html>
<html>
    <head>
<?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <title><?= $home == false ? $this->fetch('title') . ' | ' : '' ?><?= Configure::read('Settings.Sites.title'); ?></title>
        <?= $this->Html->meta('icon') ?>
        <?php
        $this->Html->css([
            'bootstrap.min', //bootstrap Styles
            'font-awesome.min',
            '//fonts.googleapis.com/css?family=Pacifico|Roboto',
            'responsive', //responsive
            'owl.carousel.min',
            'owl.theme.default.min',
            'sweetalert',
            'twitter',
            'bootstrap-datepicker.min',
            'style'
                ], ['block' => true]
        );

        $this->Layout->js();

        $this->Html->script([
            'jquery-2.1.3.min',
            'tether.min',
            'bootstrap.min',
            'bootstrap-datepicker.min'
                ], ['block' => true]
        );

        $this->Html->script([
            'owl.carousel.min',
            'sweetalert.min',
            'jquery.slimscroll.min',
            'scripts',
            'itvalidate',
            'itform'
                ], ['block' => 'scriptBottom']
        );
        ?>
        <?= $this->fetch('meta'); ?>
        <?= $this->fetch('css'); ?>                
        <?= $this->fetch('script'); ?>
    </head>

    <body class="">
        <?php if ($this->fetch('header')): ?>
            <?= $this->fetch('header'); ?>
        <?php else: ?>
            <?= $this->element('header'); ?>
        <?php endif; ?>

        <?php if ($home == true): ?>
            <div class="container-fluid" id="slideshow">
                <div class="row">
                    <?php
                    echo $system->getModule('home-page');
                    ?>
                </div>
                <div class="row bg-blue">
                    <div class="container news_feed">
                        <p><i class="fa fa-hand-o-right" aria-hidden="true"></i> Miễn phí hoàn toàn website trường học 1 năm cho 10 khách hàng đầu tiên. <a class="btn btn-xs btn-success pull-right" href="#"><i class="fa fa-info-circle" aria-hidden="true"></i> Xem thêm</a></p>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <div class="container-fluid bg-faded mb-3" id="breadcrumb">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $this->Html->getCrumbList(['firstClass' => 'breadcrumb-item', 'lastClass' => 'breadcrumb-item active', 'class' => 'breadcrumb', 'escape' => false], '<i class="fa fa-home"></i> ' . __d('ittvn', 'Home')); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="container mb-3" id="content">
            <?php if ($home == true || $this->fetch('full-width')): ?>
                <div id="left" class="col-xs-12 col-md-12">
                    <?= $this->fetch('content'); ?>
                </div>
            <?php else: ?>
                <div id="left" class="col-xs-12 col-md-3 pb-2">
                    <?php if ($this->fetch('left')): ?>
                        <?= $this->fetch('left'); ?>
                    <?php else: ?>
                        <?= $this->element('left'); ?>
                    <?php endif; ?>
                </div>
                <div id="right" class="col-xs-12 col-md-9">
                    <?= $this->fetch('content'); ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($this->fetch('footer')): ?>
            <?= $this->fetch('footer'); ?>
        <?php else: ?>
            <?= $this->element('footer'); ?>
        <?php endif; ?>

        <?= $this->element('modal_ajax'); ?>

        <?= $this->fetch('scriptBottom'); ?>
        <?= $this->fetch('scriptArea'); ?>
    </body>
</html>
