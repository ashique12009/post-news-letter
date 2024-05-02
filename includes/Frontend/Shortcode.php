<?php 
namespace Post_News_Letter\Frontend;

/**
 * Shortcode class
 */
class Shortcode
{
    public function __construct()
    {
        add_shortcode('post-news-letter-form', [$this, 'render_post_news_letter_form']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_stylesheet_scripts']);
    }

    public function render_post_news_letter_form($atts, $content = '')
    {
        ob_start();
        ?>
            <form class="post-news-letter-subscription-form" type="post" action="">
                <input type="email" name="email" id="pnls-email-field" placeholder="Your Email Address" value="" required />
                <?php wp_nonce_field('get_newsletter_email_nonce');?>
                <input type="hidden" name="action" value="get_newsletter_email_action" />
                <input type="submit" name="submit" class="pnls-submit-button" value="Subscribe" />
            </form>
        <?php 

        $content = ob_get_clean();

        return $content;
    }

    public function enqueue_stylesheet_scripts()
    {
        wp_enqueue_style('post-news-letter-toastr-stylesheet', 
            POST_NEWS_LETTER_PLUGIN_URL . '/assets/css/toastr.min.css', 
            [], 
            POST_NEWS_LETTER_VERSION
        );

        wp_enqueue_style('post-news-letter-frontend-stylesheet', 
            POST_NEWS_LETTER_PLUGIN_URL . '/assets/css/frontend-stylesheet.css', 
            [], 
            POST_NEWS_LETTER_VERSION
        );
            
        wp_enqueue_script('post-news-letter-toastr-script', 
            POST_NEWS_LETTER_PLUGIN_URL . '/assets/js/toastr.min.js', 
            ['jquery'], 
            POST_NEWS_LETTER_VERSION, 
            true
        );

        wp_enqueue_script('post-news-letter-frontend-script', 
            POST_NEWS_LETTER_PLUGIN_URL . '/assets/js/frontend-script.js', 
            ['jquery'], 
            POST_NEWS_LETTER_VERSION, 
            true
        );
    
        $script_data_array = [
            'ajax_url' => admin_url('admin-ajax.php')
        ];
        wp_localize_script('post-news-letter-frontend-script', 'script_data', $script_data_array);
    }
}