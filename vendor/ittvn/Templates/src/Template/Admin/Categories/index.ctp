<?php

use Cake\Utility\Inflector;

$singularize = Inflector::singularize($cat_type);
$pluralize = Inflector::pluralize($cat_type);
$this->assign('title', __d('ittvn', $metaCategorie->name));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', $metaCategorie->name), ['plugin' => 'Contents', 'controller' => 'Categories', 'action' => 'index', $cat_type]);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', $metaCategorie->name));

//custom button add new
$this->start('title-bar');
echo $this->Html->link(
        '<i class="fa fa-plus"></i>', ['plugin' => 'Contents', 'controller' => 'Categories', 'action' => 'add', $cat_type], ['class' => 'button-icon jarviswidget-add-new', 'rel' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => __d('ittvn', 'Add new'), 'escape' => false]
);
$this->end();
//End custom button add new
?>