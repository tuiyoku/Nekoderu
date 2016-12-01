<!DOCTYPE html>
<html lang="ja">
<?= $this->element('partial/head'); ?>
<body>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-7119528-12', 'auto');
      ga('send', 'pageview');
    </script>
    <div class="container navbar-static-top">
        <?= $this->element('partial/header'); ?>
        <?= $this->Flash->render() ?>
    </div>
    <?= $this->fetch('content') ?>
    <footer>
    </footer>
</body>

</html>
