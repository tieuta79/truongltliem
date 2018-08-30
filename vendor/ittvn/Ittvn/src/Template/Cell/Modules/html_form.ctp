<div class="form-group">
    <label class="col-sm-12">Title</label>
    <div class="col-sm-12"><input type="text" class="form-control input-sm block-cell-title" name="title" value="<?= isset($data['title'])?$data['title']:''; ?>" /></div>
</div>
<?php 
//pr($data);
    echo $this->Form->input('translate',[
        'label' => ['text' => __d('ittvn', 'Translate'), 'class' => 'col-sm-2'],
        'id' => 'translate' ,
        'type' => 'select',
        'class' => 'form-control input-sm choose_meta_translate',
        'options' => $languages,
        'empty' => __d('ittvn', 'Select All'),
        'value' => isset($data['translate']) ? $data['translate'] : '',
        'templates' => [
            'select' => '<div class="col-sm-12"><select name="{{name}}"{{attrs}}>{{content}}</select></div>',
        ]
    ]);
?>
<div class="form-group">
    <label class="col-sm-12">Html Form</label>
    <div class="col-sm-12"><textarea class="form-control input-sm" name="html"><?= isset($data['html'])?$data['html']:''; ?></textarea></div>
</div>
<div class="form-group">
    <label class="col-sm-12">Layout</label>
    <div class="col-sm-12"><input type="text" class="form-control input-sm" name="layout" value="<?= isset($data['layout'])?$data['layout']:''; ?>" /></div>
</div>