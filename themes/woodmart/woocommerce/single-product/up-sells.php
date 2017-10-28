<?php
/**
 * Single Product Up-Sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product;

$position = woodmart_get_opt( 'upsells_position' );

$slider_args = array(
	'slides_per_view' => apply_filters( 'woodmart_cross_sells_products_per_view', 4 ),
	'hide_pagination_control' => false,
	'title' => esc_html__( 'You may also like&hellip;', 'woodmart' ),
	'img_size' => 'shop_catalog'
);

if ( $upsells ) : ?>

	<?php if ($position == 'sidebar'): ?>
	<div class="upsells-widget">
		<?php woodmart_products_widget_template( $upsells, true ); ?>
	</div>
	<?php else: ?>
	<div class="upsells-carousel">
		<?php  
			echo woodmart_generate_posts_slider( $slider_args, false, $upsells );
		?>
	</div>
	<?php endif ?>

<?php endif;


wp_reset_postdata();
