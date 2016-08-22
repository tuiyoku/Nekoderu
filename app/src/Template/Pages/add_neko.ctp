<div style="margin:15px 0;text-align:center">
    のら猫、地域猫について教えて下さい
</div>
<!-- The Modal -->
<div id="modal-ear" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="container clearfix">
            <span style="text-align:right" class="close">閉じる</span>
        </div>
        <h3 style="margin-top:10px;margin-bottom:20px;">ねこの耳の状態について</h3>
        <div>避妊手術やさくら耳について説明を書く</div>
    </div>
</div>

<!-- The Modal -->
<div id="modal-gps" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="container clearfix">
            <span style="text-align:right" class="close">閉じる</span>
        </div>
        <h3 style="margin-top:10px;margin-bottom:20px;">位置情報が取れませんか？</h3>
        <div>本体の設定から位置情報の利用を許可してください</div>
    </div>
</div>
        
<?php
    echo $this->Form->create(null, [
        'url' => 'add_neko',
        'id' => 'post',
        'onsubmit' => 'return confirm("送信してもいいですか？");'
    ]);
    echo $this->Form->input('time', ['type' => 'hidden', 'id' => 'time']);
    echo $this->Form->input('locate', ['type' => 'hidden', 'id' => 'locate']);
?>
    <div id='now' class="box">
        <div class="memo-title">
            <a href="javascript:void(0)" onclick="now()">１．位置を設定する </a> <i id='gps-info' class="glyphicon glyphicon-question-sign"></i>
        </div>
    </div>
    <div class="box">
        <div class="memo-title">２．猫の耳の情報を入力する <i id='ear-info' class="glyphicon glyphicon-question-sign"></i></div>
        <div class="inline_checkboxes">
            <?php
                echo $this->Form->input(
                    'ear_shape',
                    array(
                        'multiple' => 'checkbox',
                        'type' => 'radio',
                        'options' => [
                            '0' => $this->Html->image('/img/cat_ears/cat_normal.png', ['width'=>'24px']) . ' 処置なし', 
                            '1' => $this->Html->image('/img/cat_ears/cat_donno.png', ['width'=>'24px']) . ' 不明',
                            '2' => $this->Html->image('/img/cat_ears/cat_trimmed_right.png', ['width'=>'24px']) . ' 右耳に印',
                            '3' => $this->Html->image('/img/cat_ears/cat_trimmed_left.png', ['width'=>'24px']) . ' 左耳に印'
                        ],
                        'escape' => false,
                        'label' => false,
                        'default' => '0'
                    )  
                );
             ?>
        </div>
    </div>
    <div class="box">
        <div class="memo-title">３．その他の情報を入力する</div>
        <?php
        echo $this->Form->input('comment', 
            ['type' => 'textarea', 'id' => 'comment', 'label' => false, 'rows' => 2,
            'placeholder'=>'猫について教えて下さい。人懐っこい？怖がり？']);
    ?>
    </div>
    
    <div class="box">
        <div class="memo-title">４．
            <label class="button-file">
            <?php
                echo $this->Form->input('image', ['type' => 'file', 'id' => 'image', 'class' => 'hide', 'label' => false]);
            ?>
            写真があれば選択する
            </label>
        </div>
    </div>
    <div class="box-mini">
        <?php
        echo $this->Form->submit(
            '投稿', ['id' => 'js-submit-button', 'value'=>'投稿', 'label' => false]);
    ?>
    </div>
<?php echo $this->Form->end(); ?>
        <div id="map"></div>
    <!--<div id="customZoomBtn">-->
    <!--    <div id="small" class="float_l btn">ズームアウト</div>-->
    <!--    <div id="big" class="float_l btn">ズームイン</div>-->
    <!--</div>-->
    <!--<div id="footer">Project NEKODERU</div>-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script type="text/javascript" src="//maps.google.com/maps/api/js?key=AIzaSyAb1SFRkz9TtARWL_sPqw6D3oHCgbpLLcw"></script>
    <script type="text/javascript" src="<?php echo$this->Url->build('/', false); ?>js/rousui_post.js"></script>
    <script type="text/javascript" src="<?php echo$this->Url->build('/', false); ?>js/add_neko.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo$this->Url->build('/', false); ?>css/add_neko.css"> 