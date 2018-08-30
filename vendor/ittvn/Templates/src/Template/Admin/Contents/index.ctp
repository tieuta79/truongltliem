<?php

use Cake\Utility\Inflector;

$singularize = Inflector::singularize($content_type);
$pluralize = Inflector::pluralize($content_type);
$this->assign('title', __d('ittvn', $metaType->name));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', $metaType->name), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'index', $content_type]);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', $metaType->name));

//custom button add new
$this->start('title-bar');
echo $this->Html->link(
        '<i class="fa fa-plus"></i>', ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'add', $content_type], ['class' => 'button-icon jarviswidget-add-new', 'rel' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => __d('ittvn', 'Add new'), 'escape' => false]
);
$this->end();
//End custom button add new
?>