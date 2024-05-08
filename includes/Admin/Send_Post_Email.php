<?php 
namespace Post_News_Letter\Admin;

class Send_Post_Email
{
    public function __construct()
    {
        add_action('save_post_post', [$this, 'send_notification_to_subscribers'], 10, 3);
        add_filter('wp_mail_content_type', [$this, 'pnl_wp_mail_content_type']);
    }

    public function send_notification_to_subscribers($post_id, $post, $update) 
    {
        // If an old post is being updated, exit
        if ($update) {
            return;
        }

        // Get the list of subscribers
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        $sql          = "SELECT email_address FROM {$table_prefix}postnewsletter_emails";
        $subscribers  = $wpdb->get_col($sql);

        if (empty($subscribers)) {
            return;
        }

        $subject     = 'A new post has beed added!';
        $message     = sprintf('We\'ve added a new post. Click <a href="%s">here</a> to see the post', get_permalink($post));

        wp_mail($subscribers, $subject, $message); 
    }

    public function pnl_wp_mail_content_type() 
    {
        return 'text/html';
    }
}