<?php

use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
$metaType = TableRegistry::get('MetaTypes')->find()->where(['slug' => $this->request->params['pass'][1]])->first();
$metaCategories = TableRegistry::get('MetaCategories')->findByMetaTypeId($metaType->id)->select(['id', 'name', 'slug']);
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
                    if ($block['label'] == 'Default'):
                        ?>            
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab-1"><?= Inflector::pluralize($this->request->params['pass'][1]); ?></a></li>     
                                <?php foreach ($metaCategories as $metaCategory): ?>
                                <li class=""><?= $this->Html->link('Add '.$metaCategory->name, ['plugin' => 'Contents', 'controller' => 'Categories', 'action' => 'addRelation', $metaCategory->slug, $this->request->params['pass'][0]]); ?></li>
                                <?php endforeach;?>
                            </ul>
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <?php $block = Hash::remove($block, 'label'); ?>
                                        <?= $this->Admin->inputs($block); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>

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
                    <?php endif; ?>
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
                                    <button type="submit" class="btn btn-success btn-sm" data-toggle="tooltip" title="Save"><i class="fa fa-save"></i> Save</button>
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