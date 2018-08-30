<?= $this->Form->create('Translates', ['url' => ['plugin' => 'Translates', 'controller' => 'Translates', 'action' => 'add']]); ?>
<div class="modal-body">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><i class="fa fa-bars modal-icon"></i> <?= __d('ittvn','Translate Text'); ?></h4>
    </div>
    <div class="row">              
        <div class="col-md-12">
            <div class="modal-body">
                <div class="form-group">
                    <strong><?= __d('ittvn','Static Text'); ?></strong> <br />
                    <?= $locale->msgid; ?>
                </div>
                <?php
                    echo $this->Form->input('locale_id',['type'=>'hidden','value'=>$locale->id]);
                    if($languages->count() > 0){
                        foreach($languages as $language){
                            echo $this->Form->input('language_id.'.$language->id,[
                                'type'=>'textarea',
                                'label'=>$language->name,
                                'class'=>'form-control',
                                'value' => isset($translates[$language->id])?$translates[$language->id]:''
                            ]);
                        }
                    }
                ?>                                      
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="submit_ajax btn btn-primary"><?= __d('ittvn', 'Save'); ?></button>
</div>
<?= $this->Form->end(); ?>