<?php
/**
 * Copyright 2010 - 2015, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2015, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
use Cake\Core\Configure;
?>

<?php
//デフォルトのレイアウトを外す
$this->layout= '';
//ネコデルのレイアウトを適用
$this->extend('/Layout/nekoderu');
?>

<div class="users form large-10 medium-9 columns">
    <?= $this->Form->create($user, ['url' => ['controller' => 'profiles', 'action' => 'registration']]); ?>
    <fieldset>
        <legend><?= __d('CakeDC/Users', '新規登録') ?></legend>
        <?php
        echo $this->Form->input('username', ['label' => 'アカウント']);
        echo $this->Form->input('email', ['label' => 'メールアドレス']);
        echo $this->Form->input('password', ['label' => 'パスワード']);
        echo $this->Form->input('password_confirm', ['type' => 'password', 'label' => 'パスワード（確認）']);
        ?>
        <p>
        <small>※ 苗字と名前は本名ではなくても大丈夫です</small>
        </p>
        <?php
        echo $this->Form->input('last_name', ['label' => '苗字']);
        echo $this->Form->input('first_name', ['label' => '名前']);
        ?>
        <iframe style="width:100%" src="/policy/policy" height="300"></iframe>
        <?php
        if (Configure::read('Users.Tos.required')) {
            echo $this->Form->input('tos', ['type' => 'checkbox', 'label' => __d('CakeDC/Users', '利用規約に同意しますか?'), 'required' => true]);
        }
        if (Configure::read('Users.reCaptcha.registration')) {
            echo $this->User->addReCaptcha();
        }
        ?>
    </fieldset>
    <?= $this->Form->button(__d('CakeDC/Users', '登録')) ?>
    <?= $this->Form->end() ?>
</div>

