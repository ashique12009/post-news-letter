<div class="wrap">
    <h1>Dashboard - Post news letter</h1>
    <div class="grid auto-fill">
        <?php 
        $dashboard = new \Post_News_Letter\Admin\Dashboard();
        ?>
        <div class="grid-info grid-item"><h1>Total Emails Subscribed: <?php echo $dashboard->dashboard_page_get_total_email_subscribed(); ?></h1></div>
        <div class="grid-success grid-item"><h1>Emails Subscribed Current Month: 0</h1></div>
        <div class="grid-warning grid-item"><h1>Emails Subscribed Today: <?php echo $dashboard->dashboard_page_get_total_email_subscribed_today(); ?></h1></div>
    </div>
</div>