<?php
use Cake\Core\Configure;
Configure::write('Admin.Views.Forms', []);
$this->assign('title', __d('ittvn', 'View form'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Forms'), ['controller' => 'Forms', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'View form'), $this->request->here);
?>
