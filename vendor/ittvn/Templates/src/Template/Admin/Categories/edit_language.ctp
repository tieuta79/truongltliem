<?php

use Cake\Utility\Inflector;

$singularize = Inflector::singularize($cat_type);
$pluralize = Inflector::pluralize($cat_type);
$this->assign('title', __d('ittvn', 'Edit Translate '.Inflector::humanize($pluralize)));
$this->extend('/Admin/Common/form');
$this->Html->addCrumb(__d('ittvn', Inflector::humanize($pluralize)), ['plugin' => 'Contents', 'controller' => 'Categories', 'action' => 'index', $cat_type]);
$this->Html->addCrumb(__d('ittvn', 'Edit Translate ' . Inflector::humanize($pluralize)), $this->request->here);

$this->viewVars['title_form'] = 'Translate '.$category->name;
$this->viewVars['action_form'] = $this->Html->link(
        $this->Html->tag('i', '' ,['class'=> 'fa fa-flag']).' sync languages', '#',['class'=> 'btn btn-primary ajaxLangCategories','escape'=> false]);
?>