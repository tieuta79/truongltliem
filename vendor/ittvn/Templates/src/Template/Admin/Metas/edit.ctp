<?php 
$this->assign('title', __d('ittvn', 'Edit Field'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Extra Fields'), ['plugin'=>'Metas','controller' => 'Metas', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn','Edit Field'), $this->request->here);
?>