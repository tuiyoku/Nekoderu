<div id="notifications">
    <div class="notification">
        <a href="#" target="_top" >
            <div>
                <div class="time"><small>時間</small></div>
                    <div class="title">たいとる
                </div>
                <div class="content">
                    内容
                </div>
            </div>
        </a>
        <div class="btn btn-sm btn-default">既読にする</div>
    </div>
</div>

<style>
    .notfication a, .notfication a:link, .notfication a:visited, .notfication a:hover, .notfication a:active {
        color: black;
        text-decoration: none;
    }
    
    .notfication a:hover  {
        background-color: yellow;
    }
    
    .notification {
        padding: 10px;
        border-bottom: solid 1px #cccccc;
        position: relative;
    }
  
    .notification .time {
        float: right;
        padding-left: 10px;
    }
    .notification .time small {
        vertical-align: top;
    }
    
    .notification .title {
        font-size: 12px;
        margin-bottom: 5px;
    }
    
    .notification .content {
        font-size: 12px;
        padding-left: 5px;
        border-left: solid 3px orange;
    }
    
    .notification div.btn {
        width: 100%;
        margin-top: 10px;
    }
    
    .btn-default {
        background-image: none;
    }
    
</style>

<script>
$(function(){
    createTemplate("#notifications .notification:first", "notification");
    $("#notifications .notification:first").remove();
    
    var limit = <?= $limit ?>;
    if(limit > 0){
        $url = "/profiles/notifications"+"/"+limit+".json"
    }else{
        $url = "/profiles/notifications.json"
    }
    $.get({                                                                            
        url: $url,                   
    }).done(function(data) {
        updateNotifications(data);
    });         
});

function updateNotifications(data){
    // console.log(data);
    $("#notifications").empty();
    
    data.notifications.forEach(function(notification){
        var cln = template.notification.clone();
        cln.find(".title").text(notification.title);
        cln.find(".content").html(notification.description);
        if(notification.unread == 1){
            cln.find(".content").css('border-left-color', 'orange');
            cln.find("div.btn").click(function(e){
                e.preventDefault();
                var not = notification;
                var self = $(this);
                var line = cln.find(".content");
                $.get({
                    url: "/profiles/markRead/"+not.id+".json",
                }).done(function(data){
                    self.slideUp(500);
                    line.css('border-left-color', 'gray');
                });
            });
        }else{
            cln.find(".content").css('border-left-color', 'gray');
            cln.find("div.btn").hide();
        }
        cln.find(".time small").text(new Date(notification.created).toTwitterRelativeTime('ja'));
        cln.find("a").attr("href", notification.url);
        cln.find("a").click(function(e){
            e.preventDefault();
            var self = $(this);
            var not = notification;
            $.get({
                url: "/profiles/markRead/"+not.id+".json",
            }).done(function(data){
                self.unbind('click').click();
            });
        });
        
    var limit = <?= $limit ?>;
        if(limit>0 && !notification.unread){
            // cln.css('background-color', '#cccccc');
        }else{
            $("#notifications").append(cln);
        }
        
    });
}
</script>

<script src="/js/twitter.relative.time.min.js"></script>
