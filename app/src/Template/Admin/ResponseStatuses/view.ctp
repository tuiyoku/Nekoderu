<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Response Status'), ['action' => 'edit', $responseStatus->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Response Status'), ['action' => 'delete', $responseStatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $responseStatus->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Response Statuses'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Response Status'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="responseStatuses view large-9 medium-8 columns content">
    <h3><?= h($responseStatus->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($responseStatus->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($responseStatus->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($responseStatus->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Title') ?></h4>
        <?= $this->Text->autoParagraph(h($responseStatus->title)); ?>
    </div>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($responseStatus->description)); ?>
    </div>
</div>
