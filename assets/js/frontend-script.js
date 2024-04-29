jQuery(function($) {

    $('form.post-news-letter-subscription-form').submit(function(e) {
        e.preventDefault();

        let input = $(this).serialize();

        console.log('input');
        console.log(input);

        if (input != '') {
            let data = {
                'action': 'get_newsletter_email_action',
                'email_input': input,
            }
            
            $.post(script_data.ajax_url, data, function(response) {
                //$('#txtHint').html(response);
                console.log('response');
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