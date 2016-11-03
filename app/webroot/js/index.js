'use strict';

window.app = {};
app.gMarkers = [];
app.infoWindows = [];

(function ($) {
    
    /**
     * Google Maps初期化時にコール
     * Google Mapsをレンタリング
     */
    window.initMap = function () {
        console.log('initMap');
    
        var init = getInitMapLocation();
        
        // 座標データがある場合は SessionStorage から読み込む
        if (hasLocationItem() === true) {
            var data = JSON.parse( sessionStorage.getItem( 'google-map-post-location' ) );
            
            // overwrite
            init.lat = data.lat;
            init.lng = data.lng;
            init.zoom = data.zoom;
        }
        
        var center = new google.maps.LatLng(init.lat, init.lng);
        var zoom   = data ? data.zoom : init.zoom;
        
        var mapEl = document.getElementById('map');
        app.gMap = new google.maps.Map(mapEl, {
                center: center,
                zoom: zoom,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            
        // イベント登録
        google.maps.event.addListener(app.gMap, 'zoom_changed', function() {
            console.log('call zoom change event');
            saveLocationItem();
        });
        
        // リクエスト
        promiseCatList()
            .done(function (response) {
                console.log(response);
                $("#js-cat-count").text("(" + response.cats.length + ")");
                renderNekoderu(response.cats);
            })
            .fail(function (error) {
                console.error(error);
                alert(JSON.stringify(error));
            });
    };
    
    /**
     * Event: DOMContentLoaded
     * DOMの準備ができたら呼ばれる場所
     */
    $(function () {
        console.log("ready");
        
        // イベント登録
        var nekoPostButton = document.getElementById('js-neko-post');
        nekoPostButton.addEventListener('click', function () {
            saveLocationItem();
        });
    });
    
    
    // だいたい熊本市
    function getInitMapLocation () {
        return {
            lat  : 32.7858659,
            lng  : 130.7633434,
            zoom : 9
        };
    }
    
    function getLocationItem () {
        return sessionStorage.getItem( 'google-map-post-location' );
    }
    
    function hasLocationItem () {
        return !!getLocationItem();
    }
    
    function saveLocationItem () {
        var map = app.gMap;
        var currentCenter = map.getCenter();

        var ss = {
            lat  : currentCenter.lat(),
            lng  : currentCenter.lng(),
            zoom : map.getZoom()
        };
        sessionStorage.setItem('google-map-post-location', JSON.stringify(ss));
        return ss;
    }
    
    /**
     * ネコアイコンをマップに表示する
     * 現状猫しかいないため、マーカー固定
     */
    function renderNekoderu (data) {
        removeMarkers();
        
        console.log(data);
        
        Object.keys(data).forEach(function (key) {
            var item    = data[key];
            var locates = item.locate.split(/,/);
            var modified    = item.modified;
            var comments = item.comments;
            var cat_images  = item.cat_images;
            var ear_shape  = item.ear_shape;
            var status  = item.status;
            var flag    = item.flg;
            var id      = item.id;
            var icon    = '';
            
            
            var ear_images = ['normal', 'donno', 'trimmed_right', 'trimmed_left'];
            var ear_statuses = ['処置なし', '不明', '右耳に印', '左耳に印'];
            
            
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(locates[0], locates[1]),
                map: app.gMap,
                icon: '/img/' + 'cat_track' + '.png'
            });
            var template = $('#template-info-window').html();
            Mustache.parse(template);
            google.maps.event.addListener(marker, 'click', function (e) {
                
                new google.maps.Geocoder().geocode({
                    latLng: marker.getPosition()
                }, function (result, status) {
                    if (status !== google.maps.GeocoderStatus.OK) return;
                    
                    console.log(result);
                    
                    hideInfoWindows();
                    var rendered = Mustache.render(template,
                        {
                            modified:   modified,
                            comments:   comments,
                            has_comment: comments.length > 0,
                            address:    result[0].formatted_address,
                            ear_shape:  ear_shape,
                            ear_image:  "cat_"+ear_images[ear_shape]+".png",
                            ear_status: ear_statuses[ear_shape],
                            cat_images: cat_images,
                            id:         id
                        });
                    var gmiw = new google.maps.InfoWindow({
                        content: rendered
                    });
                    
                    gmiw.open(marker.getMap(), marker);
                    app.infoWindows.push(gmiw);
                    
                    console.log($(".lightbox"));
                    $(".lightbox").lightbox();
                });
            
                
            });
            
            app.gMarkers.push(marker);
        });
    }
    
    function hideInfoWindows(){
        for(var i = 0, len = app.infoWindows.length; i < len; i++){
            app.infoWindows[i].close();
        }
    }
    
    function removeMarkers(){
        for(var i = 0, len = app.gMarkers.length; i < len; i++){
            app.gMarkers[i].setMap(null);
        }
    }
    
    function promiseCatList (start, end, flag) {
        var now = new Date();
        var duration = 60 * 60 * 24 * 365 * 1000; // milliseconds
        var start = new Date(now.getTime() - duration);
        var noranekoFlag = 4; // other 0,1,2,3
        return requestCatList(formatDate(start), formatDate(now), noranekoFlag);
    }
    
    /**
     * 既存の猫登録データをリクエストして取得する
     * @param start 検索データ開始日
     * @param end 検索データ終了日
     * @param flag 検索項目 現状4が猫のデータ
     * @return promise
     */
    function requestCatList (start, end, flag) {
      return $.ajax({
            url: '/cats/data.json',
            type: 'get',
            data: {
                map_start: start,
                map_end: end,
                map_flg: flag
            }
        }).promise();  
    }
    
    /**
     * 日付をフォーマットする
     * @param  {Date}   date     日付
     * @param  {String} [format] フォーマット
     * @return {String}          フォーマット済み日付
     */
    function formatDate (date, oFormat) {
        var format = oFormat || 'YYYY-MM-DD hh:mm:ss.SSS';
        
        format = format.replace(/YYYY/g, date.getFullYear());
        format = format.replace(/MM/g, ('0' + (date.getMonth() + 1)).slice(-2));
        format = format.replace(/DD/g, ('0' + date.getDate()).slice(-2));
        format = format.replace(/hh/g, ('0' + date.getHours()).slice(-2));
        format = format.replace(/mm/g, ('0' + date.getMinutes()).slice(-2));
        format = format.replace(/ss/g, ('0' + date.getSeconds()).slice(-2));
        if (format.match(/S/g)) {
            var milliSeconds = ('00' + date.getMilliseconds()).slice(-3);
            var length = format.match(/S/g).length;
            for (var i = 0; i < length; i++) format = format.replace(/S/, milliSeconds.substring(i, i + 1));
        }
        return format;
    }
    
})(window.jQuery || {});
