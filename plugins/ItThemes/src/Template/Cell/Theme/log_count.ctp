<?php

use Cake\Routing\Router;
?>
<li class="nav-item">
    <a href="<?= Router::url(['plugin' => 'Users', 'controller' => 'Messages', 'action' => 'index', 'role' => $this->request->role]); ?>" class="nav-link">
        <i class="fa fa-bell text-red" aria-hidden="true"></i> 
        <span class="itnotify rounded-circle"><?= $log_count; ?></span>
    </a>
</li>