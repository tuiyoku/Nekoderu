<!DOCTYPE html>
<html lang="ja">
<?= $this->element('partial/head'); ?>
<body>
    <?php include_once("analyticstracking.php") ?>
    <?= $this->fetch('content') ?>
</body>
</html>
