<?php

$this->assign('title', __d('ittvn', 'View site'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Sites'), ['plugin' => 'Sites', 'controller' => 'Sites', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'View site'), $this->request->here);
?>
