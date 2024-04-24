<?php
namespace Post_News_Letter\Admin;

class WelcomeTemplate {

    public function __construct()
    {
        add_action('admin_post_action_welcome_template', [$this, 'welcome_template_form_handler']);
    }

    public function welcome_template_form()
    {
        $welcome_template = get_option('post_news_letter_welcome_template') ? get_option('post_news_letter_welcome_template') : '';

        include_once POST_NEWS_LETTER_PLUGIN_PATH . '/includes/Admin/Views/welcome-template-form.php';
    }

    public function welcome_template_form_handler()
    {
        if (!isset($_POST['submit_welcome_template'])) {
            return;
        }
        if (!wp_verify_nonce($_POST['_wpnonce'], 'email-template')) {
            wp_die('Nonce error');
        }
        if (!current_user_can('manage_options')) {
            wp_die('You do not have sufficient permissions to access this page.');
        }

        $welcome_template = isset($_POST['welcome_template']) ? $_POST['welcome_template'] : '';

        update_option('post_news_letter_welcome_template', $welcome_template);

        wp_safe_redirect(admin_url('admin.php?page=welcome-template-form&success=1'));
    }
}