<?php if ($this->request->query(['slug'])): ?>
    <figure class="figure">
        <?= $this->Layout->screenshot($content->Theme_meta, 'screenshot.png'); ?>
        <?= $this->Form->input('theme_name', ['type' => 'hidden', 'value' => $content->Theme_meta]); ?>
        <?= $this->Form->input('database_demo_name', ['type' => 'hidden', 'value' => $content->Database_demo_meta]); ?>
    </figure>
<?php else: ?>
    <figure class="figure">
        <?= $this->Layout->screenshot($setting->value, $theme_info->site->image); ?>
        <?= $this->Form->input('database_demo_name', ['type' => 'hidden', 'value' => $contentmeta->value]);  ?>
    </figure>
<?php endif; ?>
