<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Cat'), ['action' => 'edit', $cat->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Cat'), ['action' => 'delete', $cat->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cat->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Cats'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cat'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="cats view large-9 medium-8 columns content">
    <h3><?= h($cat->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Locate') ?></th>
            <td><?= h($cat->locate) ?></td>
        </tr>
        <tr>
            <th><?= __('Image Url') ?></th>
            <td><?= h($cat->image_url) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($cat->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Time') ?></th>
            <td><?= $this->Number->format($cat->time) ?></td>
        </tr>
        <tr>
            <th><?= __('Flg') ?></th>
            <td><?= $this->Number->format($cat->flg) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= $this->Number->format($cat->status) ?></td>
        </tr>
        <tr>
            <th><?= __('Ear Shape') ?></th>
            <td><?= $this->Number->format($cat->ear_shape) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Comment') ?></h4>
        <?= $this->Text->autoParagraph(h($cat->comment)); ?>
    </div>
    <div class="row">
        <h4><?= __('Address') ?></h4>
        <?= $this->Text->autoParagraph(h($cat->address)); ?>
    </div>
</div>
