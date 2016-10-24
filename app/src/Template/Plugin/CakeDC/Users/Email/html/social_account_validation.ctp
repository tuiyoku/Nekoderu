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
?>

<p>
<?= __d('CakeDC/Users', "こんにちわ {0}", $user['first_name']) ?>,
</p>
<p>
    <strong><?php
    $text = __d('CakeDC/Users', 'ここを開いて登録を完了してください');
    $activationUrl = [
        '_full' => true,
        'plugin' => 'CakeDC/Users',
        'controller' => 'SocialAccounts',
        'action' => 'validateAccount',
        $socialAccount['provider'],
        $socialAccount['reference'],
        $socialAccount['token'],
    ];
    echo $this->Html->link($text, $activationUrl);
    ?></strong>
</p>
<p>
    <?= __d('CakeDC/Users', "リンクが正しく表示されない場合は次のアドレスをブラウザに貼り付けてください。 {0}", $this->Url->build($activationUrl)) ?>
</p>
<p>
    <?= __d('CakeDC/Users', 'ご利用ありがとうございます。') ?>,
</p>
