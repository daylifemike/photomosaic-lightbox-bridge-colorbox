(function (window) {
    'use strict';
    window.PhotoMosaic.LightboxBridge.colorbox = function ($, $mosaic, $items) {
        var instance = $mosaic.parent().data('photoMosaic');
        var original_settings = window.jQueryColorboxSettingsArray;
        var colorbox_settings = {};
        var str_to_bool = function(str){
            switch(str.toLowerCase()){
                case "true": return true;
                case "false": return false;
                default: return str;
            }
        };
        var scrubKey = function(str){
            var resp = str.replace('colorbox', '').replace(/^image/i, '');
            resp = resp.charAt(0).toLowerCase() + resp.slice(1);
            return resp;
        };
        var scrubVal = function(k){
            var key = scrubKey(k);
            var val = str_to_bool(original_settings[k]);
            if (key == "speed" || key == "slideshowSpeed") {
                val = parseInt(val, 10);
            }
            return val;
        };
        for (var k in original_settings) {
            if (k != "colorboxMaxWidth" && k != "colorboxMaxHeight"){
                colorbox_settings[scrubKey(k)] = scrubVal(k);
            }
        }
        colorbox_settings.rel = instance.opts.modal_name + "[" + instance.opts.modal_hash + "]";
        $($items).colorbox(colorbox_settings);
    }
}(window));