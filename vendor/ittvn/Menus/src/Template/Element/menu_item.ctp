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
echo $this->Html->link($menu->name, $system->stringToUrl($menu->url), (array)$menu->attributes);
?>