<div style="margin:15px 0;text-align:center">
    水漏れを報告してください
</div>
<form action="" enctype="multipart/form-data" method="POST" id="post" onsubmit="return confirm('送信してもいいですか？');">
    <input type="hidden" id="time" name="time" value="">
    <input type="hidden" name="locate" id="locate" value="">

    <div id='now' class="box">
        <div class="memo-title">
            <a href="javascript:void(0)" onclick="now()">１．位置を設定する</a>
        </div>
        <div class="memo">本体の設定から位置情報の利用を許可してください．</div>
    </div>
    <div class="box">
        <div class="memo-title">２．水漏れ箇所の情報を入力する</div>
        <textarea id="comment" name="comment"></textarea>
    </div>
    <div class="box">
        <div class="memo-title">３．写真があれば添付してください</div>
        <label class="button-file">
            <input type="file" class="hide" id="image" name="image" value="">
            写真を選ぶ
        </label>
    </div>
    <div class="box-mini">
        <input type="submit" id="js-submit-button" name="submit" value="投稿">
    </div>
    <div class="patchworks">
        <span class="memo">sojo univ. patchworks</span>
    </div>
</form>

<div id="map"></div>
<div id="customZoomBtn">
    <div id="small" class="float_l btn">ズームアウト</div>
    <div id="big" class="float_l btn">ズームイン</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="<?php echo$this->Url->build('/', true); ?>js/rousui_post.js"></script>