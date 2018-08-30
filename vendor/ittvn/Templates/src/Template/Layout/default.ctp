<?php

use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title><?= $this->fetch('title') ?> | <?= Configure::read('Settings.Sites.title'); ?></title>
        <?= $this->Html->meta('icon') ?>
        <?php
        $this->Html->css([
            'bootstrap.min', //Basic Styles
            'font-awesome.min',
            'smartadmin-production-plugins.min', //SmartAdmin Styles
            'smartadmin-production.min',
            'smartadmin-skins.min',
            'smartadmin-rtl.min', //SmartAdmin RTL Support
            'demo.min', //Demo purpose only,
            '//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700',
            'ittvn'
                ], ['block' => true]
        );

        $this->Layout->js();

        $this->Html->script([
            'libs/jquery-2.1.1.min',
            'libs/jquery-ui-1.10.3.min',
            'bootstrap/bootstrap.min'
                ], ['block' => true]
        );

        $this->Html->script([
            'plugin/pace/pace.min',
            'app.config',
            'app.min',
            'plugin/jquery-touch/jquery.ui.touch-punch.min',
            'notification/SmartNotification.min',
            'smartwidgets/jarvis.widget.min',
            'plugin/easy-pie-chart/jquery.easy-pie-chart.min',
            'plugin/sparkline/jquery.sparkline.min',
            'plugin/easy-pie-chart/jquery.easy-pie-chart.min',
            'plugin/jquery-validate/jquery.validate.min',
            'plugin/masked-input/jquery.maskedinput.min',
            'plugin/select2/select2.min',
            'plugin/bootstrap-slider/bootstrap-slider.min',
            'plugin/msie-fix/jquery.mb.browser.min',
            'plugin/fastclick/fastclick.min',
            'jquery.slimscroll.min',
            //'demo.min',            
            'speech/voicecommand.min',
            'plugin/moment/moment.min',
            'plugin/fullcalendar/jquery.fullcalendar.min',
            'plugin/bootstrap-timepicker/bootstrap-timepicker.min',
            'smart-chat-ui/smart.chat.ui.min',
            'smart-chat-ui/smart.chat.manager.min',
            'plugin/flot/jquery.flot.cust.min',
            'plugin/flot/jquery.flot.resize.min',
            'plugin/flot/jquery.flot.fillbetween.min',
            'plugin/flot/jquery.flot.orderBar.min',
            'plugin/flot/jquery.flot.pie.min',
            'plugin/flot/jquery.flot.time.min',
            'plugin/flot/jquery.flot.tooltip.min',
            'jquery.upload'
                ], ['block' => 'scriptBottom']
        );

        $this->Html->script([
            'script',
            'ittvn'
                ], ['block' => 'scriptArea']
        );
        ?>
        <?= $this->fetch('meta'); ?>
        <?= $this->fetch('css'); ?>                
        <?= $this->fetch('script'); ?>
    </head>

    <body data-smart-device-detect
          data-smart-fast-click
          data-smart-layout
          data-smart-page-title="SmartAdmin AngularJS" class="menu-on-top smart-style-6">
              <?php if ($this->fetch('header')): ?>
                  <?= $this->fetch('header'); ?>
              <?php else: ?>
                  <?= $this->element('header'); ?>
              <?php endif; ?>
        <!-- MAIN PANEL -->
        <div id="main" role="main">
            <!-- RIBBON -->
            <div id="slideshow">
                <?= $this->cell('Medias.Slideshow::show',['params'=>['slide'=>'slideshow'],'form'=>false]); ?>
            </div>
            <!-- END RIBBON -->

            <!-- MAIN CONTENT -->
            <div id="content">
                <section id="widget-grid" class="">
                    <div class="row">
                        <article class="col-xs-12 col-md-12">
                            <?= $this->fetch('content'); ?>
                        </article>
                    </div>                    
                </section>
            </div>
        </div>	
        <?php if ($this->fetch('footer')): ?>
            <?= $this->fetch('footer'); ?>
        <?php else: ?>
            <?= $this->element('footer'); ?>
        <?php endif; ?>
        <div class="modal inmodal" id="modal_ajax" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content animated bounceInRight">

                </div>
            </div>
        </div>        
        <input type="file" id="input_by_upload_ajax" multiple="true" style="display: none" />
        <?php //$this->element('control-sidebar'); ?>
        <?= $this->fetch('scriptBottom'); ?>
        <?= $this->fetch('scriptArea'); ?>
    </body>
</html>
