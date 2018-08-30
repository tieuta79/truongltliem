<?php
$this->assign('title', __d('ittvn', 'Bookings'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', 'Bookings'), ['controller' => 'Bookings', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All Booking'));
?>
