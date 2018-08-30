<?php

$this->assign('title', __d('ittvn', 'Edit filter'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn', 'Filters'), ['controller' => 'Filters', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'Edit Filter'), $this->request->here);
?>
