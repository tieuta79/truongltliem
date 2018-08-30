<?php 
$this->assign('title', __d('ittvn', 'Add content type'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Content types'), ['plugin'=>'Metas','controller' => 'MetaTypes', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn','Add content type'), ['plugin'=>'Metas','controller' => 'MetaTypes', 'action' => 'add']);
?>