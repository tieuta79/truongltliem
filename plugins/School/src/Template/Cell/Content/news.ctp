<li>
    <div id="homecategory-5" class="widget widget_homecategory">
        <div class="widget-title">
            <h4><span><i class="icon-th-list"></i> <?= isset($data['title']) ? $data['title'] : ''; ?></span></h4>
            <div class="side-right-line"></div>
        </div>
        <?php if ($contents->count() > 0): ?>
            <ul>
                <?php foreach ($contents as $content): ?>
                    <li>
                        <?=
                        $this->Html->link(
                                $content->name, ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'posts', 'slug' => $content->slug], ['class' => 'title-' . $content->id]
                        );
                        ?>
                        <?php if (!empty($data['readmore'])): ?>
                            <span class="pull-right">(<?= sprintf(__d('ittvn', 'Views: %s'), $content->hits); ?>)</span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <div class="clear"> </div>
    </div>
</li>