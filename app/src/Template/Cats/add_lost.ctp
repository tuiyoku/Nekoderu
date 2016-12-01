<h3>迷い猫登録フォーム</h3>
<div id="for-saving-cats-privacy-panel" class="w3-panel w3-info">
ここで登録すると自動的にハッシュタグ<br>「#迷子猫探してます」がつけられます
</div>
<div style="margin:15px 0;text-align:center">
    お探しの「ねこ」について教えてください
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
            避妊手術したねこには、何度もお腹を開けるような事態が起きないように、手術が終わった証にお耳の先をV字にカットしています。
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
        <p>ねこの行動範囲は限られています限られています。お探しのねこを飼っていた場所をご記入ください。位置情報は一般には公開しません。</p>
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
        <p>ねこの詳しい情報を猫の詳しい情報がわかると、迷子ねこを探すのに役立ちます。
        </p>
        <p>わかる範囲でご回答ください。</p>
    </div>
</div>
        
<?= $this->element('partial/for_saving_cats_privacy'); ?>
<?php
    echo $this->Form->create(null, [
        'url' => 'cats/addLost',
        'id' => 'post',
        'onsubmit' => 'return confirm("送信してもいいですか？");',
        'enctype' => 'multipart/form-data'
    ]);
    echo $this->Form->input('time', ['type' => 'hidden', 'id' => 'time']);
    echo $this->Form->input('locate', ['type' => 'hidden', 'id' => 'locate']);
?>
    <div class="box">
        <div class="memo-title">
            １．写真を選ぶ <sup class="required">※必須</sup>
            <?= $this->element('partial/multi_image_selector'); ?>
        </div>
    </div>
    <div id='now' class="box">
        <div class="memo-title">
            ２．場所を設定する <sup class="required">※必須</sup> <i id='gps-info' class="glyphicon glyphicon-question-sign"></i>
            <br><a id='get_gps' href="#">クリックしてGPSから取得</a> 
        </div>
        
        <?php echo $this->Form->input('', 
        ['type' => 'text', 'id' => 'address', 'name' => 'address', 'placeholder' => '飼っていたときの場所や住所をご記入ください', 'required' => 'required']); ?>
    </div>
    <table class="details">
        <tr>
            <th>名前</th>
            <td>
                <?php echo $this->Form->text('name', ['placeholder' => 'お探しのねこのお名前はなんですか？' ]); ?>
            </td>
    </table>
    <div class="box">
        <div class="memo-title">３．コメントを書く</div>
        <?php
        echo $this->Form->input('comment', 
            ['type' => 'textarea', 'id' => 'comment', 'label' => false, 'rows' => 5,
            'placeholder'=>'お探しのねこの特徴を教えて下さい']);
        ?>
    </div>
    

    <div class="btn-default">
        <?php
        echo $this->Form->submit(
            '投稿', ['id' => 'js-submit-button', 'value'=>'投稿', 'label' => false]);
    ?>
    </div>
<?php echo $this->Form->end(); ?>

<!--<div class="map-rapper">-->
<!--    <div id="map" class="map"></div>-->
<!--</div>-->
<script>
$(function(){
    setModal("modal-ear", "#ear-info", null);
    setModal("modal-gps", "#gps-info", null);
    setModal("modal-detail", "#detail-info", null);
});

$("form").submit(function(e) {
    
    if($('.button-file').length < 2){
        alert("写真を選んでください");

        e.preventDefault();
        return false;
    }

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
<link rel="stylesheet" href="/css/w3.css">
<style>
.w3-note{background-color:#ffffcc;border-left:6px solid #ffeb3b}
.w3-warning{background-color:#ffdddd;border-left:6px solid #f44336}
.w3-info{background-color:#ddffdd;border-left:6px solid #4CAF50}
</style>


