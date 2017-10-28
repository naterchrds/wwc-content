<?php if ( ! defined('WOODMART_THEME_DIR')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------------------------
 * Add theme support for WooCommerce
 * ------------------------------------------------------------------------------------------------
 */

add_theme_support( 'woocommerce' );
add_theme_support( 'wc-product-gallery-zoom' );

/**
 * ------------------------------------------------------------------------------------------------
 * Main loop
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_woocommerce_main_loop' ) ) {

	add_action( 'woodmart_woocommerce_main_loop', 'woodmart_woocommerce_main_loop' );

	function woodmart_woocommerce_main_loop( $fragments = false ) {
		global $paged, $wp_query, $woocommerce_loop;

        $max_page = $wp_query->max_num_pages;

 		if ( $fragments ) ob_start();
 		if ( $fragments && isset( $_GET['loop'] ) ) $woocommerce_loop['loop'] = (int) $_GET['loop'];
		
		if ( have_posts() ) : ?>
		
			<?php if( ! $fragments ) woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php if( ! $fragments ) woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				if( ! $fragments ) do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif;

		if ( $fragments ) $output = ob_get_clean();

	    if( $fragments ) {
	    	$output =  array(
	    		'items' => $output,
	    		'status' => ( $max_page > $paged ) ? 'have-posts' : 'no-more-posts',
	    		'nextPage' => add_query_arg( 'woo_ajax', '1', next_posts( $max_page, false ) )
	    	);

	    	echo json_encode( $output );
	    }
	}
}
/**
 * ------------------------------------------------------------------------------------------------
 * Change number of products displayed per page
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_shop_products_per_page' ) ) {
	function woodmart_shop_products_per_page() {
		$per_page = 12;
		$number = apply_filters('woodmart_shop_per_page', woodmart_get_products_per_page() );
		if( is_numeric( $number )  &&  $number > 0) {
			$per_page = $number;
		}
		return $per_page;
	}

	add_filter( 'loop_shop_per_page', 'woodmart_shop_products_per_page', 20 );
}


/**
 * ------------------------------------------------------------------------------------------------
 * Set full width layouts for woocommerce pages on set up
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_woocommerce_install_actions' ) ) {
	function woodmart_woocommerce_install_actions() {
		if ( ! empty( $_GET['page'] ) && @$_GET['page'] == 'wc-setup' && ! empty( $_GET['step'] ) && @$_GET['step'] == 'next_steps') {
			$pages = apply_filters( 'woocommerce_create_pages', array(
				'cart' => array(
					'name'    => _x( 'cart', 'Page slug', 'woodmart' ),
					'title'   => _x( 'Cart', 'Page title', 'woodmart' ),
					'content' => '[' . apply_filters( 'woocommerce_cart_shortcode_tag', 'woocommerce_cart' ) . ']'
				),
				'checkout' => array(
					'name'    => _x( 'checkout', 'Page slug', 'woodmart' ),
					'title'   => _x( 'Checkout', 'Page title', 'woodmart' ),
					'content' => '[' . apply_filters( 'woocommerce_checkout_shortcode_tag', 'woocommerce_checkout' ) . ']'
				),
			) );

			foreach ( $pages as $key => $page ) {
				$option = 'woocommerce_' . $key . '_page_id';
				$page_id = get_option( $option );
				update_post_meta( $page_id, '_woodmart_main_layout', 'full-width' );
			}

			woodmart_woocommerce_image_dimensions();
		}
	}

	add_action( 'admin_init', 'woodmart_woocommerce_install_actions', 1000);
	add_action( 'admin_print_styles', 'woodmart_woocommerce_install_actions', 1000);
}


/**
 * Define image sizes
 */
if( ! function_exists( 'woodmart_woocommerce_image_dimensions' ) ) {
	function woodmart_woocommerce_image_dimensions() {
		global $pagenow;
	 	
	  	$catalog = array(
			'width' 	=> '600',	// px
			'height'	=> '800',	// px
			'crop'		=> 0 		// true
		);
		$single = array(
			'width' 	=> '1200',	// px
			'height'	=> '1800',	// px
			'crop'		=> 0 		// true
		);
		$thumbnail = array(
			'width' 	=> '280',	// px
			'height'	=> '280',	// px
			'crop'		=> 0 		// false
		);
		// Image sizes
		update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
		update_option( 'shop_single_image_size', $single ); 		// Single product image
		update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Check if WooCommerce is active
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_woocommerce_installed' ) ) {
	function woodmart_woocommerce_installed() {
	    return class_exists( 'WooCommerce' );
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Get base shop page link
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_shop_page_link' ) ) {
	function woodmart_shop_page_link( $keep_query = false, $taxonomy = '' ) {
		// Base Link decided by current page
		if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
			$link = home_url();
		} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id('shop') ) ) {
			$link = get_post_type_archive_link( 'product' );
		} elseif( is_product_category() ) {
			$link = get_term_link( get_query_var('product_cat'), 'product_cat' );
		} elseif( is_product_tag() ) {
			$link = get_term_link( get_query_var('product_tag'), 'product_tag' );
		} else {
			$link = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
		}

		if( $keep_query ) {

			// Min/Max
			if ( isset( $_GET['min_price'] ) ) {
				$link = add_query_arg( 'min_price', wc_clean( $_GET['min_price'] ), $link );
			}

			if ( isset( $_GET['max_price'] ) ) {
				$link = add_query_arg( 'max_price', wc_clean( $_GET['max_price'] ), $link );
			}

			// Orderby
			if ( isset( $_GET['orderby'] ) ) {
				$link = add_query_arg( 'orderby', wc_clean( $_GET['orderby'] ), $link );
			}

			/**
			 * Search Arg.
			 * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
			 */
			if ( get_search_query() ) {
				$link = add_query_arg( 's', rawurlencode( htmlspecialchars_decode( get_search_query() ) ), $link );
			}

			// Post Type Arg
			if ( isset( $_GET['post_type'] ) ) {
				$link = add_query_arg( 'post_type', wc_clean( $_GET['post_type'] ), $link );
			}

			// Min Rating Arg
			if ( isset( $_GET['min_rating'] ) ) {
				$link = add_query_arg( 'min_rating', wc_clean( $_GET['min_rating'] ), $link );
			}

			// All current filters
			if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) {
				foreach ( $_chosen_attributes as $name => $data ) {
					if ( $name === $taxonomy ) {
						continue;
					}
					$filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );
					if ( ! empty( $data['terms'] ) ) {
						$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
					}
					if ( 'or' == $data['query_type'] ) {
						$link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
					}
				}
			}
		}

		return $link;
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * is ajax request
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woodmart_is_woo_ajax' ) ) {
	function woodmart_is_woo_ajax() {
		
		$request_headers = getallheaders();

		if( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return 'wp-ajax';
		}
		if( isset( $request_headers['x-pjax'] ) || isset( $request_headers['X-PJAX'] ) || isset( $request_headers['X-Pjax'] ) ) {
			return 'full-page';
		}
		if( isset( $_REQUEST['woo_ajax'] ) ) {
			return 'fragments';
		}
		if( isset( $_REQUEST['_pjax'] ) ) {
			return 'full-page';
		}

		if( woodmart_is_pjax() ) {
			return true;
		}
		return false;
	}
}

if( ! function_exists( 'woodmart_is_pjax' ) ) {
	function woodmart_is_pjax(){
		return isset( $_REQUEST['_pjax'] );
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Get product design option
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woodmart_product_design' ) ) {
	function woodmart_product_design() {
		$design = woodmart_get_opt( 'product_design' );
		if( is_singular( 'product' ) ) {
			$custom = get_post_meta( get_the_ID(), '_woodmart_product_design', true );
			if( ! empty( $custom ) && $custom != 'inherit' ) $design = $custom;
		}

		return $design;
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Is product sticky
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woodmart_product_sticky' ) ) {
	function woodmart_product_sticky() {
		$sticky = woodmart_get_opt( 'product_sticky' );
		if( is_singular( 'product' ) ) {
			$custom = get_post_meta( get_the_ID(), '_woodmart_product_sticky', true );
			if( ! empty( $custom ) && $custom != 'inherit' ) $sticky = $custom;
		}

		return $sticky;
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Custom function for product title
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woocommerce_template_loop_product_title' ) ) {
	function woocommerce_template_loop_product_title() {
		echo '<h3 class="product-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>';
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Register new image size two times larger than standard woocommerce one 
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_add_image_size' ) ) {
	add_action( 'after_setup_theme', 'woodmart_add_image_size' );

	function woodmart_add_image_size() {

		if( ! function_exists( 'wc_get_image_size' ) ) return;

		$shop_catalog = wc_get_image_size( 'shop_catalog' );

		$width = (int) ( $shop_catalog['width'] * 2 );
		$height = (int) ( $shop_catalog['height'] * 2 );

		add_image_size( 'woodmart_shop_catalog_x2', $width, $height, $shop_catalog['crop'] );
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Custom thumbnail function for slider
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woodmart_template_loop_product_thumbnail' ) ) {
	function woodmart_template_loop_product_thumbnail() {
		echo woodmart_get_product_thumbnail();
	}
}

if ( ! function_exists( 'woodmart_get_product_thumbnail' ) ) {
	function woodmart_get_product_thumbnail( $size = 'shop_catalog', $attach_id = false ) {
		global $post, $woodmart_loop;
		$custom_size = $size;
		$defined_sizes = array('shop_catalog', 'woodmart_shop_catalog_x2');

		if( ! empty( $woodmart_loop['double_size'] ) && $woodmart_loop['double_size'] ) {
			$size = 'woodmart_shop_catalog_x2';
		}

		if ( has_post_thumbnail() ) {

			if( ! $attach_id ) $attach_id = get_post_thumbnail_id();

			$props = wc_get_product_attachment_props( $attach_id, $post );
			
			if( ! empty( $woodmart_loop['img_size'] ) ) {
				$custom_size = $woodmart_loop['img_size'];
			} 

			if( ! in_array( $custom_size, $defined_sizes ) && function_exists( 'wpb_getImageBySize' ) ) {

				$img = wpb_getImageBySize( array( 'attach_id' => $attach_id, 'thumb_size' => $custom_size, 'class' => 'content-product-image' ) );
				$img = $img['thumbnail'];

			} else {
				$img = wp_get_attachment_image( $attach_id, $size, array(
					'title'	 => $props['title'],
					'alt'    => $props['alt'],
				) );
			}

			return $img;

		} elseif ( wc_placeholder_img_src() ) {
			return wc_placeholder_img( $size );
		}
	}
}

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woodmart_template_loop_product_thumbnail', 10 );


/**
 * ------------------------------------------------------------------------------------------------
 * Checkout steps in page title
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_checkout_steps' ) ) {
	function woodmart_checkout_steps() {

		?>
            <div class="woodmart-checkout-steps">
                <ul>
                	<li class="step-cart <?php echo (is_cart()) ? 'step-active' : 'step-inactive'; ?>">
                		<a href="<?php echo esc_url(WC()->cart->get_cart_url()); ?>">
                			<span><?php esc_html_e('Shopping cart', 'woodmart'); ?></span>
                		</a>
                	</li>
                	<li class="step-checkout <?php echo (is_checkout() && ! is_order_received_page()) ? 'step-active' : 'step-inactive'; ?>">
                		<a href="<?php echo esc_url(WC()->cart->get_checkout_url()); ?>">
                			<span><?php esc_html_e('Checkout', 'woodmart'); ?></span>
                		</a>
                	</li>
                	<li class="step-complete <?php echo (is_order_received_page()) ? 'step-active' : 'step-inactive'; ?>">
                		<span><?php esc_html_e('Order complete', 'woodmart'); ?></span>
                	</li>
                </ul>
            </div>
		<?php
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Custom thumbnail for category (wide items)
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_category_thumb_double_size' ) ) {
	function woodmart_category_thumb_double_size( $category ) {
		global $woodmart_loop;
		$small_thumbnail_size  	= apply_filters( 'subcategory_archive_thumbnail_size', 'shop_catalog' );
		$dimensions    			= wc_get_image_size( $small_thumbnail_size );
		$thumbnail_id  			= get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );

		if( ! empty( $woodmart_loop['double_size'] ) && $woodmart_loop['double_size'] ) {
			$small_thumbnail_size = 'woodmart_shop_catalog_x2';
			$dimensions['width'] *= 2;
			$dimensions['height'] *= 2;
		}

		if ( $thumbnail_id ) {
			$image = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size  );
			$image = $image[0];
		} else {
			$image = wc_placeholder_img_src();
		}

		if ( $image ) {
			// Prevent esc_url from breaking spaces in urls for image embeds
			// Ref: https://core.trac.wordpress.org/ticket/23605
			$image = str_replace( ' ', '%20', $image );

			echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" />';
		}
	}
}

remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );
add_action( 'woocommerce_before_subcategory_title', 'woodmart_category_thumb_double_size', 10 );


/**
 * ------------------------------------------------------------------------------------------------
 * Quick View button
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_quick_view_btn' ) ) {
	function woodmart_quick_view_btn( $id = false, $loop = 0, $loop_name = 'loop' ) {
		if( ! $id ) {
			$id = get_the_ID();
		}

		if ( woodmart_get_opt( 'quick_view') ): ?>
			<div class="quick-view">
				<a 
					href="<?php echo esc_url( get_the_permalink($id) ); ?>" 
					class="open-quick-view" 
					data-loop="<?php echo esc_attr( $loop ); ?>"
					data-loop-name="<?php echo esc_attr( $loop_name ); ?>"
					data-id="<?php echo esc_attr( $id ); ?>"><?php esc_html_e('Quick View', 'woodmart'); ?></a>
			</div>
		<?php endif;

	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Quick shop element
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_quick_shop_wrapper' ) ) {
	function woodmart_quick_shop_wrapper() {
		global $product;
		?>
			<div class="quick-shop-wrapper">
				<div class="quick-shop-close"><span><?php esc_html_e('Close', 'woodmart'); ?></span></div>
				<div class="quick-shop-form">
				</div>
			</div>
		<?php
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Show attribute swatches list
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_swatches_list' ) ) {
	function woodmart_swatches_list( $attribute_name = false ) {
		global $product;

		$id = $product->get_id();

		if( empty( $id ) || ! $product->is_type( 'variable' ) ) return false;

		$available_variations = $product->get_available_variations();

		if( ! $attribute_name ) {
			$attribute_name = woodmart_grid_swatches_attribute();
		}

		if( empty( $available_variations ) ) return false;

		$swatches_to_show = woodmart_get_option_variations(  $attribute_name, $available_variations, false, $id );

		if( empty( $swatches_to_show ) ) return false;
		$out = '';

		$out .=  '<div class="swatches-on-grid">';

		$swatch_size = woodmart_wc_get_attribute_term( $attribute_name, 'swatch_size' );

		if( apply_filters( 'woodmart_swatches_on_grid_right_order', true ) ) {
			$terms = wc_get_product_terms( $product->get_id(), $attribute_name, array( 'fields' => 'slugs' ) );

			$swatches_to_show_tmp = $swatches_to_show;

			$swatches_to_show = array();

			foreach ($terms as $id => $slug) {
				$swatches_to_show[$slug] = $swatches_to_show_tmp[$slug];
			}
		}


		foreach ($swatches_to_show as $key => $swatch) {
			$style = $class = '';

			if( ! empty( $swatch['color'] )) {
				$style = 'background-color:' .  $swatch['color'];
			} else if( ! empty( $swatch['image'] ) ) {
				$style = 'background-image: url(' . $swatch['image'] . ')';
			} else if( ! empty( $swatch['not_dropdown'] ) ) {
				$class .= 'text-only ';
			}

			$style .= ';';

			$data = '';

			if( isset( $swatch['image_src'] ) ) {
				$class .= 'swatch-has-image';
				$data .= 'data-image-src="' . $swatch['image_src'] . '"';
				$data .= ' data-image-srcset="' . $swatch['image_srcset'] . '"';
				$data .= ' data-image-sizes="' . $swatch['image_sizes'] . '"';
				if( woodmart_get_opt( 'swatches_use_variation_images' ) ) {
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $swatch['variation_id'] ), 'shop_thumbnail');
					if ( !empty( $thumb ) ) {
						$style = 'background-image: url(' . $thumb[0] . ')';
						$class .= ' variation-image-used';
					}
				}

				if( ! $swatch['is_in_stock'] ) {
					$class .= ' variation-out-of-stock';
				}
			}

			$class .= ' swatch-size-' . $swatch_size;

			$term = get_term_by( 'slug', $key, $attribute_name );

			$out .=  '<div class="swatch-on-grid woodmart-tooltip ' . esc_attr( $class ) . '" style="' . esc_attr( $style ) .'" ' . $data . '>' . $term->name . '</div>';
		}

		$out .=  '</div>';

		return $out;

	}
}


if( ! function_exists( 'woodmart_grid_swatches_attribute' ) ) {
	function woodmart_grid_swatches_attribute() {
		$custom = get_post_meta(get_the_ID(),  '_woodmart_swatches_attribute', true );
		return empty( $custom ) ? woodmart_get_opt( 'grid_swatches_attribute' ) : $custom;
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Product deal countdown
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_product_sale_countdown' ) ) {
	function woodmart_product_sale_countdown() {
		global $post;
		$sale_date = get_post_meta( $post->ID, '_sale_price_dates_to', true );

		if( ! $sale_date ) return;

		echo '<div class="woodmart-product-countdown woodmart-timer" data-end-date="' . esc_attr( date( 'Y/m/d', $sale_date ) ) . '"></div>';
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Brand image
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_product_brand' ) ) {
	function woodmart_product_brand() {
		global $product;
		$attr = woodmart_get_opt( 'brands_attribute' );
		if( ! $attr || ! woodmart_get_opt( 'product_page_brand' ) ) return;

		$attributes = $product->get_attributes();

		if( ! isset( $attributes[ $attr ] ) || empty( $attributes[ $attr ] ) ) return;

		$brands = wc_get_product_terms( $product->get_id(), $attr, array( 'fields' => 'all' ) );

		if( empty( $brands ) ) return;

		if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
			$link = home_url();
		} else {
			$link = get_post_type_archive_link( 'product' );
		}

		echo '<div class="woodmart-product-brands">';

		foreach ($brands as $brand) {
			$image = get_term_meta( $brand->term_id, 'image', true);
			$filter_name    = 'filter_' . sanitize_title( str_replace( 'pa_', '', $attr ) );

			$attr_link = add_query_arg( $filter_name, $brand->slug, $link );

			if( ! empty( $image ) ) {
				echo '<div class="woodmart-product-brand">';
					echo '<a href="' . esc_url( $attr_link ) . '"><img src="' . esc_url( $image ) . '" title="' . esc_attr( $brand->slug ) . '" alt="' . esc_attr( $brand->slug ) . '" /></a>';
				echo '</div>';
			}

		}

		echo '</div>';

	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Hover image
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_hover_image' ) ) {
	function woodmart_hover_image() {
		global $product, $woocommerce_loop;
	
		$attachment_ids = $product->get_gallery_image_ids();

		$hover_image = '';

		if ( ! empty( $attachment_ids[0] ) ) {
			$hover_image = woodmart_get_product_thumbnail( 'shop_catalog', $attachment_ids[0] );
		}

		if( $hover_image != '' && woodmart_get_opt( 'hover_image' ) ): ?>
			<div class="hover-img">
				<a href="<?php echo esc_url( get_permalink() ); ?>">
					<?php echo ( $hover_image ); ?>
				</a>
			</div>
		<?php endif;

	}
}


if( ! function_exists( 'woodmart_products_nav' ) ) {
	function woodmart_products_nav() {
	    $next = get_next_post();
	    $prev = get_previous_post();

	    $next = ( ! empty( $next ) ) ? wc_get_product( $next->ID ) : false;
	    $prev = ( ! empty( $prev ) ) ? wc_get_product( $prev->ID ) : false;

		?>
			<div class="woodmart-products-nav">
				<?php if ( ! empty( $prev ) ): ?>
				<div class="product-btn product-prev">
					<a href="<?php echo esc_url( $prev->get_permalink() ); ?>"><?php esc_html_e('Previous product', 'woodmart'); ?><span class="product-btn-icon"></span></a>
					<div class="wrapper-short">
						<div class="product-short">
							<div class="product-short-image">
								<a href="<?php echo esc_url( $prev->get_permalink() ); ?>" class="product-thumb">
									<?php echo wp_kses( $prev->get_image(), array( 'img' => array('class' => true,'width' => true,'height' => true,'src' => true,'alt' => true) ) );?>
								</a>
							</div>
							<div class="product-short-description">
								<a href="<?php echo esc_url( $prev->get_permalink() ); ?>" class="product-title">
									<?php echo esc_html( $prev->get_title() ); ?>
								</a>
								<span class="price">
									<?php echo $prev->get_price_html(); ?>
								</span>
							</div>
						</div>
					</div>
				</div>
				<?php endif ?>

				<?php woodmart_back_btn();  ?>

				<?php if ( ! empty( $next ) ): ?>
				<div class="product-btn product-next">
					<a href="<?php echo esc_url( $next->get_permalink() ); ?>"><?php esc_html_e('Next product', 'woodmart'); ?><span class="product-btn-icon"></span></a>
					<div class="wrapper-short">
						<div class="product-short">
							<div class="product-short-image">
								<a href="<?php echo esc_url( $next->get_permalink() ); ?>" class="product-thumb">
									<?php echo wp_kses( $next->get_image(), array( 'img' => array('class' => true,'width' => true,'height' => true,'src' => true,'alt' => true) ) );?>
								</a>
							</div>
							<div class="product-short-description">
								<a href="<?php echo esc_url( $next->get_permalink() ); ?>" class="product-title">
									<?php echo esc_html( $next->get_title() ); ?>
								</a>
								<span class="price">
									<?php echo $next->get_price_html(); ?>
								</span>
							</div>
						</div>
					</div>
				</div>
				<?php endif ?>
			</div>
		<?php
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Compare button
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_configure_compare' ) ) {
	add_action( 'init', 'woodmart_configure_compare' );
	function woodmart_configure_compare() {
		global $yith_woocompare;
		if( ! class_exists( 'YITH_Woocompare' ) ) return;

		$compare = $yith_woocompare->obj;

		if ( get_option('yith_woocompare_compare_button_in_products_list') == 'yes' ) {
			remove_action( 'woocommerce_after_shop_loop_item', array( $compare, 'add_compare_link' ), 20 );
		}

        if ( get_option('yith_woocompare_compare_button_in_product_page') == 'yes' ) {
        	add_action( 'woocommerce_single_product_summary', 'woodmart_before_compare_button', 33 );
        	add_action( 'woocommerce_single_product_summary', 'woodmart_after_compare_button', 37 );
        }

	}
}

if( ! function_exists( 'woodmart_before_compare_button' ) ) {
	function woodmart_before_compare_button() {
		echo '<div class="compare-btn-wrapper">';
	}
}

if( ! function_exists( 'woodmart_after_compare_button' ) ) {
	function woodmart_after_compare_button() {
		echo '</div>';
	}
}

if( ! function_exists( 'woodmart_compare_btn' ) ) {
	function woodmart_compare_btn() {
		if( ! class_exists( 'YITH_Woocompare' ) ) return;

		if( get_option('yith_woocompare_compare_button_in_products_list') != 'yes' ) return;

		echo '<div class="product-compare-button">';
            global $product;
            $product_id = $product->get_id();

            // return if product doesn't exist
            if ( empty( $product_id ) || apply_filters( 'yith_woocompare_remove_compare_link_by_cat', false, $product_id ) )
	            return;

            $is_button = ! isset( $button_or_link ) || ! $button_or_link ? get_option( 'yith_woocompare_is_button' ) : $button_or_link;

            if ( ! isset( $button_text ) || $button_text == 'default' ) {
                $button_text = get_option( 'yith_woocompare_button_text', esc_html__( 'Compare', 'woodmart' ) );
            }

            printf( '<a href="%s" class="%s" data-product_id="%d" rel="nofollow">%s</a>', woodmart_compare_add_product_url( $product_id ), 'compare' . ( $is_button == 'button' ? ' button' : '' ), $product_id, $button_text );
        
		echo '</div>';
	}
}


if( ! function_exists( 'woodmart_compare_add_product_url' ) ) {
    function woodmart_compare_add_product_url( $product_id ) {
    	$action_add = 'yith-woocompare-add-product';
        $url_args = array(
            'action' => 'asd',
            'id' => $product_id
        );
        return apply_filters( 'yith_woocompare_add_product_url', esc_url_raw( add_query_arg( $url_args ) ), $action_add );
    }
}


if( ! function_exists( 'woodmart_compare_styles' ) ) {
	add_action( 'wp_print_styles', 'woodmart_compare_styles', 200 );
	function woodmart_compare_styles() {
		if( ! class_exists( 'YITH_Woocompare' ) ) return;
		$view_action = 'yith-woocompare-view-table';
		if ( ( ! defined('DOING_AJAX') || ! DOING_AJAX ) && ( ! isset( $_REQUEST['action'] ) || $_REQUEST['action'] != $view_action ) ) return;
		wp_enqueue_style( 'woodmart-style' );
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * WishList button
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_wishlist_btn' ) ) {
	function woodmart_wishlist_btn() {
		if( class_exists('YITH_WCWL_Shortcode')) echo YITH_WCWL_Shortcode::add_to_wishlist(array());
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Get product page classes (columns) for product images and product information blocks
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_product_images_class' ) ) {
	function woodmart_product_images_class() {
		$size = woodmart_product_images_size();
		$class = 'col-sm-';
		return $class . $size;
	}

		function woodmart_product_images_size() {
			return apply_filters( 'woodmart_product_summary_size', 12 - woodmart_product_summary_size() );
		}
}

if( ! function_exists( 'woodmart_product_summary_class' ) ) {
	function woodmart_product_summary_class() {
		$size = woodmart_product_summary_size();
		$class = 'col-sm-';

		return $class . $size;
	}

		function woodmart_product_summary_size() {
			$page_layout = woodmart_get_opt( 'single_product_style' );

			$size = 6;
			switch ( $page_layout ) {
				case 1:
					$size = 8;
				break;
				case 2:
					$size = 6;
				break;
				case 3:
					$size = 4;
				break;
			}
			return apply_filters( 'woodmart_product_summary_size', $size );
		}
}

if( ! function_exists( 'woodmart_single_product_class' ) ) {
	function woodmart_single_product_class() {
		global $product;
		$classes = array();
		$classes[] = 'single-product-page';
		$classes[] = 'single-product-content';

		$design = woodmart_product_design();
		$product_bg  = woodmart_get_opt( 'product-background' );
		$attachment_ids = $product->get_gallery_image_ids();
		
		$classes[] = 'product-design-' . $design;
		$classes[] = 'tabs-location-' . woodmart_get_opt( 'product_tabs_location' );
		$classes[] = 'tabs-type-' . woodmart_get_opt( 'product_tabs_layout' );
		$classes[] = 'meta-location-' . woodmart_get_opt( 'product_show_meta' );
		$classes[] = 'reviews-location-' . woodmart_get_opt( 'reviews_location' );

		if( $design == 'alt' ) {
			$classes[] = 'product-align-center';
		}

		if( woodmart_get_opt( 'single_full_width' ) ) {
			$classes[] = 'product-full-width';
		}

		if( woodmart_get_opt( 'product_summary_shadow' ) ) {
			$classes[] = 'product-summary-shadow';
		}

		if( woodmart_product_sticky() ) {
			$classes[] = 'product-sticky-on';
		}

		if( ! empty( $product_bg ) &&  ! empty( $product_bg['background-color'] ) ) {
			$classes[] = 'product-has-bg';
		} else {
			$classes[] = 'product-no-bg';
		}

		if( $attachment_ids ) {
			$classes[] = 'product-with-attachments';
		}

		return $classes;

	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Configure product image gallery JS
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_get_product_gallery_settings' ) ) {
	function woodmart_get_product_gallery_settings() {
		return apply_filters( 'woodmart_product_gallery_settings', array(
			'images_slider' => woodmart_is_main_product_images_carousel(),
			'thumbs_slider' => array(
				'enabled' => woodmart_is_product_thumb_enabled(),
				'position' => woodmart_get_opt('thums_position'),
				'items' => array(
					'desktop' => 4,
					'desktop_small' => 3,
					'tablet' => 4,
					'mobile' => 3,
					'vertical_items' => 3
				)
			)
		) );
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Remove product content link
 * ------------------------------------------------------------------------------------------------
 */
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );
remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10 );

/**
 * ------------------------------------------------------------------------------------------------
 * WooCommerce enqueues 3 stylesheets by default. You can disable them all with the following snippet
 * ------------------------------------------------------------------------------------------------
 */

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * ------------------------------------------------------------------------------------------------
 * Disable photoswipe
 * ------------------------------------------------------------------------------------------------
 */

remove_action( 'wp_footer', 'woocommerce_photoswipe' );


/**
 * ------------------------------------------------------------------------------------------------
 * Change position of woocommerce notices
 * ------------------------------------------------------------------------------------------------
 */

remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
add_action( 'woocommerce_before_main_content', 'wc_print_notices', 50 );

/**
 * ------------------------------------------------------------------------------------------------
 * Remove ordering from toolbar
 * ------------------------------------------------------------------------------------------------
 */

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );


/**
 * ------------------------------------------------------------------------------------------------
 * Unhook the WooCommerce wrappers
 * ------------------------------------------------------------------------------------------------
 */

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);


/**
 * ------------------------------------------------------------------------------------------------
 * hook in your own functions to display the wrappers your theme requires
 * ------------------------------------------------------------------------------------------------
 */


/**
 * ------------------------------------------------------------------------------------------------
 * Get CSS class for widget in shop area. Based on the number of widgets
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_get_widget_column_class' ) ) {
	function woodmart_get_widget_column_class( $sidebar_id = 'filters-area' ) {
		global $_wp_sidebars_widgets;
		if ( empty( $_wp_sidebars_widgets ) ) :
			$_wp_sidebars_widgets = get_option( 'sidebars_widgets', array() );
		endif;
		
		$sidebars_widgets_count = $_wp_sidebars_widgets;

		if ( isset( $sidebars_widgets_count[ $sidebar_id ] ) || $sidebar_id == 'filters-area' ) {
			$count = ( isset( $sidebars_widgets_count[ $sidebar_id ] ) ) ? count( $sidebars_widgets_count[ $sidebar_id ] ) : 0;
			$widget_count = apply_filters( 'widgets_count_' . $sidebar_id, $count );
			$widget_classes = 'widget-count-' . $widget_count;
			$widget_classes .= woodmart_get_grid_el_class( 0, ( ($widget_count > 4) ? 4 : $widget_count ), false, 12, 6, 6 );
			return apply_filters( 'widget_class_' . $sidebar_id, $widget_classes);
		}
	}
}

 

add_action('woocommerce_before_main_content', 'woodmart_woo_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'woodmart_woo_wrapper_end', 10);

if(!function_exists( 'woodmart_woo_wrapper_start' )) {
	function woodmart_woo_wrapper_start() {
		$content_class = woodmart_get_content_class();
		if( is_singular('product') ) $content_class = 'col-sm-12';
		echo '<div class="site-content content-with-products ' . $content_class . '" role="main">';
	}
}


if(!function_exists( 'woodmart_woo_wrapper_end' )) {
	function woodmart_woo_wrapper_end() {
		echo '</div>';
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * My account sidebar
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_before_my_account_navigation' ) ) {
	function woodmart_before_my_account_navigation() {
		echo '<div class="woodmart-my-account-sidebar">';
		if(!function_exists('woodmart_my_account_title')) {
			the_title( '<h3 class="woocommerce-MyAccount-title entry-title">', '</h3>' );
		}
	}

	add_action( 'woocommerce_account_navigation', 'woodmart_before_my_account_navigation', 1 );
}

if( ! function_exists( 'woodmart_after_my_account_navigation' ) ) {
	function woodmart_after_my_account_navigation() {
		$sidebar_name = 'sidebar-my-account';
		if ( is_active_sidebar( $sidebar_name ) ) : ?>
			<aside class="sidebar-container" role="complementary">
				<div class="sidebar-inner">
					<div class="widget-area">
						<?php dynamic_sidebar( $sidebar_name ); ?>
					</div><!-- .widget-area -->
				</div><!-- .sidebar-inner -->
			</aside><!-- .sidebar-container -->
		<?php endif;
		echo '</div><!-- .woodmart-my-account-sidebar -->';
	}

	add_action( 'woocommerce_account_navigation', 'woodmart_after_my_account_navigation', 30 );
}



/**
 * ------------------------------------------------------------------------------------------------
 * Play with woocommerce hooks
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_woocommerce_hooks' ) ) {
	function woodmart_woocommerce_hooks() {
        global $woodmart_prefix;

        $product_meta_position = woodmart_get_opt( 'product_show_meta' );
        $product_show_meta = ( $product_meta_position != 'hide' );
        $product_show_share = woodmart_get_opt( 'product_share' );
        $product_show_descr = woodmart_get_opt( 'product_short_description' );
        $tabs_location = woodmart_get_opt( 'product_tabs_location' );
        $reviews_location = woodmart_get_opt( 'reviews_location' );

		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

		// Reviews location
		if( $reviews_location == 'separate' ) {
			add_filter( 'woocommerce_product_tabs', 'woodmart_disable_reviews_tab', 98 );
			add_action( 'woocommerce_after_single_product_summary', 'comments_template', 50 );
		}

		// Upsells position
		if( is_singular( 'product' ) ) {
			if( woodmart_get_opt( 'upsells_position' )  == 'sidebar' ) {
				add_action( 'woodmart_before_sidebar_area', 'woocommerce_upsell_display', 20 );
			} else {
				add_action( 'woodmart_woocommerce_after_sidebar', 'woocommerce_upsell_display', 10 );
			}
		}

		// Disable related products option
		if( woodmart_get_opt('related_products') && ! get_post_meta(get_the_ID(),  '_woodmart_related_off', true ) ) {
			add_action( 'woodmart_woocommerce_after_sidebar', 'woocommerce_output_related_products', 20 );
		}

		// Disable product tabs title option
		if( woodmart_get_opt('hide_tabs_titles') || get_post_meta(get_the_ID(),  '_woodmart_hide_tabs_titles', true ) ) {
			add_filter( 'woocommerce_product_description_heading', '__return_false', 20 );
			add_filter( 'woocommerce_product_additional_information_heading', '__return_false', 20 );
		}

		if( woodmart_get_opt('shop_filters') ) {
 			
 			// Use our own order widget list?
			if( apply_filters( 'woodmart_use_custom_order_widget', true ) ) {
				if( ! is_active_widget( false, false, 'woodmart-woocommerce-sort-by', true ) ) {
					add_action( 'woodmart_before_filters_widgets', 'woodmart_sorting_widget', 10 );
				}
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			}

			// Use our custom price filter widget list?
			if( apply_filters( 'woodmart_use_custom_price_widget', true )  && ! is_active_widget( false, false, 'woodmart-price-filter', true ) ) {
				add_action( 'woodmart_before_filters_widgets', 'woodmart_price_widget', 20 );
			}

			// Add 'filters button'
			add_action( 'woocommerce_before_shop_loop', 'woodmart_filter_buttons', 40 );
		}

		add_action( 'woocommerce_cart_is_empty', 'woodmart_empty_cart_text', 20 );

		// Wrapp cart totals

		add_action( 'woocommerce_before_cart_totals', function() {
			echo '<div class="cart-totals-inner">';
		}, 1);
		add_action( 'woocommerce_after_cart_totals', function() {
			echo '</div><!--.cart-totals-inner-->';
		}, 200);

		// Brand tab for single product
		if( woodmart_get_opt( 'brand_tab' ) ) {
			add_filter( 'woocommerce_product_tabs', 'woodmart_product_brand_tab' );
		}

		// Poduct brand
		if( woodmart_get_opt( 'product_brand_location' ) == 'about_title' && is_singular( 'product' ) ) {
			add_action( 'woocommerce_single_product_summary', 'woodmart_product_brand', 3);
		} elseif( is_singular( 'product' )) {
			add_action( 'woodmart_before_sidebar_area', 'woodmart_product_brand', 10 );
		}

		// Product share

		if ( $product_meta_position != 'after_tabs' && $product_show_share ) {
			add_action( 'woocommerce_single_product_summary', 'woodmart_product_share_buttons', 60 );
		}

		// Disable meta and description if turned off
		if ( $product_meta_position != 'add_to_cart' ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		}

		if ( ! $product_show_descr ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		}

		// Product tabs location

		if( $tabs_location == 'summary' ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 37 );
		}


		if ( $product_meta_position == 'after_tabs' ) {
			add_action( 'woodmart_after_product_tabs', function() {
				echo '<div class="woodmart-before-product-tabs"><div class="container">';
			}, 10 );

			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
			if( $product_show_meta ) add_action( 'woodmart_after_product_tabs', 'woocommerce_template_single_meta', 20 );
			if( $product_show_share ) add_action( 'woodmart_after_product_tabs', 'woodmart_product_share_buttons', 30 );

			add_action( 'woodmart_after_product_tabs', function() {
				echo '</div></div>';
			}, 200 );
		}

		// Product video, 360 view, zoom
		$video_url = get_post_meta(get_the_ID(),  '_woodmart_product_video', true );
		$images_360_gallery = woodmart_get_360_gallery_attachment_ids();
		$image_action = woodmart_get_opt( 'image_action' );

		if( ! empty( $video_url ) || ! empty( $images_360_gallery ) || ! empty( $image_action ) ) {
			add_action( 'woodmart_on_product_image', 'woodmart_additional_galleries_open', 25 );
			add_action( 'woodmart_on_product_image', 'woodmart_additional_galleries_close', 100 );
		}
		
		if( ! empty( $video_url ) ) {
			add_action( 'woodmart_on_product_image', 'woodmart_product_video_button', 30 );
		}

		if( ! empty( $images_360_gallery ) ) {
			add_action( 'woodmart_on_product_image', 'woodmart_product_360_view', 40 );
		}

		if( $image_action != 'popup' && woodmart_get_opt( 'photoswipe_icon' ) ) {
			add_action( 'woodmart_on_product_image', 'woodmart_product_zoom_button', 50 );
		}

		// Custom extra content
		$extra_block = get_post_meta(get_the_ID(),  '_woodmart_extra_content', true );

		if( ! empty( $extra_block ) && $extra_block != 0 ) {
			$extra_position = get_post_meta(get_the_ID(),  '_woodmart_extra_position', true );
			if( $extra_position == 'before' ) {
				add_action( 'woocommerce_before_single_product', 'woodmart_product_extra_content', 20 );
			} else if( $extra_position == 'prefooter' ) {
				add_action( 'woodmart_woocommerce_after_sidebar', 'woodmart_product_extra_content', 30 );
			} else {
				add_action( 'woodmart_after_product_content', 'woodmart_product_extra_content', 20 );
				
			}
		}


		// Custom tab 
		add_filter( 'woocommerce_product_tabs', 'woodmart_additional_product_tab' );

		// Timer on the single product page
		add_action( 'woocommerce_single_product_summary', 'woodmart_single_product_couuntdown', 15 );

		// Instagram by hashbat for product
		add_action( 'woodmart_woocommerce_after_sidebar', 'woodmart_product_instagram', 80 );

		// Cart page move totals
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );

	}

	add_action( 'wp', 'woodmart_woocommerce_hooks', 1000 );
}


if( ! function_exists( 'woodmart_single_product_couuntdown' ) ) {
	function woodmart_single_product_couuntdown( $tabs ) {
		$timer = woodmart_get_opt( 'product_countdown' );
		if( $timer ) woodmart_product_sale_countdown();
	}
}
/**
 * ------------------------------------------------------------------------------------------------
 * Extra content block
 * ------------------------------------------------------------------------------------------------
 */


if( ! function_exists( 'woodmart_product_extra_content' ) ) {
	function woodmart_product_extra_content( $tabs ) { 
		$extra_block = get_post_meta(get_the_ID(),  '_woodmart_extra_content', true );
		echo '<div class="product-extra-content">' . woodmart_html_block_shortcode( array( 'id' => $extra_block ) ) . '</div>';
	}
}
		

/**
 * ------------------------------------------------------------------------------------------------
 * Additional tab
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_additional_product_tab' ) ) {
	function woodmart_additional_product_tab( $tabs ) {

		$tab_title = woodmart_get_opt( 'additional_tab_title' );

		if( empty( $tab_title ) ) return $tabs;
		
		$tabs['woodmart_additional_tab'] = array(
			'title' 	=> $tab_title,
			'priority' 	=> 50,
			'callback' 	=> 'woodmart_additional_product_tab_content'
		);

		return $tabs;

	}
}

if( ! function_exists( 'woodmart_additional_product_tab_content' ) ) {
	function woodmart_additional_product_tab_content() {
		// The new tab content
		$tab_content = woodmart_get_opt( 'additional_tab_text' );
		echo do_shortcode( $tab_content );
		
	}
}


if( ! function_exists( 'woodmart_disable_reviews_tab' ) ) {
	function woodmart_disable_reviews_tab( $tabs ) {
	    unset( $tabs['reviews'] );  // Removes the reviews tab
	    return $tabs;
	}
}



/**
 * ------------------------------------------------------------------------------------------------
 * Product video, 360 view, zoom buttons
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_product_video_button' ) ) {
	function woodmart_product_video_button() {
		$video_url = get_post_meta(get_the_ID(),  '_woodmart_product_video', true );
		?>
			<div class="product-video-button">
				<a href="<?php echo esc_url( $video_url ); ?>"><span><?php esc_html_e('Watch video', 'woodmart'); ?></span></a>
			</div>
		<?php
	}
}

if( ! function_exists( 'woodmart_product_zoom_button' ) ) {
	function woodmart_product_zoom_button() {
		?>
			<div class="woodmart-show-product-gallery-wrap"><a href="#" class="woodmart-show-product-gallery"><span><?php esc_html_e('Click to enlarge', 'woodmart'); ?></span></a></div>
		<?php
	}
}

if( ! function_exists( 'woodmart_additional_galleries_open' ) ) {
	function woodmart_additional_galleries_open() {
		?>
			<div class="product-additional-galleries">
		<?php
	}
}

if( ! function_exists( 'woodmart_additional_galleries_close' ) ) {
	function woodmart_additional_galleries_close() {
		?>
			</div>
		<?php
	}
}


if( ! function_exists( 'woodmart_product_360_view' ) ) {
	function woodmart_product_360_view() {
		$images = woodmart_get_360_gallery_attachment_ids();
		if( empty( $images ) ) return;

		$id = rand(100,999);

		$title = '';

		$frames_count = count( $images );

		$images_js_string = '';

		?>
			<div class="product-360-button">
				<a href="#product-360-view"><span><?php esc_html_e('360 product view', 'woodmart'); ?></span></a>
			</div>
			<div id="product-360-view" class="product-360-view-wrapper mfp-hide">
				<div class="woodmart-threed-view threed-id-<?php echo esc_attr( $id ); ?>">
					<?php if ( ! empty( $title ) ): ?>
						<h3 class="threed-title"><span><?php echo ($title); ?></span></h3>
					<?php endif ?>
					<ul class="threed-view-images">
						<?php if ( count($images) > 0 ): ?>
							<?php $i=0; foreach ($images as $img_id): $i++; ?>
								<?php 
									$img = wp_get_attachment_image_src( $img_id, 'full' );
									$width = $img[1];
									$height = $img[2];
									$images_js_string .= "'" . $img[0] . "'"; 
									if( $i < $frames_count ) {
										$images_js_string .= ","; 
									}
								?>
							<?php endforeach ?>
						<?php endif ?>
					</ul>
				    <div class="spinner">
				        <span>0%</span>
				    </div>
				</div>
			</div>
		<?php
		wp_add_inline_script('woodmart-theme', 'jQuery(document).ready(function( $ ) {
		    $(".threed-id-' . esc_js( $id ) . '").ThreeSixty({
		        totalFrames: ' . esc_js( $frames_count ) . ',
		        endFrame: ' . esc_js( $frames_count ) . ',
		        currentFrame: 1,
		        imgList: ".threed-view-images",
		        progress: ".spinner",
		        imgArray: ' . "[".$images_js_string."]" . ',
		        height: ' . esc_js( $height ) . ', 	
		        width: ' . esc_js( $width ) . ',
		        responsive: true,
		        navigation: true
		    });
		});', 'after');
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Single product share buttons
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_product_share_buttons' ) ) {
	function woodmart_product_share_buttons() {
		$type = woodmart_get_opt( 'product_share_type' );
		?>
			<?php if ( woodmart_is_social_link_enable( $type ) ): ?>
				<div class="product-share">
					<span class="share-title"><?php echo ($type == 'share') ? esc_html__('Share', 'woodmart') :  esc_html__('Follow', 'woodmart'); ?></span>
					<?php echo woodmart_shortcode_social( array( 'type' => $type, 'size' => 'small' ) ); ?>
				</div>
			<?php endif ?>
		<?php
	}
}



/**
 * ------------------------------------------------------------------------------------------------
 * Instagram by hashtag for products
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_product_instagram' ) ) {
	function woodmart_product_instagram() {
		$hashtag = get_post_meta(get_the_ID(),  '_woodmart_product_hashtag', true );
		if( empty( $hashtag ) ) return;
		?>
			<div class="woodmart-product-instagram">
				<p class="product-instagram-intro"><?php printf( wp_kses( __('Tag your photos with <span>%s</span> on Instagram.', 'woodmart') , array('span' => array())), $hashtag ); ?></p>
				<?php echo woodmart_shortcode_instagram( array(
					'username' => esc_html( $hashtag ),
					'number' => 8,
					'size' => 'medium',
					'target' => '_blank',
					'spacing' => 0,
					'rounded' => 0,
					'per_row' => 4
				) ); ?>
			</div>
		<?php
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Filters buttons
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_filter_buttons' ) ) {
	function woodmart_filter_buttons() {
		?>
			<div class="woodmart-filter-buttons">
				<a href="#" class="open-filters"><?php esc_html_e('Filters', 'woodmart'); ?></a>
			</div>
		<?php
	}
}

if( ! function_exists( 'woodmart_sorting_widget' ) ) {
	function woodmart_sorting_widget() {
		$filter_widget_class = woodmart_get_widget_column_class( 'filters-area' );
		the_widget( 'WOODMART_Widget_Sorting', array( 'title' => esc_html__('Sort by', 'woodmart') ), array(							
			'before_widget' => '<div id="WOODMART_Widget_Sorting" class="woodmart-widget filter-widget ' . esc_attr( $filter_widget_class ) . '">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>') 
		);
	}
}

if( ! function_exists( 'woodmart_price_widget' ) ) {
	function woodmart_price_widget() {
		$filter_widget_class = woodmart_get_widget_column_class( 'filters-area' );
		the_widget( 'WOODMART_Widget_Price_Filter', array( 'title' => esc_html__('Price filter', 'woodmart') ), array(							
			'before_widget' => '<div id="WOODMART_Widget_Price_Filter" class="woodmart-widget filter-widget ' . esc_attr( $filter_widget_class ) . '">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>') 
		);
	}
}

if( ! function_exists( 'woodmart_filter_widgts_classes' ) ) {
	function woodmart_filter_widgts_classes( $count ) {

		if( apply_filters( 'woodmart_use_custom_order_widget', true )  && ! is_active_widget( false, false, 'woodmart-woocommerce-sort-by', true ) ) {
			$count++;
		}

		if( apply_filters( 'woodmart_use_custom_price_widget', true )  && ! is_active_widget( false, false, 'woodmart-price-filter', true ) ) {
			$count++;
		}

		return $count;
	}

	add_filter('widgets_count_filters-area', 'woodmart_filter_widgts_classes');
}

/**
 * ------------------------------------------------------------------------------------------------
 * Add product brand tab to the single product page
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_product_brand_tab' ) ) {
	function woodmart_product_brand_tab( $tabs ) {
		global $product;
		$attribute = woodmart_get_opt( 'brands_attribute' );
		$brands_attribute = $product->get_attribute( $attribute );
		
		if ( $brands_attribute ) {
			$tabs['brand_tab'] = array(
				'title' 	=> esc_html__( 'About brand', 'woodmart' ),
				'priority' 	=> 50,
				'callback' 	=> 'woodmart_product_brand_tab_content'
			);
		}

		return $tabs;
	}
}

if( ! function_exists( 'woodmart_product_brand_tab_content' ) ) {
	function woodmart_product_brand_tab_content() {
		global $product;
		$attr = woodmart_get_opt( 'brands_attribute' );
		if( ! $attr || ! woodmart_get_opt( 'product_page_brand' ) ) return;

		$attributes = $product->get_attributes();

		if( ! isset( $attributes[ $attr ] ) || empty( $attributes[ $attr ] ) ) return;

		$brands = wc_get_product_terms( $product->get_id(), $attr, array( 'fields' => 'slugs' ) );

		if( empty( $brands ) ) return;

		foreach ($brands as $id => $slug) {
			echo '<div class="woodmart-product-brand-description">';
				$brand = get_term_by('slug', $slug, $attr);
				echo do_shortcode( $brand->description );
			echo '</div>';
		}

	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Force WOODMART Swatche layered nav and price widget to work
 * ------------------------------------------------------------------------------------------------
 */


add_filter( 'woocommerce_is_layered_nav_active', 'woodmart_is_layered_nav_active' );
if( ! function_exists( 'woodmart_is_layered_nav_active' ) ) {
	function woodmart_is_layered_nav_active() {
		return is_active_widget( false, false, 'woodmart-woocommerce-layered-nav', true );
	}
}

add_filter( 'woocommerce_is_price_filter_active', 'woodmart_is_layered_price_active' );

if( ! function_exists( 'woodmart_is_layered_price_active' ) ) {
	function woodmart_is_layered_price_active() {
		$result = is_active_widget( false, false, 'woodmart-price-filter', true );
		if( ! $result ) {
			$result = apply_filters( 'woodmart_use_custom_price_widget', true );
		}
		return $result;
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Empty cart text
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_empty_cart_text' ) ) {
	add_action( 'woocommerce_cart_is_empty', 'woodmart_empty_cart_text', 20 );

	function woodmart_empty_cart_text() {
		$empty_cart_text = woodmart_get_opt( 'empty_cart_text' );

		if( ! empty( $empty_cart_text ) ) {
			?>
				<div class="woodmart-empty-cart-text"><?php echo wp_kses( $empty_cart_text, array('p' => array(), 'h1' => array(), 'h2' => array(), 'h3' => array(), 'strong' => array(), 'em' => array(), 'span' => array(), 'div' => array() , 'br' => array()) ); ?></div>
			<?php
		}
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Change the position of woocommerce breadcrumbs
 * ------------------------------------------------------------------------------------------------
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 * ------------------------------------------------------------------------------------------------
 * Add photoswipe template to body
 * ------------------------------------------------------------------------------------------------
 */
add_action( 'woodmart_after_footer', 'woodmart_photoswipe_template', 1000 );
if( ! function_exists( 'woodmart_photoswipe_template' ) ) {
	function woodmart_photoswipe_template() {
		get_template_part('woocommerce/single-product/photo-swipe-template');
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Closer overlap div
 * ------------------------------------------------------------------------------------------------
 */
add_action( 'woodmart_after_footer', 'woodmart_closer_overlay', 1000 );
if( ! function_exists( 'woodmart_closer_overlay' ) ) {
	function woodmart_closer_overlay() {
		echo '<div class="woodmart-closer-overlay"></div>';
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Wrap shop tables with divs
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_open_table_wrapper_div' ) ) {
	function woodmart_open_table_wrapper_div() {
		echo '<div class="woodmart-table-wrapper">';
	}
	add_action( 'woocommerce_checkout_order_review', 'woodmart_open_table_wrapper_div', 7 );
}


if( ! function_exists( 'woodmart_close_table_wrapper_div' ) ) {
	function woodmart_close_table_wrapper_div() {
		echo '</div><!-- .woodmart-table-wrapper -->';
	}
	add_action( 'woocommerce_checkout_order_review', 'woodmart_close_table_wrapper_div', 13 );
}


// **********************************************************************// 
// ! Start woocommerce customer session
// **********************************************************************// 

if( ! function_exists( 'woodmart_set_customer_session' ) ) {

	add_action( 'init', 'woodmart_set_customer_session', 10 );

	function woodmart_set_customer_session() {
		if( ! function_exists( 'WC' ) ) return;
		if ( WC()->version > '2.1' && ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' ) ) :
			WC()->session->set_customer_session_cookie( true );
		endif;
	}
}

// **********************************************************************// 
// ! Items per page select on the shop page
// **********************************************************************// 

if( ! function_exists( 'woodmart_show_sidebar_btn' ) ) {
	
	add_action( 'woocommerce_before_shop_loop', 'woodmart_show_sidebar_btn', 25 );

	function woodmart_show_sidebar_btn() {
		?>
			<div class="woodmart-show-sidebar-btn">
				<span class="woodmart-side-bar-icon"></span>
				<span><?php esc_html_e('Show sidebar', 'woodmart'); ?></span>
			</div>
		<?php

	}
}

// **********************************************************************// 
// ! Items per page select on the shop page
// **********************************************************************// 

if( ! function_exists( 'woodmart_products_per_page_select' ) ) {
	
	add_action( 'woocommerce_before_shop_loop', 'woodmart_products_per_page_select', 25 );

	function woodmart_products_per_page_select() {
		if( ! woodmart_get_opt( 'per_page_links' ) ) return;
		global $wp_query;

		$per_page_options = woodmart_get_opt('per_page_options');

		$products_per_page_options = (!empty($per_page_options)) ? explode(',', $per_page_options) : array(12,24,36,-1);

		?>

		<div class="woodmart-products-per-page">

			<span class="per-page-title"><?php esc_html_e('Show', 'woodmart'); ?></span>

				<?php
					foreach( $products_per_page_options as $key => $value ) :
						?>
							<a href="<?php echo add_query_arg('per_page', $value, woodmart_shop_page_link(true)); ?>" class="per-page-variation<?php echo ($value == woodmart_get_products_per_page()) ? ' current-variation' : ''; ?>">
								<span><?php
									$text = '%s';
									esc_html( printf( $text, $value == -1 ? esc_html__( 'All', 'woodmart' ) : $value ) );
								?></span>
							</a>
							<span class="per-page-border"></span>
				<?php endforeach; ?>
		</div>
		<?php
	}
}


if( ! function_exists( 'woodmart_products_per_page_action' ) ) {

	add_action( 'init', 'woodmart_products_per_page_action', 100 );

	function woodmart_products_per_page_action() {
		if ( isset( $_REQUEST['per_page'] ) ) :
			if( ! class_exists('WC_Session_Handler')) return;
			$s = WC()->session; // WC()->session
			$s->set( 'shop_per_page', intval( $_REQUEST['per_page'] ) );
		endif;
	}
}

// **********************************************************************// 
// ! Get Items per page number on the shop page
// **********************************************************************// 

if( ! function_exists( 'woodmart_get_products_per_page' ) ) {
	function woodmart_get_products_per_page() {
		if( ! class_exists('WC_Session_Handler') ) return;
		$s = WC()->session; // WC()->session

		if ( isset( $_REQUEST['per_page'] ) && ! empty( $_REQUEST['per_page'] ) ) :
			return intval( $_REQUEST['per_page'] );
		elseif ( $s->__isset( 'shop_per_page' ) ) :
			$val = $s->__get( 'shop_per_page' );
			if( ! empty( $val ) )
				return intval( $s->__get( 'shop_per_page' ) );
		endif;
		return intval( woodmart_get_opt('shop_per_page') );
	}
}


// **********************************************************************// 
// ! Items per ROW select on the shop page
// **********************************************************************// 

if( ! function_exists( 'woodmart_products_columns_select' ) ) {
	
	add_action( 'woocommerce_before_shop_loop', 'woodmart_products_columns_select', 27 );

	function woodmart_products_columns_select() {
		if( ! woodmart_get_opt( 'per_row_columns_selector' ) ) return;

		$per_row_options = woodmart_get_opt('products_columns_variations');

		$products_per_row_options = (!empty($per_row_options)) ? array_unique( $per_row_options ) : array(2,3,4);
		?>
		<div class="woodmart-products-per-row">
			<?php foreach( $products_per_row_options as $key => $value ) : if( $value == 0 ) continue; ?>
				<a href="<?php echo add_query_arg('per_row', $value, woodmart_shop_page_link(true)); ?>" class="per-row-<?php echo esc_attr( $value ); ?> per-row-variation<?php echo ($value == woodmart_get_products_columns_per_row()) ? ' current-variation' : ''; ?>">
					<?php
						echo woodmart_get_svg_content('column-' . $value);
					?>
				</a>
			<?php endforeach; ?>
		</div>
		<?php
	}
}


if( ! function_exists( 'woodmart_products_columns_per_row_action' ) ) {

	add_action( 'init', 'woodmart_products_columns_per_row_action', 100 );

	function woodmart_products_columns_per_row_action() {
		if ( isset( $_REQUEST['per_row'] ) ) :
			if( ! class_exists('WC_Session_Handler')) return;
			$s = WC()->session; // WC()->session
			$s->set( 'shop_per_row', intval( $_REQUEST['per_row'] ) );
		endif;
	}
}

// **********************************************************************// 
// ! Get Items per ROW number on the shop page
// **********************************************************************// 

if( ! function_exists( 'woodmart_get_products_columns_per_row' ) ) {
	function woodmart_get_products_columns_per_row() {
		if( ! class_exists('WC_Session_Handler') ) return;
		$s = WC()->session; // WC()->session

		if ( isset( $_REQUEST['per_row'] ) ) :
			return intval( $_REQUEST['per_row'] );
		elseif ( $s->__isset( 'shop_per_row' ) ) :
			return intval( $s->__get( 'shop_per_row' ) );
		else :
			return intval( woodmart_get_opt('products_columns') );
		endif;
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Display categories menu
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_product_categories_nav' ) ) {
	function woodmart_product_categories_nav() {
		global $wp_query, $post;

		$show_subcategories = woodmart_get_opt( 'shop_categories_ancestors' );

		$list_args = array(  
			'taxonomy' => 'product_cat', 
			'hide_empty' => false 
		);

		// Menu Order
		$list_args['menu_order'] = false;
		$list_args['menu_order'] = 'asc';

		// Setup Current Category
		$current_cat   = false;
		$cat_ancestors = array();

		if ( is_tax( 'product_cat' ) ) {

			$current_cat   = $wp_query->queried_object;
			$cat_ancestors = get_ancestors( $current_cat->term_id, 'product_cat' );

		}

		$list_args['depth']            = 5;
		$list_args['child_of']         = 0;
		$list_args['title_li']         = '';
		$list_args['hierarchical']     = 1;
		$list_args['show_count']       = woodmart_get_opt( 'shop_products_count' );
		$list_args['walker'] = new WOODMART_Walker_Category();

		$class = ( woodmart_get_opt( 'shop_products_count' ) ) ? 'has-product-count' : 'hasno-product-count';

		$shop_link = get_post_type_archive_link( 'product' );

		include_once( WC()->plugin_path() . '/includes/walkers/class-product-cat-list-walker.php' );

		echo '<div class="woodmart-show-categories"><a href="#">' . esc_html__('Categories', 'woodmart') . '</a></div>';

		echo '<ul class="woodmart-product-categories ' . esc_attr( $class ). '">';
		
		echo '<li class="cat-link shop-all-link"><div class="category-nav-link"><a href="' . esc_url( $shop_link ) . '">
				<span class="category-summary">
					<span class="category-name">' . esc_html__('All', 'woodmart') . '</span>
					<span class="category-products-count">
						<span class="cat-count-label">' . esc_html__('products', 'woodmart') . '</span>
					</span>
				</span>
		</a></div></li>';


		if( $show_subcategories ) {
			woodmart_show_category_ancestors();
		} else {
			wp_list_categories( $list_args  );
		}

		echo '</ul>';
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Display ancestors of current category
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_show_category_ancestors' )) {
	function woodmart_show_category_ancestors() {
		global $wp_query, $post;

		$current_cat   = false;
		$list_args = array();

		if ( is_tax('product_cat') ) {
			$current_cat   = $wp_query->queried_object;
		}

		$list_args = array( 'taxonomy' => 'product_cat', 'hide_empty' => true );

		// Show Siblings and Children Only
		if ( $current_cat ) {

			// Direct children are wanted
			$include = get_terms(
				'product_cat',
				array(
					'fields'       => 'ids',
					'parent'       => $current_cat->term_id,
					'hierarchical' => true,
					'hide_empty'   => false
				)
			);

			$list_args['include']     = implode( ',', $include );

			if ( empty( $include ) ) {
				return;
			}

		} else {
			$list_args['depth']            = 1;
			$list_args['child_of']         = 0;
			$list_args['hierarchical']     = 1;
		}

		$list_args['title_li']                   = '';
		$list_args['pad_counts']                 = 1;
		$list_args['show_option_none']           = esc_html__('No product categories exist.', 'woodmart' );
		$list_args['current_category']           = ( $current_cat ) ? $current_cat->term_id : '';
		$list_args['show_count']       			 = woodmart_get_opt( 'shop_products_count' );
		$list_args['walker']					 = new WOODMART_Walker_Category();


		wp_list_categories( $list_args );

	}
}


if( ! class_exists( 'WOODMART_Walker_Category' ) ) {
	class WOODMART_Walker_Category extends Walker_Category {
		public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
			/** This filter is documented in wp-includes/category-template.php */
			$cat_name = apply_filters(
				'list_cats',
				esc_attr( $category->name ),
				$category
			);

			// Don't generate an element if the category name is empty.
			if ( ! $cat_name ) {
				return;
			}

			$link = '<div class="category-nav-link">';
			$link .= '<a href="' . esc_url( get_term_link( $category ) ) . '" ';

			$link .= '>';


			$icon_url = woodmart_tax_data( $category->taxonomy, $category->term_id, 'category_icon' );

			if( ! empty( $icon_url ) ) {
				$link .= '<img src="'  . esc_url( $icon_url ) . '" alt="' . esc_attr( $category->cat_name ) . '" class="category-icon" />';
			}
			
			$link .= '<span class="category-summary">';
			$link .= '<span class="category-name">' . $cat_name . '</span>';

			if ( ! empty( $args['show_count'] ) ) {
				$link .= '<span class="category-products-count"><span class="cat-count-number">' . number_format_i18n( $category->count ) . '</span> <span class="cat-count-label">' . esc_html__('products', 'woodmart') . '</span></span>';
			}

			$link .= '</span>';
			$link .= '</a>';
			
			$link .= '</div>';


			if ( 'list' == $args['style'] ) {
				$output .= "\t<li";
				$css_classes = array(
					'cat-item',
					'cat-item-' . $category->term_id,
				);

				if ( ! empty( $args['current_category'] ) ) {
					// 'current_category' can be an array, so we use `get_terms()`.
					$_current_terms = get_terms( $category->taxonomy, array(
						'include' => $args['current_category'],
						'hide_empty' => false,
					) );

					foreach ( $_current_terms as $_current_term ) {
						if ( $category->term_id == $_current_term->term_id ) {
							$css_classes[] = 'current-cat';
						} elseif ( $category->term_id == $_current_term->parent ) {
							$css_classes[] = 'current-cat-parent';
						}
						while ( $_current_term->parent ) {
							if ( $category->term_id == $_current_term->parent ) {
								$css_classes[] =  'current-cat-ancestor';
								break;
							}
							$_current_term = get_term( $_current_term->parent, $category->taxonomy );
						}
					}
				}

				/**
				 * Filter the list of CSS classes to include with each category in the list.
				 *
				 * @since 4.2.0
				 *
				 * @see wp_list_categories()
				 *
				 * @param array  $css_classes An array of CSS classes to be applied to each list item.
				 * @param object $category    Category data object.
				 * @param int    $depth       Depth of page, used for padding.
				 * @param array  $args        An array of wp_list_categories() arguments.
				 */
				$css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );

				$output .=  ' class="' . $css_classes . '"';
				$output .= ">$link\n";
			} elseif ( isset( $args['separator'] ) ) {
				$output .= "\t$link" . $args['separator'] . "\n";
			} else {
				$output .= "\t$link<br />\n";
			}
		}
	}
}

if ( ! class_exists( 'WOODMART_WC_Product_Cat_List_Walker' ) && function_exists('WC') ) :

include_once( WC()->plugin_path() . '/includes/walkers/class-product-cat-list-walker.php' );

class WOODMART_WC_Product_Cat_List_Walker extends WC_Product_Cat_List_Walker {

	/**
	 * Start the element output.
	 *
	 * @see Walker::start_el()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of category in reference to parents.
	 * @param integer $current_object_id
	 */
	public function start_el( &$output, $cat, $depth = 0, $args = array(), $current_object_id = 0 ) {
		$output .= '<li class="cat-item cat-item-' . $cat->term_id;

		if ( $args['current_category'] == $cat->term_id ) {
			$output .= ' current-cat';
		}

		if ( $args['has_children'] && $args['hierarchical'] ) {
			$output .= ' cat-parent';
		}

		if ( $args['current_category_ancestors'] && $args['current_category'] && in_array( $cat->term_id, $args['current_category_ancestors'] ) ) {
			$output .= ' current-cat-parent';
		}

		$output .=  '"><a href="' . get_term_link( (int) $cat->term_id, $this->tree_type ) . '">' . $cat->name . '</a>';

		if ( $args['show_count'] ) {
			$output .= ' <span class="count">' . $cat->count . '</span>';
		}
	}
}

endif;


/**
 * ------------------------------------------------------------------------------------------------
 * Remove () from numbers in categories widget
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_filter_product_categories_widget_args' ) ) {
	function woodmart_filter_product_categories_widget_args( $list_args ) {

		$list_args['walker'] = new WOODMART_WC_Product_Cat_List_Walker();

		return $list_args;
	}

	add_filter( 'woocommerce_product_categories_widget_args', 'woodmart_filter_product_categories_widget_args', 10, 1);
}

/**
 * ------------------------------------------------------------------------------------------------
 * Show product categories
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_product_categories' ) ) {
	function woodmart_product_categories() {
		global $post, $product;
		if( ! woodmart_get_opt( 'categories_under_title' ) ) return;
		?>
            <div class="woodmart-product-cats">
                <?php
                    echo wc_get_product_category_list( $product->get_id(), ', ' );
                ?>
            </div>
		<?php
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Function returns quick shop of the product by ID. Variations form HTML
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_quick_shop' ) ) {
	function woodmart_quick_shop($id = false) {
		if( isset($_GET['id']) ) {
			$id = (int) $_GET['id'];
		}
		if( ! $id || ! woodmart_woocommerce_installed() ) {
			return;
		}

		global $post;

		$args = array( 'post__in' => array($id), 'post_type' => 'product' );

		$quick_posts = get_posts( $args );

		$quick_view_variable = woodmart_get_opt( 'quick_view_variable' );

		foreach( $quick_posts as $post ) :
			setup_postdata($post);
        	woocommerce_template_single_add_to_cart();
		endforeach; 

		wp_reset_postdata(); 

		die();
	}

	add_action( 'wp_ajax_woodmart_quick_shop', 'woodmart_quick_shop' );
	add_action( 'wp_ajax_nopriv_woodmart_quick_shop', 'woodmart_quick_shop' );

}

/**
 * ------------------------------------------------------------------------------------------------
 * Function returns quick view of the product by ID
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_quick_view' ) ) {
	function woodmart_quick_view($id = false) {
		if( isset($_GET['id']) ) {
			$id = (int) $_GET['id'];
		}
		if( ! $id || ! woodmart_woocommerce_installed() ) {
			return;
		}

		global $post, $product;


		$args = array( 'post__in' => array($id), 'post_type' => 'product' );

		$quick_posts = get_posts( $args );

		$quick_view_variable = woodmart_get_opt( 'quick_view_variable' );

		foreach( $quick_posts as $post ) :
			setup_postdata($post);
			$product = wc_get_product($post);
        	remove_action( 'woocommerce_single_product_summary', 'woodmart_before_compare_button', 33 );
        	remove_action( 'woocommerce_single_product_summary', 'woodmart_after_compare_button', 37 );
        	remove_action( 'woocommerce_before_single_product', 'wc_print_notices', 10 );

        	// Add brand image
        	add_action( 'woocommerce_single_product_summary', 'woodmart_product_brand', 8 );

        	// Disable add to cart button for catalog mode
			if( woodmart_get_opt( 'catalog_mode' ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			} elseif( ! $quick_view_variable ) {
				// If no needs to show variations
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_loop_add_to_cart', 30 );
			}

			if( woodmart_get_opt( 'product_share' ) ) add_action( 'woocommerce_single_product_summary', 'woodmart_product_share_buttons', 45 );
			get_template_part('woocommerce/content', 'quick-view');
		endforeach; 

		wp_reset_postdata(); 

		die();
	}

	add_action( 'wp_ajax_woodmart_quick_view', 'woodmart_quick_view' );
	add_action( 'wp_ajax_nopriv_woodmart_quick_view', 'woodmart_quick_view' );

}

if( ! function_exists( 'woodmart_product_images_slider' ) ) {
	function woodmart_product_images_slider() {
		wc_get_template( 'quick-view/product-images.php' );
	}
}

if( ! function_exists( 'woodmart_view_product_button' ) ) {
	function woodmart_view_product_button() {
		echo '<a href="' . get_permalink() . '" class="view-details-btn">' . esc_html__('View details', 'woodmart') . '</a>';
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Function returns numbers of items in the cart. Filter woocommerce fragments
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_cart_data' ) ) {
	add_filter('woocommerce_add_to_cart_fragments', 'woodmart_cart_data', 30);
	function woodmart_cart_data( $array ) {
		ob_start();
		woodmart_cart_count();
		$count = ob_get_clean();
		
		ob_start();
		woodmart_cart_subtotal();
		$subtotal = ob_get_clean();
		
		$array['span.woodmart-cart-number'] = $count;
		$array['span.woodmart-cart-subtotal'] = $subtotal;
		
		return $array;
	}
}

if( ! function_exists( 'woodmart_cart_count' ) ) {
	function woodmart_cart_count() {
		$count = WC()->cart->cart_contents_count;
		?>
			<span class="woodmart-cart-number"><?php echo esc_html($count); ?> <span><?php echo esc_html( _n( 'item', 'items', $count, 'woodmart' ) ); ?></span></span>
		<?php
	}
}

if( ! function_exists( 'woodmart_cart_subtotal' ) ) {
	function woodmart_cart_subtotal() {
		?>
			<span class="woodmart-cart-subtotal"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
		<?php
	}
}



/**
 * ------------------------------------------------------------------------------------------------
 * AJAX add to cart for all product types
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_ajax_add_to_cart' ) ) {
	function woodmart_ajax_add_to_cart() {

		// Get messages
		ob_start();

		wc_print_notices();

		$notices = ob_get_clean();


		// Get mini cart
		ob_start();

		woocommerce_mini_cart();

		$mini_cart = ob_get_clean();

		// Fragments and mini cart are returned
		$data = array(
			'notices' => $notices,
			'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', array(
					'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
				)
			),
			'cart_hash' => apply_filters( 'woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() )
		);

		wp_send_json( $data );

		die();
	}
}

add_action( 'wp_ajax_woodmart_ajax_add_to_cart', 'woodmart_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_woodmart_ajax_add_to_cart', 'woodmart_ajax_add_to_cart' );


/**
 * ------------------------------------------------------------------------------------------------
 * If you are using YITH Products Addons plugin you will need to apply the following workaround to
 * be able to add to cart products with AJAX.
 * File: includes/class.yith-wapo-frontend.php, method: add_to_cart_validation, comment line: return false;
 * File: includes/class.yith-wapo.php, method: init, change line: if ( is_admin() && ! $this->is_quick_view() && ! defined( 'DOING_AJAX' ) && DOING_AJAX ) {
 * ------------------------------------------------------------------------------------------------
 */

/**
 * ------------------------------------------------------------------------------------------------
 * Set wishlist cookie
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_maybe_set_wishlist_cookies' ) ) {
	function woodmart_maybe_set_wishlist_cookies() {
		if( ! class_exists( 'YITH_WCWL' ) ) return;
		if ( ! headers_sent() && did_action( 'wp_loaded' ) ) {
			if ( YITH_WCWL()->count_products() > 0 ) {
				woodmart_set_wishlist_cookies( true );
			} elseif ( isset( $_COOKIE['woodmart_items_in_wishlist'] ) ) {
				woodmart_set_wishlist_cookies( false );
			}
		}
	}
	add_action( 'wp', 'woodmart_maybe_set_wishlist_cookies', 100 ); // Set cookies
	add_action( 'shutdown', 'woodmart_maybe_set_wishlist_cookies', 0 ); // Set cookies before shutdown and ob flushing
}


if( ! function_exists( 'woodmart_set_wishlist_cookies' ) ) {
	function woodmart_set_wishlist_cookies( $set = true ) {
		if( ! class_exists( 'YITH_WCWL' ) || ! function_exists( 'wc_setcookie' ) ) return;
		if ( $set ) {
			wc_setcookie( 'woodmart_items_in_wishlist', 1 );
			wc_setcookie( 'woodmart_wishlist_hash', YITH_WCWL()->count_products() );
		} elseif ( isset( $_COOKIE['woodmart_items_in_wishlist'] ) ) {
			wc_setcookie( 'woodmart_items_in_wishlist', 0, time() - HOUR_IN_SECONDS );
			wc_setcookie( 'woodmart_wishlist_hash', '', time() - HOUR_IN_SECONDS );
		}
		do_action( 'woodmart_set_wishlist_cookies', $set );
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Function returns numbers of items in the wishlist
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_wishlist_number' ) ) {
	function woodmart_wishlist_number() {
		if( ! class_exists( 'YITH_WCWL' ) ) die();
		echo YITH_WCWL()->count_products();
		die();
	}

	add_action( 'wp_ajax_woodmart_wishlist_number', 'woodmart_wishlist_number' );
	add_action( 'wp_ajax_nopriv_woodmart_wishlist_number', 'woodmart_wishlist_number' );

}


/**
 * ------------------------------------------------------------------------------------------------
 * Function that removes item from cart and returns fragments
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_remove_from_cart' ) ) {
	function woodmart_remove_from_cart() {
		if( ! class_exists( 'WC_AJAX' ) ) die(-1);

		if ( ! empty( $_GET['cart_item'] ) && isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'woocommerce-cart' ) ) {
			// Remove from cart
			$cart_item_key = sanitize_text_field( $_GET['cart_item'] );

			if ( $cart_item = WC()->cart->get_cart_item( $cart_item_key ) ) {
				WC()->cart->remove_cart_item( $cart_item_key );
			}
		}


		WC_AJAX::get_refreshed_fragments();
	}

	add_action( 'wp_ajax_woodmart_remove_from_cart', 'woodmart_remove_from_cart' );
	add_action( 'wp_ajax_nopriv_woodmart_remove_from_cart', 'woodmart_remove_from_cart' );
}
		
/**
 * ------------------------------------------------------------------------------------------------
 * Determine is it product attribute archieve page
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_is_product_attribute_archieve' ) ) {
	function woodmart_is_product_attribute_archieve() {
	    $queried_object = get_queried_object();
	    if( $queried_object && property_exists( $queried_object, 'taxonomy' ) ) {
	        $taxonomy = $queried_object->taxonomy;
	        return substr($taxonomy, 0, 3) == 'pa_';
	    }
	    return false;
	}
} 
		
/**
 * ------------------------------------------------------------------------------------------------
 * Function to prepare classes for grid element (column)
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_get_grid_el_class' ) ) {
	function woodmart_get_grid_el_class($loop = 0, $columns = 4, $different_sizes = false, $xs_size = false, $sm_size = 4, $md_size = 3) {
		$classes = '';

		$items_wide = woodmart_get_wide_items_array( $different_sizes );

		if( ! in_array( $columns, array(1,2,3,4,6,12) ) ) {
			$columns = 4;
		}

		if( ! $xs_size ) {
			$xs_size = apply_filters('woodmart_grid_xs_default', 6);
		}

		if( $columns <= 3 ) {
			if( ! $xs_size ) $xs_size = 12;
			if($columns == 1)
				$sm_size = 12;
			else
				$sm_size = 6;
		}		


		$col = ' col-xs-' . $xs_size . ' col-sm-' . $sm_size . ' col-md-';

		$md_size = 12/$columns;

		// every third element make 2 times larger (for isotope grid)
		if( $different_sizes && ( in_array( $loop, $items_wide ) ) ) { 
			$md_size *= 2;
		}

		$classes .= $col . $md_size;

		if($loop > 0) {
			if ( 0 == ( $loop - 1 ) % $columns || 1 == $columns )
				$classes .= ' first ';
			if ( 0 == $loop % $columns )
				$classes .= ' last ';
		}

		return $classes;
	}
}

if( ! function_exists( 'woodmart_get_wide_items_array' ) ) {
	function woodmart_get_wide_items_array( $different_sizes = false ){
		$items_wide = apply_filters( 'woodmart_wide_items', array( 3, 4, 5, 6, 11, 12) );

		if( is_array( $different_sizes ) ) {
			$items_wide = apply_filters( 'woodmart_wide_items', $different_sizes );
		}

		return $items_wide;
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Function to generate clear elements <div class="clear"></div>
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_get_grid_clear' )) {
	function woodmart_get_grid_clear($loop = 0, $columns = 4, $xs_columns = 1) {
		$output = '';

		if( ! in_array( $columns, array(1,2,3,4,6,12) ) ) {
			$columns = 4;
		}

		if( $columns < 4) {
			if( 0 == $loop % $xs_columns ) {
				$output .= '<div class="clearfix visible-xs-block"></div>';
			}

			if( 0 == $loop % 2 && $columns != 1) {
				$output .= '<div class="clearfix visible-sm-block"></div>';
			}
		} else {
			if( 0 == $loop % $xs_columns ) {
				$output .= '<div class="clearfix visible-xs-block"></div>';
			}

			if( 0 == $loop % 3 ) {
				$output .= '<div class="clearfix visible-sm-block"></div>';
			}
		}

		if( 0 == $loop % $columns ) {
			$output .= '<div class="clearfix visible-md-block visible-lg-block"></div>';
		}

		return $output;
	}
}

if( ! function_exists( 'woodmart_get_current_term_id' ) ) {
	/**
	 * FIX CMB2 bug
	 */
	function woodmart_get_current_term_id() {
		return isset( $_REQUEST['tag_ID'] ) ? $_REQUEST['tag_ID'] : 0;
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Woodmart Related product count
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_related_count' ) ) {
	add_filter( 'woocommerce_output_related_products_args', 'woodmart_related_count' );
	  function woodmart_related_count() {
		$args['posts_per_page'] = 8;
		if  ( woodmart_get_opt( 'related_product_count' ) ) $args['posts_per_page'] = woodmart_get_opt( 'related_product_count' );
		return $args;
	}
}

// **********************************************************************// 
// Woodmart is product thumb enabled
// **********************************************************************// 
if( ! function_exists( 'woodmart_is_product_thumb_enabled' ) ) {
	function woodmart_is_product_thumb_enabled() {
		$thums_position = woodmart_get_opt('thums_position');
		$product_design = woodmart_get_opt('product_design');
		return ( $product_design != 'sticky' && ( $thums_position == 'bottom' || $thums_position == 'left' ) );
	}
}

// **********************************************************************// 
// Woodmart is main product images carousel
// **********************************************************************// 
if( ! function_exists( 'woodmart_is_main_product_images_carousel' ) ) {
	function woodmart_is_main_product_images_carousel() {
		return ( woodmart_get_opt('thums_position') == 'without' ) ? true : woodmart_is_product_thumb_enabled();
	}
}