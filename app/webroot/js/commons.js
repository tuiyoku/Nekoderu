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

