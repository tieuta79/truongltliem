<?Php

use Cake\Routing\Router;
?>
<h3><?= sprintf(__d('ittvn', 'Xin chào %s'), $user['email']); ?></h3>
<p>
    Cảm ơn bạn đã đăng ký thành công trên hệ thống tạo website nhanh. 
    Bạn chỉ còn một bước nữa, hãy bấm vào link bên dưới để kích hoạt tài khoản và cập nhật thông tin website.
</p>
<p>
    <?php
    $link = Router::url(['plugin' => 'Users', 'controller' => 'Users', 'action' => 'verify', 'role' => $role, 'code' => $user['active_code'], 'prefix' => false], true);
    echo $this->Html->link($link, $link);
    ?>
</p>