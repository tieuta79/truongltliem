<?php

use Cake\Utility\Inflector;

$singularize = Inflector::singularize($cat_type);
$pluralize = Inflector::pluralize($cat_type);
$this->assign('title', __d('ittvn', 'View ' . Inflector::humanize($pluralize)));
$this->extend('/Admin/Common/view');
$this->Html->addCrumb(__d('ittvn', Inflector::humanize($pluralize)), ['plugin' => 'Contents', 'controller' => 'Categories', 'action' => 'index', $cat_type]);
$this->Html->addCrumb(__d('ittvn', 'View ' . Inflector::humanize($pluralize)), $this->request->here);
//custom box action
$this->start('action-view');
?>
<div class="hr-line-dashed"></div>
<div class="form-group">
    <?=
    $this->Html->link(
            '<i class="fa fa-angle-double-left"></i> ' . __d('ittvn', 'Back'), ['plugin' => 'Contents', 'controller' => 'Categories', 'action' => 'index', $this->request->params['pass'][1]], ['class' => 'btn btn-info btn-sm', 'data-toggle' => 'tooltip', 'title' => 'Back', 'escape' => false]
    );
    ?>                 
    <?=
    $this->Html->link(
            '<i class="fa fa-pencil-square-o"></i> ' . __d('ittvn', 'Edit'), ['plugin' => 'Contents', 'controller' => 'Categories', 'action' => 'edit', $category->id, $this->request->params['pass'][1]], ['class' => 'btn btn-success btn-sm', 'data-toggle' => 'tooltip', 'title' => 'Edit', 'escape' => false]
    );
    ?> 

    <?=
    $this->Html->link(
            '<i class="fa fa-trash-o"></i> ' . __d('ittvn', 'Delete'), ['plugin' => 'Contents', 'controller' => 'Categories', 'action' => 'delete', $category->id, $this->request->params['pass'][1]], ['escape' => false, 'class' => 'btn btn-danger btn-sm pull-right', 'data-toggle' => 'tooltip', 'title' => __d('ittvn', 'Delete'), 'confirm' => __d('ittvn', 'Are you sure you want to delete # {0}?', $category->id)]
    );
    ?>
</div>
<?php $this->end(); ?>