<?Php

use Cake\Routing\Router;
?>
<h3><?= sprintf(__d('ittvn', 'Xin chào %s'), $user['email']); ?></h3>
<p>
    Bạn đã thay đổi mật khẩu thành công. Hẫy đăng nhập để tạo website cho riêng mình.
</p>
<p>
    <?php
    $link = Router::url(['plugin' => 'Users', 'controller' => 'Users', 'action' => 'login', 'role' => $role, 'prefix' => false], true);
    echo $this->Html->link($link, $link);
    ?>
</p>