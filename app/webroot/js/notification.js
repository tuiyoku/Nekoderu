'use strict';

$(function(){
    $(".notification-count a").hide();
    
    var countUnread = function(){
        // console.log("checking");
        $.get({
            url:"/profiles/countUnread.json"
        }).done(function (data){
            // console.log(data);
            if(data.count > 0){
                $(".notification-count a").show();
                $(".notification-count .count").text(data.count);
                $(".notification-count a").click(function(e) {
                    e.preventDefault();
                    $.magnificPopup.open({
                        items: {
                          src: '#notification-popup',
                          type: 'inline'
                      }
                    }, 0);
                })
            }else{
                $(".notification-count a").hide();
            }
        });
    }
    countUnread();
    setInterval(countUnread, 30*1000);
   
});