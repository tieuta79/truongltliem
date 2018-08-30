<li class="dd-item" data-id="<?= $menu->id; ?>">
    <div class="dd-handle">
        <span class="title_menu"><?= $menu->name; ?></span>
        <div class="toolbar-widget pull-right">           
            <small style="font-style: italic">
                <?php
                if (!empty($menu->content_id)) {
                    echo $menu->metaContent;
                } else if (!empty($menu->category_id)) {
                    echo $menu->metaCategory;
                } else {
                    echo __d('ittvn', 'Custom link');
                }
                ?>
            </small>
            &nbsp;&nbsp;
            <i class="fa fa-pencil-square-o" data-toggle="collapse" data-target="#<?= $menu->id; ?>"></i> &nbsp;&nbsp;
            <i class="fa fa-trash text-danger remove_menu"></i>
        </div>
    </div>

    <div id="<?= $menu->id; ?>" class="collapse box_widget form-horizontal">
        <?php
        echo $this->Form->input('menus.' . $menu->id . '.id', ['type' => 'hidden', 'class' => 'form-control input-sm', 'value' => $menu->id]);
        echo $this->Form->input('menus.' . $menu->id . '.parent_id', ['type' => 'hidden', 'class' => 'form-control input-sm', 'value' => (isset($menu->parent_id) ? $menu->parent_id : '')]);
        echo $this->Form->input('menus.' . $menu->id . '.url', ['type' => 'hidden', 'class' => 'form-control input-sm', 'value' => $menu->url]);

        if (empty($menu->content_id)):
            if (!empty($menu->category_id)):
                echo $this->Form->input('menus.' . $menu->id . '.category_id', ['type' => 'hidden', 'class' => 'form-control input-sm', 'value' => $menu->category_id]);
            endif;
        else:
            echo $this->Form->input('menus.' . $menu->id . '.content_id', ['type' => 'hidden', 'class' => 'form-control input-sm', 'value' => $menu->content_id]);
        endif;

        echo $this->Form->input('menus.' . $menu->id . '.name', [
            'type' => 'text',
            'label' => ['text' => __d('ittvn', 'Name'), 'class' => 'col-sm-2 control-label'],
            'class' => 'form-control input-sm change_title_menu',
            'value' => $menu->name,
            'templates' => [
                'input' => '<div class="col-sm-10"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
            ]
        ]);

        echo $this->Form->input('menus.' . $menu->id . '.slug', [
            'type' => 'text',
            'label' => ['text' => __d('ittvn', 'Slug'), 'class' => 'col-sm-2 control-label'],
            'class' => 'form-control input-sm',
            'value' => $menu->slug,
            'templates' => [
                'input' => '<div class="col-sm-10"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                'inputContainer' => '<div class="form-group {{type}}{{required}}" style="display:none">{{content}}</div>',
            ]
        ]);

        echo $this->Form->input('menus.' . $menu->id . '.description', [
            'type' => 'textarea',
            'label' => ['text' => __d('ittvn', 'Description'), 'class' => 'col-sm-2 control-label'],
            'class' => 'form-control input-sm',
            'value' => $menu->description,
            'templates' => [
                'textarea' => '<div class="col-sm-10"><textarea name="{{name}}"{{attrs}}>{{value}}</textarea></div>',
            ]
        ]);

        echo $this->Form->input('menus.' . $menu->id . '.attributes', [
            'type' => 'textarea',
            'label' => ['text' => __d('ittvn', 'Attributes'), 'class' => 'col-sm-2 control-label'],
            'class' => 'form-control input-sm',
            'value' => $menu->attributes,
            'templates' => [
                'textarea' => '<div class="col-sm-10"><textarea name="{{name}}"{{attrs}}>{{value}}</textarea></div>',
            ]
        ]);
        
        echo $this->Form->input('menus.' . $menu->id . '.is_dropdown', [
            'type' => 'checkbox',
            'label' => ['text' => __d('ittvn', 'Dropdown Menu'), 'class' => 'col-sm-2 control-label'],
            'class' => 'form-control',
            'checked' => intval($menu->is_dropdown),
            'templates' => [
                'inputContainer' => '<div class="form-group {{required}}"><div class="smart-form">{{content}}</div></div>',
                'nestingLabel' => '<label{{attrs}}>{{text}}</label> {{hidden}}{{input}}',
                'checkbox' => '<div class="col-sm-1"><label class="checkbox"><input type="checkbox" name="{{name}}"{{attrs}}> <i></i></label></div>',
            ]
        ]);
        ?>          
    </div>

    <?php if (count($menu['children']) > 0): ?>
        <ol class="dd-list">
            <?php foreach ($menu['children'] as $child): ?>    
                <?= $this->element('list_menu_admin', ['menu' => $child]); ?>
            <?php endforeach; ?>
        </ol>
    <?php endif; ?>
</li>