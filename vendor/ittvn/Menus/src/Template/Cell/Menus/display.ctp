<?Php

use Ittvn\Utility\System;

$system = new System();
?>
<div class="footer-link-list col-md-6">
    <div class="group">
        <h5 class="general-title"><?= isset($data['title']) ? $data['title'] : ''; ?></h5>	
            <?php if ($menus->count() > 0): ?>
            <ul class="list-unstyled list-styled">		
                    <?php foreach ($menus as $menu): ?>
                    <li class="list-unstyled">
                    <?= $this->Html->link($menu->name, $system->stringToUrl($menu->url)); ?>
                    </li>					
            <?php endforeach; ?>					  
            </ul>
<?php endif; ?>
    </div>
</div> 