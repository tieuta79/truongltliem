<?php

$this->assign('title', __d('ittvn', 'Add message'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn', 'Messages'), ['controller' => 'Messages', 'action' => 'index']);

$this->Html->addCrumb(__d('ittvn', 'Add Message'), ['controller' => 'Messages', 'action' => 'add']);
?>
