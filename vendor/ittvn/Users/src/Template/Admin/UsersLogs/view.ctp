<?php
use Cake\Core\Configure;
Configure::write('Admin.Views.UsersLogs', []);
$this->assign('title', __d('ittvn', 'View usersLog'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Users Logs'), ['controller' => 'UsersLogs', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'View usersLog'), $this->request->here);
?>
