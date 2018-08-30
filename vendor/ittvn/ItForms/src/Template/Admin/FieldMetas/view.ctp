<?php
use Cake\Core\Configure;
Configure::write('Admin.Views.FieldMetas', []);
$this->assign('title', __d('ittvn', 'View fieldMeta'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Field Metas'), ['controller' => 'FieldMetas', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'View fieldMeta'), $this->request->here);
?>
