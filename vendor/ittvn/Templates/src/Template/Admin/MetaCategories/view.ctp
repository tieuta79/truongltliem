<?php

$this->assign('title', __d('ittvn', 'View Taxonomy'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Taxonomies'), ['plugin' => 'Metas', 'controller' => 'MetaCategories', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'view Taxonomy'), $this->request->here);
?>