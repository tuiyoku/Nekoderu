<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#  website: http://ogp.me/ns/website#">
    <meta charset="utf-8">
    <title>Nekoderu (alpha)</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="keywords" content="nekoderu,ねこでる,猫,ネコ">
    <meta http-equiv="content-style-type" content="text/css">
    <meta http-equiv="content-script-type" content="text/javascript">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <?= $this->Html->css("//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css") ?>
    <link rel="stylesheet" href="<?php echo$this->Url->build('/', false); ?>css/owl.carousel.css">
    <link rel="stylesheet" href="<?php echo$this->Url->build('/', false); ?>css/jquery.onoff.css">
    <link rel="stylesheet" href="<?php echo$this->Url->build('/', false); ?>css/base.css">
    <link rel="stylesheet" href="<?php echo$this->Url->build('/', false); ?>css/index.css">
    <link rel="stylesheet" href="<?php echo$this->Url->build('/', false); ?>css/post.css">
    <!-- OGP -->
    <meta property="og:type" content="website">
    <meta property="og:description" content="ネコ出るです。">
    <meta property="og:title" content="Nekoderu (alpha)">
    <meta property="og:site_name" content="Nekoderu">
    <meta property="og:locale" content="ja_JP" />
    <!-- OGP -->
</head>
<body>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
