<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#  website: http://ogp.me/ns/website#">
    <meta charset="utf-8">
    <title>Nekoderu (alpha)</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    
    <meta name="keywords" content="nekoderu,ねこでる,猫,ネコ">
    <meta http-equiv="content-style-type" content="text/css">
    <meta http-equiv="content-script-type" content="text/javascript">
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    
    <link rel="stylesheet" href="/honoka/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    
    <link rel="stylesheet" href="<?php echo$this->Url->build('/', false); ?>css/jquery.onoff.css">
    <link rel="stylesheet" href="<?php echo$this->Url->build('/', false); ?>css/base.css">
    <link rel="stylesheet" href="<?php echo$this->Url->build('/', false); ?>css/app.css">
    <link rel="stylesheet" href="<?php echo$this->Url->build('/', false); ?>css/cats.css">
    <link rel="stylesheet" href="<?php echo$this->Url->build('/', false); ?>css/index.css">
    <link rel="stylesheet" href="<?php echo$this->Url->build('/', false); ?>css/post.css">
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="/honoka/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/mustache.js/2.2.1/mustache.min.js"></script>
    
    <!-- OGP -->
    <meta property="og:type" content="website">
    <meta property="og:description" content="ネコ出るです。">
    <meta property="og:title" content="Nekoderu (alpha)">
    <meta property="og:site_name" content="Nekoderu">
    <meta property="og:locale" content="ja_JP" />
    <!-- OGP -->
    <script>
    <?php if ($auth): ?>
        var isAuthorized = true;
    <?php else: ?>
        var isAuthorized = false;
    <?php endif; ?>
    </script>
</head>
<body>
    
    <div class="container navbar-static-top">
        <?= $this->element('partial/header'); ?>
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
