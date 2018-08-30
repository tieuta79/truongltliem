<?php
use Cake\Core\Configure;
Configure::write('Admin.Views.Bookings', []);
$this->assign('title', __d('ittvn', 'View booking'));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', 'Bookings'), ['controller' => 'Bookings', 'action' => 'index']);
$this->Html->addCrumb(__d('ittvn', 'View booking'), $this->request->here);
?>
