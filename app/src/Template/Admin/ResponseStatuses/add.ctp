<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Response Statuses'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="responseStatuses form large-9 medium-8 columns content">
    <?= $this->Form->create($responseStatus) ?>
    <fieldset>
        <legend><?= __('Add Response Status') ?></legend>
        <?php
            echo $this->Form->input('title');
            echo $this->Form->input('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
