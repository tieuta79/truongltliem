<?php

use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\Event\EventManager;
use Cake\Event\Event;
use Cake\Core\Configure;
?>
<div class="row">
    <div class="col-md-8">
        <?= $this->Flash->render('auth'); ?>
        <?= $this->Flash->render(); ?>
    </div>
</div>
<?php
if ($this->fetch('default-form')):
    echo $this->fetch('default-form');
else:
    if ($this->fetch('block-start-form')):
        echo $this->fetch('block-start-form');
    else:
        $form_options = [];
        if (Hash::check($positionMain, '{s}.{s}[type=file]') || Hash::check($positionSidebar, '{s}.{s}[type=file]')) {
            $form_options['type'] = 'file';
        }
        echo $this->Form->create(${$this->request->params['pass'][1]}, $form_options);
    endif;
    ?>  
    <div class="row" id="sortable-view">
        <div class="col-md-8">
            <?php
            if (count($positionMain) > 0):
                foreach ($positionMain as $key => $block):
                    ?>            
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5><?= isset($block['label']) ? __d('ittvn', $block['label']) : __d('ittvn', $key); ?></h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <?php $block = Hash::remove($block, 'label'); ?>
                        <div class="ibox-content">
                            <?= $this->Admin->inputs($block); ?>
                        </div>
                    </div>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
        <div class="col-md-4">
            <?php
            if (count($positionSidebar) > 0):
                $i = 0;
                foreach ($positionSidebar as $key => $block):
                    ?>            
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5><?= isset($block['label']) ? __d('ittvn', $block['label']) : __d('ittvn', $key); ?></h5>
                        </div>
                        <?php $block = Hash::remove($block, 'label'); ?>
                        <div class="ibox-content">
                            <?= $this->Admin->inputs($block); ?>  
                            <?php if ($i++ == 0): ?>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-sm" data-toggle="tooltip" title="Save"><i class="fa fa-save"></i> Save</button> &nbsp;
                                    <?php
                                    echo $this->Html->link(
                                            '<i class="fa fa fa-undo"></i> ' . __d('ittvn', 'Back'), ['plugin' => $this->request->plugin, 'controller' => $this->request->controller, 'action' => 'edit', $this->request->params['pass'][2]], ['class' => 'btn btn-info btn-sm', 'data-toggle' => 'tooltip', 'title' => 'Back', 'escape' => false]
                                    );
                                    ?>
                                </div>
                            <?php endif; ?>                            

                        </div>
                    </div>
                    <?php
                endforeach;
            endif;
            ?>            
        </div>
    </div>
    <?= $this->Form->end(); ?>
<?php endif; ?>


<?php
if (count($belongsToMany) > 0):

    $modVariable = Inflector::variable($this->request->controller);
    $modSingularize = Inflector::singularize($this->request->controller);
    $modUnderscore = Inflector::underscore($modSingularize);
    $mode = TableRegistry::get($this->request->plugin . '.' . $this->request->controller);
    $displayField = $mode->displayField();

    foreach ($belongsToMany as $bTMany):
        $variable_alias = Inflector::variable($bTMany['alias']);
        $humanize_alias = Inflector::humanize($bTMany['alias']);
        $singularize_alias = Inflector::singularize($bTMany['alias']);
        $camelize_alias = Inflector::camelize($bTMany['joinTable']);
        $underscore_alias = Inflector::underscore($singularize_alias);

        $belongsTo = [];

        $headers = [
            $bTMany['foreignKey'] => [
                'label' => $modSingularize,
                'map' => [Inflector::variable($modSingularize), $bTMany['foreignKey']],
                'filter' => 'list'
            ],
            $bTMany['targetForeignKey'] => [
                'label' => $humanize_alias,
                'map' => [Inflector::variable($singularize_alias), $bTMany['targetForeignKey']],
                'filter' => 'list'
            ],            
            
        ];

        Configure::write('Admin.Tables.' . $camelize_alias . '.header', $headers);
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?= Inflector::humanize($bTMany['joinTable']); ?></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>                    
                        </div>                
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered it_dataTable">
                                <?= $this->cell('Templates.Tables::header', [$camelize_alias, 'thead']); ?>
                                <?= $this->cell('Templates.Tables::header', [$camelize_alias, 'tfoot']); ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    endforeach;
endif;
?>