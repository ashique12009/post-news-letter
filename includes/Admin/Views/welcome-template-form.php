<div class="wrap">
    <h1>Welcome Email Template Form</h1>
    <p class="description">Enter your welcome email body text:</p>
    <?php if (isset($_GET['success']) && $_GET['success'] == 1) { ?>
        <div class="notice notice-success is-dismissible">
            <p>Template saved successfully.</p>
        </div>
    <?php } ?>
    <form action="<?php echo admin_url('admin-post.php?action=action_welcome_template'); ?>" method="post">
        <textarea name="welcome_template" id="welcome_template" rows="5" cols="45" class="large-text"><?php echo trim($welcome_template); ?></textarea>
        <?php wp_nonce_field('email-template');?>
        <input type="submit" name="submit_welcome_template" id="submit" class="button button-primary" value="Save">
    </form>
</div>