<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Report'), ['action' => 'edit', $report->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Report'), ['action' => 'delete', $report->id], ['confirm' => __('Are you sure you want to delete # {0}?', $report->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Reports'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Report'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cats'), ['controller' => 'Cats', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cat'), ['controller' => 'Cats', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="reports view large-9 medium-8 columns content">
    <h3><?= h($report->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($report->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $report->has('user') ? $this->Html->link($report->user->id, ['controller' => 'Users', 'action' => 'view', $report->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cat') ?></th>
            <td><?= $report->has('cat') ? $this->Html->link($report->cat->id, ['controller' => 'Cats', 'action' => 'view', $report->cat->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($report->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($report->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($report->modified) ?></td>
        </tr>
    </table>
</div>
