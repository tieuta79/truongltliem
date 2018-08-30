<?php
$this->assign('title', __d('ittvn', 'Locales'));
$this->Html->addCrumb(__d('ittvn', 'Locales'), ['plugin' => 'Translates', 'controller' => 'Locales', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All Locale'));

$this->Admin->adminScript('index');
?>
<div class="jarviswidget jarviswidget-color-orange" data-widget-sortable="true" data-widget-deletebutton="false" data-widget-colorbutton="false" data-widget-editbutton="false">
    <header>
        <div class="jarviswidget-ctrls" role="menu">              
            <?php
                echo $this->Html->link(
                        '<i class="fa fa-flag"></i>', ['plugin' => 'Translates', 'controller' => 'Locales', 'action' => 'generate'], ['class' => 'button-icon jarviswidget-add-new', 'rel' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => __d('ittvn', 'Generate file to file po'), 'escape' => false]
                );
                
                echo $this->Html->link(
                        '<i class="fa fa-refresh"></i>', ['plugin' => 'Translates', 'controller' => 'Locales', 'action' => 'reload'], ['class' => 'button-icon jarviswidget-add-new', 'rel' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => __d('ittvn', 'Scan files'), 'escape' => false]
                );
                echo $this->Html->link(
                        '<i class="fa fa-plus"></i>', ['plugin' => 'Translates', 'controller' => 'Locales', 'action' => 'add'], ['class' => 'button-icon jarviswidget-add-new', 'rel' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => __d('ittvn', 'Add new'), 'data-toggle' => 'modal', 'data-target' => '#modal_ajax', 'escape' => false]
                );
            ?>              
        </div>        
        <h2> <i class="fa fa-circle-o"></i> <?= __d('ittvn', 'All Locale'); ?> </h2>
    </header>
    <div>
        <div class="widget-body no-padding">    
            <div class="row">
                <div class="col-md-12">
                    <?= $this->Flash->render('auth'); ?>
                    <?= $this->Flash->render(); ?>                     
                </div>
            </div>
            <?= $this->cell('Templates.Tables::filter'); ?>                    
            <?php
            if ($this->fetch('content-table')):
                echo $this->fetch('content-table');
            else:
                ?>
                <table id="it_table_cool" class="table table-striped table-bordered table-hover it_dataTable" width="100%">
                    <?= $this->cell('Templates.Tables::header', [null, 'thead']); ?>
                </table>            
            <?php endif; ?>            
        </div>
    </div>
</div>