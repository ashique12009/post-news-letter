<?php 
namespace Post_News_Letter\Frontend;

/**
 * Shortcode class
 */
class Shortcode_Form_Ajax
{
    public function __construct()
    {
        add_action('wp_ajax_get_newsletter_email_action', [$this, 'post_news_letter_form_ajax_handler']);
        add_action('wp_ajax_nopriv_get_newsletter_email_action', [$this, 'post_news_letter_form_ajax_handler']);
    }

    public function post_news_letter_form_ajax_handler()
    {
        echo 'HERE AJAX';
        // exit('HERE AJAX');
        // $nonce = $_POST['nonce'];
        // $email = $_POST['email_input'];

        // die('email n nonce' . $nonce . $email);

        // if (empty($_POST) || !wp_verify_nonce($nonce, 'email-nonce')) {
        //     wp_send_json_error('Nonce error');
        // }

        // if ($email == '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //     wp_send_json_error('Invalid email address');
        // }

        // // Send success response
        // wp_send_json_success('Email subscribed successfully');
    }
}