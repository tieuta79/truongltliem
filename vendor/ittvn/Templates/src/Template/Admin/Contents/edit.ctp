<?php

use Cake\Utility\Inflector;
use Cake\Event\EventManager;
use Cake\Event\Event;

$singularize = Inflector::singularize($content_type);
$pluralize = Inflector::pluralize($content_type);
$this->assign('title', __d('ittvn', 'Edit ' . Inflector::humanize($pluralize)));
$this->Html->addCrumb(__d('ittvn', Inflector::humanize($pluralize)), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'index', $content_type]);
$this->Html->addCrumb(__d('ittvn', 'Edit ' . Inflector::humanize($pluralize)), $this->request->here);

$result = (new EventManager())->dispatch(new Event('Admin.View.extend', ['request' => $this->request]));
if ($result->result) {
    $this->extend($result->result);
} else {
    //$this->extend('/Admin/Common/relation');
    $this->extend('/Admin/Common/form');
}
?>