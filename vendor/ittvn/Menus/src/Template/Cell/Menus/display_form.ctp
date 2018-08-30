<?php

use Ittvn\Utility\Language;

echo $this->Form->input('title', [
    'type' => 'text',
    'label' => ['class' => 'col-sm-12', 'text' => __d('ittvn', 'Title')],
    'class' => 'form-control input-sm change_title_block',
    'value' => isset($data['title']) ? $data['title'] : '',
    'templates' => [
        'input' => '<div class="col-sm-12"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
    ]
]);
if (Language::getLanguages()->count() > 1) {
    echo $this->Form->input('translate', [
        'label' => ['text' => __d('ittvn', 'Translate'), 'class' => 'col-sm-2'],
        'id' => 'translate',
        'type' => 'select',
        'class' => 'form-control input-sm choose_meta_translate',
        'options' => $languages,
        'empty' => __d('ittvn', 'Select All'),
        'value' => isset($data['translate']) ? $data['translate'] : '',
        'templates' => [
            'select' => '<div class="col-sm-12"><select name="{{name}}"{{attrs}}>{{content}}</select></div>',
        ]
    ]);
}

echo $this->Form->input('menutype', [
    'type' => 'select',
    'label' => ['class' => 'col-sm-12', 'text' => __d('ittvn', 'Menu')],
    'class' => 'form-control input-sm',
    'options' => $menutypes->toArray(),
    'default' => isset($data['menutype']) ? $data['menutype'] : '',
    'templates' => [
        'select' => '<div class="col-sm-12"><select name="{{name}}"{{attrs}}>{{content}}</select></div>',
    ]
]);

echo $this->Form->input('layout', [
    'type' => 'text',
    'label' => ['class' => 'col-sm-12', 'text' => __d('ittvn', 'Layout')],
    'class' => 'form-control input-sm',
    'value' => isset($data['layout']) ? $data['layout'] : '',
    'templates' => [
        'input' => '<div class="col-sm-12"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
    ]
]);
?>