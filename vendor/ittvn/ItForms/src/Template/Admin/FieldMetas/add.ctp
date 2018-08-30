<?php
$this->assign('title', __d('ittvn', 'Add fieldMeta'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Field Metas'), ['controller' => 'FieldMetas', 'action' => 'index']);
    
$this->Html->addCrumb(__d('ittvn','Add FieldMeta'), ['controller' => 'FieldMetas', 'action' => 'add']);
?>
