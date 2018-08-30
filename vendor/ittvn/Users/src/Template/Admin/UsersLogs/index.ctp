<?php
$this->assign('title', __d('ittvn', 'Users Logs'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Users Logs'), ['controller' => 'UsersLogs', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All UsersLog'));
?>
