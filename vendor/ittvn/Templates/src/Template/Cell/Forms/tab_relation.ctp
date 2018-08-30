<?php

use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\Event\EventManager;
use Cake\Event\Event;

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
                        $block = Hash::remove($block, 'label');
                        $result = (new EventManager())->dispatch(new Event('Admin.View.setTabs', [
                            'helper' => $this->Admin,
                            'data' => $block,
                            'tabs' => [Inflector::humanize(Inflector::underscore($this->request->params['pass'][1]))],
                            'contentTabs' => [$this->Admin->inputs($block)]
                        ]));
                        if ($result->result && isset($result->result['tabs']) && count($result->result['tabs']) > 0) {
                            ?>            
                            <div class="tabs-container">
                                <ul class="nav nav-tabs">
                                    <?php
                                    foreach ($result->result['tabs'] as $key => $tab) {
                                        $class = '';
                                        if ($key == 0) {
                                            $class = 'active';
                                        }
                                        echo $this->Html->tag('li', $this->Html->link($tab, '#form_tab-' . $key, ['data-toggle' => 'tab']), ['class' => $class]);
                                    }
                                    ?>
                                    <?php foreach ($metaCategories as $metaCategory): ?>
                                        <li class=""><?= $this->Html->link('Add Relation' . $metaCategory->name, ['plugin' => 'Contents', 'controller' => 'Categories', 'action' => 'addRelation', $metaCategory->slug, $this->request->params['pass'][0]]); ?></li>
                                    <?php endforeach; ?>                                    
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
                        <?php } ?>
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


<?php if (!empty($listAssocTable)): ?>
    <?php
    $variable_alias = Inflector::variable($relationship['belongsToMany'][0]['alias']);
    $camelize_alias = Inflector::camelize($relationship['belongsToMany'][0]['joinTable']);
    $columns = $relationship['belongsToMany'][0]['schema']->columns();
    $belongsTo = [];
    if (count($relationship['belongsTo']) > 0) {
        $belongsTo = Hash::combine($relationship['belongsTo'], '{n}.foreignKey', '{n}.displayField');
    }

    $headers = [];
    $headers[$relationship['belongsToMany'][0]['foreignKey']] = [
        'label' => $singularize,
        'map' => [Inflector::underscore($singularize), $display_field_relation],
        'filter' => 'list'
    ];
    foreach ($columns as $column) {
        if (!in_array($column, array('id', 'delete'))) {
            if (isset($belongsTo[$column])) {
                $headers[$column . '_id'] = [
                    'label' => Inflector::humanize($column),
                    'map' => [Inflector::underscore(Inflector::singularize($relationship['belongsToMany'][0]['alias'])), $belongsTo[$column]],
                    'filter' => 'list'
                ];
            } else {
                $headers[$column . '_id'] = [
                    'label' => Inflector::humanize($column),
                    'map' => [Inflector::underscore(Inflector::singularize($relationship['belongsToMany'][0]['alias'])), $column],
                    'filter' => 'text'
                ];
            }
        }
    }

    Configure::write('Admin.Tables.' . $model_related . '.header', $headers);
    ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Inflector::humanize($relationship['belongsToMany'][0]['joinTable']); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row row-table">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="it_dataTable table table-bordered table-striped dataTable">
                                    <?= $this->cell('Templates.Tables::header', [$model_related, 'thead']); ?>
                                    <?= $this->cell('Templates.Tables::rows', [$model_related, $listAssocTable]); ?>
                                    <?= $this->cell('Templates.Tables::header', [$model_related, 'tfoot']); ?>          
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
<?php endif; ?>