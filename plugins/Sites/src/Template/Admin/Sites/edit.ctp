<?php

$this->assign('title', __d('ittvn', 'Edit site'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn', 'Sites'), ['plugin' => 'Sites', 'controller' => 'Sites', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'Edit Site'), $this->request->here);
?>
