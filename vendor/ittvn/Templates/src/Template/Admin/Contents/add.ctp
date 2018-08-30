<?php

use Cake\Utility\Inflector;
use Cake\Event\EventManager;
use Cake\Event\Event;

$singularize = Inflector::singularize($content_type);
$pluralize = Inflector::pluralize($content_type);
$this->assign('title', __d('ittvn', 'Add ' . $metaType->name));

$this->Html->addCrumb(__d('ittvn', $metaType->name), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'index', $content_type]);
$this->Html->addCrumb(sprintf(__d('ittvn', 'Add %s'),__d('ittvn', $metaType->name)), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'add', $content_type]);

$result = (new EventManager())->dispatch(new Event('Admin.View.extend', ['request' => $this->request]));
if ($result->result) {
    $this->extend($result->result);
} else {
    $this->extend('/Admin/Common/form');
}
?>