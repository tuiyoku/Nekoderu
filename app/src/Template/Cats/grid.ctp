<script src="//unpkg.com/masonry-layout@4.1/dist/masonry.pkgd.min.js"></script>
<style>
    html,body{
         height: 100%;
    }
    
    .grid-item { 
        width: 200px; 
        padding: 5px;
        box-shadow: 2px 2px 2px 2px rgba(0,0,0,0.2);
        margin-bottom: 8px;
        border-radius: 5px;
        
    }
    .grid-item--width2 { 
        width: 400px; 
        
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
      transform: translateY(-50%);
    }

</style>
<?php 
    $ear_images = ['normal', 'donno', 'trimmed_right', 'trimmed_left'];
?>
<div class="cats index large-12 medium-8 columns content">

    <div class="grid" data-masonry='{ "itemSelector": ".grid-item", "columnWidth": 200px }'>
        
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
                          <span class="glyphicon glyphicon-star" aria-hidden="true"></span> Star
                        </button>
                        <a href="/cats/view/<?=$cat->id ?>">
                        <button type="button" class="btn btn-default btn-sm">
                          <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Comment
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
          <span class="glyphicon glyphicon-camera" aria-hidden="true"></span> 報告する
        </button>
    </a>
</div>

<script type="text/javascript">
    $(function(){
        $('.grid').masonry({
          // options...
          itemSelector: '.grid-item',
          columnWidth: 200,
          gutter: 8
        });
    });
</script>
