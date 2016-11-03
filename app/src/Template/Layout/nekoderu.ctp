<!DOCTYPE html>
<html lang="ja">
<?= $this->element('partial/head'); ?>
<body>
    <?php include_once("analyticstracking.php") ?>
    <div class="container navbar-static-top">
        <?= $this->element('partial/header'); ?>
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>

</html>
