<?php
$this->assign('title', __d('ittvn', 'Add field'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Fields'), ['controller' => 'Fields', 'action' => 'index']);
    
$this->Html->addCrumb(__d('ittvn','Add Field'), ['controller' => 'Fields', 'action' => 'add']);
?>
