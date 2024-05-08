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

    public function get_subscriber_row($id) 
    {
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        $sql          = "SELECT id FROM {$table_prefix}postnewsletter_emails WHERE id=%d";
        return $wpdb->get_row($wpdb->prepare($sql, $id));
    }

    public function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="subscriber[]" value="%s" />', $item->id);
    }

    public function column_id($item)
    {
        $actions = [];
        $actions['delete'] = sprintf('<a href="?page=%s&action=%s&id=%s" onclick="return confirm(\'Are you sure?\')">Delete</a>', $_REQUEST['page'], 'delete', $item->id);  
        return $item->id . $this->row_actions($actions);
    }

    public function get_bulk_actions()
    {
        $actions = [
            'delete' => 'Delete',
        ];

        return $actions;
    }

    public function delete_subscriber($id)
    {
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        return $wpdb->delete($table_prefix . 'postnewsletter_emails', ['id' => $id], ['%d']);
    }
}