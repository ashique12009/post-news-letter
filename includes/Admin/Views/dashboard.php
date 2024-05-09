<?php 
if (isset($_GET['action']) && $_GET['action'] === 'delete_subscriber' && isset($_GET['subscriber_id'])) {
    $nonce = sanitize_text_field($_GET['_wpnonce']);
    if (!wp_verify_nonce($nonce, 'subscriber_delete_action')) {
        die('Security check failed');
    }

    // Delete subscriber
    $subscriber_id = $_GET['subscriber_id'];
    if (!empty($subscriber_id)) {
        $subscriber = new \Post_News_Letter\Admin\Subscriber_Queries();
        $subscriber->delete_subscriber($subscriber_id);
    }

    // Redirect back to the list table after deletion
    echo 'Please wait!';
    $redirect_url = admin_url('admin.php?page=post-news-letter');
    echo "<script>setTimeout(\"location.href = '$redirect_url';\", 1500);</script>";
}
?>

<div class="wrap">
    <h1>Dashboard - Post news letter</h1>
    <div class="grid auto-fill">
        <?php $dashboard = new \Post_News_Letter\Admin\Dashboard(); ?>
        <div class="grid-info grid-item"><h1>Total Emails Subscribed: <?php echo $dashboard->dashboard_page_get_total_email_subscribed(); ?></h1></div>
        <div class="grid-success grid-item"><h1>Emails Subscribed Current Month: <?php echo $dashboard->dashboard_page_get_total_email_subscribed_current_month(); ?></h1></div>
        <div class="grid-warning grid-item"><h1>Emails Subscribed Today: <?php echo $dashboard->dashboard_page_get_total_email_subscribed_today(); ?></h1></div>
    </div>

    <h1>Subscribers</h1>
    <form method="get" action="">
        <?php wp_nonce_field('bulk-action', '_wpnonce_bulk_action'); ?>
        <?php 
            if (!class_exists('Post_News_Letter\Admin\Subscriber_List_Table')) {
                require_once POST_NEWS_LETTER_PLUGIN_PATH . '/includes/Admin/Subscriber_List_Table.php';
            }

            $table = new Post_News_Letter\Admin\Subscriber_List_Table();
            $table->prepare_items();
            $table->display();
        ?>
    </form>
</div>