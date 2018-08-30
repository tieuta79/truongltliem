<?php

use Cake\Utility\Hash;

if (isset($this->request->params['pass'][0]) && $this->request->params['pass'][0] == 1) {
    $title = __d('ittvn', 'Network settings');
    $this->Html->addCrumb($title, ['plugin' => 'Settings', 'controller' => 'Settings', 'action' => 'general', $this->request->params['pass'][0]]);
} else {
    $title = __d('ittvn', 'General settings');
    $this->Html->addCrumb($title, ['plugin' => 'Settings', 'controller' => 'Settings', 'action' => 'general']);
}
$this->assign('title', $title);
?>

<?= $this->Form->create('settings'); ?>
<div class="row">
    <div class="col-md-8 settings">
        <?php if (isset($settings) && count($settings) > 0): ?>
            <?php foreach ($settings as $label => $setting): ?>
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <div class="jarviswidget jarviswidget-color-orange" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-sortable="true">
                            <header>
                                <h2><?= $label; ?></h2>
                            </header>
                            <div>
                                <div class="widget-body">
                                    <?Php
                                    if (Hash::check($setting, '{s}[type=/checkbox/]') || Hash::check($setting, '{s}[type=/radio/]')) {
                                        $setting = Hash::insert($setting, '{s}[type=/checkbox/].templates', ['inputContainer' => '<section class="form-group smart-form {{required}}">{{content}}</section>', 'nestingLabel' => '<label{{attrs}} class="checkbox">{{input}} {{text}}</label>',]);
                                        $setting = Hash::insert($setting, '{s}[type=/radio/].templates', ['inputContainer' => '<section class="form-group smart-form {{required}}">{{content}}</section>', 'nestingLabel' => '<label{{attrs}} class="radio">{{input}} {{text}}</label>',]);
                                    }
                                    ?>
                                    <?= $this->Form->inputs($setting, ['legend' => false]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>         
            <?php endforeach; ?>
        <?php endif; ?>     
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="jarviswidget jarviswidget-color-orange" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-sortable="true">
                    <header>
                        <h2><?= __d('ittvn', 'Action'); ?></h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-sm" data-toggle="tooltip" title="<?= __d('ittvn', 'Save'); ?>"><i class="fa fa-save"></i> <?= __d('ittvn', 'Save'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>         
    </div>
</div>
<?= $this->Form->end(); ?>