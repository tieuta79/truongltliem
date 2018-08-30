<?php

use Settings\Utility\Setting;

$setting = new Setting();
if(!isset($domainMapping)):
?>
<div class="project-context">
    <span class="label"><?= __d('ittvn', 'Networks'); ?>:</span>
    <span class="project-selector dropdown-toggle" data-toggle="dropdown"><?= sprintf('%s (%s)', $scope->title, $scope->title_page) ?> <i class="fa fa-angle-down"></i></span>
    <ul class="dropdown-menu">
        <?php if ($sites->count() > 0): ?>
            <?php foreach ($sites as $site): ?>
                <li>
                    <?= $this->Html->link(sprintf('%s (%s)', $site->title, $site->title_page), ['plugin' => 'Sites', 'controller' => 'Sites', 'action' => 'change', $site->username]); ?>
                </li>
            <?php endforeach; ?>
            <li class="divider"></li>
            <?php endif; ?>
        <li>
            <?= $this->Html->link(sprintf('%s (%s)', __d('ittvn', 'Main Site'), $title), ['plugin' => 'Sites', 'controller' => 'Sites', 'action' => 'change', 'default']); ?>
        </li>
    </ul>
</div>
<?php endif; ?>