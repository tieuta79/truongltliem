<?php
use Cake\Core\Configure;
$col = ceil(12 / (count($action_right_selects) + 1));
foreach ($action_right_selects as $key => $action_right_select):
    echo $this->Form->input($key, [
        'type' => 'select',
        'label' => false,
        'options' => $action_right_select['list'],
        'value' => isset($this->request->query[$key]) ? $this->request->query[$key] : '',
        'empty' => __d('ittvn',$action_right_select['label']),
        'class' => 'form-control input-sm '.$key,
        'onchange' => 'this.form.submit()',
        'templates' => ['inputContainer' => '<div class="col-sm-' . $col . ' {{type}} {{require}}">{{content}}</div>']
    ]);
endforeach;
echo $this->Form->input('limit', [
    'type' => 'select',
    'label' => false,
    'options' => Configure::read('Settings.Paging.limit'),
    'value' => isset($this->request->query['limit']) ? $this->request->query['limit'] : 10,
    'default' => 10,
    'class' => 'form-control input-sm limit_paging',
    'onchange' => 'this.form.submit()',
    'templates' => ['inputContainer' => '<div class="col-sm-' . $col . ' {{type}} {{require}}">{{content}}</div>']
]);
?>