<div id="tools">
    <div class="flex-container select-button-box">
        <a href="<?php echo$this->Url->build('/', false); ?>add_neko" class="post-button">
            ねこいますか？<br>報告する
        </a>
    </div>

    <div class="memo">
        <br>
        <img src="<?php echo$this->Url->build('/img', false); ?>/rousui.png"> 水漏れ<span id="rousui_count"></span>&nbsp;
        <img src="<?php echo$this->Url->build('/img', false); ?>/no.png"> 水出ない<span id="no_count"></span>&nbsp;
        <img src="<?php echo$this->Url->build('/img', false); ?>/ok.png"> 水出る<span id="ok_count"></span>&nbsp;
        <img src="<?php echo$this->Url->build('/img', false); ?>/go.png"> 水の提供可能<span id="go_count"></span>&nbsp;
        <img src="<?php echo$this->Url->build('/img', false); ?>/notdrink.png"> 水出るが飲めない<span id="notdrink_count"></span>&nbsp;&nbsp;&nbsp;
        <button id="range-toggle">絞り込み</button>
    </div>
    <div id="filter_options" class="memo" style="display: none;">
        <div id="water_filter">
            <div id="rousui_chk"><input name="water_flg" type="checkbox" value="4" checked></div>
            <div id="no_chk"><input name="water_flg" type="checkbox" value="0" checked></div>
            <div id="ok_chk"><input name="water_flg" type="checkbox" value="1" checked></div>
            <div id="go_chk"><input name="water_flg" type="checkbox" value="2" checked></div>
            <div id="notdrink_chk"><input name="water_flg" type="checkbox" value="3" checked></div>
        </div>
        <div id="time-range">
            <p>
                <input type="text" id="amount" style="border: 0; color: #f6931f; font-weight: bold;" size="100"/>
            </p>
            <input type="hidden" id="start" value="<?php echo $from_time; ?>" >
            <input type="hidden" id="end" value=""<?php echo $now + 1800; ?>" >
            <div id="slider-range"></div>
        </div>
    </div>
</div>
<div id="map"></div>
<div id="breaking_news" class="owl-carousel"></div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="<?php echo$this->Url->build('/', false); ?>js/jquery.ui.touch-punch.min.js"></script>
<script src="<?php echo$this->Url->build('/', false); ?>js/owl.carousel.min.js"></script>
<script src="<?php echo$this->Url->build('/', false); ?>js/jquery.onoff.min.js"></script>
<script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="<?php echo$this->Url->build('/', false); ?>js/index.js"></script>
<script>
    $( "#range-toggle" ).click(function() {
        $( "#filter_options" ).toggle( "fold", 1000 );
    });
    $('input[type="checkbox"]').onoff();
</script>