<?php
$this->assign('title', __d('ittvn', 'Edit field'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Fields'), ['controller' => 'Fields', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn','Edit Field'), $this->request->here);
?>
