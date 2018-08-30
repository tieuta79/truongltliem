<?php

use Cake\Utility\Inflector;

$this->assign('title', __d('ittvn', 'Custommers'));

$this->Html->addCrumb(__d('ittvn', 'Custommers'), ['plugin' => 'Products', 'controller' => 'Products', 'action' => 'custommers']);
$this->assign('title-table', '<i class="fa fa-users"></i> ' . __d('ittvn', 'All Custommer'));


$this->Admin->adminScript('index');

if (!$this->fetch('title-bar')) {
    $this->start('title-bar');
    echo $this->Html->link(
            '<i class="fa fa-plus"></i> ' . __d('ittvn', 'Add Custommer'), ['plugin' => 'Products', 'controller' => 'Products', 'action' => 'addCustommer'], ['escape' => false, 'class' => 'btn btn-success']
    );
    $this->end();
}
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>
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
                </h5>
                <div class="ibox-tools">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><?= $this->Html->link(__d('ittvn', 'All'), ['action' => 'index']); ?></li>
                        <li><?= $this->Html->link(__d('ittvn', 'Trash'), ['action' => 'index', 'trash' => 1]); ?></li>
                        <li class="divider"></li>
                        <li><a href="#">Help</a></li>
                    </ul>
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>                    
                </div>
            </div>
            <div class="ibox-content">
                <?= $this->Flash->render('auth'); ?>
                <?= $this->Flash->render(); ?>
                <?= $this->cell('Templates.Tables::filter'); ?>                
                <div class="table-responsive">
                    <?php
                    if ($this->fetch('content-table')):
                        echo $this->fetch('content-table');
                    else:
                        ?>                            
                        <table class="table table-bordered it_dataTable">
                            <?= $this->cell('Templates.Tables::header', [null, 'thead']); ?>
                            <?= $this->cell('Templates.Tables::rows', [null, $users]); ?>
                            <?= $this->cell('Templates.Tables::header', [null, 'tfoot']); ?>
                        </table>
                    <?php endif; ?>                    
                </div>
            </div>
        </div>
    </div>
</div>