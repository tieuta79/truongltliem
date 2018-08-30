<?php
use Cake\Core\Configure;
$this->assign('title', __d('ittvn', 'View content type'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Content types'), ['plugin' => 'Metas', 'controller' => 'MetaTypes', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'view content type'), $this->request->here);
?>