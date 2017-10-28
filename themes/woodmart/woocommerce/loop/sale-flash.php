<?php
/**
 * Product loop sale flash
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

?>
<?php if ( $product->is_on_sale() ) : ?>

	<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale', 'woodmart' ) . '</span>', $post, $product ); ?>

<?php endif; ?>

<?php if ( ! $product->is_in_stock() ) : ?>

	<?php echo apply_filters( 'woodmart_stock_flash', '<span class="out-of-stock-label">' . esc_html__( 'Sold out', 'woodmart' ) . '</span>', $post, $product ); ?>

<?php endif; ?>
