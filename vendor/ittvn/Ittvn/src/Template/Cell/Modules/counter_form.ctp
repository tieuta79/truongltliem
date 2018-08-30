<div class="form-group">
    <label class="col-sm-12">Title</label>
    <div class="col-sm-12"><input type="text" class="form-control input-sm block-cell-title" name="title" value="<?= isset($data['title'])?$data['title']:''; ?>" /></div>
</div>
<div class="form-group">
    <label class="col-sm-12">Html Form</label>
    <div class="col-sm-12"><textarea class="form-control input-sm" name="html"><?= isset($data['html'])?$data['html']:''; ?></textarea></div>
</div>
<div class="form-group">
    <label class="col-sm-12">Layout</label>
    <div class="col-sm-12"><input type="text" class="form-control input-sm" name="layout" value="<?= isset($data['layout'])?$data['layout']:''; ?>" /></div>
</div>