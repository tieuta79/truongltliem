<?php foreach ($contents as $post): ?>
<li class="list-group-item">
    <h6>
        <?= $this->Html->link($post->name, ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => $post->meta_type->slug, 'slug' => $post->slug]); ?>
    </h6>
    <p>
        <?= $post->description; ?>
    </p>
</li>
<?php endforeach; ?>
