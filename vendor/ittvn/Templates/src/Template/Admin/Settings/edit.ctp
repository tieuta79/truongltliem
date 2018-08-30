<?php 
$this->assign('title', __d('ittvn', 'Edit Setting'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Settings'), ['plugin'=>'Settings','controller' => 'Settings', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn','Edit Setting'), $this->request->here);
?>