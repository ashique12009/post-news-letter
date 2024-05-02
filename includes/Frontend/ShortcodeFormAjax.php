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
        parse_str($_POST['email_input'], $data);

        // Access individual values
        $email = $data['email'];
        $nonce = $data['_wpnonce'];

        if (!wp_verify_nonce($nonce, 'get_newsletter_email_nonce')) {
            wp_send_json_error('Nonce error');
        }

        if ($email == '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            wp_send_json_error('Invalid email address');
        }

        global $wpdb;
        $table = $wpdb->prefix . 'postnewsletter_emails';
        // Check if email already exists
        $result = $wpdb->get_row($wpdb->prepare("SELECT id FROM $table WHERE email_address = %s", $email));

        if ($result) {
            wp_send_json_error('This email address is already subscribed!');
        }

        $wpdb->insert($table, [
            'email_address' => $email,
            'ip'            => $_SERVER['REMOTE_ADDR'],
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        // Send success response
        wp_send_json_success('Email subscribed successfully');
    }
}