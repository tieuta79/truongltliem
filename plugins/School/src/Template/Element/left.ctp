<?php

use Ittvn\Utility\System;
use Cake\Routing\Router;

$system = new System();
?>
<div class="sideboxes-left">
    <ul>
        <?= $system->getModule('left'); ?>
    </ul>
</div> 
