"use strict";

jQuery(document).ready(function($) {
    var buttons = jQuery('.nictiz_toolkit_like_clickable');    
    if(buttons.length){
        buttons.on('click', function(event){
            event.preventDefault();
            var post_id = jQuery(this).data('post-id');
            nictitate_toolkit_ii_like.click_like_button(event, jQuery(this), post_id);
        });
    }
});

var nictitate_toolkit_ii_like = {
    click_like_button: function(event, obj, post_id) {
        event.preventDefault();

        if (!obj.hasClass('inprocess')) {
            var icon       = obj.find('i').first();
            var icon_class = icon.attr('class');
            var status     = obj.data('status');
            jQuery.ajax({
                type: 'POST',
                url: nictiz_toolkit_meta_likes.ajax.url.meta_like,
                dataType: 'json',
                async: true,
                timeout: 5000,
                data: {
                    action: 'nictiz_toolkit_meta_like',                    
                    post_id: post_id,                    
                    status: status
                },
                beforeSend: function(XMLHttpRequest, settings) {
                    obj.addClass('inprocess');
                    icon.attr('class', 'fa fa-refresh fa-spin');
                },
                complete: function(XMLHttpRequest, textStatus) {
                    icon.attr('class', icon_class);
                    obj.removeClass('inprocess');
                },
                success: function(data) {
                    obj.find('span').text(data.total);
                    obj.data('status', data.status);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });
        }
    }
};