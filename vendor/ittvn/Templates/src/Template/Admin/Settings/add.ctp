<?php 
$this->assign('title', __d('ittvn', 'Add Setting'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Settings'), ['plugin'=>'Settings','controller' => 'Settings', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn','Add Setting'), ['plugin'=>'Settings','controller' => 'Settings', 'action' => 'add']);
?>