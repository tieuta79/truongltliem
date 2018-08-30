<?php

use Settings\Utility\Setting;

$setting = new Setting();
$ring_sizes = $setting->getThemeOption('ring_sizes');
if (!empty($ring_sizes)) {
    $ring_sizes = explode("\n", $ring_sizes);
} else {
    $ring_sizes = [];
}
$this->Html->script(['//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4f98f6407c376dbd'], ['block' => true]);
?>
<div class="modal-header">
    <i class="close fa fa-times btooltip" data-toggle="tooltip" data-placement="top" title="" data-dismiss="modal" aria-hidden="true" data-original-title="Close"></i>
</div>
<div class="modal-body">
    <div class="row">              
        <div id="col-main" class="product-page col-xs-24 col-sm-24 ">
            <div itemscope="" itemtype="<?= $this->request->here; ?>">
                <meta itemprop="url" content="<?= $this->request->here; ?>">
                <div id="product" class="content clearfix">      
                    <div id="product-image" class="product-image">     
                        <div class="image featured col-smd-12 col-sm-12 fadeInUp animated" data-animate="fadeInUp"> 
                            <?= $this->Html->link($this->Html->image($this->Layout->resizeImage($content->image, '555x555')), $content->image, ['rel' => 'prettyPhoto', 'escape' => false, 'title' => $content->name]); ?>
                        </div>
                        <div id="product-information" class="product-information col-sm-12">        
                            <div id="product-header" class="clearfix">
                                <h1 id="page-title" class="">
                                    <span itemprop="name"><?= $content->name; ?></span>
                                </h1>                                                        
                                <div id="product-info-left">
                                    <div class="description">
                                        <p><?= $content->excerpt ?></p>
                                    </div>
                                </div>          
                                <div id="product-info-right">     
                                    <div class="col-sm-24 group-variants">
                                        <div id="product-actions" class="options">
                                            <div class="row">
                                                <div id="purchase" class="col-sm-12">
                                                    <div class="code_product">
                                                        <span><?= sprintf(__d('ittvn', 'Id Product:  %s'), $content->Id_Products_meta); ?></span>
                                                    </div>                                                    
                                                    <div class="detail-price">
                                                        <span class="price"><?= $this->Layout->formatCurrency($content->Price_meta); ?></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <?= $this->Form->input('ring_size', ['type' => 'select', 'label' => false, 'empty' => __d('ittvn', 'Size'), 'class' => 'form-control', 'options' => $ring_sizes]); ?>                                                
                                                </div>           
                                                <div class="col-sm-12">
                                                    <?= $this->Html->link(__d('ittvn', 'Sizing guide'), [], ['class' => 'guid_size']) ?>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="others-bottom col-sm-12">
                                                    <button id="add-to-cart" class="btn btn-1 add-to-cart" data-parent=".product-information" type="submit" name="add">Add to Cart</button>
                                                </div>                                            
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-24 share_social">
                                                    <div class="addthis_native_toolbox"></div>
                                                </div>
                                            </div>                                    
                                        </div>                                                                                                                                                                                                            
                                    </div>              
                                </div>
                            </div>
                        </div>                                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>