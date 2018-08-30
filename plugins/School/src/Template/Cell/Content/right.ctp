<li>
    <div id="homecategory-2" class="widget widget_homecategory">
        <div class="widget-title">
            <h4><span><i class="icon-th-list"></i> <?= isset($data['title']) ? $data['title'] : ''; ?></span></h4>
            <div class="side-right-line"></div>
        </div>
        <?php if (isset($categories) && $categories->count() > 0): ?>
            <ul>
                <?php foreach ($categories as $category): ?>
                    <li>
                        <?=
                        $this->Html->link(
                                $category->name, ['plugin' => 'Contents', 'controller' => 'Categories', 'action' => 'view', 'type'=>$metaType->slug, 'taxonomy' => $category->meta_category->slug, 'slug' => $category->slug], ['class' => 'title-' . $category->id]
                        );
                        ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <div class="clear"> </div>
    </div>
</li>
