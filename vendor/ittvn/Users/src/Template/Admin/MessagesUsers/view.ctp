<?php
use Cake\Core\Configure;
Configure::write('Admin.Views.MessagesUsers', []);
$this->assign('title', __d('ittvn', 'View messagesUser'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Messages Users'), ['controller' => 'MessagesUsers', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'View messagesUser'), $this->request->here);
?>
