<?= $this->Form->create(null, [
    'url' => ['action' => 'visionTest'],
    'enctype' => 'multipart/form-data'
    ]) ?>
<fieldset>
<?php
        echo $this->Form->file('image');
        echo "<br>";
?>
</fieldset>
<?= $this->Form->button(__('投稿する')) ?>
<?= $this->Form->end() ?>

<pre>
<?php
    if(isset($json)){
        echo $json;
    }
?>
</pre>