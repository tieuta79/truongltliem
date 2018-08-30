<?php

use Cake\Core\Configure;
use Settings\Utility\Setting;
use Ittvn\Utility\Language;

$setting = new Setting();
$theme = $setting->getOption('Themes.site');
$themeOptions = [];
if (Configure::check('Theme.options')) {
    $themeOptions = Configure::read('Theme.options');
};
?>
<?php $this->assign('title', __d('ittvn', 'Options')); ?>
<?php $this->Html->addCrumb(__d('ittvn', 'Options'), ['plugin' => 'Themes', 'controller' => 'Themes', 'action' => 'options']); ?>

<?= $this->Form->create('settings'); ?>
<div class="row">
    <div class="col-xs-12 col-md-9">
        <div class="jarviswidget jarviswidget-color-orange" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-sortable="true">
            <header>
                <h2><?= __d('ittvn', 'Theme Options'); ?> (<?= $theme; ?>)</h2>
            </header>
            <div>
                <div class="widget-body no-padding theme_options">
                    <?php if (count($themeOptions) > 0): ?>
                        <div class="panel-group smart-accordion-default" id="theme_options">
                            <?php
                            $i = 0;
                            foreach ($themeOptions as $k => $options):
                                ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><a data-toggle="collapse" data-parent="#theme_options" href="#<?= $k; ?>"> <i class="fa fa-fw fa-plus-circle txt-color-green"></i> <i class="fa fa-fw fa-minus-circle txt-color-red"></i> <?= __d('ittvn', $options['label']); ?> </a></h4>
                                    </div>
                                    <div id="<?= $k; ?>" class="panel-collapse collapse <?= $i++ == 0 ? 'in' : ''; ?>">
                                        <div class="panel-body">
                                            <?= $this->Admin->inputs($options['options'], ['legend' => false]); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?> 
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-md-3">
        <div class="jarviswidget jarviswidget-color-orange" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-sortable="true">
            <header>
                <h2><?= __d('ittvn', 'Action'); ?></h2>
            </header>
            <div>
                <div class="widget-body">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-sm" data-toggle="tooltip" title="<?= __d('ittvn', 'Save'); ?>"><i class="fa fa-save"></i> <?= __d('ittvn', 'Save'); ?></button>
                        <?php if (Language::getLanguages()->count() > 1) : ?>
                        <button class="btn btn-primary"><i class="fa fa-flag"></i> <?= __d('ittvn', 'Sync to languages'); ?> </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>  
<?= $this->Form->end(); ?>