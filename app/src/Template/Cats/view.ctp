<script src="https://unpkg.com/imagesloaded@4.1/imagesloaded.pkgd.min.js"></script>
<script src="//unpkg.com/masonry-layout@4.1/dist/masonry.pkgd.min.js"></script>
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
</style>
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
                'url' => 'cats/addComment',
                'id' => 'addComment'
            ]);
        ?>
        <?php if ($auth): ?>
            <?= $this->Form->input('cat_id', ['type' => 'hidden', 'id' => 'cat_id', 'value' => $cat->id]); ?>
            <div>
                <?= $this->Form->input('comment', ['id' => 'comment', 'label' => false]); ?>
                <?=$this->Form->submit('コメント投稿', ['id' => 'js-submit-button', 'value'=>'コメント投稿', 'label' => false]); ?>
            </div>
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
		    <div class="chat-area">
    			<div class="chat-fukidashi">
    			  コメントテンプレート
    			</div>
		    </div>
		    <div class="chat-menu"><a href="#"><i class="glyphicon glyphicon-trash"></i></a></div>
  	    </div>
  	</div>
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
        
        <script  type="text/javascript">
            var imageURLCache = {};
    
            var updateComments = function(data){
                $("#comment").val('');
                $("#comments").empty();
                $("#addComment .submit input").prop("disabled", false);
                $("#addComment .submit input").attr('value', '投稿');
                
                $.each(data.comments, function() {
                    var url;
                    var cln = template.comment.clone();
                    cln.find('.chat-fukidashi').text(this.comment);
                    // cln.find('form').attr('action', '/cats/delete/'+this.id);
                    var key = this.users_id;
                    if(key in imageURLCache){
                        cln.find('.chat-face img').attr('style', 'background-image: url('+imageURLCache[key]+');');
                    }else{
                        $.get({                                                              
                            url: '/profiles/thumbnail/' + key + '.json'
                        }).done(function(data) {
                            imageURLCache[key] = data;
                            cln.find('.chat-face img').attr('style', 'background-image: url('+imageURLCache[key]+');');
                        });  
                    }
                    
                    if(this.users_id !== "<?= $auth['id'] ?>"){
                        cln.find('.chat-menu').remove();
                    }else{
                        var id = this.id;
                        cln.find('a').click(function(e){
                            e.stopPropagation();
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
        
            $('#addComment').on('submit', function() {                                                               
                event.preventDefault();                                                                       
                event.stopPropagation();
                if($("#comment").val().length <= 0)
                    return;
                
                $("#addComment .submit input").prop("disabled", true);
                $("#addComment .submit input").attr('value', '投稿中');
                
                $.post({                                                                            
                    url: '/cats/addComment.json',                   
                    data: { data: $(this).serialize() },                                                      
                }).done(function(data) {
                    $.post({                                                                            
                        url: '/cats/comments/<?= $cat->id ?>.json',                   
                    }).done(function(data) {
                        updateComments(data);
                    });         
                });                                                                                           
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
    </div>
</div>

<link rel="stylesheet" type="text/css" href="<?php echo$this->Url->build('/', false); ?>css/modal.css">
<link rel="stylesheet" type="text/css" href="<?php echo$this->Url->build('/', false); ?>css/lightbox/magnific-popup.css"> 
<script src="<?php echo$this->Url->build('/', false); ?>js/lightbox/jquery.magnific-popup.js"></script>
