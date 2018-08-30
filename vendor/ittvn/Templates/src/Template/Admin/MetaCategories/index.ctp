<?php

$this->assign('title', __d('ittvn', 'Taxonomies'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Taxonomies'), ['plugin' => 'Metas', 'controller' => 'MetaCategories', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'Taxonomies'));
?>