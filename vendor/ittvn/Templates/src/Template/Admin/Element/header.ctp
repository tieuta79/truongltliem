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
    <?php
    if (Configure::check('Network')):
        $p = Configure::read('Network.plugin');
        echo $this->cell($p . '.' . $p . '::display');
    endif;
    ?>
    <!-- pulled right: nav area -->
    <div class="pull-right">

        <!-- collapse menu button -->
        <div id="hide-menu" class="btn-header pull-right">
            <span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
        </div>
        <!-- end collapse menu -->

        <!-- #MOBILE -->
        <!-- Top menu profile link : this shows only when top menu is active -->
        <ul id="mobile-profile-img" class="header-dropdown-list hidden-xs padding-5">
            <li class="">
                <a href="#" class="dropdown-toggle no-margin userdropdown" data-toggle="dropdown"> 
                    <?= $this->Html->image(Configure::read('Settings.Users.avatar_default'), ['class' => 'online', 'width' => 48, 'alt' => $this->request->session()->read('Auth.User.full_name')]); ?>
                </a>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0"><i class="fa fa-cog"></i> Setting</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <?= $this->Html->link('<i class="fa fa-user"></i> ' . __d('ittvn', 'Profile'), ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'view', $this->request->session()->read('Auth.User.id')], ['class' => 'padding-10 padding-top-0 padding-bottom-0', 'escape' => false]); ?>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="toggleShortcut"><i class="fa fa-arrow-down"></i> <u>S</u>hortcut</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="launchFullscreen"><i class="fa fa-arrows-alt"></i> Full <u>S</u>creen</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <?php
                        if (Network::checkScopeByUrl($this->request->here()) == false) {
                            echo $this->Html->link('<i class="fa fa-sign-out fa-lg"></i> <strong>' . __d('ittvn', 'Logout') . '</strong>', '/admin/logout', ['escape' => false, 'class' => 'padding-10 padding-top-5 padding-bottom-5']);
                        } else {
                            echo $this->Html->link('<i class="fa fa-sign-out fa-lg"></i> <strong>' . __d('ittvn', 'Logout') . '</strong>', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'logout'], ['escape' => false, 'class' => 'padding-10 padding-top-5 padding-bottom-5']);
                        }
                        ?>
                    </li>
                </ul>
            </li>
        </ul>
        <?= $this->cell('Extensions.Languages')->render('admin'); ?>
    </div>
    <!-- end pulled right: nav area -->	
</header>
<!-- END HEADER -->