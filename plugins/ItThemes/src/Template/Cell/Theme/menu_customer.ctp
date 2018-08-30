<?php

use Cake\Routing\Router;
use Ittvn\Utility\User;
?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-top">
                <h3>
                    <i class="fa fa-graduation-cap" aria-hidden="true"></i> 
                    <strong><?= __d('ittvn', 'Tài khoản'); ?></strong>
                </h3>
            </div>
            <div class="box-content">
                <ul class="list-group list-unstyled">
                    <li>
                        <?php
                        $link = Router::url(['plugin' => 'Users', 'controller' => 'Users', 'action' => 'view', 'role' => User::get('role.slug')]);
                        $active = ($link == $this->request->here) ? ' active' : ' list-group-item-action';
                        echo $this->Html->link(
                                ($link == $this->request->here ? '<i class="fa fa-check text-red" aria-hidden="true"></i> ' : '') .
                                __d('ittvn', 'Cập nhật thông tin'), $link, ['escape' => false, 'class' => 'list-group-item' . $active]);
                        ?>
                    </li>
                    <li>
                        <?php
                        $link = Router::url(['plugin' => 'Users', 'controller' => 'Users', 'action' => 'updatePassword', 'role' => User::get('role.slug')]);
                        $active = ($link == $this->request->here) ? ' active' : ' list-group-item-action';
                        echo $this->Html->link(
                                ($link == $this->request->here ? '<i class="fa fa-check text-red" aria-hidden="true"></i> ' : '') .
                                __d('ittvn', 'Thay đôỉ mật khẩu'), $link, ['escape' => false, 'class' => 'list-group-item' . $active]);
                        ?>
                    </li>
                    <li>
                        <?php
                        $link = Router::url(['plugin' => 'Sites', 'controller' => 'Sites', 'action' => 'website', 'role' => User::get('role.slug')]);
                        $active = ($link == $this->request->here) ? ' active' : ' list-group-item-action';
                        echo $this->Html->link(
                                ($link == $this->request->here ? '<i class="fa fa-check text-red" aria-hidden="true"></i> ' : '') .
                                __d('ittvn', 'Cài đặt website'), $link, ['escape' => false, 'class' => 'list-group-item' . $active]);
                        ?>
                    </li>
                    <li>
                        <?php
                        $link = Router::url(['plugin' => 'Users', 'controller' => 'Logs', 'action' => 'index', 'role' => User::get('role.slug')]);
                        $active = ($link == $this->request->here) ? ' active' : ' list-group-item-action';
                        echo $this->Html->link(
                                ($link == $this->request->here ? '<i class="fa fa-check text-red" aria-hidden="true"></i> ' : '') .
                                __d('ittvn', 'Lịch sử đăng nhập') . ' <span class="itnotify bg-danger rounded-circle pull-right">' . $log_count . '</span>', $link, ['escape' => false, 'class' => 'list-group-item' . $active]);
                        ?>
                    </li>
                    <!--<li><a href="#" class="list-group-item list-group-item-action">Giới thiệu bạn bè <span class="itnotify bg-danger rounded-circle pull-right">5</span></a></li>-->
                    <li>
                        <?php
                        $link = Router::url(['plugin' => 'Users', 'controller' => 'Messages', 'action' => 'index', 'role' => User::get('role.slug')]);
                        $active = ($link == $this->request->here) ? ' active' : ' list-group-item-action';
                        echo $this->Html->link(
                                ($link == $this->request->here ? '<i class="fa fa-check text-red" aria-hidden="true"></i> ' : '') .
                                __d('ittvn', 'Thông báo') . ' <span class="itnotify bg-danger rounded-circle pull-right">' . $message_count . '</span>', $link, ['escape' => false, 'class' => 'list-group-item' . $active]);
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>