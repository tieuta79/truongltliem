<?php if (!empty($showFilter) && $showFilter == true): ?>
    <div class="row">
        <?php
        echo $this->Form->create('search', ['type' => 'get']);
        /*
          if ($this->fetch('action-table')):
          echo $this->fetch('action-table');
          else:
          echo $this->Form->input('action_table', [
          'type' => 'select',
          'label' => false,
          'options' => $filterOptions,
          'value' => '',
          'class' => 'input-sm form-control input-s-sm inline action_table',
          'templates' => ['inputContainer' => '<div class="col-sm-2 m-b-xs action {{type}} {{require}}">{{content}}</div>']
          ]);
          echo $this->Form->input('action_table_value', ['type' => 'hidden', 'label' => false, 'value' => '']);
          endif;
         * 
         */
        ?>
        <?php
        if ($this->fetch('search-table')):
            echo $this->fetch('search-table');
        else:
            ?>
            <div id="it_search_fix" class="col-sm-4" style="display: none;">
                <div class="input-group">
                    <?= $this->Form->input('q', ['type' => 'text', 'value' => (isset($this->request->query['q']) ? $this->request->query['q'] : ''), 'label' => false, 'placeholder' => __d('ittvn', 'Keyword'), 'class' => 'input-sm form-control', 'templates' => ['inputContent' => '{{content}}']]); ?>
                    <span class="input-group-btn">
                        <button class="btn btn-sm btn-primary" type="button">
                            <i class="fa fa-search"></i> <?= __d('ittvn', 'Search') ?>
                        </button>
                    </span>
                </div>
            </div>

        <?php endif; ?>

        <?php
        if ($this->fetch('action-right-table')):
            echo $this->fetch('action-right-table');
        else:
            ?>
            <div class="col-sm-6 action-right">                        
                <div id="action-right" class="row pull-right">
                    <?php
                    /*
                      if (!empty($filterSelectBox)) {
                      $col = ceil(12 / count($filterSelectBox));
                      foreach ($filterSelectBox as $key => $action_right_select):
                      echo $this->Form->input($key, [
                      'type' => 'select',
                      'label' => false,
                      'options' => $action_right_select['list'],
                      'value' => isset($this->request->query[$key]) ? $this->request->query[$key] : '',
                      'empty' => __d('ittvn', $action_right_select['label']),
                      'class' => 'input-sm form-control input-s-sm inline ' . $key,
                      'onchange' => 'this.form.submit()',
                      'templates' => ['inputContainer' => '<div id="it_table_cool_length" class="dataTables_length m-b-xs col-sm-' . $col . ' {{type}} {{require}}">{{content}}</div>']
                      ]);
                      endforeach;
                      }
                     * 
                     */
                    ?>                           
                </div>
            </div>
        <?php endif; ?>
        <?= $this->Form->end(); ?>
    </div>
<?php endif; ?>