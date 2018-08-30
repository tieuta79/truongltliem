<?php
$this->assign('title', __d('ittvn', 'Field Metas'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Field Metas'), ['controller' => 'FieldMetas', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All FieldMeta'));
?>
