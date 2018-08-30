<?php
use Ittvn\Utility\System;
use Cake\Utility\Hash;

$system = new System();
if(!empty($menu->attributes)){
    $menu->attributes = json_decode($menu->attributes,true);
	$menu->attributes['escape'] = false;
}else{
	$menu->attributes['escape'] = false;
}

if($menu->menutype_id == 2){
    if(empty($menu->parent_id)){
        $menu->name = '<i class="fa fa-plus-square"></i> '.$menu->name;
    }
}else {
    if(!empty($menu->children)){
        $menu->attributes = Hash::merge($menu->attributes,['class' => 'nav-link dropdown-toggle' , 'data-toggle' => 'dropdown']);
    }else{
        if(!empty($menu->parent_id)){
            $menu->attributes = Hash::merge($menu->attributes,['class' => 'dropdown-item']);
        }else {
            $menu->attributes = Hash::merge($menu->attributes,['class' => 'nav-link']);
        }
    }
}

echo $this->Html->link($menu->name, $system->stringToUrl($menu->url), (array)$menu->attributes);
?>