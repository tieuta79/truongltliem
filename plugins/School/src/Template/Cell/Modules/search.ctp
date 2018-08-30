<li>
    <div id="search-2" class="widget widget_search">
        <div class="widget-title">
            <h4><span><i class="icon-th-list"></i> <?= isset($data['title']) ? $data['title'] : ''; ?></span></h4>
            <div class="side-right-line"></div>
        </div>
        <?php echo $this->Form->create('Content',['class'=>'search_form','id'=>'searchform']); ?>
            <input type="text" value="" name="s" id="s" placeholder="Từ cần tìm" />
            <input type="submit" class="search_btn" id="searchsubmit" value="Tìm kiếm" />
            <!--<input type="hidden" name="post_type" value="post" /> -->
        <?php echo $this->Form->end(); ?>
        <div class="clear"> </div>
    </div>
</li>