<div class="message error" onclick="this.classList.add('hidden');"><?= h($message) ?></div>
<?php if (isset($params) AND isset($params['errors'])) : ?>
    <ul class="collection with-header">
        <li class="collection-header"><h5><?= __('下記の内容を確認してください。') ?></h5></li>
        <?php foreach ($params['errors'] as $error) : ?>
            <li class="collection-item"><i class="material-icons">error</i><?= h($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>