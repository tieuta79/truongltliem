<?php
use Cake\Core\Configure;
Configure::write('Admin.Views.Fields', []);
$this->assign('title', __d('ittvn', 'View field'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Fields'), ['controller' => 'Fields', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'View field'), $this->request->here);
?>
