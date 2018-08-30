<li>
    <div id="text-5" class="widget widget_text">
        <div class="widget-title">
            <h4><span><i class="icon-th-list"></i> <?= isset($data['title']) ? $data['title'] : ''; ?></span></h4>
            <div class="side-right-line"></div>
        </div>
        <div class="textwidget">
            <div class="textwidget link">
                <?php if ($contents->count() > 0): ?>
                    <ul>
                        <?php foreach ($contents as $content): ?>
                            <li>
                                <?=
                                $this->Html->link(
                                        $this->Html->image($content->image), $content->Link_meta, ['class' => $content->name, 'escape' => false, 'target' => '_blank']
                                );
                                ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
        <div class="clear"> </div>
    </div>
</li>