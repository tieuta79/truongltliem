<%
use Cake\Utility\Inflector;
use Cake\Core\Plugin;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

$fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return !in_array($schema->columnType($field), ['binary', 'text']);
    })
    ->take(7);

if (isset($modelObject) && $modelObject->behaviors()->has('Tree')) {
    $fields = $fields->reject(function ($field) {
        return $field === 'lft' || $field === 'rght';
    });
}
$plugin = '';
$model = '';
if(strpos($modelClass,'.')){
    list($plugin, $model) = explode('.',$modelClass);
}else{
    $model = $modelClass;
}

if($prefix!='Admin'){
%>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New <%= $singularHumanName %>'), ['action' => 'add']) ?></li>
<%
    $done = [];
    foreach ($associations as $type => $data):
        foreach ($data as $alias => $details):
            if (!empty($details['navLink']) && $details['controller'] !== $this->name && !in_array($details['controller'], $done)):
%>
        <li><?= $this->Html->link(__('List <%= $this->_pluralHumanName($alias) %>'), ['controller' => '<%= $details['controller'] %>', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New <%= $this->_singularHumanName($alias) %>'), ['controller' => '<%= $details['controller'] %>', 'action' => 'add']) ?></li>
<%
                $done[] = $details['controller'];
            endif;
        endforeach;
    endforeach;
%>
    </ul>
</nav>
<div class="<%= $pluralVar %> index large-9 medium-8 columns content">
    <h3><?= __('<%= $pluralHumanName %>') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
<% foreach ($fields as $field): %>
                <th><?= $this->Paginator->sort('<%= $field %>') ?></th>
<% endforeach; %>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($<%= $pluralVar %> as $<%= $singularVar %>): ?>
            <tr>
<%        foreach ($fields as $field) {
            $isKey = false;
            if (!empty($associations['BelongsTo'])) {
                foreach ($associations['BelongsTo'] as $alias => $details) {
                    if ($field === $details['foreignKey']) {
                        $isKey = true;
%>
                <td><?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?></td>
<%
                        break;
                    }
                }
            }
            if ($isKey !== true) {
                if (!in_array($schema->columnType($field), ['integer', 'biginteger', 'decimal', 'float'])) {
%>
                <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
<%
                } else {
%>
                <td><?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></td>
<%
                }
            }
        }

        $pk = '$' . $singularVar . '->' . $primaryKey[0];
%>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', <%= $pk %>]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', <%= $pk %>]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', <%= $pk %>], ['confirm' => __('Are you sure you want to delete # {0}?', <%= $pk %>)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
<% }else{ %>
<?php
<%
$headers = [];
foreach ($fields as $field) { 
    $isKey = false;
    if (!empty($associations['BelongsTo'])) {
        foreach ($associations['BelongsTo'] as $alias => $details) {
            if ($field === $details['foreignKey']) {
                $isKey = true;
                $headers[$field] = [
                    'label' => __d('ittvn',$details['property']),
                    'sort' => true,
                    'filter'=>'list',
                    'map' => [$details['property'],$details['displayField']]
                ];
                break;
            }
        }
    }
    
    if ($isKey !== true && $field!='password') {
        if (!in_array($schema->columnType($field), ['integer', 'biginteger', 'decimal', 'float'])) {
            if($field!='delete'){
                $headers[$field] = [
                    'label' => __d('ittvn',ucfirst($field)),
                    'sort' => true,
                    'filter'=>'text'
                ];
            }
        }else if($schema->columnType($field)=='boolean'){
            $headers[$field] = [
                'label' => __d('ittvn',ucfirst($field)),
                'sort' => true,
                'filter'=>'list'
            ];            
        } else {
            $headers[$field] = [
                'label' => __d('ittvn',ucfirst($field)),
                'sort' => true,
                'filter'=>'text'
            ];
        }
    }
}
//echo Plugin::path($plugin).'config'.DS.'bootstrap.php';die();
$put = "Configure::write('Admin.Tables.".$model.".header',[";
foreach($headers as $f=>$header):
    $put .= "\n\t'".$f."' => [";
    foreach($header as $f1=>$header1):
        if(!is_array($header1)){
            $put .= "\n\t\t'".$f1."' => '".$header1."',";
        }else{
            $put .= "\n\t\t'".$f1."' => [";
            foreach($header1 as $f2=>$header2):
                $put .= "\n\t\t\t'".$f2."' => '".$header2."',";
            endforeach;
            $put .= "\n\t\t],";
        }        
    endforeach;
    $put .= "\n\t],";
endforeach;
$put .= "\n]);\n\n";

$file = new File(Plugin::path($plugin).'config'.DS.'bootstrap.php', true);
$file->append($put);
$file->close();
%>
$this->assign('title', __d('ittvn', '<%= $pluralHumanName %>'));
$this->extend('/Admin/Common/index');
$this->Html->addCrumb(__d('ittvn', '<%= $pluralHumanName %>'), ['controller' => '<%= $model %>', 'action' => 'index']);
$this->assign('title-table', '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All <%= ucfirst($singularVar) %>'));
?>
<% } %>