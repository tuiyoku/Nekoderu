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
    .notfication a:link, a:visited, a:hover, a:active {
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
    
    $.get({                                                                            
        url: '/profiles/notifications.json',                   
    }).done(function(data) {
        updateNotifications(data);
    });         
});

function updateNotifications(data){
    $("#notifications").empty();
    data.notifications.forEach(function(notification){
        var cln = template.notification.clone();
        cln.find(".title").text(notification.title);
        cln.find(".content").html(notification.description);
        cln.find(".time small").text(new Date(notification.created).toTwitterRelativeTime('ja'));
        cln.find("a").attr("href", notification.url);
        cln.find("a").click(function(e){
            // e.preventDefault();
            $.get({
                url: "/profiles/markRead/"+notification.id+".json",
            }).done(function(data){
                // console.log(data);
                // updateNotifications(data);
            });
        });
        // if(!notification.unread){
        //     cln.css('background-color', '#cccccc');
        // }
        $("#notifications").prepend(cln);
        
    });
}
</script>

<script src="/js/twitter.relative.time.min.js"></script>
