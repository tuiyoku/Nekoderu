<div id="notifications">
    <div class="notification">
        <a href="#" target="_top" >
            <div class="time"><small>時間</small></div>
            <div class="title">
                たいとる
            </div>
            <div class="content">
                内容
            </div>
        </a>
    </div>
</div>

<style>
    .notfication a, a:link, a:visited, a:hover, a:active {
        color: black;
        text-decoration: none;
    }
    
    .notfication a:hover  {
        background-color: yellow;
    }
    
    .notification {
        padding: 10px;
        border-bottom: solid 1px #cccccc;
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
        if(notification.unread == 1)
            cln.find(".content").css('border-left-color', 'orange');
        else
            cln.find(".content").css('border-left-color', 'gray');
        cln.find(".time small").text(new Date(notification.created).toTwitterRelativeTime('ja'));
        cln.find("a").attr("href", notification.url);
        cln.find("a").click(function(e){
            e.preventDefault();
            var self = $(this);
            $.get({
                url: "/profiles/markRead/"+notification.id+".json",
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
