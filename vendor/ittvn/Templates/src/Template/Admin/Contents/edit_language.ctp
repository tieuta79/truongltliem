<?php

use Cake\Utility\Inflector;
use Cake\Event\EventManager;
use Cake\Event\Event;
use Cake\Utility\Hash;
use Cake\Core\Configure;
$singularize = Inflector::singularize($content_type);
$pluralize = Inflector::pluralize($content_type);
$this->assign('title', __d('ittvn', 'Edit Language ' . Inflector::humanize($pluralize)));
$this->Html->addCrumb(__d('ittvn', Inflector::humanize($pluralize)), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'index', $content_type]);
$this->Html->addCrumb(__d('ittvn', 'Edit Language ' . Inflector::humanize($pluralize)), $this->request->here);

$this->extend('/Admin/Common/form');

    ?> 

<?php
$this->viewVars['title_form'] = 'Translate '.$content->name;
$this->viewVars['action_form'] = $this->Html->link(
        $this->Html->tag('i', '' ,['class'=> 'fa fa-flag']).' sync languages', '#',['class'=> 'btn btn-primary ajaxLanguages','escape'=> false]);
?>