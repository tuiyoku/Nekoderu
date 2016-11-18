<script src="https://unpkg.com/imagesloaded@4.1/imagesloaded.pkgd.min.js"></script>
<script src="//unpkg.com/masonry-layout@4.1/dist/masonry.pkgd.min.js"></script>

<!-- The Modal -->
<div id="modal-status" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="container clearfix">
            <span style="text-align:right" class="close">閉じる</span>
        </div>
        <h3 style="margin-top:10px;margin-bottom:20px;"><?= $cat->response_status->title ?></h3>
        <div><?= $cat->response_status->description ?></div>
    </div>
</div>

<div class="cats view large-9 medium-8 columns content">
    <?php if($auth && $cat->user && $auth['id'] == $cat->user->id): ?>
        <div class="row user_menu">
            <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $cat->id, ],
                ['confirm' => __('本当に削除してもいいですか？', $cat->id), 'class' => 'btn btn-danger btn-sm']) ?>
        </div>
    <?php endif; ?>
	<div class="row">
	    <div class="grid">
    	    <div class="grid-sizer"></div>
            <div class="gutter-sizer"></div>
            <?php foreach ($cat->cat_images as $image): ?>
                <div class="grid-item">
                    <?php if($image->thumbnail):?>
                        <a class='gallery' href="<?= $image->url ?>"><img src="<?= $image->thumbnail ?>"></img></a>
                    <?php else: ?>
                        <a class='gallery' href="<?= $image->url ?>"><img src="<?= $image->url ?>"></img></a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
   
    <div class="row">
        <?php
            echo $this->Form->create(null, [
                'url' => 'cats/addComment.json',
                'id' => 'addComment',
                'enctype' => 'multipart/form-data'
            ]);
        ?>
        <?php if ($auth): ?>
            <!--<?= $this->element('partial/multi_image_selector'); ?>-->
            <?= $this->Form->input('cat_id', ['type' => 'hidden', 'id' => 'cat_id', 'value' => $cat->id]); ?>
                <?= $this->Form->input('comment', ['id' => 'comment', 'label' => false]); ?>
                <?=$this->Form->submit('投稿', ['id' => 'js-submit-button', 'value'=>'投稿', 'label' => false]); ?>
        <?php else: ?>
            <div>
                <?= $this->Form->input('comment', [
                    'id' => 'comment', 
                    'label' => false,
                    'disabled' => true,
                    'placeholder' => 'ログインするとコメントを投稿できます'
                ]); ?>
            </div>
            <div class="view large-12 medium-12 columns content">
                <a href="/login">ログインする</a>
            </div>
        <?php endif; ?>
        <?php echo $this->Form->end(); ?>
        </div>
        <div class="row" id="comments">
            <div class="comment" hidden>
                <div class="chat-face">
    			    <img src="" width="30" height="30">
    		    </div>
    		    <div class="chat-info"><span class="chat-id">id here</span> - <span class="chat-time">time here</span></div>
    			<div class="chat-fukidashi">
    			  コメントテンプレート
    			</div>
    		    <div class="chat-menu"><a href="#" class="chat-trash"><i class="glyphicon glyphicon-trash"></i></a></div>
      	    </div>
        </div>
    </div>
</div>

<style>
.grid-sizer, .grid-item { 
    width: 48%; 
    padding: 5px;
    box-shadow: 2px 2px 2px 2px rgba(0,0,0,0.2);
    margin-bottom: 8px;
    border-radius: 5px;
}

.grid-item--width2 { 
    width: 80%; 
}

.grid-sizer {
    visibility: hidden;
}

.gutter-sizer { 
    width: 2%; 
}

#addComment {
    margin-top: 10px;
}

#addComment .text{
    display: inline-block;
    margin-bottom: 0px;
    width : calc(100% - 90px);
}

#addComment .submit{
    display: inline-block;
    float:right;
    width : 80px;
}


#photos {
    margin-left: 0;
    margin-bottom: 10px;
}

#photos .button-file {
    height: 60px;
    width: 60px;
}

#photos .button-file span {
    line-height: 60px;
}

#photos .button-file img {
    height: 60px;
    width: 60px;
}

.user_menu {
    margin-bottom: 10px;
}
.user_menu .btn {
    float: right;
}
</style>

<script>
$(function(){
    setModal("modal-status", "status-info");
});
</script>

<script>
$(function(){
    $('a.gallery').magnificPopup({
        type:'image',
        gallery:{
            enabled:true
        },
        callbacks: {
            open: function() {
            },
            close: function() {
              // Will fire when popup is closed
            }
        }
        
    });
});
</script>

<script>
var imageURLCache = {};

var updateComments = function(data){
    $("#comment").val('');
    $("#comments").empty();
    $("#addComment .submit input").prop("disabled", false);
    $("#addComment .submit input").attr('value', '投稿');
    
    $.each(data.comments, function() {
        var url;
        var cln = template.comment.clone();
        
        if(isJSON(this.comment)){
            var data = $.parseJSON(this.comment);
            var part = '<div>';
            data.media.forEach(function(url){
                part += '<img style="height:64px; margin-left:5px; margin-top:5px;" src=' + url + '></img>';
            });
            part +='</div>';
            part +='<div>'+data.comment+'</div>';
            cln.find('.chat-fukidashi').html(part);
            
        }else{
            cln.find('.chat-fukidashi').text(this.comment);
        }
        cln.find('.chat-id').html('<a href="/profiles/user/'+this.user.username+'">@'+this.user.username+'</a>');
        cln.find('.chat-time').text(new Date(this.created).toTwitterRelativeTime('ja') );
        
        var key = this.users_id;
        console.log(imageURLCache);
        if(key in imageURLCache){
            cln.find('.chat-face img').attr('style', 'background-image: url('+imageURLCache[key]+');');
            
            if("/tapatar/img/default.svg" === imageURLCache[key]){
                cln.find('.chat-face img').remove();
                $('.chat-info, .chat-fukidashi').css('margin-left', '0');
            }
                    
        }else{
            $.get({                                                              
                url: '/profiles/thumbnail/' + key + '.json'
            }).done(function(data) {
                imageURLCache[key] = data;
                cln.find('.chat-face img').attr('style', 'background-image: url('+imageURLCache[key]+');');
                
                if("/tapatar/img/default.svg" === imageURLCache[key]){
                    cln.find('.chat-face img').remove();
                    cln.find('.chat-info, .chat-fukidashi').css('margin-left', '0');
                    cln.find('.chat-info, .chat-fukidashi').css('width', 'calc(80% + 40px)');
                }
                    
            });  
        }
        
        if(this.users_id !== "<?= $auth['id'] ?>"){
            cln.find('.chat-menu').remove();
        }else{
            var id = this.id;
            cln.find('a.chat-trash').click(function(e){
                e.preventDefault();
                (function(cln) {
                    if(confirm("本当に削除していいですか？")){
                        $.get({
                            url: '/cats/deleteComment/'+id+'.json',
                            success: function(response){
                                (function(cln) {
                                    console.log(response);
                                    cln.fadeOut(200, function(){
                                        cln.remove();
                                    });
                                })(cln);
                            },
                            error: function(response){
                                console.log(response);
                            }
                        });
                    }
                })(cln);
            });
        }
        
       $("#comments").append(cln);
       cln.show();
    });
    if($(".comment:first").length > 0){
        $(".comment:first").hide();
        $(".comment:first").slideDown(100);
        $("html,body").animate({scrollTop:$('.comment:first').offset().top});
    }
};

$(function(){
    createTemplate("#comments .comment:first", "comment");
    
    $.post({                                                                            
        url: '/cats/comments/<?= $cat->id ?>.json',                   
    }).done(function(data) {
        updateComments(data);
    });         
});

$('#addComment').submit(function(event) {                                                               
    event.preventDefault();
    
    if($("#comment").val().length <= 0)
        return;
    
    $("#addComment .submit input").prop("disabled", true);
    $("#addComment .submit input").attr('value', '投稿中');
    
    // 操作対象のフォーム要素を取得
    var $form = $(this);
    
    // 送信
    $.ajax({
        url: $form.attr('action'),
        method: $form.attr('method'),
        dataType: 'json',
        data: new FormData($('#addComment').get()[0]),
        processData: false,
        contentType: false,
        timeout: 10000,  // 単位はミリ秒
        // 通信成功時の処理
        success: function(result, textStatus, xhr) {
            console.log(result);
            $.post({                                                                            
                url: '/cats/comments/<?= $cat->id ?>.json',                   
            }).done(function(data) {
                updateComments(data);
            });     
        },
        // 通信失敗時の処理
        error: function(xhr, textStatus, error) {
            console.log(error);
        }
    });
        
    // $.post({                                                                            
    //     url: '/cats/addComment.json',                   
    //     data: { data: $(this).serialize() },                                                      
    // }).done(function(data) {
    //     $.post({                                                                            
    //         url: '/cats/comments/<?= $cat->id ?>.json',                   
    //     }).done(function(data) {
    //         updateComments(data);
    //     });         
    // });                                                                                           
 }); 
</script>
<script type="text/javascript">
    var container = document.querySelector('.grid');
    imagesLoaded(container, function () {
        var $grid = $('.grid').masonry({
            columnWidth: '.grid-sizer',
            gutter: '.gutter-sizer',
            itemSelector: '.grid-item',
            percentPosition: true
        });
        $grid.masonry();
    });
</script>

<link rel="stylesheet" type="text/css" href="<?php echo$this->Url->build('/', false); ?>css/modal.css">
<link rel="stylesheet" type="text/css" href="<?php echo$this->Url->build('/', false); ?>css/lightbox/magnific-popup.css"> 
<script src="<?php echo$this->Url->build('/', false); ?>js/lightbox/jquery.magnific-popup.js"></script>
<script async src="/tapatar/exif.js"></script>
<script async src="/tapatar/megapix-image.js"></script>
<script src="/js/twitter.relative.time.min.js"></script>


