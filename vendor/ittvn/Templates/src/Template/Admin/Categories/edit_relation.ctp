<?php

use Cake\Utility\Inflector;

$singularize = Inflector::singularize($cat_type);
$pluralize = Inflector::pluralize($cat_type);
$this->assign('title', __d('ittvn', 'Edit relation ' .Inflector::humanize($pluralize)));

$this->Html->addCrumb(__d('ittvn', Inflector::humanize($pluralize)), ['plugin' => 'Contents', 'controller' => 'Categories', 'action' => 'index', $cat_type]);
$this->Html->addCrumb(__d('ittvn', 'Edit relation ' . Inflector::humanize($pluralize)), $this->request->here);

$this->Admin->adminScript('form');
echo $this->cell('Templates.Forms::form',['data'=>$this->viewVars])->render('form_relation_category');
?>