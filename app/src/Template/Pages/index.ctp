<div class="row">
    <div class="col-lg-12 text-center">
        <div id="tools">
            <div class="select-button-box">
                <a href="<?php echo$this->Url->build('/', false); ?>add_neko" id="js-neko-post" class="btn btn-default btn-lg">
                    報告する
                </a>
            </div>
        
            <div class="memo">
                <img src="<?php echo$this->Url->build('/img', false); ?>/cat_track.png"> のら猫がいる<span id="js-cat-count"></span>&nbsp;
            </div>
            <div id="filter_options" class="memo" style="display: none;">
                <div id="water_filter">
                    <div id="rousui_chk"><input name="water_flg" type="checkbox" value="4" checked></div>
                    <div id="no_chk"><input name="water_flg" type="checkbox" value="0" checked></div>
                    <div id="ok_chk"><input name="water_flg" type="checkbox" value="1" checked></div>
                    <div id="go_chk"><input name="water_flg" type="checkbox" value="2" checked></div>
                    <div id="notdrink_chk"><input name="water_flg" type="checkbox" value="3" checked></div>
                </div>
                <!--<div id="time-range">-->
                <!--    <p>-->
                <!--        <input type="text" id="amount" style="border: 0; color: #f6931f; font-weight: bold;" size="100"/>-->
                <!--    </p>-->
                <!--    <input type="hidden" id="start" value="<?php echo $from_time; ?>" >-->
                <!--    <input type="hidden" id="end" value="<?php echo $now + 1800; ?>" >-->
                <!--    <div id="slider-range"></div>-->
                <!--</div>-->
            </div>
        </div>
        <div class="map-rapper">
            <div id="map" class="map"></div>
        </div>
    
    </div>
</div>

<!-- maps window template -->
<script type="x-tmpl-mustache" id="template-info-window">
    <div class="infowin">{{datetime}}<br>
    <img src="img/cat_track.png"> 猫がいる
    {{comment}}<br>
    {{address}}<br>
    {{#url}}
    <a href="{{url}}" target="_blank"><img src="{{url}}" width="200" alt=""></a>
    {{/url}}
    </div>
</script>

<link rel="stylesheet" type="text/css" href="<?php echo$this->Url->build('/', false); ?>css/add_neko.css"> 

<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="<?php echo$this->Url->build('/', false); ?>js/jquery.ui.touch-punch.min.js"></script>
<script src="<?php echo$this->Url->build('/', false); ?>js/jquery.onoff.min.js"></script>
<script type="text/javascript" src="<?php echo$this->Url->build('/', false); ?>js/index.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAb1SFRkz9TtARWL_sPqw6D3oHCgbpLLcw&callback=initMap"></script>

<script>
    $( "#range-toggle" ).click(function() {
        $( "#filter_options" ).toggle( "fold", 1000 );
    });
    $('input[type="checkbox"]').onoff();
</script>
