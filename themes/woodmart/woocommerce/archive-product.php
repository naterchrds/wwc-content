<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( woodmart_is_woo_ajax() == 'fragments' ) {
	woodmart_woocommerce_main_loop( true );
	die();
}

if ( ! woodmart_is_woo_ajax() ) {
	get_header( 'shop' ); 
} else {
	woodmart_page_top_part();
}

?>

	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20 
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php do_action( 'woocommerce_archive_description' ); ?>
			
		<div class="shop-loop-head">
			<div class="woodmart-woo-breadcrumbs">
				<?php woocommerce_breadcrumb(); ?>
				<?php woocommerce_result_count(); ?>
			</div>
			<div class="woodmart-shop-tools">
				<?php
					/**
					 * woocommerce_before_shop_loop hook
					 *
					 * @hooked woocommerce_result_count - 20
					 * @hooked woocommerce_catalog_ordering - 30
					 */
					do_action( 'woocommerce_before_shop_loop' );
				?>
			</div>
		</div>
		
		<?php if ( woodmart_get_opt('shop_filters') ) : ?>
			<div class="filters-area">
				<div class="filters-inner-area row">
					<?php 

						do_action( 'woodmart_before_filters_widgets' );

						dynamic_sidebar( 'filters-area' ); 

						do_action( 'woodmart_after_filters_widgets' );

					?>
				</div><!-- .filters-inner-area -->
			</div><!-- .filters-area -->
		<?php endif; ?>

		<div class="woodmart-active-filters">
			<?php the_widget( 'WC_Widget_Layered_Nav_Filters', array(), array() ); ?>
		</div>

		<div class="woodmart-shop-loader"></div>

		<?php 

			do_action( 'woodmart_woocommerce_main_loop' );

		 ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php 
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

<?php 
	
	if ( ! woodmart_is_woo_ajax() ) {
		get_footer( 'shop' ); 
	} else {
		woodmart_page_bottom_part();
	}

 ?>