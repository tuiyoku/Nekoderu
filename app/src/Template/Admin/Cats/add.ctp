<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Cats'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="cats form large-9 medium-8 columns content">
    <?= $this->Form->create($cat) ?>
    <fieldset>
        <legend><?= __('Add Cat') ?></legend>
        <?php
            echo $this->Form->input('time');
            echo $this->Form->input('locate');
            echo $this->Form->input('image_url');
            echo $this->Form->input('flg');
            echo $this->Form->input('comment');
            echo $this->Form->input('address');
            echo $this->Form->input('status');
            echo $this->Form->input('ear_shape');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
