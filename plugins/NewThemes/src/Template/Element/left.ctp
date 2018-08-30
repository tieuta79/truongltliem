<?php

use Cake\I18n\Time;
use Cake\Core\Configure;
use Settings\Utility\Setting;
use Ittvn\Utility\System;

$system = new System();
$setting = new Setting();
?>
<div class="col-lg-3">
     <?php echo $system->getModule('left');?>
</div>