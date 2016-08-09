<div class="row">
    <div class="col-lg-12 text-center">
        <div id="tools">
            <div class="select-button-box">
                <a href="<?php echo$this->Url->build('/', false); ?>add_neko" class="btn btn-default btn-lg">
                    報告する
                </a>
            </div>
        
            <div class="memo">
                <br>
                <img src="<?php echo$this->Url->build('/img', false); ?>/cat_track.png"> のら猫がいる<span id="rousui_count"></span>&nbsp;
                <button class="btn btn-default btn-xs" id="range-toggle">絞り込み</button>
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
                    <input type="hidden" id="end" value="<?php echo $now + 1800; ?>" >
                    <div id="slider-range"></div>
                </div>
            </div>
        </div>
        <div id="map"></div>
    
    </div>
</div>

<link rel="stylesheet" type="text/css" href="<?php echo$this->Url->build('/', false); ?>css/add_neko.css"> 

<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="<?php echo$this->Url->build('/', false); ?>js/jquery.ui.touch-punch.min.js"></script>
<script src="<?php echo$this->Url->build('/', false); ?>js/jquery.onoff.min.js"></script>
<script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="<?php echo$this->Url->build('/', false); ?>js/index.js"></script>
<script>
    $( "#range-toggle" ).click(function() {
        $( "#filter_options" ).toggle( "fold", 1000 );
    });
    $('input[type="checkbox"]').onoff();
</script>