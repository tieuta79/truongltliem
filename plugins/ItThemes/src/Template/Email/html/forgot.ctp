<?Php

use Cake\Routing\Router;
?>
<h3><?= sprintf(__d('ittvn', 'Xin chào %s'), $user['email']); ?></h3>
<p>
    Bạn vừa lấy lại mật khẩu trên trang website của chúng tôi.
    Bạn hãy bấm vào liên kết bên dưới để hoàn tất việc lấy lại mật khẩu.
</p>
<p>
    <?php
    $link = Router::url(['plugin' => 'Users', 'controller' => 'Users', 'action' => 'changepass', 'role' => $role, 'code' => $code, 'prefix' => false], true);
    echo $this->Html->link($link, $link);
    ?>
</p>