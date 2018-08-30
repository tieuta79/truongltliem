<?php

use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\Event\EventManager;
use Cake\Event\Event;
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

    $title_tab = '';
    if ($this->request->action == 'add') {
        $title_tab = __d('ittvn', 'Add ' . Inflector::singularize(Inflector::humanize(Inflector::underscore($this->request->params['pass'][0]))));
    } else if ($this->request->action == 'edit') {
        $title_tab = __d('ittvn', 'Edit ' . Inflector::singularize(Inflector::humanize(Inflector::underscore($this->request->params['pass'][1]))));
    }
    ?>  
    <div class="row">
        <div class="col-xs-12 col-md-9">
            <div class="jarviswidget jarviswidget-color-orange" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-sortable="true">
                <header>
                    <h2><?= $title_tab; ?></h2>
                </header>
                <div>
                    <div class="jarviswidget-editbox">

                    </div>

                    <div class="widget-body">
                        <?php
                        if (count($positionMain) > 0):
                            $tt = $positionMain['default']['label'];
                            unset($positionMain['default']['label']);
                            $result = (new EventManager())->dispatch(new Event('Admin.View.setTabs', [
                                'form' => ${$frmVariable},
                                'helper' => $this->Admin,
                                'data' => $positionMain,
                                'tabs' => [$tt],
                                'contentTabs' => [$this->Admin->inputs($positionMain['default'])]
                            ]));
                            ?>
                            <div class="tabs-left">
                                <ul class="nav nav-tabs tabs-left" id="demo-pill-nav">
                                    <?php
                                    foreach ($result->result['tabs'] as $key => $tab) {
                                        $class = '';
                                        if ($key == 0) {
                                            $class = 'active';
                                        }
                                        echo $this->Html->tag('li', $this->Html->link($tab, '#form_tab-' . $key, ['data-toggle' => 'tab']), ['class' => $class]);
                                    }
                                    ?>                       
                                </ul>
                                <div class="tab-content">
                                    <?php
                                    foreach ($result->result['contentTabs'] as $key => $contentTab) {
                                        $class = 'tab-pane ';
                                        if ($key == 0) {
                                            $class .= 'active';
                                        }

                                        echo $this->Html->tag('div', $this->Html->tag('div', $contentTab, ['class' => 'panel-body']), ['id' => 'form_tab-' . $key, 'class' => $class]);
                                    }
                                    ?>                                 
                                </div>
                            </div>    
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-xs-12 col-md-3">
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
                                                <button type="submit" class="btn btn-success btn-sm btn-save pull-left" data-toggle="tooltip" title="Save"><i class="fa fa-save"></i> Save</button>
                                                <?php
                                                if (isset(${$frmVariable}->id)):
                                                    echo $this->Html->link(
                                                            '<i class="fa fa-trash-o"></i> ' . __d('ittvn', 'Delete'), ['plugin' => $this->request->plugin, 'controller' => $this->request->controller, 'action' => 'delete', ${$frmVariable}->id], ['class' => 'btn btn-danger btn-sm pull-right delete_submit', 'data-toggle' => 'tooltip', 'title' => 'Delete', 'escape' => false]
                                                    );
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