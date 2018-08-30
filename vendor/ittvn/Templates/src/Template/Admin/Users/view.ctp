<?php
use Cake\Core\Configure;
$this->assign('title', __d('ittvn', 'View User'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Users'), ['plugin' => 'Users', 'controller' => 'Users', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'view User'), $this->request->here);
?>