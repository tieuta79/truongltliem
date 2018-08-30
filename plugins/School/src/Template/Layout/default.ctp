<?php

use Settings\Utility\Setting;

$setting = new Setting();
$intro = false;
$home = false;
if ($this->request->action == 'display' && $this->request->pass[0] == 'home') {
    $home = true;
}
$favicon = $setting->getThemeOption('favicon');
?>
<!DOCTYPE html>
<html class="no-js">
    <head>
        <?= $this->Html->charset(); ?>    
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>
            <?php if (!$home): ?>
                <?= $this->fetch('title'); ?> | 
            <?php endif; ?>
            <?= $setting->getOption('Sites.title'); ?>
        </title>
        <?= !empty($favicon)?$this->Html->meta('icon',$setting->getThemeOption('favicon')):''; ?>
        <?php
        $this->Html->css([
			'//fonts.googleapis.com/css?family=Baloo+Bhaina',
            'style',
            'font-awesome',
            'responsive',
            'fancybox/jquery.fancybox-buttons',
            'fancybox/jquery.fancybox-thumbs',
            'fancybox/jquery.fancybox'
                ], ['block' => true]);

        $this->Layout->js();
        $this->Html->script([
            'jquery',
            'jquery-migrate.min',
            'jquery-ui-custom.min'
                ], ['block' => true]);

        $this->Html->script([
            'superfish',
            'osmplayer.magic',
            'hoverIntent',
            'jquery.eislideshow',
            'jquery.flexslider',
            'jquery.carofred',
            'jquery.easing.1.3',
            'tabs',
            'tinynav.min',
            'magneo',
            'jquery.newsTicker',
            'jssor.slider.mini',
            'jquery-custom-slide',
            'fancybox/jquery.fancybox',
            'fancybox/jquery.fancybox-buttons',
            'fancybox/jquery.fancybox-thumbs',
            'fancybox/jquery.mousewheel-3.0.6.pack',
            'script'
                ], ['block' => 'scriptBottom']);
        ?>

        <?= $this->fetch('meta'); ?>
        <?= $this->fetch('css'); ?>    
        <?= $this->fetch('script'); ?>
        <style type="text/css">
            <?= $setting->getThemeOption('css'); ?>
        </style>
    </head>
    <body class="custom-background">
        <?= $this->element('header'); ?>
        <div id="wrapper">  
            <?php
            if ($this->fetch('left')) {
                echo $this->fetch('left');
            } else {
                echo $this->element('left');
            }
            ?>
            <div id="content">
                <?php if ($home == false): ?>
                    <div id="bcs">
                        <?= $this->Html->getCrumbList(['escape' => false, 'separator' => ' » '], ['text' => __d('ittvn', 'Home'), 'class' => 'homeicon']); ?>
                    </div>
                <?php endif; ?>
                <?= $this->fetch('content'); ?>   
            </div>     
            <?php
            if ($this->fetch('right')) {
                echo $this->fetch('right');
            } else {
                echo $this->element('right');
            }
            ?>
            <div class="clear"></div> 
        </div>
        <?= $this->element('footer'); ?>
        <?= $this->fetch('scriptBottom'); ?>        
    </body>
</html>
