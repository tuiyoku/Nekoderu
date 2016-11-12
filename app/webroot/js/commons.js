'use strict';

(function($) {

    jQuery.fn.extend({
        prependClass: function(newClasses) {
            return this.each(function() {
                var currentClasses = $(this).prop("class");
                $(this).removeClass(currentClasses).addClass(newClasses + " " + currentClasses);
            });
        }
    });

})(jQuery);

var template;   

var createTemplate = function(selector, name){
        
    if(typeof template === 'undefined'){
        template = {};
    }
    eval("template."+name+" =  $('"+selector+"').first();");
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

var isJSON = function(arg) {
    arg = (typeof arg === "function") ? arg() : arg;
    if (typeof arg  !== "string") {
        return false;
    }
    try {
    arg = (!JSON) ? eval("(" + arg + ")") : JSON.parse(arg);
        return true;
    } catch (e) {
        return false;
    }
};