<?php
namespace Rigo\Controller;

use \WP_Query;

class CheckoutController{
    
    public function process_Order() {
    try {
      $nonce_value = wc_get_var( $_REQUEST['woocommerce-process-checkout-nonce'], wc_get_var( $_REQUEST['_wpnonce'], '' ) ); // @codingStandardsIgnoreLine.

      if ( empty( $nonce_value ) || ! wp_verify_nonce( $nonce_value, 'woocommerce-process_checkout' ) ) {
        WC()->session->set( 'refresh_totals', true );
        throw new Exception( __( 'We were unable to process your order, please try again.', 'woocommerce' ) );
      }

      wc_maybe_define_constant( 'WOOCOMMERCE_CHECKOUT', true );
      wc_set_time_limit( 0 );

      do_action( 'woocommerce_before_checkout_process' );

      if ( WC()->cart->is_empty() ) {
        /* translators: %s: shop cart url */
        throw new Exception( sprintf( __( 'Sorry, your session has expired. <a href="%s" class="wc-backward">Return to shop</a>', 'woocommerce' ), esc_url( wc_get_page_permalink( 'shop' ) ) ) );
      }

      do_action( 'woocommerce_checkout_process' );

      $errors      = new WP_Error();
      $posted_data = $this->get_posted_data();

      // Update session for customer and totals.
      $this->update_session( $posted_data );

      // Validate posted data and cart items before proceeding.
      $this->validate_checkout( $posted_data, $errors );

      foreach ( $errors->get_error_messages() as $message ) {
        wc_add_notice( $message, 'error' );
      }

      if ( empty( $posted_data['woocommerce_checkout_update_totals'] ) && 0 === wc_notice_count( 'error' ) ) {
        $this->process_customer( $posted_data );
        $order_id = $this->create_order( $posted_data );
        $order    = wc_get_order( $order_id );

        if ( is_wp_error( $order_id ) ) {
          throw new Exception( $order_id->get_error_message() );
        }

        if ( ! $order ) {
          throw new Exception( __( 'Unable to create order.', 'woocommerce' ) );
        }

        do_action( 'woocommerce_checkout_order_processed', $order_id, $posted_data, $order );

        if ( WC()->cart->needs_payment() ) {
          $this->process_order_payment( $order_id, $posted_data['payment_method'] );
        } else {
          $this->process_order_without_payment( $order_id );
        }
      }
    } catch ( Exception $e ) {
      wc_add_notice( $e->getMessage(), 'error' );
    }
    $this->send_ajax_failure_response();
  }
    
}
?>