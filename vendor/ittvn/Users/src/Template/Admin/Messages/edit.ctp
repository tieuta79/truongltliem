<?php

$this->assign('title', __d('ittvn', 'Edit message'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn', 'Messages'), ['controller' => 'Messages', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'Edit Message'), $this->request->here);
?>
