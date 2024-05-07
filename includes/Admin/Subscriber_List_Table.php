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
            'Id'            => 'ID',
            'email_address' => 'Email Address',
            'ip'            => 'IP',
            'created_at'    => 'Created At',
        ];

        return $columns;
    }

    public function prepare_items()
    {
        $columns  = $this->get_columns();
        $hidden   = [];
        $sortable = [];
        $this->_column_headers = [$columns, $hidden, $sortable];
    }
}