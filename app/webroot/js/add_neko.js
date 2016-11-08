

//複数の画像ファイルアップロードに関する処理
var self = this;
var numFile = 0;
self.addListener(document.getElementById('image_'+numFile));

function addListener(imageElem){
    imageElem.onchange = function () {
        
        console.log(imageElem.parentElement.firstChild.nodeName);
        var imgElem;
        
        if(imageElem.parentElement.firstChild.nodeName != "IMG"){
            imgElem = document.createElement("img");
            // imgElem.setAttribute("id", "preview");
            imgElem.setAttribute("class", "preview");
            imageElem.parentElement.parentElement.firstElementChild.firstElementChild.setAttribute("name", "image[]");
            
            numFile++;
            
            var formParentElem = imageElem.parentElement.parentElement.cloneNode(true);
            var formElem = formParentElem.firstElementChild.firstElementChild;
            formElem.setAttribute("id", "image_"+numFile);
            formElem.setAttribute("name", "");
            self.addListener(formElem);
            
            imageElem.parentElement.insertBefore(imgElem, imageElem);
            imageElem.parentElement.parentElement.parentElement.appendChild(formParentElem);
            
            imageElem.parentElement.parentElement.removeChild(imageElem.parentElement.parentElement.children.item(1));
        }else{
            imgElem = imageElem.parentElement.firstChild;
        }
        
        var reader = new FileReader();
        reader.onload = function (e) {
            imgElem.src = e.target.result;
        };
    
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    };
}
$(function(){
    
    $(".details").hide();
    $("#input-details").click(function(e){
       e.preventDefault();
       $(".details").slideToggle('fast');
    });
    
    $('#address').change(function(){
        console.log("address changed");
        navigator.geolocation.getCurrentPosition(function (position) {
            var data = position.coords;
            var lat  = data.latitude;
            var lng  = data.longitude;
            $('#locate').val(lat + ',' + lng);
            console.log(lat + ',' + lng);
        });
    });
    
    $('#get_gps').click(function(e){
        e.preventDefault();
        
        navigator.geolocation.getCurrentPosition(function (position) {
            var data = position.coords;
            var lat  = data.latitude;
            var lng  = data.longitude;
            $('#locate').val(lat + ',' + lng);
            console.log(lat + ',' + lng);
            
            
            var url = 'https://maps.googleapis.com/maps/api/geocode/json';
            var data = { 
                latlng: ''+lat + ',' + lng, 
                key: "AIzaSyDf9qWkXjrjyzDnRUVdAitmu1gXUZ_u13g" 
            };
            $.get(url, data, function(data){
                // console.log(data);
                $('#address').val(data.results[0].formatted_address);
            });

        },
        function (error) {
            var errMsg;
            switch (error.code) {
                case 1:
                    errMsg = "位置情報の利用が許可されていません．設定から位置情報の使用を許可してください．";
                    break;
                case 2:
                    errMsg = "デバイスの位置が判定できません．";
                    break;
                case 3:
                    errMsg = "タイムアウトしました．";
                    break;
            }
            if (navigator.userAgent.match(/FBAN/)) {
                errMsg = "Facebookアプリでは位置情報が取得できませんので、タイムラインのリンクを長押しし外部のブラウザで起動して下さい。";
            }
            alert("位置情報の取得に失敗しました．" + errMsg);
        });
    });
});
 // 現在位置を設定
    window.now = function () {
        navigator.geolocation.getCurrentPosition(function (position) {
                var data = position.coords;
                var lat  = data.latitude;
                var lng  = data.longitude;
                document.getElementById('locate').value = lat + ',' + lng;
                var latlng = new google.maps.LatLng(lat, lng);

                if (nowPosition) nowPosition.setMap(null);
                nowPosition = createMapMarker(latlng, map, "cat_track");

                setTimeout(function () {
                    alert('間違いがなければ "投稿" ボタンをクリックしてください．');
                }, 100);
            },
            function (error) {
                var errMsg;
                switch (error.code) {
                    case 1:
                        errMsg = "位置情報の利用が許可されていません．設定から位置情報の使用を許可してください．";
                        break;
                    case 2:
                        errMsg = "デバイスの位置が判定できません．";
                        break;
                    case 3:
                        errMsg = "タイムアウトしました．";
                        break;
                }
                if (navigator.userAgent.match(/FBAN/)) {
                    errMsg = "Facebookアプリでは位置情報が取得できませんので、タイムラインのリンクを長押しし外部のブラウザで起動して下さい。";
                }
                alert("位置情報の取得に失敗しました．" + errMsg);
            }
        )
    };


