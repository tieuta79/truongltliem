<?php

$this->assign('title', __d('ittvn', 'Provinces'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn', 'Provinces'), ['plugin' => 'Countries', 'controller' => 'Provinces', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'Add Province'), ['plugin' => 'Countries', 'controller' => 'Provinces', 'action' => 'add']);
?>