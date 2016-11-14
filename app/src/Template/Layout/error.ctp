<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'お探しのページが見つかりません';
?>

<?php
//デフォルトのレイアウトを外す
$this->layout= '';
//ネコデルのレイアウトを適用
$this->extend('/Layout/nekoderu');
?>

<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <div class="container" style="background-color: white;">
        <div class="row">
            <div class="box">
                <div class="col-lg-12 text-center">
                    
                    <img class="img-responsive img-border img-left" src="/img/banner.png" alt="">
                    <h2 class="brand-before">
                        <small>404</small>
                    </h2>
                    <h3 class="brand-name">お探しのページが見つかりませんでした</h3>
                    <div>
                        <a href="/">
                            トップに戻る
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
