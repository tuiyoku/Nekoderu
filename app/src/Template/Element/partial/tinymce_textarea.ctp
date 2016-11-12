<!--写真アップ可能なエディタ-->
<!--作りかけて挫折したものです-->
 
<div class="cats view large-9 medium-8 columns content">
<div clsss='row'>
    <textarea style="white-space: pre-wrap;"id="message"></textarea>
    <div class="btn" id="photo-button"><i class='glyphicon glyphicon-camera'></i></div>
    <?php
        echo $this->Form->create(null, [
            'url' => 'cats/addPhoto.json',
            'id' => 'photo-upload-form',
            'enctype' => 'multipart/form-data'
        ]);
    ?>
        <?= $this->Form->input('cat_id', ['type' => 'hidden', 'name' => 'cat_id', 'value' => $cat->id]); ?>
        <?= $this->Form->file('image', ['type' => 'hidden', 'name' => 'image', 'id' => 'hidden-photo-input']); ?>
    <?php echo $this->Form->end(); ?>
</div>
</div>
    
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
tinymce.init({ 
        selector:'textarea',
        statusbar: false,
        plugins: 'code',
        toolbar: false,
        menubar: false,
        images_upload_url: 'postAcceptor.php',
        images_upload_base_path: '/some/basepath',
        images_upload_credentials: true,
        setup: function (editor) {
            editor.on('init', function (e) {
            });
        }
    });
    
    // tinymce.activeEditor.uploadImages(function(success) {
    //   $.post('ajax/post.php', tinymce.activeEditor.getContent()).done(function() {
    //     console.log("Uploaded images and posted content as an ajax request.");
    //   });
    // });

    // tinymce.activeEditor.uploadImages(function(success) {
    //   document.forms[0].submit();
    // });
    
    $('#photo-button').click(function(e){
        e.preventDefault();
        $('#hidden-photo-input').trigger('click');   
    });
    $('#hidden-photo-input').hide();
    $('#hidden-photo-input').change(function(e){
        console.log("submit");
        
        
        var f = $(this)[0].files[0];
            var reader = new FileReader();
            reader.onload = (function(theFile) {
              return function(e) {
                //if EXIF and MegaPixImage exists modify orientation based on EXIF information
                if(typeof EXIF !== 'undefined' && typeof MegaPixImage !== 'undefined'){
                    EXIF.getData(theFile, function(){
                        var orientation = theFile.exifdata.Orientation;
                        var img = new Image();
                        new MegaPixImage(theFile).render(img, { orientation: orientation });
                        
                        (function(){
                            if (img.src){
                                console.log(img.src);
                                tinymce.activeEditor.insertContent('<img width="64" src="'+img.src+'">');
                            }else{
                                setTimeout(arguments.callee, 100);
                            }
                        })();
                    });
                }else{
                    tinymce.activeEditor.insertContent('<img width="64" src="'+e.target.result+'">');
                }
              };
            })(f);
            // read the image file as a data URL.
            reader.readAsDataURL(f);
        
        
        // $('#photo-upload-form').submit(function(event) {
        //      event.preventDefault();
        
        //     // 操作対象のフォーム要素を取得
        //     var $form = $(this);
            
        //     // 送信
        //     $.ajax({
        //         url: $form.attr('action'),
        //         method: $form.attr('method'),
        //         dataType: 'json',
        //         data: new FormData($('#photo-upload-form').get()[0]),
        //         processData: false,
        //         contentType: false,
        //         timeout: 10000,  // 単位はミリ秒
        //         // 通信成功時の処理
        //         success: function(result, textStatus, xhr) {
        //             console.log(result);
        //             // 入力値を初期化
        //             // $form[0].reset();
        //             // $('#result').text('OK');
                    
        //             tinymce.activeEditor.insertContent('<img src="'+result.response.thumbnail+'">\n');
        //         },
        //         // 通信失敗時の処理
        //         error: function(xhr, textStatus, error) {
        //             console.log(error);
        //             tinymce.activeEditor.setContent(''+error);
        //         }
        //     });
        // });
        // $('#photo-upload-form').submit();
    });
    

</script>