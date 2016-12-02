<?= $this->Form->create(null, [
    'url' => ['prefix' => 'api' ,'controller' => 'Cats', 'action' => 'addSheltered'],
    'id' => "form",
    'enctype' => 'multipart/form-data'
    ]) ?>
<fieldset>
<?php
        echo $this->Form->file('image[]');
        echo $this->Form->file('image[]');
        echo $this->Form->input('locate', ['value' => '32.8031,130.707891']);
        echo $this->Form->input('address', ['value' => '熊本市']);
        echo $this->Form->input('comment', ['value' => 'コメント']);
        echo $this->Form->input('name', ['value' => '名前']);
        echo $this->Form->input('token', ['value' => '']);
?>
</fieldset>
<?= $this->Form->button(__('投稿する')) ?>
<?= $this->Form->end() ?>

<script>
$('#form').submit(function(event) {                                                               
    event.preventDefault();
    
    $.post({
    	url: "/api/users/token.json",
    	data: { 
    		email: "stagesp1@gmail.com",
    		password: "fromsiva"
    	}, 
    	success: function(result, textStatus, xhr) {
            var token = result.data.token;
            $("input[name='token']").attr('value', token);
            
             // 操作対象のフォーム要素を取得
		    var $form = $('#form');

		    // 送信
		    $.post({
		        url: $form.attr('action')+"?token="+token,
		        method: $form.attr('method'),
		        // dataType: 'json',
		        data: new FormData($('#form').get()[0]),
		        processData: false,
		        contentType: false,
		        timeout: 10000,  // 単位はミリ秒
		        // 通信成功時の処理
		        success: function(result, textStatus, xhr) {
		            console.log(result);
		        },
		        // 通信失敗時の処理
		        error: function(xhr, textStatus, error) {
		            console.log(error);
		        }
		    });
        }
    });
    
 }); 
	
</script>
