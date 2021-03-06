<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Response Status'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="responseStatuses index large-9 medium-8 columns content">
    <h3><?= __('Response Statuses') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($responseStatuses as $responseStatus): ?>
            <tr>
                <td><?= $this->Number->format($responseStatus->id) ?></td>
                <td><?= h($responseStatus->created) ?></td>
                <td><?= h($responseStatus->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $responseStatus->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $responseStatus->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $responseStatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $responseStatus->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
