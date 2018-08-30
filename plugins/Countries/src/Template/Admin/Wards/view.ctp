<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Ward'), ['action' => 'edit', $ward->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ward'), ['action' => 'delete', $ward->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ward->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Wards'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ward'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Countries'), ['controller' => 'Countries', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Country'), ['controller' => 'Countries', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Provinces'), ['controller' => 'Provinces', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Province'), ['controller' => 'Provinces', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Addresses'), ['controller' => 'Addresses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Address'), ['controller' => 'Addresses', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="wards view large-9 medium-8 columns content">
    <h3><?= h($ward->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($ward->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Slug') ?></th>
            <td><?= h($ward->slug) ?></td>
        </tr>
        <tr>
            <th><?= __('Country') ?></th>
            <td><?= $ward->has('country') ? $this->Html->link($ward->country->name, ['controller' => 'Countries', 'action' => 'view', $ward->country->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Province') ?></th>
            <td><?= $ward->has('province') ? $this->Html->link($ward->province->name, ['controller' => 'Provinces', 'action' => 'view', $ward->province->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('City') ?></th>
            <td><?= $ward->has('city') ? $this->Html->link($ward->city->name, ['controller' => 'Cities', 'action' => 'view', $ward->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($ward->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Delete') ?></th>
            <td><?= $ward->delete ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Addresses') ?></h4>
        <?php if (!empty($ward->addresses)): ?>
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
            <?php foreach ($ward->addresses as $addresses): ?>
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
</div>
