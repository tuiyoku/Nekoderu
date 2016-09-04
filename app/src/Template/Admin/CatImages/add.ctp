<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Cat Images'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cats'), ['controller' => 'Cats', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cat'), ['controller' => 'Cats', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="catImages form large-9 medium-8 columns content">
    <?= $this->Form->create($catImage) ?>
    <fieldset>
        <legend><?= __('Add Cat Image') ?></legend>
        <?php
            echo $this->Form->input('url');
            echo $this->Form->input('cats_id', ['options' => $cats]);
            echo $this->Form->input('users_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
