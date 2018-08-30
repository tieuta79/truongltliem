<?php

$this->assign('title', __d('ittvn', 'Cities'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn', 'Cities'), ['plugin' => 'Countries', 'controller' => 'Cities', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'Add City'), ['plugin' => 'Countries', 'controller' => 'Cities', 'action' => 'add']);
?>