<?php

$this->assign('title', __d('ittvn', 'Add Taxonomy'));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn', 'Taxonomies'), ['plugin' => 'Metas', 'controller' => 'MetaCategories', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'Add Taxonomy'), ['plugin' => 'Metas', 'controller' => 'MetaCategories', 'action' => 'add']);
?>