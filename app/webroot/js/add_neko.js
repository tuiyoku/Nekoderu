 $(function(){
            var modal = $("#myModal");
           
            $(window).click(function(e) {
                console.log(e);
                if (e.target == modal) {
                    modal.css('display', 'none');
                }
            });
            
            $("#myModal .modal-content .close").click(function(){
                modal.css('display', 'none');
            });
            
            $("#ear-info").click(function(e){
                modal.css('display', 'block');
            });
        });
        function showEarInfo(){
            
            var modal = $("#myModal");
            console.log(model);
            modal.css('display', 'block');

            alert('<h3>耳について</h3><div>さくら耳の説明とか書く</div>'); 
            return false;
        }