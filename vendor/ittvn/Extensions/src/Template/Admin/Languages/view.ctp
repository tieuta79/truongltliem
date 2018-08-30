<?php
use Cake\Core\Configure;
Configure::write('Admin.Views.Languages', []);
$this->assign('title', __d('ittvn', 'View language'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Languages'), ['controller' => 'Languages', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'View language'), $this->request->here);
?>
