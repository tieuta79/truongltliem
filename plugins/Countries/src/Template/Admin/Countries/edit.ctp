<?php

$this->assign('title', __d('ittvn', 'Countries'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn', 'Countries'), ['plugin' => 'Countries', 'controller' => 'Countries', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'Edit Country'), $this->request->here);
?>