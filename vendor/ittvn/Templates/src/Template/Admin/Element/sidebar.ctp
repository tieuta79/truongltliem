<?php

use Cake\Core\Configure; ?>
<!-- Left panel : Navigation area -->
<!-- Note: This width of the aside area can be adjusted through LESS variables -->
<aside id="left-panel">
    <!-- User info -->
    <div class="login-info">
        <span> <!-- User image size is adjusted inside CSS, it should stay as it --> 
            <a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
                <?= $this->Html->image(Configure::read('Settings.Users.avatar_default'), ['class' => 'online', 'width' => 48, 'alt' => $this->request->session()->read('Auth.User.full_name')]); ?> 
                <span><?= $this->request->session()->read('Auth.User.full_name'); ?></span>
                <i class="fa fa-angle-down"></i>
            </a> 
        </span>
    </div>
    <!-- end user info -->

    <!-- NAVIGATION : This navigation is also responsive-->
    <nav>
        <?=
        $this->Html->menusAdmin(Configure::read('Menus.Admin'), [
            'li' => [
                'hasChild' => [
                    'class' => ''
                ]
            ]
        ]);
        ?>
    </nav>


    <span class="minifyme" data-action="minifyMenu"> 
        <i class="fa fa-arrow-circle-left hit"></i> 
    </span>

</aside>
<!-- END NAVIGATION -->