<?php

use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
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
        echo $this->Form->create(${$frmVariable}, $form_options);
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
                                    <button type="submit" class="btn btn-success btn-sm pull-left" data-toggle="tooltip" title="Save"><i class="fa fa-save"></i> Save</button>
                                    <?php
                                    if (isset(${$frmVariable}->id)):
                                        echo $this->Html->link(
                                                '<i class="fa fa-trash-o"></i> ' . __d('ittvn', 'Delete'), ['plugin' => $this->request->plugin, 'controller' => $this->request->controller, 'action' => 'delete', ${$frmVariable}->id], ['class' => 'btn btn-danger btn-sm pull-right delete_submit', 'data-toggle' => 'tooltip', 'title' => 'Delete', 'escape' => false]
                                        );
                                    endif;
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