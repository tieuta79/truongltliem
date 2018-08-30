<?php

use Cake\Utility\Inflector;

$this->extend('/Admin/Common/form');
if (empty($role)) {
    $humanize = $pluralize = 'Users';
    $singularize = 'User';
} else {
    $singularize = Inflector::singularize($role);
    $pluralize = Inflector::pluralize($role);
    $humanize = Inflector::humanize($pluralize);
    
    $this->viewVars['title_form'] = $humanize;
}

$this->assign('title', sprintf(__d('ittvn', 'Add %s'), $singularize));

$this->Html->addCrumb(sprintf(__d('ittvn', '%s'), $humanize), ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'index', $role]);
$this->Html->addCrumb(sprintf(__d('ittvn', 'Add %s'), $singularize), ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'add', $role]);
?>