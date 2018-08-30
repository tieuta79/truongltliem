<?php

if ($languages->count() > 0) {
    foreach ($languages as $language) {
        echo $this->Html->link($language->name, ['plugin' => 'Contents', 'controller' => 'Contents', 'action' => 'view', 'type' => 'pages', 'slug' => 'shop']);
    }
}
?>