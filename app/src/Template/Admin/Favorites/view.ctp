<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Favorite'), ['action' => 'edit', $favorite->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Favorite'), ['action' => 'delete', $favorite->id], ['confirm' => __('Are you sure you want to delete # {0}?', $favorite->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Favorites'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Favorite'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cats'), ['controller' => 'Cats', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cat'), ['controller' => 'Cats', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="favorites view large-9 medium-8 columns content">
    <h3><?= h($favorite->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $favorite->has('user') ? $this->Html->link($favorite->user->id, ['controller' => 'Users', 'action' => 'view', $favorite->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cat') ?></th>
            <td><?= $favorite->has('cat') ? $this->Html->link($favorite->cat->id, ['controller' => 'Cats', 'action' => 'view', $favorite->cat->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($favorite->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($favorite->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($favorite->modified) ?></td>
        </tr>
    </table>
</div>
