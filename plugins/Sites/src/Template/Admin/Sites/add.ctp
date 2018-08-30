<?php

$this->assign('title', __d('ittvn', 'Add site'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn', 'Sites'), ['plugin' => 'Sites', 'controller' => 'Sites', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'Add Site'), ['plugin' => 'Sites', 'controller' => 'Sites', 'action' => 'add']);
?>
