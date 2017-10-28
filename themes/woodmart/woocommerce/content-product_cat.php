<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version 	2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop, $woodmart_loop;

$isotope 		   = woodmart_get_opt( 'products_masonry' );
$different_sizes   = woodmart_get_opt( 'products_different_sizes' );
$categories_design = woodmart_get_opt( 'categories_design' );

// Store loop count we're currently on
// if ( empty( $woocommerce_loop['loop'] ) )
	// $woocommerce_loop['loop'] = 1;


// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );


if ( ! empty( $woocommerce_loop['categories_design'] ) )
	$categories_design = $woocommerce_loop['categories_design'];

$style = '';

if ( ! empty( $woocommerce_loop['style'] ) )
	$style = $woocommerce_loop['style'];

// Increase loop count
// $woocommerce_loop['loop']++;

$different_sizes = false;

if( ! empty( $woocommerce_loop['different_sizes'] ) ) {
	$different_sizes = $woocommerce_loop['different_sizes'];
	$isotope = true;
}

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	if( $different_sizes ) {
		$woocommerce_loop['loop'] = 1;
	} else {
		$woocommerce_loop['loop'] = 0;
	}
}

$items_wide = woodmart_get_wide_items_array( $different_sizes );
if( $different_sizes && ( in_array( $woocommerce_loop['loop'], $items_wide ) ) ) { 
	$woodmart_loop['double_size'] = true;
}
$classes = array();

$xz_columns = (int) woodmart_get_opt( 'products_columns_mobile' );
$xz_size = 12 / $xz_columns;

if( $style != 'carousel' )
	$classes[] = woodmart_get_grid_el_class($woocommerce_loop['loop'], $woocommerce_loop['columns'], $different_sizes, $xz_size);

$classes[] = 'category-grid-item';
$classes[] = 'cat-design-' . $categories_design;

?>
<div <?php wc_product_cat_class($classes, $category); ?> data-loop="<?php echo esc_attr( $woocommerce_loop['loop'] ); ?>">
	<div class="wrapp-category">
		<div class="category-image-wrapp">
			<a href="<?php echo esc_url( get_term_link( $category->slug, 'product_cat' ) ); ?>" class="category-image">
				<?php do_action( 'woocommerce_before_subcategory', $category ); ?>

				<?php
					/**
					 * woocommerce_before_subcategory_title hook
					 *
					 * @hooked woodmart_category_thumb_double_size - 10
					 */
					do_action( 'woocommerce_before_subcategory_title', $category );
				?>
			</a>
		</div>
		<div class="hover-mask">
			<h3 class="category-title">
				<?php
					echo esc_html( $category->name );

					if ( $category->count > 0 )
						echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . $category->count . ')</mark>', $category );
				?>
			</h3>

			<div class="more-products"><a href="<?php echo esc_url( get_term_link( $category->slug, 'product_cat' ) ); ?>"><?php echo sprintf( _n( '%s product', '%s products', $category->count, 'woodmart' ), $category->count ); ?></a></div>

			<?php
				/**
				 * woocommerce_after_subcategory_title hook
				 */
				do_action( 'woocommerce_after_subcategory_title', $category );
			?>
		</div>
		<a href="<?php echo esc_url( get_term_link( $category->slug, 'product_cat' ) ); ?>" class="category-link"></a>
		<?php do_action( 'woocommerce_after_subcategory', $category ); ?>
	</div>
</div>

<?php $woodmart_loop['double_size'] = false; ?>
<?php if( ! $isotope ) echo woodmart_get_grid_clear($woocommerce_loop['loop'], $woocommerce_loop['columns'], $xz_columns); ?>