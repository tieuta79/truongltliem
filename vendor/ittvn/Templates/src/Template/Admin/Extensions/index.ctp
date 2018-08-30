<?php

use Cake\Core\Configure;
use Cake\Utility\Hash;

$this->assign('title', __d('ittvn', 'Plugins'));
$this->Html->addCrumb(__d('ittvn', 'Plugins'), ['plugin' => 'Extensions', 'controller' => 'Extensions', 'action' => 'index']);
?>

<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="jarviswidget jarviswidget-color-orange" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-sortable="true">
            <header>
                <h2><?= __d('ittvn', 'Plugins'); ?> for <?= Configure::read('Settings.Sites.title'); ?></h2>
            </header>
            <div>
                <div class="widget-body">
                    <small class="clearfix"><?= __d('ittvn', 'Click on icon and drag to order plugin active.'); ?></small>
                    <?= $this->Flash->render(); ?>
                    <div class="row">
                        <div class="col-xs-12 col-md-12 well">
                            <table class="table table-striped table-forum">
                                <thead>
                                    <tr>
                                        <th colspan="4"><?= __d('ittvn', 'Plugin is active'); ?></th>
                                        <th class="text-right"><samll><?= __d('ittvn', 'Total plugins'); ?>: <?= count($plugins['active']); ?></samll></th>                                        
                                </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($plugins['active']) > 0): ?>
                                        <?php foreach ($plugins['active'] as $key => $plugin_active): ?>                                    
                                            <tr>
                                                <td class="text-center" style="width:100px"><i class="fa-2x <?= isset($plugin_active->icon) ? $plugin_active->icon : 'fa fa-plug'; ?>"></i></td>
                                                <td>
                                                    <h4><a href="#" class="forum-item-title"><?= $plugin_active->name; ?></a></h4>
                                                    <small><?= $plugin_active->description; ?></small>
                                                </td>
                                                <td class="text-center" style="width:100px">
                                                    <span class="views-number"><?= $plugin_active->version; ?></span>
                                                    <div><small><?= __d('ittvn', 'Version'); ?></small></div>                                                
                                                </td>
                                                <td class="text-center" style="width:100px">
                                                    <span class="views-number"><?= $plugin_active->author; ?></span>
                                                    <div><small><?= __d('ittvn', 'Author'); ?></small></div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="views-number"><?= $this->Html->link('<i class="fa fa-times"></i>', ['plugin' => 'Extensions', 'controller' => 'Extensions', 'action' => 'deactive', $key], ['class' => 'btn btn-danger btn-plugin', 'title' => 'Deactive', 'escape' => false]); ?></span>
                                                    <div><small><?= __d('ittvn', 'Deactive'); ?></small></div>                                                    
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>                                        
                                </tbody>
                            </table>

                            <table class="table table-striped table-forum">
                                <thead>
                                    <tr>
                                        <th colspan="4"><?= __d('ittvn', 'Plugin is deactive'); ?></th>
                                        <th class="text-right"><samll><?= __d('ittvn', 'Total plugins'); ?>: <?= count($plugins['deactive']); ?></samll></th>                                        
                                </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($plugins['deactive']) > 0): ?>
                                        <?php foreach ($plugins['deactive'] as $key => $plugin_deactive): ?>                                
                                            <tr>
                                                <td class="text-center" style="width:100px"><i class="fa-2x <?= isset($plugin_deactive->icon) ? $plugin_deactive->icon : 'fa fa-plug'; ?>"></i></td>
                                                <td><h4><a href="#" class="forum-item-title"><?= $plugin_deactive->name; ?></a></h4><small><?= $plugin_deactive->description; ?></small></td>
                                                <td class="text-center" style="width:100px">
                                                    <span class="views-number"><?= $plugin_deactive->version; ?></span>
                                                    <div><small><?= __d('ittvn', 'Version'); ?></small></div>                                                
                                                </td>
                                                <td class="text-center" style="width:100px">
                                                    <span class="views-number"><?= $plugin_deactive->author; ?></span>
                                                    <div><small><?= __d('ittvn', 'Author'); ?></small></div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="views-number"><?= $this->Html->link('<i class="fa fa-check"></i>', ['plugin' => 'Extensions', 'controller' => 'Extensions', 'action' => 'active', $key], ['class' => 'btn btn-success btn-plugin', 'title' => 'Active', 'escape' => false]); ?></span>
                                                    <div><small><?= __d('ittvn', 'Active'); ?></small></div>                                                    
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>                                        
                                </tbody>
                            </table>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 