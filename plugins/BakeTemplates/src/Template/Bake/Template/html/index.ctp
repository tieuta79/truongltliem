<%
use Cake\Utility\Inflector;

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
%>

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
            $headers[$field] = [
                'label' => __d('ittvn',$field),
                'sort' => true,
                'filter'=>'text'
            ];
        }else if($schema->columnType($field)=='boolean'){
            $headers[$field] = [
                'label' => __d('ittvn',$field),
                'sort' => true,
                'filter'=>'list'
            ];            
        } else {
            $headers[$field] = [
                'label' => __d('ittvn',$field),
                'sort' => true,
                'filter'=>'text'
            ];
        }
    }
}
%>
use Cake\Utility\Inflector;

$plugin = false;
if (isset($this->request->plugin) && !empty($this->request->plugin)) {
    $plugin = $this->request->plugin;
}
$variable = Inflector::variable($this->request->controller);
$dataRows = isset(${$variable}) ? ${$variable} : [];

$this->Admin->adminScript('index');

\Cake\Core\Configure::write('Admin.Tables.<%= $modelClass; %>.header', [<%
    foreach($headers as $f=>$header):
        if(!is_array($header)){
            echo "'".$f."'"; %>=><% if(is_string($header)){echo "'".$header."'"; }else{ echo $header;} %>,
    <%                
        }else{
            echo "'".$f."'"; %>=>[
                <% 
                foreach($header as $f1=>$header1):
                    if(!is_array($header1)){
                        echo "'".$f1."'"; %>=><% if(is_string($header1)){echo "'".$header1."'"; }else{ echo $header1;} %>,
                <%                
                    }else{
                        echo "'".$f1."'"; %>=>[
                        <%
                        foreach($header1 as $f2=>$header2):
                            echo "'".$f2."'"; %>=><% if(is_string($header2)){echo "'".$header2."'"; }else{ echo $header2;} %>,
                    <% 
                        endforeach;
                        %>
                            ],
                        <%
                    }

                endforeach;
                %>
            ],
    <%                
        }
    endforeach;
%>]);
$this->assign('title', __d('ittvn', '<%= $pluralHumanName %>'));

$this->start('title-bar');
echo $this->Html->link(
        '<i class="fa fa-plus"></i> ' . __d('ittvn', 'Add new'), ['plugin' => $plugin, 'controller' => $this->request->controller, 'action' => 'add'], ['escape' => false, 'class' => 'btn btn-success']
);
$this->end();

$this->Html->addCrumb(__d('ittvn', '<%= $pluralHumanName %>'), ['controller' => '<%= $modelClass %>', 'action' => 'index']);
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <?php
                    echo '<i class="fa fa-circle-o"></i> ' . __d('ittvn', 'All <%= ucfirst($singularVar) %>');

                    if (isset($this->request->query['trash']) && $this->request->query['trash'] == 1) {
                        echo ' ' . __d('ittvn', '(Trash)');
                    }
                    ?>
                </h3>
                <div class="box-tools pull-right">
                    <div class="btn-group">
                        <button class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown"><i class="fa fa-wrench"></i></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><?= $this->Html->link(__d('ittvn', 'All'), ['action' => 'index']) ?></li>
                            <li><?= $this->Html->link(__d('ittvn', 'Trash'), ['action' => 'index', 'trash' => 1]) ?></li>
                            <li class="divider"></li>
                            <li><a href="#">Help</a></li>
                        </ul>
                    </div>
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <?= $this->Flash->render(); ?>
                <?= $this->cell('Cms.Tables::filter'); ?>
                <div class="row row-table">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="it_dataTable table table-bordered table-striped dataTable">
                                <?= $this->cell('Cms.Tables::header', [null,'thead']); ?>
                                <?= $this->cell('Cms.Tables::rows', [null, $dataRows]); ?>
                                <?= $this->cell('Cms.Tables::header', [null,'tfoot']); ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>