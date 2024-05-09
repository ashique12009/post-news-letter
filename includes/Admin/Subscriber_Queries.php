<?php 
namespace Post_News_Letter\Admin;

class Subscriber_Queries
{
    public function get_subscriber_row($id) 
    {
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        $sql          = "SELECT id FROM {$table_prefix}postnewsletter_emails WHERE id=%d";
        return $wpdb->get_row($wpdb->prepare($sql, $id));
    }
    
    public function delete_subscriber($id)
    {
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        return $wpdb->delete($table_prefix . 'postnewsletter_emails', ['id' => $id], ['%d']);
    }

    public function delete_subscribers($ids)
    {
        global $wpdb;
        $table_prefix = $wpdb->prefix;
        $wpdb->delete($table_prefix . 'postnewsletter_emails', ['id' => $ids], ['%d']);
    }
}