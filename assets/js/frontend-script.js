jQuery(function($) {

    $('#pnls-loading').hide();

    $('form.post-news-letter-subscription-form').submit(function(e) {
        e.preventDefault();

        let input = $(this).serialize();

        if (input != '') {
            let data = {
                'action': 'get_newsletter_email_action',
                'email_input': input,
            }

            $.ajaxSetup({
                beforeSend: function() {
                    $('#pnls-loading').show();
                    $('#pnls-form input.pnls-submit-button').prop('disabled', true);
                }
            })

            $.post(script_data.ajax_url, data, function(response) {
                if (response.success) {
                    toastr.success(response.data, "Success");
                    $('form.post-news-letter-subscription-form').children('input#pnls-email-field').val('');
                }
                if (response.success == false) {
                    toastr.error(response.data, "Error");
                }
                $('#pnls-loading').hide();
                $('#pnls-form input.pnls-submit-button').prop('disabled', false);
            })
            .fail(function() {
                $('#pnls-loading').hide();
                $('#pnls-form input.pnls-submit-button').prop('disabled', false);
                toastr.error("Something went wrong!", "Error");
            });
        }
        else {
            toastr.error("Empty email field!", "Error");
        }
    });

});