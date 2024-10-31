jQuery(document).ready(function($) {

    if ( jQuery('.mailchimp-form').length ) {
        jQuery('.mailchimp-form').each(function(){
            var $this = jQuery(this);
            $this.submit(function() {
                var data_nonce = $this.attr('data-nonce');
                var data_list_id = $this.attr('data-list-id');
                var data_api_key = $this.attr('data-api-key');
                var data_email = $this.find('input[name="email"]').val();
                jQuery.ajax({
                    url:nictitate_toolkit_ii_mailchimp.ajaxurl,
                    data: {
                        'action' : 'nictitate_toolkit_add_subscriber_list',
                        'nonce' : data_nonce,
                        'list_id' : data_list_id,
                        'api_key' : data_api_key,
                        'email' : data_email
                    },
                    beforeSend: function( xhr ) {
                        $this.find('.response').html(nictitate_toolkit_ii_mailchimp.process);
                    }
                })
                    .done(function( data ) {
                        if ( '' !== data ) {
                            $this.find('.response').html(data);
                        }
                    });
                return false;
            });
        });
    }
});