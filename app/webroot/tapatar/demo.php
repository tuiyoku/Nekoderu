<?php
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Tapatar | Demo | Tapfiliate</title>

       <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
       
       <script async src="/tapatar/exif.js"></script>
       <script async src="/tapatar/megapix-image.js"></script>
        <script async src="/tapatar/tapatar.js"></script>
        <link rel="stylesheet" href="/tapatar/tapatar.css">

</head>

    <body data-spy="scroll" >
     
    <div class="ma spaced-big" style="width: 70px;">
        <input type="hidden" class="tapatar">
    </div>
           


<script>
$(window).on('load', function(){
    
    $('input.tapatar').tapatar({
        image_url_prefix: '/tapatar/img/',
        sources: {
        }
    });
});
</script>


</body>
</html>
