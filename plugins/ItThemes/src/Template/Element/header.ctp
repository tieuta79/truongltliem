<?php

use Cake\I18n\Time;
use Cake\Core\Configure;
use Settings\Utility\Setting;
use Ittvn\Utility\User;

$setting = new Setting();
?>
<header class="container-fluid" id="header">
    <div class="row header-top bg-faded clearfix">
        <div class="container">
            <div class="col-md-5 col-xs-12 text-lg-left text-xs-center">
                <p><?= sprintf(__d('ittvn', '<strong>Hotline: </strong> %s'), $setting->getThemeOption('hotline')); ?></p>
            </div>
            <div class="col-md-7 col-xs-9 offset-xs-2 offset-md-0">
                <ul class="nav navbar-nav float-lg-right mx-auto">
                    <?php if (User::checkLogin()): ?>
                        <?= $this->cell('ItThemes.Theme::logCount', [User::get('id')]); ?>
                        <li class="nav-item dropdown">
                            <?=
                            $this->Html->link('<i class="fa fa-user-circle text-red" aria-hidden="true"></i> ' . sprintf(__d('ittvn', '<span>Hello %s</span>'), $this->request->session()->read('Auth.Registered.full_name')), ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'view', 'role' => $this->request->session()->read('Auth.Registered.role.slug')], [
                                'data-toggle' => 'dropdown',
                                'aria-haspopup' => 'true',
                                'aria-expanded' => 'false',
                                'title' => sprintf(__d('ittvn', 'Hello %s'), $this->request->session()->read('Auth.Registered.full_name')),
                                'escape' => false,
                                'class' => 'nav-link dropdown-toggle'
                            ]);
                            ?>
                            <?php echo $this->cell('ItThemes.Theme::menuCustomer')->render('menu_customer_header');?>
                        </li>
                        <li class="nav-item">
                            <?=
                            $this->Html->link('<i class="fa fa-sign-out text-red" aria-hidden="true"></i> <span>' . __d('ittvn', 'Logout') . '</span>', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'logout', 'role' => $this->request->session()->read('Auth.Registered.role.slug')], [
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'bottom',
                                'title' => __d('ittvn', 'Logout'),
                                'escape' => false,
                                'class' => 'nav-link'
                            ]);
                            ?>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <?= $this->Html->link('<i class="fa fa-user-circle" aria-hidden="true"></i> <span>' . __d('ittvn', 'Đăng nhập') . '</span>', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'login', 'role' => 'customers'], ['escape' => false, 'data-target' => '#itmodal_ajax', 'data-modal' => true, 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => __d('ittvn', 'Đăng nhập'), 'class' => 'nav-link']); ?>
                        </li>
                        <li class="nav-item">
                            <?= $this->Html->link('<i class="fa fa-key" aria-hidden="true"></i> <span>' . __d('ittvn', 'Đăng ký') . '</span>', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'register', 'role' => 'customers'], ['escape' => false, 'data-target' => '#itmodal_ajax', 'data-modal' => true, 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => __d('ittvn', 'Đăng ký'), 'class' => 'nav-link']); ?>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </div>

    <div class="row menus clearfix">
        <div class="container">
            <div class="col-xs-12 col-md-2">
                <div class="row">
                    <div class="col-xs-10 col-md-12">
                        <?php
                        echo $this->Html->link(
                                $this->Html->image($setting->getThemeOption('logo'), ['width' => 120]), '/', ['escape' => false, 'class' => 'logo']
                        );
                        ?>    
                    </div>
                    <div class="col-xs-2 hidden-lg-up menu_mobile">
                        <nav class="navbar navbar-light">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"></button>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-10">  
                <nav class="navbar navbar-light">
                    <div class="collapse navbar-toggleable-md" id="navbarResponsive">
                        <?=
                        $this->cell('Menus.Menus::show', [
                            'menutype' => 1,
                            'options' => [
                                'attributes' => ['class' => 'nav navbar-nav'],
                                'tags' => [
                                    'child' => ['tag' => 'li', 'attribute' => ['class' => 'nav-item']],
                                ],
                                'subTags' => [
                                    'parent' => ['tag' => 'ul', 'attribute' => ['class' => 'dropdown-menu']],
                                    'child' => ['tag' => 'li', 'attribute' => ['class' => 'dropdown-item']]
                                ],
                                'hasChild' => ['class' => 'dropdown']
                            ]
                        ]);
                        ?>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- END HEADER -->