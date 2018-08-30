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
        <title><?= $home==false?$this->fetch('title').' | ':'' ?><?= Configure::read('Settings.Sites.title'); ?></title>
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
            'main',
            'itform'
                ], ['block' => 'scriptBottom']
        );
        
        ?>
        <?= $this->fetch('meta'); ?>
        <?= $this->fetch('css'); ?>                
        <?= $this->fetch('script'); ?>
    </head>

    <body>
        <div class="container">
        <?php if ($this->fetch('header')): ?>
            <?= $this->fetch('header'); ?>
        <?php else: ?>
            <?= $this->element('header'); ?>
        <?php endif; ?>


        <div id="content">
            <div class="row no-gutters">
                <?php if ($this->fetch('left')): ?>
                    <?= $this->fetch('left'); ?>
                <?php else: ?>
                    <?= $this->element('left'); ?>
                <?php endif; ?>
                <?= $this->fetch('content'); ?>
                <?php if ($this->fetch('right')): ?>
                    <?= $this->fetch('right'); ?>
                <?php else: ?>
                    <?= $this->element('right'); ?>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($this->fetch('footer')): ?>
            <?= $this->fetch('footer'); ?>
        <?php else: ?> 
            <?= $this->element('footer'); ?>
        <?php endif; ?>

        <?= $this->fetch('scriptBottom'); ?>
        <?= $this->fetch('scriptArea'); ?>
        </div>
    </body>
</html>
