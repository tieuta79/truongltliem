<?Php

use Cake\Routing\Router;
?>
<h2><?= sprintf(__d('ittvn', '%s is registered.'), $user['surname'] . ' ' . $user['name']); ?></h2>
<p><strong><?= __d('ittvn', 'Email'); ?></strong>: <?= $user['email']; ?></p>
<p><strong><?= __d('ittvn', 'Phone'); ?></strong>: <?= $user['phone']; ?></p>
<p><strong><?= __d('ittvn', 'Username'); ?></strong>: <?= $user['username']; ?></p>
<br /><br />
<p><?= __d('ittvn', 'Please verify your account by below link'); ?>:</p>
<p><?= Router::url(['plugin' => 'Users', 'controller' => 'Users', 'action' => 'verify', 'code' => $user['active_code'], 'prefix' => 'admin'], true); ?></p>