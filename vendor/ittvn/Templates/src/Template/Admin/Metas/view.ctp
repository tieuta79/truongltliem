<?php
use Cake\Core\Configure;
$this->assign('title', __d('ittvn', 'View Field'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Extra Fields'), ['plugin' => 'Metas', 'controller' => 'Metas', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'view Field'), $this->request->here);
?>