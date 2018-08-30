<?php
use Cake\Core\Configure;
$this->assign('title', __d('ittvn', 'View Role'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Roles'), ['plugin' => 'Users', 'controller' => 'Roles', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'view Role'), $this->request->here);
?>