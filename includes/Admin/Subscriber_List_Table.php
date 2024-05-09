<?php 
namespace Post_News_Letter\Admin;

// Check if the class exists before requiring it
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class Subscriber_List_Table extends \WP_List_Table
{
    public function __construct()
    {
        parent::__construct([
            'singular' => 'Subscriber',
            'plural'   => 'Subscribers',
            'ajax'     => false
        ]);
    }

    // Return column name
    public function get_columns()
    {
        $columns = [
            'cb'            => '<input type="checkbox" />',
            'id'            => 'ID',
            'email_address' => 'Email Address',
            'ip'            => 'IP',
            'created_at'    => 'Created At',
        ];

        return $columns;
    }

    public function no_items()
    {
        echo 'No Subscribers Found'; 
    }

    public function prepare_items()
    {
        $this->process_bulk_action();

        $columns  = $this->get_columns();
        $hidden   = [];
        $sortable = [];
        $this->_column_headers = [$columns, $hidden, $sortable];

        $per_page   = 25;
        $offset     = ($this->get_pagenum() - 1) * $per_page;
        $order_by   = 'id';
        $order      = 'ASC';

        $this->set_pagination_args([
            'total_items' => $this->get_total_subscriber(),
            'per_page'    => $per_page,
            'total_pages' => ceil($this->get_total_subscriber() / $per_page),
        ]);

        $this->items = $this->get_subscribers($order_by, $order, $per_page, $offset);
    }

    public function column_default($item, $column_name)
    {
        return isset($item->$column_name) ? $item->$column_name  : '';
    }

    public function get_subscribers($order_by, $order, $per_page, $offset)
    {
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        $sql          = "SELECT * FROM {$table_prefix}postnewsletter_emails ORDER BY %s %s LIMIT %d, %d";
        $subscribers  = $wpdb->get_results($wpdb->prepare($sql, $order_by, $order, $offset, $per_page));
        return $subscribers;
    }

    public function get_total_subscriber()
    {
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        $sql          = "SELECT COUNT(*) FROM {$table_prefix}postnewsletter_emails";
        $total        = $wpdb->get_var($sql);
        return $total;
    }

    public function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="subscriber[]" value="%s" />', $item->id);
    }

    public function column_id($item)
    {
        $actions = [];

        $actions['delete'] = sprintf('<a href="%s" onclick="return confirm(\'Are you sure?\')">Delete</a>', 
            wp_nonce_url(admin_url('admin.php?page=post-news-letter&action=delete_subscriber&subscriber_id=' . $item->id), 
            'subscriber_delete_action'));

        return $item->id . $this->row_actions($actions);
    }

    public function get_bulk_actions()
    {
        $actions = [
            'subscriber_delete' => 'Delete',
        ];

        return $actions;
    }

    // Handle the bulk delete action
    public function process_bulk_action() {
        if (isset($_GET['action']) && $_GET['action'] === 'subscriber_delete' && isset($_GET['subscriber'])) {
            var_dump($_GET['action'], $_GET['subscriber']);exit;
            // Verify nonce
            if (isset($_GET['_wpnonce_bulk_action']) && !empty($_GET['_wpnonce_bulk_action'])) {
                $nonce = sanitize_text_field($_GET['_wpnonce_bulk_action']);
                if (!wp_verify_nonce($nonce, 'bulk-action')) {
                    die('Security check failed');
                }
            }
    
            $items = isset($_GET['subscriber']) ? $_GET['subscriber'] : array();
            if (empty($items)) {
                return;
            }
            foreach ($items as $item_id) {
                $this->delete_subscriber($item_id);
            }
    
            // Redirect back to the list table after deletion
            $redirect_url = remove_query_arg(array('action', 'subscriber', '_wpnonce'), wp_unslash($_SERVER['REQUEST_URI']));
            wp_redirect($redirect_url);
            exit;
        }
    }

}