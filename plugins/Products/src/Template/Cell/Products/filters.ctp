<div class="row">
    <div class="filters clearfix">
        <div class="col-md-12 dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa fa-filter" aria-hidden="true"></i> <span class="title_filter"><?= __d('ittvn', 'Filter By'); ?></span>
            </a>                            
            <?php if ($attributes->count() > 0): ?>
                <ul class="dropdown-menu">
                    <?php foreach ($attributes as $attribute): ?>
                        <?php if (in_array($attribute->type, ['select', 'checkbox', 'radio'])): ?>
                            <li class="dropdown dropdown-submenu">
                                <?= $this->Html->link($attribute->name, [], ['class' => 'dropdown-toggle', 'data-toggle' => 'dropdown']); ?>
                                <?php
                                $options = json_decode($attribute->options, true);
                                if (count($options) > 0):
                                    ?>
                                    <ul class="dropdown-menu">
                                        <?php foreach ($options as $option): ?>
                                            <li><?= $this->Html->link($option['value'], []); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>                
                        <?php else: ?>
                            <li><?= $this->Html->link($attribute->name, []); ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <div class="col-md-12 text-right dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-sort" aria-hidden="true"></i> <span class="title_filter"><?= __d('ittvn', 'Sort By'); ?></span>
            </a>                            
            <ul class="dropdown-menu pull-right">
                <li><a href="#"><?= __d('ittvn', 'Price: Low to High'); ?></a></li>
                <li><a href="#"><?= __d('ittvn', 'Price: High to Low'); ?></a></li>
                <li><a href="#"><?= __d('ittvn', 'A-Z'); ?></a></li>
                <li><a href="#"><?= __d('ittvn', 'Z-A'); ?></a></li>
                <li><a href="#"><?= __d('ittvn', 'Oldest to Newest'); ?></a></li>
                <li><a href="#"><?= __d('ittvn', 'Newest to Oldest'); ?></a></li>
            </ul>                            
        </div>                          
    </div>                  
</div>