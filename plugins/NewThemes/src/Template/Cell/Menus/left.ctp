<?Php
use Ittvn\Utility\System;
$system = new System();
?>
<div class="card card-outline-info mb-2">
    <div class="card-header bg-light-blue text-center bg-card-title">
        » <?= isset($data['title']) ? $data['title'] : ''; ?> «
    </div>
    <?php if ($menus->count() > 0): ?>
    <ul class="list-group list-group-flush">
        <?php foreach ($menus as $menu): ?>
        <li class="list-group-item list-group-item-action">
            <?php             
             if(empty($menu->parent_id)){
                $menu->name = '<i class="fa fa-plus-square"></i> '.$menu->name;
            }            
            echo $this->Html->link($menu->name, $system->stringToUrl($menu->url),['escape' => false]); 
            ?>
            <?php if(!empty($menu->children)): ?>
            <ul class="list-group-sub-menu">
                <?php foreach ($menu->children as $child): ?>
                    <li class="list-group-item list-group-item-action">
                        <?= $this->Html->link($child->name, $system->stringToUrl($child->url)); ?>
                    </li>
                <?php endforeach; ?>                
            </ul>
            <?php endif; ?>
        </li>        
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</div>