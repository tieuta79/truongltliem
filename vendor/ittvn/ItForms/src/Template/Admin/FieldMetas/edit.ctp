<?php
$this->assign('title', __d('ittvn', 'Edit fieldMeta'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn','Field Metas'), ['controller' => 'FieldMetas', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn','Edit FieldMeta'), $this->request->here);
?>
