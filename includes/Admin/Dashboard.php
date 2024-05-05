<?php

namespace Post_News_Letter\Admin;

/**
 * Dashboard class
 */
class Dashboard
{

    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'include_admin_scripts']);
    }

    public function include_admin_scripts()
    {
        wp_register_style(
            'post-news-letter-admin-css',
            POST_NEWS_LETTER_PLUGIN_URL . '/assets/css/admin-style.css',
            false,
            POST_NEWS_LETTER_VERSION
        );
        wp_enqueue_style('post-news-letter-admin-css');
    }

    public function dashboard_page_get_total_email_subscribed()
    {
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        $sql          = "SELECT COUNT(*) FROM `" . $table_prefix . "postnewsletter_emails`";
        $total        = $wpdb->get_var($sql);
        return $total;
    }

    public function dashboard_page_get_total_email_subscribed_today()
    {
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        $sql          = "SELECT COUNT(*) FROM `" . $table_prefix . "postnewsletter_emails` WHERE DATE(`created_at`) = CURDATE()";
        $total        = $wpdb->get_var($sql);
        return $total;
    }
}
