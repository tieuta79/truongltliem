<?php
foreach ($content as &$article) {
    unset($article->generated_html);
}
echo json_encode(compact('content'));
//use Cake\Utility\Inflector;
//
//$singularize = Inflector::singularize($content_type);
//$pluralize = Inflector::pluralize($content_type);
//$this->assign('title', __d('ittvn', 'View ' . Inflector::humanize($pluralize)));
//$this->extend('/Admin/Common/view');
//$this->Html->addCrumb(__d('ittvn', Inflector::humanize($pluralize)), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'index', $content_type]);
//$this->Html->addCrumb(__d('ittvn', 'View ' . Inflector::humanize($pluralize)), $this->request->here);
////custom box action
//$this->start('action-view');
?>

<?php //$this->end(); ?>