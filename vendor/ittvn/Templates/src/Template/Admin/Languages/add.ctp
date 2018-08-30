<?php 
$this->assign('title', __d('ittvn', 'Add Language'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Languages'), ['plugin'=>'Extensions','controller' => 'Languages', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn','Add Language'), ['plugin'=>'Extensions','controller' => 'Languages', 'action' => 'add']);
?>