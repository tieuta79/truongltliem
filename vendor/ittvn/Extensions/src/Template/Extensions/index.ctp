<?php

use Cake\Core\Configure;
use Cake\Utility\Hash;

$this->assign('title', __d('ittvn', 'Plugins'));
$this->Html->addCrumb(__d('ittvn', 'Plugins'), ['plugin' => 'Extensions', 'controller' => 'Plugins', 'action' => 'index']);
?>
<div class="ibox-content m-b-sm border-bottom">
    <div class="p-xs">
        <div class="pull-left m-r-md">
            <i class="fa fa-plug text-navy mid-icon"></i>
        </div>
        <h2><?= __d('ittvn', 'Plugins'); ?> for <?= Configure::read('Settings.Sites.title'); ?></h2>
        <span><?= __d('ittvn', 'Click on icon and drag to order plugin active.'); ?></span>
    </div>
</div>

<div class="ibox-content forum-container">

    <div class="forum-title">
        <div class="pull-right forum-desc">
            <samll><?= __d('ittvn', 'Total plugins'); ?>: <?= count($plugins['active']); ?></samll>
        </div>
        <h3><?= __d('ittvn', 'Plugin is active'); ?></h3>
    </div>

    <div class="list_plugin">
        <?php if (count($plugins['active']) > 0): ?>
            <?php foreach ($plugins['active'] as $key => $plugin_active): ?>
                <div class="forum-item active" data-order="0">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="forum-icon">
                                <i class="<?= isset($plugin_active->icon)?$plugin_active->icon:''; ?>"></i>
                            </div>
                            <a href="#" class="forum-item-title"><?= $plugin_active->name; ?></a>
                            <div class="forum-sub-title"><?= $plugin_active->description; ?></div>
                        </div>
                        <div class="col-md-1 forum-info">
                            <span class="views-number">
                                <?= $plugin_active->version; ?>
                            </span>
                            <div>
                                <small><?= __d('ittvn', 'Version'); ?></small>
                            </div>
                        </div>
                        <div class="col-md-1 forum-info">
                            <span class="views-number">
                                <?= $plugin_active->author; ?>
                            </span>
                            <div>
                                <small><?= __d('ittvn', 'Author'); ?></small>
                            </div>
                        </div>
                        <div class="col-md-1 forum-info">
                            <span class="views-number">
                                <a href="#" title="Deactive" class="btn btn-danger btn-plugin"><i class="fa fa-times"></i></a>
                            </span>
                            <div>
                                <small><?= __d('ittvn', 'Deactive'); ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>        
    </div>

    <div class="forum-title">
        <div class="pull-right forum-desc">
            <samll><?= __d('ittvn', 'Total plugins'); ?>: <?= count($plugins['deactive']); ?></samll>
        </div>
        <h3><?= __d('ittvn', 'Plugin is deactive'); ?></h3>
    </div>
    <?php if (count($plugins['deactive']) > 0): ?>
        <?php foreach ($plugins['deactive'] as $key => $plugin_deactive): ?>
            <div class="forum-item">
                <div class="row">
                    <div class="col-md-9">
                        <div class="forum-icon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                        <a href="#" class="forum-item-title"><?= $plugin_deactive->name; ?></a>
                        <div class="forum-sub-title"><?= $plugin_deactive->description; ?></div>
                    </div>
                    <div class="col-md-1 forum-info">
                        <span class="views-number">
                            1.0
                        </span>
                        <div>
                            <small><?= __d('ittvn', 'Version'); ?></small>
                        </div>
                    </div>
                    <div class="col-md-1 forum-info">
                        <span class="views-number">
                            ITTVN
                        </span>
                        <div>
                            <small><?= __d('ittvn', 'Author'); ?></small>
                        </div>
                    </div>
                    <div class="col-md-1 forum-info">
                        <span class="views-number">
                            <a href="#" title="Active" class="btn btn-primary btn-plugin"><i class="fa fa-check"></i></a>
                        </span>
                        <div>
                            <small><?= __d('ittvn', 'Active'); ?></small>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>