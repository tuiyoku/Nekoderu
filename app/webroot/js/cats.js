'use strict';

var template;   

var createTemplate = function(selector, name){
        
    if(typeof template === 'undefined'){
        template = {};
    }
    eval("template."+name+" =  $('"+selector+"').first();");
}