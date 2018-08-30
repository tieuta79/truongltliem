<?php if ($languages->count() > 1): ?>
    <ul class="header-dropdown-list">
        <li>
            <?=
            $this->Html->link(
                    $this->Html->image('blank.gif', ['class' => 'flag ' . $language_admin[0]->class, 'alt' => $language_admin[0]->name]) .
                    ' <span> ' . $language_admin[0]->name . ' </span> <i class="fa fa-angle-down"></i>'
                    , '#', ['escape' => false, 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown']
            );
            ?>
            <ul class="dropdown-menu pull-right">
                <?php foreach ($languages as $language): ?>
                    <li class="<?= ($language->id == $language_admin[0]->id) ? 'active' : ''; ?>">
                        <?=
                        $this->Html->link(
                                $this->Html->image('blank.gif', ['class' => 'flag ' . $language->class, 'alt' => $language->name]) .
                                ' ' . $language->name
                                , 'javascript:void(0);', ['escape' => false]
                        );
                        ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
    </ul>
<?php endif; ?>