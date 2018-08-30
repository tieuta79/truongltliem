<?php
$this->assign('title', __d('ittvn', 'Export'));
$this->Html->addCrumb(__d('ittvn', 'Export'), ['controller' => 'Tool', 'action' => 'export']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'Export'));
?>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="jarviswidget jarviswidget-color-orange" data-widget-sortable="true" data-widget-deletebutton="false" data-widget-colorbutton="false" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-sitemap"></i> </span>
                <h2><?= __d('ittvn', 'Export'); ?></h2>
            </header>
            <div>
                <?php $exportdata = ['Contents' => 'Contents', 'Menus' => 'Menus', 'Blocks' => 'Blocks', 'Themes' => 'Theme options'] ?>
                <?= $this->Form->create('exportdata'); ?>
                <div class="widget-body">
                    <div class="widget-body-toolbar bg-color-white">
                        <div class="col-sm-12 col-md-9">
                            <?=
                            $this->Form->input('exportdata', ['type' => 'select', 'id' => 'change_export_data',
                                'label' => 'Choose a Export data',
                                'class' => 'form-control',
                                'options' => $exportdata, 'default' => $models]);
                            ?>
                        </div>
                        <div class="col-sm-12 col-md-3 text-align-right">
                            <button type="submit" class="btn btn-success btn-sm" data-toggle="tooltip" title="<?= __d('ittvn', 'Export'); ?>"><i class="fa fa-save"></i> <?= __d('ittvn', 'Export'); ?></button>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php
                        if($models == 'Contents'){
                            echo $this->Form->input('Contents', [
                                'type' => 'select',
                                'multiple' => 'checkbox',
                                'options' => $metaTypes,
                                'templates' => [
                                    'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>'
                            ]]);

                            echo $this->Form->input('Categories', [
                                'type' => 'select',
                                'multiple' => 'checkbox',
                                'options' => $metaCategories,
                                'templates' => [
                                    'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>'
                            ]]);

                            echo $this->Form->input('Fields', [
                                'type' => 'select',
                                'multiple' => 'checkbox',
                                'options' => $metas,
                                'templates' => [
                                    'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>'
                            ]]);
                        }
                        if($models == 'Blocks'){
                            echo $this->Form->input('Blocks', [
                                'type' => 'select',
                                'multiple' => 'checkbox',
                                'options' => $blocks,
                                'templates' => [
                                    'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>'
                            ]]);
                        }
                        if($models == 'Themes'){
                            echo $this->Form->input('Themes', [
                                'type' => 'select',
                                'multiple' => 'checkbox',
                                'options' => $themes,
                                'templates' => [
                                    'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>'
                            ]]);
                        }
                        if($models == 'Menus'){
                            echo $this->Form->input('Menus', [
                                'type' => 'select',
                                'multiple' => 'checkbox',
                                'options' => $menutypes,
                                'templates' => [
                                    'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>'
                            ]]);
                        }
                        
                        ?>


                    </div>
                </div>
<?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>