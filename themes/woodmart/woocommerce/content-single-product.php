<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$product_images_class  	= woodmart_product_images_class();
$product_summary_class 	= woodmart_product_summary_class();
$single_product_class  	= woodmart_single_product_class();
$content_class 			= woodmart_get_content_class();
$product_design 		= woodmart_product_design();

$container_summary = 'container';

if( woodmart_get_opt( 'single_full_width' ) ) {
	$container_summary = 'container-fluid';
}


?>

<?php if ( $product_design == 'alt' ): ?>
	<div class="single-breadcrumbs-wrapper">
		<div class="container">
			<?php woocommerce_breadcrumb(); ?>
			<?php if ( woodmart_get_opt( 'products_nav' ) ): ?>
				<?php woodmart_products_nav(); ?>
			<?php endif ?>
		</div>
	</div>
<?php endif ?>

<div class="container">
	<?php
		/**
		 * woocommerce_before_single_product hook
		 *
		 * @hooked wc_print_notices - 10
		 */
		 do_action( 'woocommerce_before_single_product' );

		 if ( post_password_required() ) {
		 	echo get_the_password_form();
		 	return;
		 }

	?>
</div>
<div id="product-<?php the_ID(); ?>" <?php post_class( $single_product_class ); ?>>

	<div class="<?php echo esc_attr( $container_summary ); ?>">

		<div class="row product-image-summary-wrap">
			<div class="product-image-summary <?php echo esc_attr( $content_class ); ?>">
				<div class="row product-image-summary-inner">
					<div class="<?php echo esc_attr( $product_images_class ); ?> product-images">
						<div class="product-images-inner">
							<?php
								/**
								 * woocommerce_before_single_product_summary hook
								 *
								 * @hooked woocommerce_show_product_sale_flash - 10
								 * @hooked woocommerce_show_product_images - 20
								 */
								do_action( 'woocommerce_before_single_product_summary' );
							?>
						</div>
					</div>
					<div class="<?php echo esc_attr( $product_summary_class ); ?> summary entry-summary">
						<div class="summary-inner">
							<?php if ( $product_design == 'default' ): ?>
								<div class="single-breadcrumbs-wrapper">
									<div class="single-breadcrumbs">
										<?php woocommerce_breadcrumb(); ?>
										<?php if ( woodmart_get_opt( 'products_nav' ) ): ?>
											<?php woodmart_products_nav(); ?>
										<?php endif ?>
									</div>
								</div>
							<?php endif ?>

							<?php
								/**
								 * woocommerce_single_product_summary hook
								 *
								 * @hooked woocommerce_template_single_title - 5
								 * @hooked woocommerce_template_single_rating - 10
								 * @hooked woocommerce_template_single_price - 10
								 * @hooked woocommerce_template_single_excerpt - 20
								 * @hooked woocommerce_template_single_add_to_cart - 30
								 * @hooked woocommerce_template_single_meta - 40
								 * @hooked woocommerce_template_single_sharing - 50
								 */
								do_action( 'woocommerce_single_product_summary' );
							?>
						</div>
					</div>
				</div><!-- .summary -->
			</div>

			<?php 
				/**
				 * woocommerce_sidebar hook
				 *
				 * @hooked woocommerce_get_sidebar - 10
				 */
				do_action( 'woocommerce_sidebar' );
			?>

		</div>
		
		<?php
			/**
			 * woodmart_after_product_content hook
			 *
			 * @hooked woodmart_product_extra_content - 20
			 */
			do_action( 'woodmart_after_product_content' );
		?>

	</div>


	<div class="product-tabs-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 poduct-tabs-inner">
					<?php
						/**
						 * woocommerce_after_single_product_summary hook
						 *
						 * @hooked woocommerce_output_product_data_tabs - 10
						 * @hooked woocommerce_upsell_display - 15
						 * @hooked woocommerce_output_related_products - 20
						 */
						do_action( 'woocommerce_after_single_product_summary' );
					?>
				</div>
			</div>	
		</div>
	</div>

	<?php
		do_action( 'woodmart_after_product_tabs' );
	?>

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
