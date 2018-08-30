<?php

$this->assign('title', __d('ittvn', 'Edit Payment'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn', 'Payments'), ['plugin' => 'Products', 'controller' => 'Payments', 'action' => 'index']);

$this->Html->addCrumb(__d('ittvn', 'Edit Payment'), $this->request->here);
?>