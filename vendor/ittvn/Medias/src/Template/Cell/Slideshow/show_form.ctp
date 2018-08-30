<?php

use Ittvn\Utility\Language;
?>
<div class="form-group">
    <label class="col-sm-2 control-label"><?= __d('ittvn', 'Title'); ?></label>
    <div class="col-sm-10"><input type="text" class="form-control input-sm" name="title" value="<?= isset($data['title']) ? $data['title'] : '' ?>" /></div>
</div>

<?php
echo $this->Form->input('slideshow', [
    'label' => ['text' => __d('ittvn', 'Slide'), 'class' => 'col-sm-2 control-label'],
    'type' => 'select',
    'class' => 'form-control input-sm',
    'options' => $slides,
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

?>