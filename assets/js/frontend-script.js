jQuery(function($) {

    $('form.post-news-letter-subscription-form').submit(function(e) {
        e.preventDefault();

        var input = $(this).serialize();

        console.log(input);

        if (input != '') {
            var data = {
                'action': 'get_newsletter_email_action',
                'email_input': input,
                'nonce': script_data.nonce
            }
            $.post(script_data.ajax_url, data, function(response) {
                //$('#txtHint').html(response);
                console.log(response);
            })
            .fail(function() {
                console.log('Something went wrong!');
            });
        }
        else {
            console.log('Empty email field');
        }
    });

});