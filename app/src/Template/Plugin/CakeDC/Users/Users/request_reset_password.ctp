<?php
$this->extend('/Layout/TwitterBootstrap/signin');
?>

<div class="users form">
    <?= $this->Flash->render('auth') ?>
    <?= $this->Form->create('User') ?>
    <fieldset>
        <legend><?= __d('CakeDC/Users', '登録しているメールアドレスを入力してください') ?></legend>
        <?= $this->Form->input('reference', ['label' => 'メールアドレス']) ?>
    </fieldset>
    <?= $this->Form->button(__d('CakeDC/Users', '送信')); ?>
    <?= $this->Form->end() ?>
</div>
