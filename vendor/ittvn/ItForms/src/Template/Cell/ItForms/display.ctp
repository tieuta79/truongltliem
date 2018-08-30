<h1> Show form <?= $forms->name; ?> </h1>
<?= $this->Form->create($forms->slug); ?>
<div class="row">
    <div class="col-xs-12">
        <div class="jarviswidget jarviswidget-color-orange" data-widget-sortable="true" data-widget-deletebutton="false" data-widget-colorbutton="false" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-sitemap"></i> </span>
                <h2><?= __d('ittvn', $forms->slug); ?></h2>
            </header>

            <div class="content">
                <?= $this->Form->inputs($fields); ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="form-actions">
            <div class="row">
                <div class="col-md-12 text-left">
                    <button type="submit" class="btn btn-success btn-sm" data-toggle="tooltip" title="<?= __d('ittvn', 'Save'); ?>"><i class="fa fa-save"></i> <?= __d('ittvn', 'Save'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->Form->end(); ?>
