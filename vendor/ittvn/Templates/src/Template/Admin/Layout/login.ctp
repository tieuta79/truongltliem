<!DOCTYPE html>
<html id="extr-page">
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title><?= $this->fetch('title') ?> | <?= \Cake\Core\Configure::read('Settings.Sites.title'); ?></title>
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
                ], ['block' => true]);

        $this->Html->script([
            'jquery-3.0.0.min',
            'jquery-ui.min',
            'bootstrap/bootstrap.min'
                ], ['block' => true]
        );

        $this->Html->script([
            'plugin/pace/pace.min',
            'app.config',
            'plugin/jquery-validate/jquery.validate.min',
            'plugin/masked-input/jquery.maskedinput.min',
            'app.min',
            'login'
                ], ['block' => 'scriptBottom']);
        ?>
        <?= $this->fetch('meta'); ?>
        <?= $this->fetch('css'); ?>    
        <?= $this->fetch('script'); ?>
    </head>

    <body class="animated fadeInDown">
        <?= $this->element('header-login'); ?>
        <!-- MAIN PANEL -->
        <div id="main" role="main">			
            <div id="content" class="container">
                <?= $this->fetch('content'); ?>
            </div>
        </div>	

        <?= $this->element('footer'); ?>
        <?= $this->fetch('scriptBottom'); ?>
    </body>
</html>