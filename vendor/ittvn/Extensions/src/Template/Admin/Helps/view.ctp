<?php
use Cake\Core\Configure;
Configure::write('Admin.Views.Helps', []);
$this->assign('title', __d('ittvn', 'View help'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Helps'), ['controller' => 'Helps', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'View help'), $this->request->here);
?>
