<?php
namespace Rigo\Controller;

use \WP_Query;

class OrderController{
    
    
    public function createOrder( &$item ) {
      
    global $wpdb;

    $wpdb->insert(
      $wpdb->prefix . 'woocommerce_order_items', array(
        'order_item_name' => $item->get_name(),
        'order_item_type' => $item->get_type(),
        'order_id'        => $item->get_order_id(),
      )
    );
    $item->set_id( $wpdb->insert_id );
    $this->save_item_data( $item );
    $item->save_meta_data();
    $item->apply_changes();
    $this->clear_cache( $item );

    do_action( 'woocommerce_new_order_item', $item->get_id(), $item, $item->get_order_id() );
  }
    
}
?>