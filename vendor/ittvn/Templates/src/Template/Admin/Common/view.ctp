<?php

use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

$plugin = false;
$controller = $this->request->controller;
if (isset($this->request->plugin) && !empty($this->request->plugin)) {
    $plugin = $this->request->plugin;
}

if (!empty($plugin)) {
    $aliasTable = TableRegistry::get($plugin . '.' . ucfirst($controller));
} else {
    $aliasTable = TableRegistry::get(ucfirst($controller));
}
$viewFields = isset($aliasTable->showView) ? $aliasTable->showView : [];

$singularize = Inflector::variable(Inflector::singularize($controller));
$dataViews = ${$singularize};
?>
<div class="row">
    <div class="col-md-8">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        if ($this->fetch('title-view')):
                            echo $this->fetch('title-view');
                        endif;
                        ?>  
                        <?= $this->cell('Templates.Views::viewInfo', ['data' => $dataViews]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="ibox">
            <div class="ibox-title">
                <h5><?= __d('ittvn', 'Action'); ?></h5>
            </div>
            <div class="ibox-content">
                <?php
                if ($this->fetch('action-view')):
                    echo $this->fetch('action-view');
                else:
                    ?>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <?=
                        $this->Html->link(
                                '<i class="fa fa-angle-double-left"></i> ' . __d('ittvn', 'Back'), ['plugin' => $plugin, 'controller' => $controller, 'action' => 'index'], ['class' => 'btn btn-info btn-sm', 'data-toggle' => 'tooltip', 'title' => 'Back', 'escape' => false]
                        );
                        ?>                 
                        <?php if (!isset($aliasTable->removeActionEdit) || (isset($aliasTable->removeActionEdit) && $aliasTable->removeActionEdit == false)) { ?>
                            <?=
                            $this->Html->link(
                                    '<i class="fa fa-pencil-square-o"></i> ' . __d('ittvn', 'Edit'), ['plugin' => $plugin, 'controller' => $controller, 'action' => 'edit', ${$singularize}->id], ['class' => 'btn btn-success btn-sm', 'data-toggle' => 'tooltip', 'title' => 'Edit', 'escape' => false]
                            );
                            ?> 
                        <?php } ?>
                        <?=
                        $this->Html->link(
                                '<i class="fa fa-trash-o"></i> ' . __d('ittvn', 'Delete'), ['plugin' => $plugin, 'controller' => $controller, 'action' => 'delete', ${$singularize}->id], ['escape' => false, 'class' => 'btn btn-danger btn-sm pull-right', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Delete'), 'confirm' => __d('ittvn', 'Are you sure you want to delete # {0}?', ${$singularize}->id)]
                        );
                        ?>
                    </div>                    
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>