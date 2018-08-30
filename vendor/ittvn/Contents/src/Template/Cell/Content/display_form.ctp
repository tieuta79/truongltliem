<?php

use Ittvn\Utility\Language;
?>
<div class="form-group">
    <label class="col-sm-2 control-label"><?= __d('ittvn', 'Title'); ?></label>
    <div class="col-sm-10"><input type="text" class="form-control input-sm block-cell-title" name="title" value="<?= isset($data['title']) ? $data['title'] : '' ?>" /></div>
</div>

<?php
echo $this->FOrm->input('meta_type', [
    'label' => ['text' => __d('ittvn', 'Post Type'), 'class' => 'col-sm-2 control-label'],
    'id' => 'meta-type-' . $data['id'],
    'type' => 'select',
    'class' => 'form-control input-sm choose_meta_type',
    'options' => $metaTypes,
    'value' => isset($data['meta_type']) ? $data['meta_type'] : '',
    'templates' => [
        'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
        'select' => '<div class="col-sm-10"><select name="{{name}}"{{attrs}}>{{content}}</select></div>',
    ]
]);

if (Language::getLanguages()->count() > 1) {
    echo $this->form->input('translate', [
        'label' => ['text' => __d('ittvn', 'Translate'), 'class' => 'col-sm-2 control-label'],
        'id' => 'translate',
        'type' => 'select',
        'class' => 'form-control input-sm choose_meta_translate',
        'options' => $languages,
        'empty' => __d('ittvn', 'Select All'),
        'value' => isset($data['translate']) ? $data['translate'] : '',
        'templates' => [
            'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
            'select' => '<div class="col-sm-10"><select name="{{name}}"{{attrs}}>{{content}}</select></div>',
        ]
    ]);
}

echo $this->FOrm->input('meta_category', [
    'label' => ['text' => __d('ittvn', 'Category Type'), 'class' => 'col-sm-2 control-label'],
    'id' => 'meta-category-' . $data['id'],
    'type' => 'select',
    'class' => 'form-control input-sm choose_meta_category',
    'options' => $metaCategories,
    'empty' => __d('ittvn', 'Select All'),
    'value' => isset($select_metaCategory_id) ? $select_metaCategory_id : '',
    'templates' => [
        'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
        'select' => '<div class="col-sm-10"><select name="{{name}}"{{attrs}}>{{content}}</select></div>',
    ]
]);

echo $this->FOrm->input('category', [
    'label' => ['text' => __d('ittvn', 'Category'), 'class' => 'col-sm-2 control-label'],
    'id' => 'category-' . $data['id'],
    'type' => 'select',
    'class' => 'form-control input-sm choose_category',
    'options' => isset($categories) ? $categories : [],
    'empty' => __d('ittvn', 'Select All'),
    'default' => isset($select_category_id) ? $select_category_id : '',
    'templates' => [
        'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
        'select' => '<div class="col-sm-10"><select name="{{name}}"{{attrs}}>{{content}}</select></div>',
    ]
]);

echo $this->FOrm->input('post', [
    'label' => ['text' => __d('ittvn', 'Content'), 'class' => 'col-sm-2 control-label'],
    'id' => 'post-' . $data['id'],
    'type' => 'select',
    'class' => 'form-control input-sm choose_post',
    'options' => $contents,
    'value' => isset($data['post']) ? $data['post'] : '',
    'empty' => __d('ittvn', 'Select All'),
    'templates' => [
        'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
        'select' => '<div class="col-sm-10"><select name="{{name}}"{{attrs}}>{{content}}</select></div>',
    ]
]);

echo $this->FOrm->input('limit', [
    'label' => ['text' => __d('ittvn', 'Limit'), 'class' => 'col-sm-2 control-label'],
    'id' => 'limit-' . $data['id'],
    'type' => 'text',
    'class' => 'form-control input-sm',
    'value' => isset($data['limit']) ? $data['limit'] : '',
    'templates' => [
        'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
        'input' => '<div class="col-sm-10"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
    ]
]);

echo $this->Form->input('readmore', [
    'type' => 'checkbox',
    'label' => ['text' => __d('ittvn', 'Show read more'), 'class' => 'col-sm-4 control-label text-left', 'style' => 'padding-left:15px;'],
    'id' => 'readmore-' . $data['id'],
    'class' => 'form-control',
    'checked' => isset($data['readmore']) ? intval($data['readmore']) : 0,
    'templates' => [
        'inputContainer' => '<div class="form-group {{required}}"><div class="smart-form">{{content}}</div></div>',
        'nestingLabel' => '<label{{attrs}}>{{text}}</label> {{hidden}}{{input}}',
        'checkbox' => '<div class="col-sm-5"><label class="checkbox"><input type="checkbox" name="{{name}}"{{attrs}}> <i></i></label></div>',
    ]
]);

echo $this->FOrm->input('layout', [
    'label' => ['text' => __d('ittvn', 'Layout'), 'class' => 'col-sm-2 control-label'],
    'id' => 'layout-' . $data['id'],
    'type' => 'text',
    'class' => 'form-control input-sm',
    'value' => isset($data['layout']) ? $data['layout'] : '',
    'templates' => [
        'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
        'input' => '<div class="col-sm-10"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
    ]
]);
?>