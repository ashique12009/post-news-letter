<?php
namespace Post_News_Letter\Admin;

/**
 * Menu class
 */
class Menu
{

    public function __construct()
    {
        add_action('admin_menu', [$this, 'register_menu']);
    }

    public function register_menu()
    {
        add_menu_page(
            'Post News Letter',
            'Post News Letter',
            'manage_options',
            'post-news-letter',
            [$this, 'menu_page'],
            'dashicons-email',
            6
        );
    }

    public function menu_page()
    {
        include_once POST_NEWS_LETTER_PLUGIN_PATH . '/includes/Admin/Views/dashboard.php';
    }
}
