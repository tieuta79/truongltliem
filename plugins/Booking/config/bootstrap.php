<?php

use Cake\Core\Configure;
use Ittvn\Utility\System;

$system = new System();
$system->addModule('Booking.RoomTypes::featured', 'Display Room Types featured', []);

Configure::write('Admin.Tables.Bookings.header', [
    'content_id' => [
        'label' => 'Room Type',
        'sort' => '1',
        'filter' => 'text'
    ],
    'first_name' => [
        'label' => 'First_name',
        'sort' => '1',
        'filter' => 'text',
    ],
    'email' => [
        'label' => 'Email',
        'sort' => '1',
        'filter' => 'text',
    ],
    'phone' => [
        'label' => 'Phone',
        'sort' => '1',
        'filter' => 'text',
    ],
    'adults' => [
        'label' => 'Adults',
        'sort' => '1',
        'filter' => 'text',
    ],
    'children' => [
        'label' => 'Children',
        'sort' => '1',
        'filter' => 'text',
    ],
]);

