<?php

/**
 * Plugin Name: Post News Letter
 * Plugin URI: https://ashique12009.blogspot.com
 * Description: When new post is created then this plugin will send a email to you with new post title and link.
 * Version: 1.0
 * Author: Khandoker Ashique Mahamud
 * Author URI: https://ashique12009.blogspot.com
 **/

if (!defined('WPINC')) {
    die;
}

/**
 * The main plugin class
 */
class Post_News_Letter
{

    function __construct()
    {
        $this->define_constants();
        register_activation_hook(__FILE__, [$this, 'activate']);

        $this->class_initialize();
    }

    /**
     * Initialize a singleton instance
     */
    public static function init()
    {
        static $instance = false;

        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    public function define_constants()
    {
        define('POST_NEWS_LETTER_PLUGIN_FILE', __FILE__);
        define('POST_NEWS_LETTER_PLUGIN_PATH', __DIR__);
        define('POST_NEWS_LETTER_PLUGIN_URL', plugins_url('', __FILE__));
    }

    public function activate()
    {
    }

    public function class_initialize()
    {
        if (is_admin()) {
            if (!class_exists('\Post_News_Letter\Admin\Menu')) {
                require_once POST_NEWS_LETTER_PLUGIN_PATH . '/includes/Admin/Menu.php';
                new \Post_News_Letter\Admin\Menu();
                include_once POST_NEWS_LETTER_PLUGIN_PATH . '/includes/Admin/WelcomeTemplate.php';
                new \Post_News_Letter\Admin\WelcomeTemplate();
            }
        }
        else {
            if (!class_exists('\Post_News_Letter\Frontend\Shortcode')) {
                require_once POST_NEWS_LETTER_PLUGIN_PATH . '/includes/Frontend/Shortcode.php';
                new \Post_News_Letter\Frontend\Shortcode();
            }
        }
    }
}

Post_News_Letter::init();
