<?Php

use Ittvn\Utility\System;

$system = new System();
?>

<li>
    <div id="nav_menu-2" class="widget widget_nav_menu">
        <div class="widget-title">
            <h4><span><i class="icon-th-list"></i> <?= isset($data['title']) ? $data['title'] : ''; ?></span></h4>
            <div class="side-right-line"></div>
        </div>
        <div class="menu-left-menu-container">
            <?php if ($menus->count() > 0): ?>
                <ul id="menu-left-menu" class="menu">
                    <?php foreach ($menus as $menu): ?>
                        <li id="menu-item-442" class="menu-item <?= (count($menu->children) > 0) ? 'menu-item-has-children' : ''; ?>">
                            <?= $this->Html->link($menu->name, $system->stringToUrl($menu->url)); ?>
                            <?php if (count($menu->children) > 0): ?>
                                <ul class="sub-menu">
                                    <?php foreach ($menu->children as $mchild): ?>
                                        <li id="menu-item-433" class="menu-item">
                                            <?= $this->Html->link($mchild->name, $system->stringToUrl($mchild->url)); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <div class="clear"> </div>
    </div>
</li>