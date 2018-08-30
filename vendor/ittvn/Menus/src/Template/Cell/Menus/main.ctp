<div class="main-menu">
    <div id="header_menu">
        <?= $this->Html->image('logo_sticky.png', ['width' => '160', 'height' => '34', 'data-retina' => 'true']); ?>
    </div>
    <a href="#" class="open_close" id="close_in"><i class="icon_set_1_icon-77"></i></a>
    <ul>
        <?php foreach ($menus as $menu): ?>
            <?php if ($menu->is_mega == 0 && $menu->is_dropdown == 0): ?>
                <li><?= $this->Html->link($menu->name, $this->Layout->stringToUrl($menu->url), ['escape' => false]); ?></li>
            <?php else: ?>
                <li class="submenu <?= $menu->is_mega == 1 ? 'megamenu' : ''; ?>">
                    <?= $this->Html->link($menu->name . ' <i class="icon-down-open-mini"></i>', 'javascript:void(0);', ['class' => 'show-submenu' . ($menu->is_mega == 1 ? '-mega' : ''), 'escape' => false]); ?>
                    <?php if ($menu->is_mega == 1): ?>
                        <div class="menu-wrapper">
                            <?php if (count($menu->children) > 0): ?>
                                <?php foreach ($menu->children as $mchild): ?>
                                    <div class="col-md-4">
                                        <h3><?= $mchild->name; ?></h3>
                                        <?php if (count($mchild->children) > 0): ?>
                                            <ul>
                                                <?php foreach ($mchild->children as $mchild1): ?>
                                                    <li class="">
                                                        <?= $this->Html->link($mchild1->name, $this->Layout->stringToUrl($mchild1->url), ['escape' => false]); ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>  
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <?php if (count($menu->children) > 0): ?>
                            <ul>
                                <?php foreach ($menu->children as $mchild): ?>
                                    <li class="">
                                        <?= $this->Html->link($mchild->name, $this->Layout->stringToUrl($mchild->url), ['escape' => false]); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>  
                        <?php endif; ?>
                    <?php endif; ?>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>