<?php
//デフォルトのレイアウトを外す
$this->layout= '';
//ネコデルのレイアウトを適用
$this->extend('/Layout/nekoderu');
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
