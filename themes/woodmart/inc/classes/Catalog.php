<?php 
/**
 * WooCommerce catalog mode functions
 */


class WOODMART_Catalog {

	public function __construct() {

        add_action( 'wp', array( $this, 'catalog_mode_init' ) );
        add_action( 'wp', array( $this, 'pages_redirect' ) );
        
	}

    public function catalog_mode_init() {

        if( ! woodmart_get_opt( 'catalog_mode' ) ) return false;

        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

    }

    public function pages_redirect() {
        if( ! woodmart_get_opt( 'catalog_mode' ) ) return false;

        $cart     = is_page( wc_get_page_id( 'cart' ) );
        $checkout = is_page( wc_get_page_id( 'checkout' ) );

        wp_reset_postdata();

        if ( $cart || $checkout ) {
            wp_redirect( home_url() );
            exit;
        }
    }

}
