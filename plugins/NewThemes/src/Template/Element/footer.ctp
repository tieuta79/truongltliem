<?php
use Settings\Utility\Setting;
$setting = new Setting();

?>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 text-center">
                <span><?= $setting->getThemeOption('copyright'); ?></span><br>
                <span>DT: <?= $setting->getThemeOption('hotline'); ?> - Email: <?= $setting->getThemeOption('email'); ?> </span><br>
                <span> Chịu trách nhiệm: <?= $setting->getThemeOption('curator'); ?></span>
            </div>
        </div>
    </div>
</footer>
<style>
    body {background: <?= $setting->getThemeOption('bg_body'); ?>;}
    body .card-header {
        color: <?= $setting->getThemeOption('color_title'); ?>;
    }
    .bg-card-title {
        background: <?= $setting->getThemeOption('bg_card_title'); ?>;
    }
    body a {
        color: <?= $setting->getThemeOption('color_link'); ?>;
    }
    body a:hover{
        color: <?= $setting->getThemeOption('color_link_hover'); ?>;
    }
</style>