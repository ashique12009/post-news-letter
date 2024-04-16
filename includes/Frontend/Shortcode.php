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
    }

    public function render_post_news_letter_form($atts, $content = '')
    {
        return '<div class="post-news-letter-form">' . $content . 'HERE' . '</div>';
    }
}