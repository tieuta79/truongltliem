<?php 
$this->assign('title', __d('ittvn', 'Edit Role'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Roles'), ['plugin'=>'Users','controller' => 'Roles', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn','Edit Role'), $this->request->here);
?>