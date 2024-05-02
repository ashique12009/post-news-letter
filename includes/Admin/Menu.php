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
            [$this, 'dashboard_page'],
            'dashicons-email',
            6
        );

        add_submenu_page(
            'post-news-letter',
            'Dashboard',
            'Dashboard',
            'manage_options',
            'post-news-letter',
            [$this, 'dashboard_page']
        );

        add_submenu_page(
            'post-news-letter',
            'Welcome Template',
            'Welcome Template',
            'manage_options',
            'welcome-template-form',
            [$this, 'menu_welcome_email_template_form_page']
        );
    }

    public function dashboard_page()
    {
        include_once POST_NEWS_LETTER_PLUGIN_PATH . '/includes/Admin/Views/dashboard.php';
    }

    public function menu_welcome_email_template_form_page()
    {
        $welcome_template = new \Post_News_Letter\Admin\Welcome_Template();
        $welcome_template->welcome_template_form();
    }
}