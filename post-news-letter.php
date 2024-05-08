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
        define('POST_NEWS_LETTER_VERSION', '1.0');
        define('POST_NEWS_LETTER_PLUGIN_FILE', __FILE__);
        define('POST_NEWS_LETTER_PLUGIN_PATH', __DIR__);
        define('POST_NEWS_LETTER_PLUGIN_URL', plugins_url('', __FILE__));
    }

    public function activate()
    {
        global $wpdb;

        $table_prefix = $wpdb->prefix;

        $table_sql = 'CREATE TABLE `'.$table_prefix.'postnewsletter_emails` (
            `id` int NOT NULL AUTO_INCREMENT,
            `email_address` text NOT NULL,
            `ip` varchar(128) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci';

        include_once ABSPATH . 'wp-admin/includes/upgrade.php';

        dbDelta($table_sql);
    }

    public function class_initialize()
    {
        if (defined('DOING_AJAX') && DOING_AJAX) {
            if (!class_exists('\Post_News_Letter\Frontend\Shortcode_Form_Ajax')) {
                require_once POST_NEWS_LETTER_PLUGIN_PATH . '/includes/Frontend/ShortcodeFormAjax.php';
                new \Post_News_Letter\Frontend\Shortcode_Form_Ajax();
            }
        }
        
        if (is_admin()) {
            if (!class_exists('\Post_News_Letter\Admin\Menu')) {
                require_once POST_NEWS_LETTER_PLUGIN_PATH . '/includes/Admin/Menu.php';
                new \Post_News_Letter\Admin\Menu();
            }
            if (!class_exists('\Post_News_Letter\Admin\Settings')) {
                include_once POST_NEWS_LETTER_PLUGIN_PATH . '/includes/Admin/Welcome_Template.php';
                new \Post_News_Letter\Admin\Welcome_Template();
            }
            if (!class_exists('\Post_News_Letter\Admin\Dashboard')) {
                require_once POST_NEWS_LETTER_PLUGIN_PATH . '/includes/Admin/Dashboard.php';
                new \Post_News_Letter\Admin\Dashboard();
            }
            if (!class_exists('\Post_News_Letter\Admin\Send_Post_Email')) {
                require_once POST_NEWS_LETTER_PLUGIN_PATH . '/includes/Admin/Send_Post_Email.php';
                new \Post_News_Letter\Admin\Send_Post_Email();
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