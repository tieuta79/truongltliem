<li>
    <div class="two-box"> <!-- News category-1 -->    
        <h2 class="top-cat">
            <?=
            $this->Html->link(
                    (isset($data['title']) ? $data['title'] : '') . ' <i class="icon-th-list"></i>', ['plugin' => 'Contents', 'controller' => 'Categories', 'action' => 'view', 'type' => 'posts', 'taxonomy' => 'categories', 'slug' => 'doan-doi'], ['escape' => false]
            );
            ?>	
        </h2>
        <div class="right-line"></div>
        <?php if ($contents->count() > 0): ?>                            
            <div class="box-inner">
                <?php foreach ($contents as $k => $content): ?>
                    <?php if ($k == 0): ?>
                        <div class="two-cat-top-item">
                            <?=
                            $this->Html->link(
                                    $this->Html->image($content->image, ['class' => 'attachment-mgn-slider wp-post-image']), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'posts', 'slug' => $content->slug], ['class' => 'title-' . $content->id, 'escape' => false]
                            );
                            ?>
                            <div class="head-comm">
                                <h3>
                                    <?=
                                    $this->Html->link(
                                            $content->name, ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'posts', 'slug' => $content->slug], ['class' => 'title-' . $content->id]
                                    );
                                    ?>
                                    <br /><span class="post-date"><i class="icon-calendar"></i> <?= $content->created->format('d M'); ?> Năm <?= $content->created->format('Y'); ?></span>
                                </h3>
                            </div>
                            <div class="clearfix"></div>
                            <p>
                                <?=
                                $this->Text->truncate($content->excerpt, 150, [
                                    'ellipsis' => '...',
                                    'exact' => false
                                ])
                                ?><br/>
                                <?php
                                if (!empty($data['readmore'])) {
                                    echo $this->Html->link(
                                            __d('ittvn', 'Xem tiếp'), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'posts', 'slug' => $content->slug], ['class' => 'rmore']
                                    );
                                }
                                ?>
                            </p>
                        </div>
                    <?php else: ?>
                        <?php if ($k == 1): ?>
                            <div class="bot-item">
                                <ul>
                                <?php endif; ?>

                                <li>
                                    <?=
                                    $this->Html->link(
                                            $this->Html->image($content->image, ['class' => 'attachment-55x55', 'width' => 55, 'height' => 55]), ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'posts', 'slug' => $content->slug], ['class' => 'title-' . $content->id, 'escape' => false]
                                    );
                                    ?>
                                    <h3>
                                        <?=
                                        $this->Html->link(
                                                $content->name, ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'posts', 'slug' => $content->slug], ['class' => 'title-' . $content->id]
                                        );
                                        ?>
                                    </h3>
                                    <span class="clock"> <i class="icon-calendar-empty"></i> <?= $content->created->format('d/m/Y'); ?></span>
                                </li>
                                <?php if ($k == $contents->count()): ?>
                                </ul>
                            </div> <!-- bot-item -->
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div> <!-- box-inner -->
        <?php endif ?>
    </div> <!-- two-box -->
</li>