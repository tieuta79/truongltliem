<div class="box_style_1 expose">
    <?php if ($success == true): ?>
        <div class="text-center">
            <p><i class="icon-ok-circled" style="font-size:75px; color:#83c99f"></i></p>
            <p><?= __d('ittvn', '<strong>Request Successfully Sent!</strong><br />We will contact you shortly to confirm your request!'); ?></p>
        </div>	
    <?php else: ?>
        <?= $this->Form->create($checkroom); ?>
        <h3 class="inner"><?= __d('ittvn', 'Check Availability'); ?></h3>
        <div class="row">
            <?php
            echo $this->Form->input('content_id', ['type' => 'hidden', 'value' => $content_id]);
            echo $this->Form->input('checkin', [
                'label' => __d('ittvn', 'Check in'),
                'class' => 'date-pick form-control',
                'data-date-format' => 'M d, D',
                'templates' => [
                    'inputContainer' => '<div class="col-md-6 col-sm-6"><div class="form-group {{type}}{{required}}">{{content}}</div></div>',
                    'inputContainerError' => '<div class="col-md-6 col-sm-6"><div class="form-group {type}}{{{required}} has-error">{{content}}{{error}}</div></div>',
                    'error' => '<label for="" generated="true" class="error">{{content}}</label>',
                    'label' => '<label {{attrs}}><i class="icon-calendar-7"></i> {{text}}</label>',
                ]
            ]);

            echo $this->Form->input('checkout', [
                'label' => __d('ittvn', 'Check out'),
                'class' => 'date-pick form-control',
                'data-date-format' => 'M d, D',
                'templates' => [
                    'inputContainer' => '<div class="col-md-6 col-sm-6"><div class="form-group {{type}}{{required}}">{{content}}</div></div>',
                    'inputContainerError' => '<div class="col-md-6 col-sm-6"><div class="form-group {type}}{{{required}} has-error">{{content}}{{error}}</div></div>',
                    'error' => '<label for="" generated="true" class="error">{{content}}</label>',
                    'label' => '<label {{attrs}}><i class="icon-calendar-7"></i> {{text}}</label>',
                ]
            ]);
            ?>
        </div>
        <div class="row">
            <?php
            echo $this->Form->input('adults', [
                'label' => __d('ittvn', 'Adults'),
                'class' => 'qty2 form-control',
                'default' => 1,
                'templates' => [
                    'inputContainer' => '<div class="col-md-6 col-sm-6"><div class="form-group {{type}}{{required}}">{{content}}</div></div>',
                    'inputContainerError' => '<div class="col-md-6 col-sm-6"><div class="form-group {type}}{{{required}} has-error">{{content}}{{error}}</div></div>',
                    'error' => '<label for="" generated="true" class="error">{{content}}</label>',
                    'input' => '<div class="numbers-row"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                ]
            ]);

            echo $this->Form->input('children', [
                'label' => __d('ittvn', 'Children'),
                'class' => 'qty2 form-control',
                'default' => 0,
                'templates' => [
                    'inputContainer' => '<div class="col-md-6 col-sm-6"><div class="form-group {{type}}{{required}}">{{content}}</div></div>',
                    'inputContainerError' => '<div class="col-md-6 col-sm-6"><div class="form-group {type}}{{{required}} has-error">{{content}}{{error}}</div></div>',
                    'error' => '<label for="" generated="true" class="error">{{content}}</label>',
                    'input' => '<div class="numbers-row"><input type="{{type}}" name="{{name}}"{{attrs}}/></div>',
                ]
            ]);
            ?>
        </div>
        <hr />
        <div class="row">
            <?php
            echo $this->Form->input('first_name', [
                'label' => __d('ittvn', 'First name'),
                'class' => 'form-control required',
                'templates' => [
                    'inputContainer' => '<div class="col-md-6 col-sm-6"><div class="form-group {{type}}{{required}}">{{content}}</div></div>',
                    'inputContainerError' => '<div class="col-md-6 col-sm-6"><div class="form-group {type}}{{{required}} has-error">{{content}}{{error}}</div></div>',
                    'error' => '<label for="" generated="true" class="error">{{content}}</label>',
                ]
            ]);

            echo $this->Form->input('last_name', [
                'label' => __d('ittvn', 'Last name'),
                'class' => 'form-control required',
                'templates' => [
                    'inputContainer' => '<div class="col-md-6 col-sm-6"><div class="form-group {{type}}{{required}}">{{content}}</div></div>',
                    'inputContainerError' => '<div class="col-md-6 col-sm-6"><div class="form-group {type}}{{{required}} has-error">{{content}}{{error}}</div></div>',
                    'error' => '<label for="" generated="true" class="error">{{content}}</label>'
                ]
            ]);
            ?>
        </div>
        <div class="row">
            <?php
            echo $this->Form->input('email', [
                'label' => __d('ittvn', 'Email'),
                'class' => 'form-control required',
                'templates' => [
                    'inputContainer' => '<div class="col-md-12 col-sm-12"><div class="form-group {{type}}{{required}}">{{content}}</div></div>',
                    'inputContainerError' => '<div class="col-md-12 col-sm-12"><div class="form-group {type}}{{{required}} has-error">{{content}}{{error}}</div></div>',
                    'error' => '<label for="" generated="true" class="error">{{content}}</label>',
                ]
            ]);

            echo $this->Form->input('phone', [
                'label' => __d('ittvn', 'Telephone'),
                'class' => 'form-control required',
                'templates' => [
                    'inputContainer' => '<div class="col-md-12 col-sm-12"><div class="form-group {{type}}{{required}}">{{content}}</div></div>',
                    'inputContainerError' => '<div class="col-md-12 col-sm-12"><div class="form-group {type}}{{{required}} has-error">{{content}}{{error}}</div></div>',
                    'error' => '<label for="" generated="true" class="error">{{content}}</label>'
                ]
            ]);
            ?>
        </div>
        <hr />
        <?= $this->Form->button(__d('ittvn', 'Check now'), ['class' => 'btn_full']); ?>
        <a class="btn_full_outline" href="#"><i class=" icon-heart"></i> Add to whislist</a>
        <?= $this->Form->end(); ?>
    <?php endif; ?>
</div>