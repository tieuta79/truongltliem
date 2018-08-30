<?php

$this->assign('title', __d('ittvn', 'Add filter'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn', 'Filters'), ['controller' => 'Filters', 'action' => 'index']);

$this->Html->addCrumb(__d('ittvn', 'Add Filter'), ['controller' => 'Filters', 'action' => 'add']);
?>
