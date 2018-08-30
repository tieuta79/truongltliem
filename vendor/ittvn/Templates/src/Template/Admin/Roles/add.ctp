<?php 
$this->assign('title', __d('ittvn', 'Add Role'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Roles'), ['plugin'=>'Users','controller' => 'Roles', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn','Add Role'), ['plugin'=>'Users','controller' => 'Roles', 'action' => 'add']);
?>