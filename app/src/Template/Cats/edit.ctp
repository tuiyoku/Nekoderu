<div class="row">
    <div style="float:left">
        <a class="btn btn-default btn-sm" href="/cats/view/<?=$cat->id?>">戻る</a>
    </div>
</div>
<div style="margin:15px 0;">
    「ねこ」について教えて下さい
</div>
<!-- The Modal -->
<div id="modal-ear" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="container clearfix">
            <span style="text-align:right" class="close">閉じる</span>
        </div>
        <h3 style="margin-top:10px;margin-bottom:20px;">ねこの耳の状態について</h3>
        <p>
            避妊手術したのらねこには、何度もお腹を開けるような事態が起きないように、手術が終わった証にお耳の先をV字にカットしています。
        </p>
        <p>耳先のカットは、不妊手術の麻酔が効いている間に行うため、猫ちゃんに痛みはありません。</p>
    </div>
</div>

<!-- The Modal -->
<div id="modal-gps" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="container clearfix">
            <span style="text-align:right" class="close">閉じる</span>
        </div>
        <h3 style="margin-top:10px;margin-bottom:20px;">位置情報について？</h3>
        <p>のらねこのTNRを行うには位置情報が大切です。位置情報一般には公開しません。</p>
        <p>撮影場所がわからない、位置を特定したくない場合は「熊本」など大きな範囲で記入してください。また「崇城大学」など位置が特定できる場所を記入していただくことも可能です。</p>
        <h3 style="margin-top:10px;margin-bottom:20px;">位置情報が取れませんか？</h3>
        <p>本体の設定から位置情報の利用を許可してください。</p>
    </div>
</div>

<div id="modal-detail" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="container clearfix">
            <span style="text-align:right" class="close">閉じる</span>
        </div>
        <h3 style="margin-top:10px;margin-bottom:20px;">詳細情報について？</h3>
        <p>ねこの詳しい情報を猫の詳しい情報がわかると、TNR時の個体確認に役立ちます。
        また、迷子ねこを探すのにも役立ちます。
        </p>
        <p>わかる範囲でご回答ください。</p>
    </div>
</div>
      
<?= $this->element('partial/for_saving_cats_privacy'); ?>  
<?php
    echo $this->Form->create(null, [
        'url' => 'cats/edit/'.$cat->id,
        'id' => 'post',
        'onsubmit' => 'return confirm("送信してもいいですか？");',
        'enctype' => 'multipart/form-data'
    ]);
    echo $this->Form->input('time', ['type' => 'hidden', 'id' => 'time']);
    echo $this->Form->input('locate', ['type' => 'hidden', 'id' => 'locate']);
?>
    <!--<div class="box">-->
    <!--    <div class="memo-title">-->
    <!--        写真を選ぶ <sup class="required">※必須</sup>-->
    <!--        <?= $this->element('partial/multi_image_selector'); ?>-->
    <!--    </div>-->
    <!--</div>-->
    
    <table class="details">
        <tr>
            <th>
                場所 <sup class="required">※必須</sup> <i id='gps-info' class="glyphicon glyphicon-question-sign"></i>
            </th>
            <td>
                <div><a id='get_gps' href="#">クリックしてGPSから取得</a></div>
                <?php echo $this->Form->input('', 
                ['type' => 'text', 'id' => 'address', 'name' => 'address', 
                'value' => $cat->address,
                'placeholder' => '住所や場所のわかる内容を記入してください', 'required' => 'required']); ?>
                 
            </td>
        </tr>
        <tr>
            <th>
            耳の情報 <i id='ear-info' class="glyphicon glyphicon-question-sign"></i>
            </th>
            <td>
                <div class="ears inline_checkboxes">
                    <?php
                        echo $this->Form->input(
                            'ear_shape',
                            [
                                'multiple' => 'checkbox',
                                'type' => 'radio',
                                'options' => $this->Cats->earOptions(),
                                'escape' => false,
                                'label' => false,
                                'default' => '0',
                                'value' => $cat->ear_shape
                            ]
                        );
                     ?>
                </div>
            </td>
        </tr>
        
        <?php foreach ($questions as $question): ?>
            <?php 
                $answerValue = ""; 
                foreach($cat->answers as $answer){
                    if($answer->questions_id == $question->id){
                        $answerValue = $answer->value;
                    }
                }
            ?>
            <tr>
                <th><?= $question['displayName'] ?></th>
            <td>
                <?php if ($question['type'] == 'radio'): ?>
                    <div class="inline_checkboxes">
                        <?php 
                            $options = explode(',', $question['options']);
                            $ar = [];
                            foreach($options as $option){
                                $ar[] = ['value' => $option, 'text' => $option];
                            }
                            echo $this->Form->input(
                                $question['name'],
                                [
                                    'multiple' => 'checkbox',
                                    'type' => 'radio',
                                    'options' => $options,
                                    'escape' => false,
                                    'label' => false,
                                    'default' => '0',
                                    'value' => $answerValue
                                ] 
                            );
                        ?>
                    </div>
                <?php endif; ?>
                <?php if ($question['type'] == 'text'): ?>
                 <div>
                    <?php
                        echo $this->Form->text($question['name'], ['placeholder' => $question['description'], 'value' => $answerValue ]);
                    ?>
                </div>
                </td>
            <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </table>
    </div>

    <div class="btn-default">
        <?php
        echo $this->Form->submit(
            '投稿', ['id' => 'js-submit-button', 'value'=>'投稿', 'label' => false]);
    ?>
    </div>
<?php echo $this->Form->end(); ?>

<script>
$(function(){
    setModal("modal-ear", "#ear-info", null);
    setModal("modal-gps", "#gps-info", null);
    setModal("modal-detail", "#detail-info", null);
});

$("form").submit(function(e) {
    
    var ref = $(this).find("[required]");
    $(ref).each(function(){
        if ( $(this).val() == '' ) {
            alert("場所の情報を入力してください");

            $(this).focus();
            e.preventDefault();
            return false;
        }
    });  return true;
});

</script>

<style>
    
input[type=radio] {
    float:left;
    margin:0px;
    width:20px;
    }

form#changeRegionStdForm input[type=radio].locRad {
    margin:3px 0px 0px 3px; 
    float:none;
}

.required{
    color:red;
}
</style>

<!--<div id="customZoomBtn">-->
<!--    <div id="small" class="float_l btn">ズームアウト</div>-->
<!--    <div id="big" class="float_l btn">ズームイン</div>-->
<!--</div>-->
<!--<div id="footer">Project NEKODERU</div>-->
<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
<!--<script type="text/javascript" src="//maps.google.com/maps/api/js?key=AIzaSyAb1SFRkz9TtARWL_sPqw6D3oHCgbpLLcw"></script>-->
<!--<script type="text/javascript" src="<?php echo$this->Url->build('/', false); ?>js/rousui_post.js"></script>-->
<script type="text/javascript" src="<?php echo$this->Url->build('/', false); ?>js/add_neko.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo$this->Url->build('/', false); ?>css/add_neko.css"> 
<link rel="stylesheet" type="text/css" href="<?php echo$this->Url->build('/', false); ?>css/modal.css"> 


