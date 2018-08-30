<?php 
$this->assign('title', __d('ittvn', 'View Setting'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn','Settings'), ['plugin'=>'Settings','controller' => 'Settings', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn','View Setting'), $this->request->here);
?>