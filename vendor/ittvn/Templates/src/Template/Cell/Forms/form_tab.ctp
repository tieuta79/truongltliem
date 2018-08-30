<?php

use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
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
        echo $this->Form->create(${$frmVariable}, $form_options);
    endif;
    ?>  
<div class="row">
    <div class="col-xs-12 col-md-9">
        <div class="jarviswidget jarviswidget-color-orange" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-sortable="true">
            <header>
                <h2>
                        <?php
                        if (isset($this->viewVars['title_form']) && !empty($this->viewVars['title_form'])):
                            echo __d('ittvn', $this->viewVars['title_form']);
                        else:
                            echo __d('ittvn', Inflector::pluralize($this->request->controller));
                        endif;
                        ?>            
                </h2>
            </header>
            <div>
                <div class="jarviswidget-editbox">

                </div>

                <div class="widget-body">
                        <?php if (count($positionMain) > 0): ?>
                    <div class="tabs-left">
                        <ul class="nav nav-tabs tabs-left" id="demo-pill-nav">
                                    <?php
                                    $i = 0;
                                    foreach ($positionMain as $key => $block):
                                        ?>
                            <li class="<?= $i++ == 0 ? 'active' : ''; ?>">
                                            <?= $this->Html->link(isset($block['label']) ? __d('ittvn', $block['label']) : __d('ittvn', $key), '#tab-' . $key, ['data-toggle' => 'tab']); ?>
                            </li>
                                    <?php endforeach; ?>

                                    <?php if (Configure::check('Admin.Table.' . $this->request->controller . '.tabs') && $this->request->action == 'edit'): ?>
                                        <?php foreach (Configure::read('Admin.Table.' . $this->request->controller . '.tabs') as $tab): ?>
                            <li>
                                                <?= $this->Html->link(__d('ittvn', $tab['label']), $tab['url'], $tab['options']); ?>
                            </li>                        
                                        <?php endforeach; ?>
                                    <?php endif; ?>                            
                        </ul>
                        <div class="tab-content">
                                    <?php
                                    $i = 0; 
                                    foreach ($positionMain as $key => $block):
                                        ?>
                            <div class="tab-pane <?= $i++ == 0 ? 'active' : ''; ?>" id="tab-<?= $key; ?>">
                                            <?php $block = Hash::remove($block, 'label'); ?>
                                            <?= $this->Admin->inputs($block); ?>
                            </div>
                                    <?php endforeach; ?>                                    
                        </div>
                    </div>    
                        <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
    <div class="col-xs-12 col-md-3 sidebarF">
            <?php
            if (count($positionSidebar) > 0):
                $i = 0;
                foreach ($positionSidebar as $key => $block):
                    ?>            
        <div class="jarviswidget jarviswidget-color-orange" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-sortable="true">
            <header>
                <h2><?= isset($block['label']) ? __d('ittvn', $block['label']) : __d('ittvn', $key); ?></h2>
            </header>
                        <?php $block = Hash::remove($block, 'label'); ?>
            <div>
                <div class="jarviswidget-editbox">

                </div>           
                <div class="widget-body">
                                <?= $this->Admin->inputs($block); ?>  
                                <?php if ($i++ == 0): ?>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-sm btn-save pull-left" data-toggle="tooltip" title="Save">
                                    <i class="fa fa-save"></i> <?= __d('ittvn','Save'); ?>
                                </button> 
                                                <?php
                                                if (isset($this->viewVars['action_form'])):
    echo $this->viewVars['action_form'];
else:
                                                if (isset(${$frmVariable}->id)):
                                                    echo $this->Html->link(
                                                            '<i class="fa fa-trash-o"></i> ' . __d('ittvn', 'Delete'), ['plugin' => $this->request->plugin, 'controller' => $this->request->controller, 'action' => 'delete', ${$frmVariable}->id], ['class' => 'btn btn-danger btn-sm pull-right delete_submit', 'data-toggle' => 'tooltip', 'title' => 'Delete', 'escape' => false]
                                                    );
                                                endif;
                                                endif;
                                                ?>                                            
                            </div>
                        </div>
                    </div> 
                                <?php endif; ?>                                  
                </div>
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