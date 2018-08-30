<?php 
$this->assign('title', __d('ittvn', 'Edit content type'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Content types'), ['plugin'=>'Metas','controller' => 'MetaTypes', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn','Edit content type'), $this->request->here);
?>