<?php 
namespace Post_News_Letter\Admin;

class Send_Post_Email
{
    public function __construct()
    {
        add_action('save_post_post', [$this, 'wpdocs_notify_subscribers'], 10, 3);
    }

    public function wpdocs_notify_subscribers($post_id, $post, $update) {
        // If an old post is being updated, exit
        if ($update) {
            return;
        }

        $subscribers = ['fin.ashique@gmail.com', 'ashique12009@gmail.com']; // list of your subscribers
        $subject     = 'A new post has beed added!';
        $message     = sprintf('We\'ve added a new post. Click <a href="%s">here</a> to see the post', get_permalink($post));

        wp_mail($subscribers, $subject, $message); 
    }

}