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

<div class="cats view large-9 medium-8 columns content">
	<div class="row">
	    <div class="grid">
    	    <div class="grid-sizer"></div>
            <div class="gutter-sizer"></div>
            <?php foreach ($cat->cat_images as $image): ?>
                <div class="grid-item">
                    <img src="<?= $image->url ?>"></img>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="row">
        <h4><?= __('Comments') ?></h4>
        <?php
            echo $this->Form->create(null, [
                'url' => 'cats/addComment',
                'id' => 'addComment'
            ]);
        ?>
        <?php if ($auth): ?>
        <div class="row">
            <?= $this->Form->input('cat_id', ['type' => 'hidden', 'id' => 'cat_id', 'value' => $cat->id]); ?>
            <div class="view large-10 medium-10 columns content">
                <?= $this->Form->input('comment', ['id' => 'comment', 'label' => false]); ?>
            </div>
            <div class="view large-2 medium-2 columns content">
                <?=$this->Form->submit('投稿', ['id' => 'js-submit-button', 'value'=>'投稿', 'label' => false]); ?>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
        <?php else: ?>
        <div class="row">
            <div class="view large-12 medium-12 columns content">
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
        </div>
        <?php endif; ?>
        
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
	  	    </div>
	  	</div>
        
        <script  type="text/javascript">
            var updateComments = function(data){
                $("#comment").val('');
                $("#comments").empty();
                $.each(data.comments, function() {
                    var cln = template.comment.clone();
                    cln.find('.chat-fukidashi').text(this.comment);
                    cln.find('.chat-face img').attr(
                        'src', 
                        "/cake_d_c/users/img/avatar_placeholder.png");
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
