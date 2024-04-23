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

        add_submenu_page(
            'post-news-letter',
            'Dashboard',
            'Dashboard',
            'manage_options',
            'post-news-letter',
            [$this, 'menu_page']
        );

        add_submenu_page(
            'post-news-letter',
            'Welcome Template Form',
            'Welcome Template Form',
            'manage_options',
            'post-news-letter-welcome-template-form',
            [$this, 'menu_welcome_template_form_page']
        );
    }

    public function menu_page()
    {
        include_once POST_NEWS_LETTER_PLUGIN_PATH . '/includes/Admin/Views/dashboard.php';
    }

    public function menu_welcome_template_form_page()
    {
        include_once POST_NEWS_LETTER_PLUGIN_PATH . '/includes/Admin/Views/welcome-template-form.php';
    }
}