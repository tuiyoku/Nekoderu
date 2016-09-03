 $(function(){
     
    
    setModal("modal-ear", "ear-info");
    setModal("modal-gps", "gps-info");
    
    
});

//複数ファイル選択に関する処理
var self = this;
var numFile = 0;
self.addListener(document.getElementById('image_'+numFile));

function addListener(imageElem){
    imageElem.onchange = function () {
        
        console.log(imageElem.parentElement.firstChild.nodeName);
        var imgElem;
        
        if(imageElem.parentElement.firstChild.nodeName != "IMG"){
            imgElem = document.createElement("img");
            // imgElem.setAttribute("id", "preview");
            imgElem.setAttribute("class", "preview");
            
            numFile++;
            
            var formParentElem = imageElem.parentElement.parentElement.cloneNode(true);
            var formElem = formParentElem.firstElementChild.firstElementChild;
            formElem.setAttribute("id", "image_"+numFile);
            self.addListener(formElem);
            
            imageElem.parentElement.insertBefore(imgElem, imageElem);
            imageElem.parentElement.parentElement.parentElement.appendChild(formParentElem);
            
            imageElem.parentElement.parentElement.removeChild(imageElem.parentElement.parentElement.children.item(1));
        }else{
            imgElem = imageElem.parentElement.firstChild;
        }
        
        var reader = new FileReader();
        reader.onload = function (e) {
            imgElem.src = e.target.result;
        };
    
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    };
}

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
