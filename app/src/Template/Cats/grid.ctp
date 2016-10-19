<script src="//unpkg.com/masonry-layout@4.1/dist/masonry.pkgd.min.js"></script>
<style>
    html,body{
         height: 100%;
    }
    
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
    
    .gutter-sizer { 
        width: 2%; 
    }
    
    .grid-buttons{
        margin-top: 2px;
    }
    
    .grid-comment{
        font-size:12px;
        padding: 2px;
        padding-left: 10px;
    }
    
    .btn-default {
        background-image: none;
    }
    
    .grid {
        padding-bottom: 50px;
    }
    
    #add-neko{
        background-color: white;
        border-width: 1px;
        border-color: gray;
        position: fixed;
        bottom: 0;
        width: 100%;
        height: 50px;
    }
    
    #add-neko button {
      position: absolute;
      top: 50%;
      left: 40%;
      transform: translate(-20%, -50%);
    }

</style>
<?php 
    $ear_images = ['normal', 'donno', 'trimmed_right', 'trimmed_left'];
?>
<div class="cats index large-12 medium-8 columns content">

    <div class="grid">
        <div class="grid-sizer"></div>
        <div class="gutter-sizer"></div>
        <?php foreach ($cats as $cat): ?>
            <?php foreach ($cat->cat_images as $image): ?>
                <div class="grid-item">
                    <div><img src="<?= $image->url ?>"></img></div>
                    <div>
                        <?php foreach ($cat->comments as $idx => $comment): ?>
                            <?php if($idx >= 3) break; ?>
                            <div class="grid-comment"><?= $comment->comment ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="grid-buttons">
                        <img width='20px' src='/img/cat_ears/<?="cat_".$ear_images[$cat->ear_shape].".png" ?>'>
                        <button type="button" class="btn btn-default btn-sm">
                          <span class="glyphicon glyphicon-star" aria-hidden="true"></span> 1
                        </button>
                        <a href="/cats/view/<?=$cat->id ?>">
                        <button type="button" class="btn btn-default btn-sm">
                          <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <?=count($cat->comments) ?>
                        </button>
                        </a>
                    </div>
                    </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
</div>
<div id="add-neko">
    <a href="<?=$this->Url->build('/', false); ?>cats/add">
        <button type="button" class="btn btn-default btn-sm">
          <span class="glyphicon glyphicon-camera" aria-hidden="true"></span> 投稿する
        </button>
    </a>
</div>

<script type="text/javascript">
    $(function(){
        var $grid = $('.grid').masonry({
            columnWidth: '.grid-sizer',
            gutter: '.gutter-sizer',
            itemSelector: '.grid-item',
            percentPosition: true,
            initLayout: true
        });
        // bind event
        // $grid.masonry( 'on', 'layoutComplete', function() {
        //   console.log('layout is complete');
        // });
        // trigger initial layout
        $grid.masonry();
    });
</script>
