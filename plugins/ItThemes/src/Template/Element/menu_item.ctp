<?php

use Ittvn\Utility\System;
use Cake\Utility\Hash;

$system = new System();
$menu->attributes = !empty($menu->attributes) ? json_decode($menu->attributes, true) : [];
if (isset($menu->attributes['class'])) {
    $menu->attributes['class'] .= ' nav-link';
} else {
    $menu->attributes['class'] = 'nav-link';
}
if (count($menu->children) > 0) {
    if (isset($menu->attributes['class'])) {
        $menu->attributes['class'] .= ' dropdown-toggle';
    } else {
        $menu->attributes['class'] = 'dropdown-toggle';
    }
}

echo $this->Html->link($menu->name, $system->stringToUrl($menu->url), Hash::merge($menu->attributes, ['escape' => false]));
?>