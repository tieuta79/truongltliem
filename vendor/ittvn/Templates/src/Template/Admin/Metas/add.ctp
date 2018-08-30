<?php 
$this->assign('title', __d('ittvn', 'Add Field'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Extra Fields'), ['plugin'=>'Metas','controller' => 'Metas', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn','Add Field'), ['plugin'=>'Metas','controller' => 'Metas', 'action' => 'add']);
?>