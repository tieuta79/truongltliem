<?php if ($contents->count() > 0): ?>
    <ul>
        <?php foreach ($contents as $content): ?>
            <li>
                <?=
                $this->Html->link(
                        $content->name, ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'posts', 'slug' => $content->slug], ['class' => 'title-' . $content->id]
                );
                ?>
                <span class="pull-right">(<?= sprintf(__d('ittvn', 'Views: %s'), $content->hits); ?>)</span>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>