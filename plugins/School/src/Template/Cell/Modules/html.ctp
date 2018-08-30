<li>
    <div id="text-2" class="widget widget_text">
        <div class="widget-title">
            <h4><span><i class="icon-th-list"></i> <?= isset($data['title']) ? $data['title'] : ''; ?></span></h4>
            <div class="side-right-line"></div>
        </div>
        <div class="textwidget">
            <?= isset($data['html']) ? $data['html'] : ''; ?>
        </div>
        <div class="clear"> </div>
    </div>
</li>