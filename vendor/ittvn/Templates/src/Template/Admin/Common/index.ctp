<?php
$plugin = false;
if (isset($this->request->plugin) && !empty($this->request->plugin)) {
    $plugin = $this->request->plugin;
}

$this->Admin->adminScript('index');
?>
<div class="jarviswidget jarviswidget-color-orange" data-widget-sortable="true" data-widget-deletebutton="false" data-widget-colorbutton="false" data-widget-editbutton="false">
    <header>
        <div class="jarviswidget-ctrls" role="menu">              
            <?php
            if (!$this->fetch('title-bar')) {
                echo $this->Html->link(
                        '<i class="fa fa-plus"></i>', ['plugin' => $plugin, 'controller' => $this->request->controller, 'action' => 'add'], ['class' => 'button-icon jarviswidget-add-new', 'rel' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => __d('ittvn', 'Add new'), 'escape' => false]
                );
            }else{
                echo $this->fetch('title-bar');
            }
            ?>      

            <?=
            $this->Html->link(
                    '<i class="fa fa-table"></i>', $this->Admin->urlTrash(false), ['class' => 'button-icon jarviswidget-all-list', 'rel' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => __d('ittvn', 'All'), 'escape' => false]
            );
            ?>

            <?=
            $this->Html->link(
                    '<i class="fa fa-trash-o"></i>', $this->Admin->urlTrash(), ['class' => 'button-icon jarviswidget-all-trash', 'rel' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => __d('ittvn', 'Trash'), 'escape' => false]
            );
            ?>                
        </div>        
        <h2>
            <?php
            if ($this->fetch('title-table')) {
                echo $this->fetch('title-table');
            } else {
                echo $this->fetch('title');
            }

            if (isset($this->request->query['trash']) && $this->request->query['trash'] == 1) {
                echo ' ' . __d('ittvn', '(Trash)');
            }
            ?>            
        </h2>
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