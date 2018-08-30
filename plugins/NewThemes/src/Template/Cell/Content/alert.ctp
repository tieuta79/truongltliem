
<div class="card card-outline-info mb-2">
    <div class="card-header bg-light-blue text-center bg-card-title">
        » <?= isset($data['title']) ? $data['title'] : ''; ?> «
    </div>
    <ul class="list-group notify">
        <marquee behavior="scroll" align="center" direction="up" scrollamount="2" scrolldelay="15" onmouseover="this.stop()" onmouseout="this.start()" style="font-family: Arial;"  height="250">
            <?php foreach ($contents as $post): ?>
                <li class="list-group-item">
                    <h6>
                        <?= $this->Html->link($post->name, ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'posts', 'slug' => $post->slug]); ?>
                    </h6>
                    <p>
                        <?= $post->description; ?>
                    </p>
                </li>
            <?php endforeach; ?>
        </marquee>
    </ul>
</div>