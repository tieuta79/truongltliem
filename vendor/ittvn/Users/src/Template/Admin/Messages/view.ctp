<?php
use Cake\Core\Configure;
Configure::write('Admin.Views.Messages', []);
$this->assign('title', __d('ittvn', 'View message'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Messages'), ['controller' => 'Messages', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'View message'), $this->request->here);
?>
