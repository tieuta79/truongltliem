<?php
$this->assign('title', __d('ittvn', 'Import'));
$this->Html->addCrumb(__d('ittvn', 'Import'), ['controller' => 'Tool', 'action' => 'import']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'Import'));
?>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="jarviswidget jarviswidget-color-orange" data-widget-sortable="true" data-widget-deletebutton="false" data-widget-colorbutton="false" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-sitemap"></i> </span>
                <h2><?= __d('ittvn', 'Import'); ?></h2>
            </header>
            <div>
                <?php $Importdata = ['Contents' => 'Contents', 'Menus' => 'Menus', 'Blocks' => 'Blocks', 'Themes' => 'Theme options']; ?>
                <?= $this->Form->create('importdata',['type'=>'file']); ?>
                <div class="widget-body">
                    <div class="widget-body-toolbar bg-color-white">
                        <div class="col-sm-12 col-md-9">
                            <?= $this->Form->input('Importdata', ['type' => 'select', 'id' => 'change_Import_data', 
                                'label' => 'Choose a Import data', 
                                'class' => 'form-control', 
                                'options' => $Importdata, 'default' => $models]); ?>
                        </div>
                        <div class="col-sm-12 col-md-3 text-align-right">
                            <button type="submit" class="btn btn-success btn-sm" data-toggle="tooltip" title="<?= __d('ittvn', 'Import'); ?>"><i class="fa fa-save"></i> <?= __d('ittvn', 'Import'); ?></button>
                        </div>
                    </div>
                    <div class="col-md-12">
						<?php 
							echo $this->Form->input('file',['type'=>'file']); 
								
								?>
					

                    </div>
                </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>