<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php
            echo $this->Form->input('username');
            echo $this->Form->input('first_name');
            echo $this->Form->input('last_name');
        ?>
       
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
    <p>
        <br>
    <?= $this->Html->link(__d('CakeDC/Users', 'Change Password'), ['plugin' => 'CakeDC/Users', 'controller' => 'Users', 'action' => 'changePassword']); ?>
    </p>
    <div class="panel-danger">
         <div class="panel-heading"><?= __("この下は注意してください") ?></div>
         <div class="panel-body">
            <?= $this->Form->postLink(__('アカウント削除'), ['action' => 'delete', $user->id, ],
                ['confirm' => __('本当に削除してもいいですか？', $user->id), 'class' => 'btn btn-danger btn-sm']) ?>
        </div>
    </div>
</div>
