<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Country'), ['action' => 'edit', $country->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Country'), ['action' => 'delete', $country->id], ['confirm' => __('Are you sure you want to delete # {0}?', $country->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Countries'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Country'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Addresses'), ['controller' => 'Addresses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Address'), ['controller' => 'Addresses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Provinces'), ['controller' => 'Provinces', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Province'), ['controller' => 'Provinces', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="countries view large-9 medium-8 columns content">
    <h3><?= h($country->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($country->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Slug') ?></th>
            <td><?= h($country->slug) ?></td>
        </tr>
        <tr>
            <th><?= __('Code') ?></th>
            <td><?= h($country->code) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($country->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Addresses') ?></h4>
        <?php if (!empty($country->addresses)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Company') ?></th>
                <th><?= __('Phone') ?></th>
                <th><?= __('Country Id') ?></th>
                <th><?= __('Province Id') ?></th>
                <th><?= __('City Id') ?></th>
                <th><?= __('Ward Id') ?></th>
                <th><?= __('Address') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Default') ?></th>
                <th><?= __('Delete') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($country->addresses as $addresses): ?>
            <tr>
                <td><?= h($addresses->id) ?></td>
                <td><?= h($addresses->name) ?></td>
                <td><?= h($addresses->company) ?></td>
                <td><?= h($addresses->phone) ?></td>
                <td><?= h($addresses->country_id) ?></td>
                <td><?= h($addresses->province_id) ?></td>
                <td><?= h($addresses->city_id) ?></td>
                <td><?= h($addresses->ward_id) ?></td>
                <td><?= h($addresses->address) ?></td>
                <td><?= h($addresses->user_id) ?></td>
                <td><?= h($addresses->default) ?></td>
                <td><?= h($addresses->delete) ?></td>
                <td><?= h($addresses->created) ?></td>
                <td><?= h($addresses->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Addresses', 'action' => 'view', $addresses->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Addresses', 'action' => 'edit', $addresses->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Addresses', 'action' => 'delete', $addresses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $addresses->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Cities') ?></h4>
        <?php if (!empty($country->cities)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Slug') ?></th>
                <th><?= __('Province Id') ?></th>
                <th><?= __('Country Id') ?></th>
                <th><?= __('Delete') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($country->cities as $cities): ?>
            <tr>
                <td><?= h($cities->id) ?></td>
                <td><?= h($cities->name) ?></td>
                <td><?= h($cities->slug) ?></td>
                <td><?= h($cities->province_id) ?></td>
                <td><?= h($cities->country_id) ?></td>
                <td><?= h($cities->delete) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Cities', 'action' => 'view', $cities->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Cities', 'action' => 'edit', $cities->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Cities', 'action' => 'delete', $cities->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cities->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Provinces') ?></h4>
        <?php if (!empty($country->provinces)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Slug') ?></th>
                <th><?= __('Country Id') ?></th>
                <th><?= __('Delete') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($country->provinces as $provinces): ?>
            <tr>
                <td><?= h($provinces->id) ?></td>
                <td><?= h($provinces->name) ?></td>
                <td><?= h($provinces->slug) ?></td>
                <td><?= h($provinces->country_id) ?></td>
                <td><?= h($provinces->delete) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Provinces', 'action' => 'view', $provinces->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Provinces', 'action' => 'edit', $provinces->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Provinces', 'action' => 'delete', $provinces->id], ['confirm' => __('Are you sure you want to delete # {0}?', $provinces->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
