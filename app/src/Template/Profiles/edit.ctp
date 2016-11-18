<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __d('CakeDC/Users', 'Edit User') ?></legend>
        <?php
            echo $this->Form->input('username', ['label' => __d('CakeDC/Users', 'Username')]);
            echo $this->Form->input('last_name', ['label' => __d('CakeDC/Users', '名字')]);
            echo $this->Form->input('first_name', ['label' => __d('CakeDC/Users', '名前')]);
        ?>
       
    </fieldset>
    <?= $this->Form->button(__d('CakeDC/Users', 'Apply')) ?>
    <?= $this->Form->end() ?>
    <p>
        <br>
    <?= $this->Html->link(__d('CakeDC/Users', 'Change Password'), ['plugin' => 'CakeDC/Users', 'controller' => 'Users', 'action' => 'changePassword']); ?>
    </p>
    <div class="panel-danger">
         <div class="panel-heading"><?= __("この下の操作は注意してください") ?></div>
         <div class="panel-body">
            <?= $this->Form->postLink(__('退会する'), ['action' => 'delete', $user->id, ],
                ['confirm' => __('本当に退会してもよろしいですか？アカウントは削除され復旧できません。', $user->id), 'class' => 'btn btn-danger btn-sm']) ?>
        </div>
    </div>
</div>
