<?php
use Ittvn\Utility\User;
?>
<ul class="dropdown-menu">
    <li class="dropdown-item">
        <?= $this->Html->link(__d('ittvn', 'Cập nhật tài khoản'), ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'view', 'role' => User::get('role.slug')]); ?>
    </li>
    <li class="dropdown-item">
        <?= $this->Html->link(__d('ittvn', 'Thay đổi mật khẩu'), ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'updatePassword', 'role' => User::get('role.slug')]); ?>
    </li>
    <li class="dropdown-item">
        <?= $this->Html->link(__d('ittvn', 'Cài đặt website'), ['plugin' => 'Sites', 'controller' => 'Sites', 'action' => 'website', 'role' => User::get('role.slug')]); ?>
    </li>
    <li class="dropdown-item">
        <?= $this->Html->link(__d('ittvn', 'Lịch sử đăng nhập'), ['plugin' => 'Users', 'controller' => 'Logs', 'action' => 'index', 'role' => User::get('role.slug')]); ?>
    </li>
    <!--<li class="dropdown-item"><a href="#">Giới thiệu bạn bè</a></li>-->
</ul>