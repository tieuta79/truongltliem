<?php

use Cake\Utility\Inflector;

$this->extend('/Admin/Common/index');
if (empty($role)) {
    $humanize = $pluralize = 'Users';
    $singularize = 'User';
    $this->Html->addCrumb(__d('ittvn', $humanize), ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'index']);
} else {
    $singularize = Inflector::singularize($role);
    $pluralize = Inflector::pluralize($role);
    $humanize = Inflector::humanize($pluralize);
    $this->Html->addCrumb(__d('ittvn', $humanize), ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'index', $role]);

//custom button add new
    $this->start('title-bar');
    echo $this->Html->link(
            '<i class="fa fa-plus"></i>', ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'add', $role], ['class' => 'button-icon jarviswidget-add-new', 'rel' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => __d('ittvn', 'Add new'), 'escape' => false]
    );
    $this->end();
//End custom button add new    
}
$this->assign('title', __d('ittvn', $humanize));
$this->assign('title-table', '<i class="fa fa-users"></i> ' . __d('ittvn', 'All ' . $singularize));
?>