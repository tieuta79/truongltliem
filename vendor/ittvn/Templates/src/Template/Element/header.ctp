<?php

use Cake\I18n\Time;
use Cake\Core\Configure;
use Ittvn\Utility\Network;
?>
<!-- HEADER -->
<header id="header">
    <div id="logo-group">

        <!-- PLACE YOUR LOGO HERE -->
        <span id="logo"> 
            <?php
            $network = Network::checkScopeByUrl($this->request->here);
            if ($network == false) {
                $network = '/';
            }
            echo $this->Html->link(
                    $this->Html->image('logo.png', ['width' => 200]), $network, ['escape' => false]
            );
            ?>
        </span>
    </div>
</header>
<!-- END HEADER -->