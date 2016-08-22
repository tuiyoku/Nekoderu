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

<link rel="stylesheet" href="<?php echo$this->Url->build('/', false); ?>css/login.css">
<?php
$this->extend('/Layout/nekoderu');
?>

<div class="users form">
    <?= $this->Flash->render('auth') ?>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __d('CakeDC/Users', '登録したメールアドレスとパスワードでログインしてください') ?></legend>
        <?= $this->Form->input('email', ['required' => true, 'label'=>'メールアドレス']) ?>
        <?= $this->Form->input('password', ['required' => true, 'label'=>'パスワード']) ?>
        <?php
        if (Configure::read('Users.reCaptcha.login')) {
            echo $this->User->addReCaptcha();
        }
        if (Configure::check('Users.RememberMe.active')) {
            echo $this->Form->input(Configure::read('Users.Key.Data.rememberMe'), [
                'type' => 'checkbox',
                'label' => __d('CakeDC/Users', 'ログイン状態を保持する'),
                'checked' => 'checked'
            ]);
        }
        ?>
            <?php
            $registrationActive = Configure::read('Users.Registration.active');
            if ($registrationActive) {
                echo $this->Html->link(__d('CakeDC/Users', 'ユーザ登録'), ['action' => 'register']);
            }
            if (Configure::read('Users.Email.required')) {
                if ($registrationActive) {
                    echo ' | ';
                }
                echo $this->Html->link(__d('CakeDC/Users', 'パスワードを忘れた場合'), ['action' => 'requestResetPassword']);
            }
            ?>
    </fieldset>
    <?= implode(' ', $this->User->socialLoginList()); ?>
    <?= $this->Form->button(__d('CakeDC/Users', 'ログイン')); ?>
    <?= $this->Form->end() ?>
</div>


