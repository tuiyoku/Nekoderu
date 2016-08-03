 $(function(){
     
    
    setModal("modal-ear", "ear-info");
    setModal("modal-gps", "gps-info");
   
    
});

function setModal(id, btn){
    var modal = $("#"+id);
   
    $(window).click(function(e) {
        if (e.target.id === modal.attr('id')) {
            modal.css('display', 'none');
        }
    });
    
    $("#"+id+" .modal-content .close").click(function(){
        modal.css('display', 'none');
    });
    
     $("#"+btn).click(function(e){
        var modal = $("#"+id);
        modal.css('display', 'block');
    });
    
}
