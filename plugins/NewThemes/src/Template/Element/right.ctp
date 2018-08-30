<?php

use Cake\I18n\Time;
use Cake\Core\Configure;
use Settings\Utility\Setting;
use Ittvn\Utility\System;

$system = new System();
$setting = new Setting();
?>
<div class="col-lg-3">
     <?php echo $system->getModule('right'); ?>    

    <div class="card card-outline-info mb-2">
        <div class="card-header bg-light-blue text-center bg-red-menu">
            »   Thống kê truy cập «
        </div>
        <div class="card-body text-center">
        	<?= $this->Html->image($setting->getThemeOption('img_default'), ['width' => 100]); ?>
            <p class="card-text">Đang online : <font color="#FF0000">11</font> người </p>
            <p class="card-text">Tổng truy cập : <font color="#FF0000">32858</font> lượt</p>
        </div>
    </div>

</div>