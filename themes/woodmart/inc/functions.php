<?php if ( ! defined('WOODMART_THEME_DIR')) exit('No direct script access allowed');

// **********************************************************************// 
// ! Body classes
// **********************************************************************// 

if( ! function_exists( 'woodmart_body_class' ) ) {
	function woodmart_body_class( $classes ) {

		$page_id = woodmart_page_ID();

		$site_width = woodmart_get_opt( 'site_width' );
		$cart_design = woodmart_get_opt( 'shopping_cart' );
		$wishlist = woodmart_get_opt( 'header_wishlist' );
		$header = woodmart_get_opt( 'header' );
		$header_overlap_opt = woodmart_get_opt( 'header-overlap' );
		$product_design = woodmart_product_design();
		$product_sticky = woodmart_product_sticky();
		$top_bar = woodmart_get_opt( 'top-bar' );
		$ajax_shop = woodmart_get_opt( 'ajax_shop' );
		$header_search = woodmart_get_opt( 'header_search' );
		$ajax_search = woodmart_get_opt( 'search_ajax' );
		$mobile_menu_position = woodmart_get_opt( 'mobile_menu_position' );
		$hide_sidebar_mobile = woodmart_get_opt( 'shop_hide_sidebar' );
		$hide_sidebar_tablet = woodmart_get_opt( 'shop_hide_sidebar_tablet' );
		$hide_sidebar_desktop = woodmart_get_opt( 'shop_hide_sidebar_desktop' );
		$catalog_mode = woodmart_get_opt( 'catalog_mode' );
		$categories_toggle = woodmart_get_opt( 'categories_toggle' );
		$logo_responsive = woodmart_get_opt( 'logo_responsive_sizes' );
		$sticky_footer = woodmart_get_opt( 'sticky_footer' );
		$dark = woodmart_get_opt( 'dark_version' );
		$form_fields_style = ( woodmart_get_opt( 'form_fields_style' ) ) ? woodmart_get_opt( 'form_fields_style' ) : 'square';
		$form_border_width = woodmart_get_opt( 'form_border_width' );
		$menu_style = ( woodmart_get_opt( 'menu_style' ) ) ? woodmart_get_opt( 'menu_style' ) : 'default';
		$header_dropdowns = ( woodmart_get_opt( 'header_dropdowns_dark' ) ) ? 'light' : 'dark';

		$header_overlap = $header_sticky = $disable_sticky = false;

		$disable = get_post_meta( $page_id, '_woodmart_title_off', true );

		$classes[] = 'wrapper-' . $site_width;
		$classes[] = 'global-cart-design-' . $cart_design;
		$classes[] = 'global-search-' . $header_search;
		$classes[] = 'mobile-nav-from-' . $mobile_menu_position;
		// Form style settings
		$classes[] = 'form-style-' . $form_fields_style;
		$classes[] = 'form-border-width-' . $form_border_width;
		// Header menu style settings
		$classes[] = 'menu-style-' . $menu_style;
		$classes[] = 'dropdowns-color-' . $header_dropdowns;

		if( is_singular( 'product') ) {
			$classes[] = 'woodmart-product-design-' . $product_design;
			if( $product_sticky ) {
				$classes[] = 'woodmart-product-sticky-on';
			}
		}
		
		$classes[] = ( $sticky_footer ) ? 'sticky-footer-on' : 'no-sticky-footer';
		$classes[] = ( $dark ) ? 'woodmart-dark' : 'woodmart-light';

		if( $catalog_mode ) {
			$classes[] = 'catalog-mode-on';
		} else {
			$classes[] = 'catalog-mode-off';
		}

		if( $categories_toggle ) {
			$classes[] = 'categories-accordion-on';
		} else {
			$classes[] = 'categories-accordion-off';
		}

		if( $wishlist != 'disable' ) {
			$classes[] = 'global-wishlist-enable';
		} else {
			$classes[] = 'global-wishlist-disable';
		}
		
		if( woodmart_is_blog_archive() ) {
			$classes[] = 'woodmart-archive-blog';
		} else if( woodmart_is_shop_archive() ) {
			$classes[] = 'woodmart-archive-shop';
		} else if( woodmart_is_portfolio_archive() ) {
			$classes[] = 'woodmart-archive-portfolio';
		}

		if( $top_bar && !get_post_meta( $page_id, '_woodmart_top_bar_off', true ) ) {
			$classes[] = 'woodmart-top-bar-on';
		}else {
			$classes[] = 'woodmart-top-bar-off';
		}

		if( woodmart_get_opt( 'top_bar_right_text' ) != '' ) {
			$classes[] = 'woodmart-top-bar-mobile-on';
		} else {
			$classes[] = 'woodmart-top-bar-mobile-off';
		}

		if( $ajax_shop ) {
			$classes[] = 'woodmart-ajax-shop-on';
		} else {
			$classes[] = 'woodmart-ajax-shop-off';
		}

		if( $ajax_search ) {
			$classes[] = 'woodmart-ajax-search-on';
		} else {
			$classes[] = 'woodmart-ajax-search-off';
		}

		$classes[] = ( $logo_responsive ) ? 'logo-responsive-on' : 'logo-responsive-off';

		if( $hide_sidebar_mobile ) {
			$classes[] = 'offcanvas-sidebar-mobile';
		}

		if( $hide_sidebar_tablet ) {
			$classes[] = 'offcanvas-sidebar-tablet';
		}

		if( $hide_sidebar_desktop ) {
			$classes[] = 'offcanvas-sidebar-desktop';
		}

		// Sticky header settings
		if( woodmart_get_opt('sticky_header') ) {
			$classes[] = 'enable-sticky-header';
			$header_sticky = true;
		} else {
			$disable_sticky = true;
			$classes[] = 'disable-sticky-header';
		}

		// Force header full width class
		if( is_singular( 'product') && woodmart_get_opt('single_full_width') ) {
			$classes[] = 'header-full-width';
		}

		if( woodmart_get_opt('header_full_width') ) {
			$classes[] = 'header-full-width';
		}

		if( in_array( $header, array('menu-top') ) ) {
			$header_sticky = false;
			$classes[] = 'sticky-navigation-only';
		} else if( in_array( $header, array('base', 'simple', 'logo-center', 'categories') ) ) {
			$header_sticky = 'clone';
		}

		$classes[] = 'woodmart-header-' . $header;

		// If header type is SHOP and overlap option is enabled
		if( $header == 'shop' || $header == 'split' ) {
			$header_sticky = 'real';
			if( $header_overlap_opt ) {
				$header_overlap = true;
			}
		}

		if( $header == 'simple' && $header_overlap_opt ) {
			$header_overlap = true;
			$header_sticky = 'real';
		}

		if( $header_overlap ) {
			$classes[] = 'woodmart-header-overlap';
		}

		if( $header_sticky == 'clone' && ! $disable_sticky ) {
			$classes[] = 'sticky-header-clone';
		} elseif( $header_sticky == 'real' && ! $disable_sticky ) {
			$classes[] = 'sticky-header-real';
		}

		$classes = array_merge( $classes, woodmart_get_buttons_config_classes() );

		return $classes;
	}

	add_filter('body_class', 'woodmart_body_class');
}
/**
 * ------------------------------------------------------------------------------------------------
 * Buttons configuration classes
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_get_buttons_config_classes' ) ) {
	function woodmart_get_buttons_config_classes() {
		$classes = array();

		$classes[] = 'btns-default-' . woodmart_get_opt( 'btns_default_style' );
		$classes[] = 'btns-default-' . woodmart_get_opt( 'btns_default_color_scheme' );
		$classes[] = 'btns-default-hover-' . woodmart_get_opt( 'btns_default_color_scheme_hover' );

		$classes[] = 'btns-shop-' . woodmart_get_opt( 'btns_shop_style' );
		$classes[] = 'btns-shop-' . woodmart_get_opt( 'btns_shop_color_scheme' );
		$classes[] = 'btns-shop-hover-' . woodmart_get_opt( 'btns_shop_color_scheme_hover' );

		$classes[] = 'btns-accent-' . woodmart_get_opt( 'btns_accent_style' );
		$classes[] = 'btns-accent-' . woodmart_get_opt( 'btns_accent_color_scheme' );
		$classes[] = 'btns-accent-hover-' . woodmart_get_opt( 'btns_accent_color_scheme_hover' );

		return $classes;
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Filter wp_title
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_wp_title' ) ) {
	function woodmart_wp_title( $title, $sep ) {
		global $paged, $page;

		if ( is_feed() )
			return $title;

		// Add the site name.
		$title .= get_bloginfo( 'name' );

		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			$title = "$title $sep $site_description";

		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( esc_html__( 'Page %s', 'woodmart' ), max( $paged, $page ) );

		return $title;
	}
	add_filter( 'wp_title', 'woodmart_wp_title', 10, 2 );

}

/**
 * ------------------------------------------------------------------------------------------------
 * Get predefined footer configuration by index
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_get_footer_config' ) ) {
	function woodmart_get_footer_config( $index ) {

		if( $index > 20 || $index < 1) {
			$index = 1;
		}

		$configs = apply_filters( 'woodmart_footer_configs_array', array(
			1 => array(
				'cols' => array(
					'col-sm-12'
				),
				
			),
			2 => array(
				'cols' => array(
					'col-sm-6',
					'col-sm-6',
				),
			),
			3 => array(
				'cols' => array(
					'col-sm-4',
					'col-sm-4',
					'col-sm-4',
				),
			),
			4 => array(
				'cols' => array(
					'col-md-3 col-sm-6',
					'col-md-3 col-sm-6',
					'col-md-3 col-sm-6',
					'col-md-3 col-sm-6',
				),
				'clears' => array(
					2 => 'sm'
				)
			),
			5 => array(
				'cols' => array(
					'col-md-2 col-sm-4',
					'col-md-2 col-sm-4',
					'col-md-2 col-sm-4',
					'col-md-2 col-sm-4',
					'col-md-2 col-sm-4',
					'col-md-2 col-sm-4',
				),
				'clears' => array(
					3 => 'sm'
				)
			),
			6 => array(
				'cols' => array(
					'col-md-3 col-sm-4',
					'col-md-6 col-sm-4',
					'col-md-3 col-sm-4',
				),
			),
			7 => array(
				'cols' => array(
					'col-md-6 col-sm-4',
					'col-md-3 col-sm-4',
					'col-md-3 col-sm-4',
				),
			),
			8 => array(
				'cols' => array(
					'col-md-3 col-sm-4',
					'col-md-3 col-sm-4',
					'col-md-6 col-sm-4',
				),
			),
			9 => array(
				'cols' => array(
					'col-md-12 col-sm-12',
					'col-md-3 col-sm-6',
					'col-md-3 col-sm-6',
					'col-md-3 col-sm-6',
					'col-md-3 col-sm-6',
				),
				'clears' => array(
					1 => 'md',
					1 => 'lg',
					3 => 'sm',
				),
			),
			10 => array(
				'cols' => array(
					'col-md-6 col-sm-12',
					'col-md-6 col-sm-12',
					'col-md-3 col-sm-6',
					'col-md-3 col-sm-6',
					'col-md-3 col-sm-6',
					'col-md-3 col-sm-6',
				),
				'clears' => array(
					2 => 'md',
					2 => 'lg',
					4 => 'sm',
				),
			),
			11 => array(
				'cols' => array(
					'col-md-6 col-sm-12',
					'col-md-6 col-sm-12',
					'col-md-2 col-sm-6',
					'col-md-2 col-sm-6',
					'col-md-2 col-sm-6',
					'col-md-2 col-sm-6',
					'col-md-4 col-sm-12',
				),
				'clears' => array(
					2 => 'md',
					2 => 'lg',
					4 => 'sm',
				),
			),
			12 => array(
				'cols' => array(
					'col-md-12 col-sm-12',
					'col-md-2 col-sm-6',
					'col-md-2 col-sm-6',
					'col-md-2 col-sm-6',
					'col-md-2 col-sm-6',
					'col-md-4 col-sm-12',
				),
				'clears' => array(
					1 => 'md',
					1 => 'lg',
					3 => 'sm',
				),
			),
			13 => array(
				'cols' => array(
					'col-md-3 col-sm-6',
					'col-md-3 col-sm-6',
					'col-md-2 col-sm-4',
					'col-md-2 col-sm-4',
					'col-md-2 col-sm-4',
				),
				'clears' => array(
					2 => 'md',
					2 => 'sm',
				),
			),
		) );

		return (isset( $configs[$index] )) ? $configs[$index] : array();
	}
}


// **********************************************************************// 
// ! Theme 3d plugins
// **********************************************************************// 


if(!defined('YITH_REFER_ID')) {
	define('YITH_REFER_ID', '1040314');
}


if( ! function_exists( 'woodmart_3d_plugins' )) {
	function woodmart_3d_plugins() {
		if( function_exists( 'set_revslider_as_theme' ) ){
			set_revslider_as_theme();
		}
	} 

	add_action( 'init', 'woodmart_3d_plugins' );
}

if( ! function_exists( 'woodmart_vcSetAsTheme' ) ) {

	function woodmart_vcSetAsTheme() {
		if( function_exists( 'vc_set_as_theme' ) ){
			vc_set_as_theme();
		}
	} 

	add_action( 'vc_before_init', 'woodmart_vcSetAsTheme' );
}


// **********************************************************************// 
// ! Function to get taxonomy meta data
// **********************************************************************// 

if( ! function_exists( 'woodmart_tax_data' ) ) {
	function woodmart_tax_data($taxonomy, $term_id, $meta_key) {
		
		return get_term_meta( $term_id, $meta_key, true);

	}
}

// **********************************************************************// 
// ! Obtain real page ID (shop page, blog, portfolio or simple page)
// **********************************************************************// 

/**
 * This function is called once when initializing WOODMART_Layout object
 * then you can use function woodmart_page_ID to get current page id
 */
if( ! function_exists( 'woodmart_get_the_ID' ) ) {
	function woodmart_get_the_ID( $settings = array() ) {
		global $post;

		$page_id = 0;

		$page_for_posts    = get_option( 'page_for_posts' );
		$page_for_shop     = get_option( 'woocommerce_shop_page_id' );
		$page_for_projects = woodmart_tpl2id( 'portfolio.php' );
		
		if(isset($post->ID)) $page_id = $post->ID;

		if( isset($post->ID) && ( is_singular( 'page' ) || is_singular( 'post' ) ) ) { 
			$page_id = $post->ID;
		} else if( is_home() || is_singular( 'post' ) || is_search() || is_tag() || is_category() || is_date() || is_author() ) {
			$page_id = $page_for_posts;
		} else if( is_archive('portfolio') && get_post_type() == 'portfolio' ) {
			$page_id = $page_for_projects;
		}

		if( woodmart_woocommerce_installed() && function_exists( 'is_shop' )  ) {
			if( isset( $settings['singulars'] ) && in_array( 'product', $settings['singulars']) && is_singular( "product" ) ) {
				// keep post id
			} else if( is_shop() || is_product_category() || is_product_tag() || is_singular( "product" ) || woodmart_is_product_attribute_archieve() )
				$page_id = $page_for_shop;
		}

		return $page_id;
	}
}


// **********************************************************************// 
// ! Function to get HTML block content
// **********************************************************************// 

if( ! function_exists( 'woodmart_get_html_block' ) ) {
	function woodmart_get_html_block($id) {
		$content = get_post_field('post_content', $id);

		$content = do_shortcode($content);

		$shortcodes_custom_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
		if ( ! empty( $shortcodes_custom_css ) ) {
			$content .= '<style type="text/css" data-type="vc_shortcodes-custom-css">';
			$content .= $shortcodes_custom_css;
			$content .= '</style>';
		}

		return $content;
	}

}

if( ! function_exists( 'woodmart_get_static_blocks_array' ) ) {
	function woodmart_get_static_blocks_array() {
		$args = array( 'posts_per_page' => 50, 'post_type' => 'cms_block' );
		$blocks_posts = get_posts( $args );
		$array = array();
		foreach ( $blocks_posts as $post ) : 
			setup_postdata( $post ); 
			$array[$post->post_title] = $post->ID; 
		endforeach;
		wp_reset_postdata();
		return $array;
	}
}

// **********************************************************************// 
// ! Set excerpt length and more btn
// **********************************************************************// 

add_filter( 'excerpt_length', 'woodmart_excerpt_length', 999 );

if( ! function_exists( 'woodmart_excerpt_length' ) ) {
	function woodmart_excerpt_length( $length ) {
		return 20;
	}
}

add_filter('excerpt_more', 'woodmart_new_excerpt_more');

if( ! function_exists( 'woodmart_new_excerpt_more' ) ) {
	function woodmart_new_excerpt_more( $more ) {
		return '';
	}
}

// **********************************************************************// 
// ! Add scroll to top buttom 
// **********************************************************************// 

add_action( 'wp_footer', 'woodmart_scroll_top_btn' );

if( ! function_exists( 'woodmart_scroll_top_btn' ) ) {
	function woodmart_scroll_top_btn( $more ) {
		?>
			<a href="#" class="scrollToTop"><?php esc_attr_e( 'Scroll To Top', 'woodmart' ); ?></a>
		<?php
	}
}


// **********************************************************************// 
// ! Return related posts args array
// **********************************************************************// 

if( ! function_exists( 'woodmart_get_related_posts_args' ) ) {
	function woodmart_get_related_posts_args( $post_id ) {
		$taxs = wp_get_post_tags( $post_id );
		$args = array();
		if ( $taxs ) {
			$tax_ids = array();
			foreach( $taxs as $individual_tax ) $tax_ids[] = $individual_tax->term_id;
			 
			$args = array(
				'tag__in'               => $tax_ids,
				'post__not_in'          => array( $post_id ),
				'showposts'             => 12,
				'ignore_sticky_posts'   => 1
			);  
			
		}

		return $args;
	}
}

// **********************************************************************// 
// ! Navigation walker
// **********************************************************************// 

if( ! class_exists( 'WOODMART_Mega_Menu_Walker' )) {
	class WOODMART_Mega_Menu_Walker extends Walker_Nav_Menu {

		private $color_scheme = 'dark';

		public function __construct() {
			$this->color_scheme = ( woodmart_get_opt( 'header_dropdowns_dark' ) ) ? 'light' : 'dark' ;
		}

		/**
		 * Starts the list before the elements are added.
		 *
		 * @see Walker::start_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);

			if( $depth == 0) {
				$output .= "\n$indent<div class=\"sub-menu-dropdown color-scheme-" . $this->color_scheme . "\">\n";
				$output .= "\n$indent<div class=\"container\">\n";

			}
			if( $depth < 1 ) {
				$sub_menu_class = "sub-menu";
			} else {
				$sub_menu_class = "sub-sub-menu";
			}
			
			$output .= "\n$indent<ul class=\"$sub_menu_class color-scheme-" . $this->color_scheme . "\">\n";

			if( $this->color_scheme == 'light' || $this->color_scheme == 'dark' ) $this->color_scheme = ( woodmart_get_opt( 'header_dropdowns_dark' ) ) ? 'light' : 'dark' ;
		}

		/**
		 * Ends the list of after the elements are added.
		 *
		 * @see Walker::end_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "$indent</ul>\n";
			if( $depth == 0) {
				$output .= "$indent</div>\n";
				$output .= "$indent</div>\n";
			}
		}

		/**
		 * Start the element output.
		 *
		 * @see Walker::start_el()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item   Menu item data object.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 * @param int    $id     Current item ID.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;
			$classes[] = 'item-level-' . $depth;

			$design = $width = $height = $icon = $label = $label_out = '';
			$design  = get_post_meta( $item->ID, '_menu_item_design',  true );
			$width   = get_post_meta( $item->ID, '_menu_item_width',   true );
			$height  = get_post_meta( $item->ID, '_menu_item_height',  true );
			$icon    = get_post_meta( $item->ID, '_menu_item_icon',    true );
			$event   = get_post_meta( $item->ID, '_menu_item_event',   true );
			$label   = get_post_meta( $item->ID, '_menu_item_label',   true );
			$label_text = get_post_meta( $item->ID, '_menu_item_label-text',   true );
			$block   = get_post_meta( $item->ID, '_menu_item_block',   true );
			$opanchor = get_post_meta( $item->ID, '_menu_item_opanchor', true );
			$callbtn  = get_post_meta( $item->ID, '_menu_item_callbtn', true );
			$color_scheme = get_post_meta( $item->ID, '_menu_item_colorscheme', true );
			
			if ( $color_scheme == 'light' ) {
				$this->color_scheme = 'light';
			}elseif( $color_scheme == 'dark' ){
				$this->color_scheme = 'dark';
			}

			if( empty($design) ) $design = 'default';

			if( $depth == 0 && $args->menu_class != 'site-mobile-menu' ) {
				$classes[] = 'menu-item-design-' . $design;
				$classes[] = 'menu-' . ( (  in_array( $design, array( 'sized', 'full-width' ) ) ) ? 'mega-dropdown' : 'simple-dropdown' );
				$event = (empty($event)) ? 'hover' : $event;
				$classes[] = 'item-event-' . $event;
			}


			if( $opanchor == 'enable' ) {
				 $classes[] = 'onepage-link';
				if(($key = array_search('current-menu-item', $classes)) !== false) {
					unset($classes[$key]);
				}
			}

			if( $callbtn == 'enable' ) {
				$classes[] = 'callto-btn';
			}

			if( !empty( $label ) ) {
				$classes[] = 'item-with-label';
				$classes[] = 'item-label-' . $label;
				$label_out = '<span class="menu-label menu-label-' . $label . '">' . esc_attr( $label_text ) . '</span>';
			}


			/**
			 * Filter the CSS class(es) applied to a menu item's list item element.
			 *
			 * @since 3.0.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
			 * @param object $item    The current menu item.
			 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth   Depth of menu item. Used for padding.
			 */
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			/**
			 * Filter the ID applied to a menu item's list item element.
			 *
			 * @since 3.0.1
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
			 * @param object $item    The current menu item.
			 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth   Depth of menu item. Used for padding.
			 */
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $class_names .'>';

			$atts = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
			$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
			$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

			/**
			 * Filter the HTML attributes applied to a menu item's anchor element.
			 *
			 * @since 3.6.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array $atts {
			 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
			 *
			 *     @type string $title  Title attribute.
			 *     @type string $target Target attribute.
			 *     @type string $rel    The rel attribute.
			 *     @type string $href   The href attribute.
			 * }
			 * @param object $item  The current menu item.
			 * @param array  $args  An array of {@see wp_nav_menu()} arguments.
			 * @param int    $depth Depth of menu item. Used for padding.
			 */
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
			$atts['class'] = 'woodmart-nav-link';

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$icon_url = '';

			if( $item->object == 'product_cat' ) {
				$icon_url = woodmart_tax_data( $item->object, $item->object_id, 'category_icon_alt' );
			}

			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			if($icon != '') {
				$item_output .= '<i class="fa fa-' . $icon . '"></i>';
			}
			if( ! empty( $icon_url ) ) {
				$item_output .= '<img src="'  . esc_url( $icon_url ) . '" alt="' . esc_attr( $item->title ) . '" class="category-icon" />';
			}
			/** This filter is documented in wp-includes/post-template.php */
			$item_output .= '<span>' . $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after . '</span>';
			$item_output .= $label_out;
			$item_output .= '</a>';
			$item_output .= $args->after;

			$styles = '';

			if( $depth == 0 && $args->menu_class != 'site-mobile-menu' ) {
				/**
				 * Add background image to dropdown
				 **/


				if( has_post_thumbnail( $item->ID ) ) {
					$post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'full' );

					//ar($post_thumbnail);

					$styles .= '.menu-item-' . $item->ID . ' > .sub-menu-dropdown {';
						$styles .= 'background-image: url(' . $post_thumbnail[0] .'); ';
					$styles .= '}';
				}

				if( ! empty( $block ) && !in_array("menu-item-has-children", $item->classes) ) {
					$item_output .= "\n$indent<div class=\"sub-menu-dropdown color-scheme-" . $this->color_scheme . "\">\n";
					$item_output .= "\n$indent<div class=\"container\">\n";
						$item_output .= woodmart_html_block_shortcode( array( 'id' => $block ) );
					$item_output .= "\n$indent</div>\n";
					$item_output .= "\n$indent</div>\n";
					
					if( $this->color_scheme == 'light' || $this->color_scheme == 'dark' ) $this->color_scheme = ( woodmart_get_opt( 'header_dropdowns_dark' ) ) ? 'light' : 'dark' ;
				}
			}

			if($design == 'sized' && !empty($height) && !empty($width) && $args->menu_class != 'site-mobile-menu' ) {
				$styles .= '.menu-item-' . $item->ID . ' > .sub-menu-dropdown {';
					$styles .= 'min-height: ' . $height .'px; ';
					$styles .= 'width: ' . $width .'px; ';
				$styles .= '}';
			}

			if( $styles != '' && $args->menu_class != 'site-mobile-menu' ) {
				$item_output .= '<style type="text/css">';
				$item_output .= $styles;
				$item_output .= '</style>';
			}

			/**
			 * Filter a menu item's starting output.
			 *
			 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
			 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
			 * no filter for modifying the opening and closing `<li>` for a menu item.
			 *
			 * @since 3.0.0
			 *
			 * @param string $item_output The menu item's starting HTML output.
			 * @param object $item        Menu item data object.
			 * @param int    $depth       Depth of menu item. Used for padding.
			 * @param array  $args        An array of {@see wp_nav_menu()} arguments.
			 */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
}



// **********************************************************************// 
// ! // Deletes first gallery shortcode and returns content (http://stackoverflow.com/questions/17224100/wordpress-remove-shortcode-and-save-for-use-elsewhere)
// **********************************************************************// 

if( ! function_exists( 'woodmart_strip_shortcode_gallery' ) ) {
	function  woodmart_strip_shortcode_gallery( $content ) {
		preg_match_all( '/'. get_shortcode_regex() .'/s', $content, $matches, PREG_SET_ORDER );
		if ( ! empty( $matches ) ) {
			foreach ( $matches as $shortcode ) {
				if ( 'gallery' === $shortcode[2] ) {
					$pos = strpos( $content, $shortcode[0] );
					if ($pos !== false)
						return substr_replace( $content, '', $pos, strlen($shortcode[0]) );
				}
			}
		}
		return $content;
	}
}


// **********************************************************************// 
// ! Get exceprt from post content
// **********************************************************************// 

if( ! function_exists( 'woodmart_excerpt_from_content' ) ) {
	function woodmart_excerpt_from_content($post_content, $limit, $shortcodes = '') {
		// Strip shortcodes and HTML tags
		if ( empty( $shortcodes )) {
			$post_content = preg_replace("/\[caption(.*)\[\/caption\]/i", '', $post_content);
			$post_content = preg_replace('`\[[^\]]*\]`','',$post_content);
		}

		$post_content = stripslashes( wp_filter_nohtml_kses( $post_content ) );

		if ( woodmart_get_opt( 'blog_words_or_letters' ) == 'letter' ) {
			$excerpt = mb_substr( $post_content, 0, $limit );
			if ( mb_strlen( $excerpt ) >= $limit ) {
				$excerpt .= '...';
			}
		}else{
			$limit++;
			$excerpt = explode(' ', $post_content, $limit);
			if ( count( $excerpt) >= $limit ) {
				array_pop( $excerpt );
				$excerpt = implode( " ", $excerpt ) . '...';
			} else {
				$excerpt = implode( " ", $excerpt );
			}
		}

		$excerpt = strip_tags( $excerpt );

		if ( trim( $excerpt ) == '...' ) {
			return '';
		}

		return $excerpt;
	}
}

// **********************************************************************// 
// ! Get portfolio taxonomies dropdown
// **********************************************************************// 

if( ! function_exists( 'woodmart_get_projects_cats_array') ) {
	function woodmart_get_projects_cats_array() {
		$return = array('All' => '');

		if( ! post_type_exists( 'portfolio' ) ) return array();

		$cats = get_terms( 'project-cat' );

		foreach ($cats as $key => $cat) {
			$return[$cat->name] = $cat->term_id;
		}

		return $return;
	}
}

// **********************************************************************// 
// ! Get menus dropdown
// **********************************************************************// 

if( ! function_exists( 'woodmart_get_menus_array') ) {
	function woodmart_get_menus_array() {
		$woodmart_menus = wp_get_nav_menus();
		$woodmart_menu_dropdown = array();
		
		foreach ( $woodmart_menus as $menu ) {

			$woodmart_menu_dropdown[$menu->term_id] = $menu->name;
			
		}

		return $woodmart_menu_dropdown;
	}
}


// **********************************************************************// 
// ! Get registered sidebars dropdown
// **********************************************************************// 

if(!function_exists('woodmart_get_sidebars_array')) {
	function woodmart_get_sidebars_array() {
		global $wp_registered_sidebars;
		$sidebars['none'] = 'none';
		foreach( $wp_registered_sidebars as $id=>$sidebar ) {
			$sidebars[ $id ] = $sidebar[ 'name' ];
		}
		return $sidebars;
	}
}


// **********************************************************************// 
// ! If page needs header
// **********************************************************************// 

if( ! function_exists( 'woodmart_needs_header' ) ) {
	function woodmart_needs_header() {
		return ( ! woodmart_maintenance_page() );
	}
}

// **********************************************************************// 
// ! If page needs footer
// **********************************************************************// 

if( ! function_exists( 'woodmart_needs_footer' ) ) {
	function woodmart_needs_footer() {
		return ( ! woodmart_maintenance_page() );
	}
}


// **********************************************************************// 
// ! Conditional tags
// **********************************************************************// 

if( ! function_exists( 'woodmart_is_shop_archive' ) ) {
	function woodmart_is_shop_archive() {
		return ( woodmart_woocommerce_installed() && ( is_shop() || is_product_category() || is_product_tag() || is_singular( "product" ) || woodmart_is_product_attribute_archieve() ) );
	}
}

if( ! function_exists( 'woodmart_is_blog_archive' ) ) {
	function woodmart_is_blog_archive() {
		return ( is_home() || is_search() || is_tag() || is_category() || is_date() || is_author() );
	}
}

if( ! function_exists( 'woodmart_is_portfolio_archive' ) ) {
	function woodmart_is_portfolio_archive() {
		return ( is_post_type_archive( 'portfolio' ) || is_tax( 'project-cat' ) );
	}
}


// **********************************************************************// 
// ! Is maintenance page
// **********************************************************************// 

if( ! function_exists( 'woodmart_maintenance_page' ) ) {
	function woodmart_maintenance_page() {
		
		$pages_ids = woodmart_pages_ids_from_template( 'maintenance' );

		if( ! empty( $pages_ids ) && is_page( $pages_ids ) ) {
			return true;
		}

		return false;
	}
}


// **********************************************************************// 
// ! Get page id by template name
// **********************************************************************// 

if( ! function_exists( 'woodmart_pages_ids_from_template' ) ) {
	function woodmart_pages_ids_from_template( $name ) {
		$pages = get_pages(array(
			'meta_key' => '_wp_page_template',
			'meta_value' => $name . '.php'
		));

		$return = array();

		foreach($pages as $page){
			$return[] = $page->ID;
		}

		return $return;
	}
}




// **********************************************************************// 
// ! Get config file
// **********************************************************************// 

if( ! function_exists( 'woodmart_get_config' ) ) {
	function woodmart_get_config( $name ) {
		$path = WOODMART_CONFIGS . '/' . $name . '.php';
		if( file_exists( $path ) ) {
			return include $path;
		} else {
			return array();
		}
	}
}


// **********************************************************************// 
// ! Text to one-line string
// **********************************************************************// 

if( ! function_exists( 'woodmart_text2line')) {
	function woodmart_text2line( $str ) {
		return trim(preg_replace("/('|\"|\r?\n)/", '', $str)); 
	}
}


// **********************************************************************// 
// ! Get page ID by it's template name
// **********************************************************************// 
if( ! function_exists( 'woodmart_tpl2id' ) ) {
	function woodmart_tpl2id( $tpl = '' ) {
		$pages = get_pages(array(
			'meta_key' => '_wp_page_template',
			'meta_value' => $tpl
		));
		foreach($pages as $page){
			return $page->ID;
		}
	}
}

// **********************************************************************// 
// ! Get content of the SVG icon located in images/svg folder
// **********************************************************************// 
if( ! function_exists( 'woodmart_get_svg_content' ) ) {
	function woodmart_get_svg_content($name) {
		$folder = WOODMART_THEMEROOT . '/images/svg';
		$file = $folder . '/' . $name . '.svg';

		return (file_exists( $file )) ? woodmart_get_any_svg( $file ) : false;
	}
}

if( ! function_exists( 'woodmart_get_any_svg' ) ) {
	function woodmart_get_any_svg( $file, $id = false ) {
		$content = woodmart_get_svg( $file );
		$start_tag = '<svg';
		if( $id ) {
			$pattern = "/id=\"(\w)+\"/";
			if( preg_match($pattern, $content) ) {
				$content = preg_replace($pattern, "id=\"" . $id . "\"", $content);
			} else {
				$content = preg_replace( "/<svg/", "<svg id=\"" . $id . "\"", $content);
			}
		}
		// Strip doctype
		$position = strpos($content, $start_tag);
		$content = substr($content, $position);
		return $content;
	}
}

// **********************************************************************// 
// ! Function print array within a pre tags
// **********************************************************************// 
if( ! function_exists( 'ar' ) ) {
	function ar($array) {

		echo '<pre>';
			print_r($array);
		echo '</pre>';

	}
}


// **********************************************************************// 
// ! Get protocol (http or https)
// **********************************************************************// 
if( ! function_exists( 'woodmart_http' )) {
	function woodmart_http() {
		if( ! is_ssl() ) {
			return 'http';
		} else {
			return 'https';
		}
	}
}

// **********************************************************************// 
// ! It could be useful if you using nginx instead of apache 
// **********************************************************************// 

if (!function_exists('getallheaders')) { 
	function getallheaders() { 
		$headers = array(); 
		foreach ($_SERVER as $name => $value) { 
			if (substr($name, 0, 5) == 'HTTP_') { 
				$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value; 
			} 
		} 
		return $headers; 
    } 
} 


// **********************************************************************// 
//  Function return vc_row with gradient.
// **********************************************************************// 
if( ! function_exists( 'woodmart_get_gradient_attr' ) ) {
	function woodmart_get_gradient_attr( $output, $obj, $attr ) {
		if ( ! empty( $attr['woodmart_gradient_switch'] ) ) {
			$gradient_css = woodmart_get_gradient_css( $attr['woodmart_color_gradient'] );
			$output = preg_replace_callback('/woodmart-row-gradient-enable.*?>/',
				function ( $matches ) use( $gradient_css ) {
				   return strtolower( $matches[0] . '<div class="woodmart-row-gradient" style="' . $gradient_css . '"></div>' );
				}, $output );
		}
		return $output;
	}
}

add_filter( 'vc_shortcode_output', 'woodmart_get_gradient_attr', 10, 3 );

// **********************************************************************// 
//  Function return vc_video with image mask.
// **********************************************************************// 
if( ! function_exists( 'woodmart_add_video_poster' ) ) {
	function woodmart_add_video_poster( $output, $obj, $attr ) {
		if ( ! empty( $attr['image_poster_switch'] ) ) {
			$image_id = $attr['poster_image'];
			$image_size = 'full';
			if ( isset( $attr['img_size'] ) ) $image_size = $attr['img_size'];
			$image = woodmart_get_image_src( $image_id, $image_size );
			$output = preg_replace_callback('/wpb_video_wrapper.*?>/',
				function ( $matches ) use( $image ) {
				   return strtolower( $matches[0] . '<div class="woodmart-video-poster-wrapper"><div class="woodmart-video-poster" style="background-image:url(' . esc_url( $image ) . ')";></div><div class="button-play"></div></div>' );
				}, $output );
		}
		return $output;
	}
}

add_filter( 'vc_shortcode_output', 'woodmart_add_video_poster', 10, 3 );

// **********************************************************************// 
//  Function return all images sizes
// **********************************************************************// 
function woodmart_get_all_image_sizes() {
    global $_wp_additional_image_sizes;

    $default_image_sizes = array( 'thumbnail', 'medium', 'large', 'full' );

    foreach ( $default_image_sizes as $size ) {
        $image_sizes[ $size ][ 'width' ] = intval( get_option( "{$size}_size_w" ) );
        $image_sizes[ $size ][ 'height' ] = intval( get_option( "{$size}_size_h" ) );
        $image_sizes[ $size ][ 'crop' ] = get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
    }

    if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ) {
        $image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
    }

    return $image_sizes;
}

if( ! function_exists( 'woodmart_get_image_size' ) ) {
	function woodmart_get_image_size( $thumb_size ) {
		if ( is_string( $thumb_size ) && in_array( $thumb_size, array( 'thumbnail', 'thumb', 'medium', 'large', 'full' ) ) ) {
			$images_sizes = woodmart_get_all_image_sizes();
			$image_size = $images_sizes[$thumb_size];
			if ( $thumb_size == 'full') {
				$image_size['width'] = 999999; 
				$image_size['height'] = 999999;
			}
			return array( $image_size['width'], $image_size['height'] );
		}elseif ( is_string( $thumb_size ) ) {
			preg_match_all( '/\d+/', $thumb_size, $thumb_matches );
			if ( isset( $thumb_matches[0] ) ) {
				$thumb_size = array();
				if ( count( $thumb_matches[0] ) > 1 ) {
					$thumb_size[] = $thumb_matches[0][0]; // width
					$thumb_size[] = $thumb_matches[0][1]; // height
				} elseif ( count( $thumb_matches[0] ) > 0 && count( $thumb_matches[0] ) < 2 ) {
					$thumb_size[] = $thumb_matches[0][0]; // width
					$thumb_size[] = $thumb_matches[0][0]; // height
				} else {
					$thumb_size = false;
				}
			}
			return $thumb_size;	
		}	
	}
}

if( ! function_exists( 'woodmart_get_image_src' ) ) {
	function woodmart_get_image_src( $thumb_id, $thumb_size ) {
		$thumb_size = woodmart_get_image_size( $thumb_size );
		$thumbnail = wpb_resize( $thumb_id, null, $thumb_size[0], $thumb_size[1], true );
		return $thumbnail['url'];
	}
}

// **********************************************************************// 
//  Function return gradient css.
// **********************************************************************// 
if( ! function_exists( 'woodmart_get_gradient_css' ) ) {
	function woodmart_get_gradient_css( $gradient_attr ) {
		$gradient_css = explode( '|', $gradient_attr );
		$result =  'background-image:-webkit-' . $gradient_css[1] . ';';
		$result .= 'background-image:-moz-' . $gradient_css[1] . ';';
		$result .= 'background-image:-o-' . $gradient_css[1] . ';';
		$result .= 'background-image:'.$gradient_css[1] . ';';
		$result .= 'background-image:-ms-' . $gradient_css[1] . ';';
		return $result;
	}
}
// **********************************************************************// 
// ! Append :hover to CSS selectors array
// **********************************************************************// 
if( ! function_exists( 'woodmart_append_hover_state' ) ) {
	function woodmart_append_hover_state( $selectors , $focus = false ) {
		$selectors = explode(',', $selectors[0]);

		$return = array();

		foreach ($selectors as $selector) {
			$return[] = $selector . ':hover';
			( $focus ) ? $return[] .= $selector . ':focus' : false ;
		}

		return implode(',', $return);
	}
}
// **********************************************************************// 
// Include gradient file
// **********************************************************************// 
if( ! function_exists( 'woodmart_register_redux_gradient' ) ) {
	function woodmart_register_redux_gradient( $field ) {
		return get_template_directory() . 'inc/classes/Gradient.php';
	}
}
add_filter( 'redux/woodmart_options/field/class/woodmart_gradient', 'woodmart_register_redux_gradient' ); 


// **********************************************************************// 
// Get gradient field
// **********************************************************************// 
if( ! function_exists( 'woodmart_get_gradient_field' ) ) {
	function woodmart_get_gradient_field( $param_name, $value, $is_VC = false ) {
		$classes = $param_name;
		$classes .= ( $is_VC ) ? ' wpb_vc_param_value' : '';
		$uniqid = uniqid();
		$output = '<div class="woodmart-grad-wrap">';
			$output .= '<div class="woodmart-grad-line" id="woodmart-grad-line' . $uniqid . '"></div>';
			$output .= '<div class="woodmart-grad-preview" id="woodmart-grad-preview' . $uniqid . '"></div>';
			$output .= '<input id="woodmart-grad-val' . $uniqid . '" class="' . $classes . '" name="' . $param_name . '"  style="display:none"  value="'.$value.'"/>';
		$output .= '</div>';

		$gradient_data = explode( '|', $value );
		$gradient_points_data = $gradient_data[0];
		$gradient_type_data = $gradient_data[2];
		$gradient_direction_data = $gradient_data[3];

		//Point result
		$result_point_value = '';
		if ( ! empty( $gradient_points_data ) ) {
			$points_value = explode( '/', $gradient_points_data );
			array_pop( $points_value );
			foreach ( $points_value as $key => $points_values ) {
				$points_values = explode( '-', $points_values );
				$result_point_value .= '{color:"' . esc_attr ( $points_values[0] ) . '",position:' . $points_values[1] . '},';
			}
		}else{
			$result_point_value = '{color:"rgb(60, 27, 59)",position:0},{color:"rgb(90, 55, 105)",position: 33},{color:"rgb(46, 76, 130)",position:66},{color:"rgb(29, 28, 44)",position:100}';
		}

		//Type result
		$result_type_value = ( ! empty( $gradient_type_data ) ) ? $gradient_type_data : 'linear' ;

		//Direction result
		$result_direction_value = ( ! empty( $gradient_direction_data ) ) ? $gradient_direction_data : 'left' ;

		
		$output .= "<script>
		jQuery( document ).ready( function() {
			var gradient_line = '#woodmart-grad-line" . $uniqid . "',
				gradient_preview = '#woodmart-grad-preview" . $uniqid . "',
				grad_val = '#woodmart-grad-val" . $uniqid . "';

			gradX(gradient_line, {
				targets: [gradient_preview],
				change: function( points, styles, type, direction ) {
				   for( i = 0; i < styles.length; ++i )  {  
				       jQuery( gradient_preview ).css( 'background-image', styles[i] );
						var points_value = '';
						jQuery( points ).each( function( index , value ){
							points_value +=  value[0] + '-' + value[1] + '/';
						})
						jQuery( grad_val ).attr( 'value', points_value + '|' + styles[i] + '|' + type + '|' + direction );
				   }
				 }, 
				type: \"" . $result_type_value . "\",
				direction: \"" .  $result_direction_value . "\",
				sliders: [" . $result_point_value . "]
			});
		})
		</script>";
		return $output;
	}
}
// **********************************************************************// 
// Reset woodmart loop
// **********************************************************************// 
if( ! function_exists( 'woodmart_reset_loop' ) ) {
	function woodmart_reset_loop() {
		$GLOBALS['woodmart_loop'] = array(
			'loop'    => '',
			'parts' => '',
			'blog_design'    => '',
			'columns'    => '',
			'img_size'    => '',
			'double_size'    => '',
	    );
	}
}

// **********************************************************************// 
// Woodmart get theme info
// **********************************************************************// 
if( ! function_exists( 'woodmart_get_theme_info' ) ) {
	function woodmart_get_theme_info( $parameter ) {
		$theme_info = wp_get_theme();
		if ( is_child_theme() ){
			$theme_info = wp_get_theme( $theme_info->parent()->template );
		} 
		return $theme_info->get( $parameter ); 
	}
}

// **********************************************************************// 
// Woodmart twitter process links
// **********************************************************************// 
if( ! function_exists( 'woodmart_twitter_process_links' ) ) {
	function woodmart_twitter_process_links( $tweet ) {

		// Is the Tweet a ReTweet - then grab the full text of the original Tweet
		if( isset( $tweet->retweeted_status ) ) {
			// Split it so indices count correctly for @mentions etc.
			$rt_section = current( explode( ":", $tweet->text ) );
			$text = $rt_section.": ";
			// Get Text
			$text .= $tweet->retweeted_status->text;
		} else {
			// Not a retweet - get Tweet
			$text = $tweet->text;
		}

		// NEW Link Creation from clickable items in the text
		$text = preg_replace( '/((http)+(s)?:\/\/[^<>\s]+)/i', '<a href="$0" target="_blank" rel="nofollow">$0</a>', $text );
		// Clickable Twitter names
		$text = preg_replace( '/[@]+([A-Za-z0-9-_]+)/', '<a href="http://twitter.com/$1" target="_blank" rel="nofollow">@$1</a>', $text );
		// Clickable Twitter hash tags
		$text = preg_replace( '/[#]+([A-Za-z0-9-_]+)/', '<a href="http://twitter.com/search?q=%23$1" target="_blank" rel="nofollow">$0</a>', $text );
		// END TWEET CONTENT REGEX
		return $text;

	}
}

// **********************************************************************// 
// Woodmart Owl Items Per Slide
// **********************************************************************// 
if( ! function_exists( 'woodmart_owl_items_per_slide' ) ) {
	function woodmart_owl_items_per_slide( $slides_per_view ) {
		$items = woodmart_get_owl_items_numbers( $slides_per_view );

		$classes = 'owl-items-xl-' . $items['desktop'];
		$classes .= ' owl-items-lg-' . $items['desktop_small'];
		$classes .= ' owl-items-md-' . $items['tablet'];
		$classes .= ' owl-items-sm-' . $items['mobile'];

		return $classes;
	}
}
// **********************************************************************// 
// Woodmart Get Owl Items Numbers
// **********************************************************************// 
if( ! function_exists( 'woodmart_get_owl_items_numbers' ) ) {
	function woodmart_get_owl_items_numbers( $slides_per_view ) {
		$items = array();
		$items['desktop'] = ( $slides_per_view > 0 ) ? $slides_per_view : 1;
		$items['desktop_small'] = ( $items['desktop'] > 1 ) ? $items['desktop'] - 1 : 1;
		$items['tablet'] = ( $items['desktop_small'] > 1 ) ? $items['desktop_small'] : 1;
		$items['mobile'] = ( $items['tablet'] > 2 ) ? $items['tablet'] - 2 : 1;

		if( $items['mobile'] > 2 ) {
			$items['mobile'] = 2;
		}

		return $items;
	}
}


// **********************************************************************// 
// Woodmart Get Settings JS
// **********************************************************************// 
if ( ! function_exists('woodmart_settings_js') ) { 
	function woodmart_settings_js() { 

        $custom_js          = woodmart_get_opt( 'custom_js' );
        $js_ready           = woodmart_get_opt( 'js_ready' );

		ob_start();

        if( ! empty( $custom_js ) || ! empty( $js_ready ) ): ?>
            <?php if( ! empty( $custom_js ) ): ?>
                <?php echo ($custom_js); ?>
            <?php endif; ?>
            <?php if( ! empty( $js_ready ) ): ?>
                jQuery(document).ready(function() {
                    <?php echo ($js_ready); ?>
                });
            <?php endif; ?>
        <?php endif; 
        
        return ob_get_clean();
	}
}


// **********************************************************************// 
// Woodmart Get Settings CSS
// **********************************************************************// 
if ( ! function_exists('woodmart_settings_css') ) { 
	function woodmart_settings_css() { 
		$logo_img_width        = woodmart_get_opt( 'logo_img_width' );
		$logo_img_width_tablet = woodmart_get_opt( 'logo_img_width_tablet' );
		$logo_img_width_mobile = woodmart_get_opt( 'logo_img_width_mobile' );
		$logo_padding        = woodmart_get_opt( 'logo_padding' );
		$logo_padding_tablet = woodmart_get_opt( 'logo_padding_tablet' );
		$logo_padding_mobile = woodmart_get_opt( 'logo_padding_mobile' );

		$logo_responsive = woodmart_get_opt( 'logo_responsive_sizes' );

		$header = woodmart_get_opt( 'header' );
		$header_height = woodmart_get_opt( 'header_height' );
		$sticky_header_height = woodmart_get_opt( 'sticky_header_height' );
		$mobile_header_height = woodmart_get_opt( 'mobile_header_height' );

		$widgets_scroll = woodmart_get_opt( 'widgets_scroll' );
		$widgets_height = woodmart_get_opt( 'widget_heights' );

		$primary_color      = woodmart_get_opt( 'primary-color' );

		$custom_css 		= woodmart_get_opt( 'custom_css' );
		$css_desktop 		= woodmart_get_opt( 'css_desktop' );
		$css_tablet 		= woodmart_get_opt( 'css_tablet' );
		$css_wide_mobile 	= woodmart_get_opt( 'css_wide_mobile' );
		$css_mobile         = woodmart_get_opt( 'css_mobile' );
		$custom_js          = woodmart_get_opt( 'custom_js' );
		$js_ready 		    = woodmart_get_opt( 'js_ready' );

		$custom_product_background = get_post_meta( get_the_ID(),  '_woodmart_product-background', true );
		
		ob_start();
		?>

		/* Header height for these layouts based on it's menu links line height */
        .wrapp-header {
            min-height: <?php echo esc_html( $header_height ); ?>px;
        }

        /* Header height browser IE */ 

        .browser-Internet .wrapp-header {
        	height: <?php echo esc_html( $header_height ); ?>px;
        }

        .act-scroll .wrapp-header,
        .sticky-header .wrapp-header {
            min-height: <?php echo esc_html( $sticky_header_height ); ?>px;
        }

        /* Stiky header height browser IE */ 

        .browser-Internet .act-scroll .wrapp-header,
        .browser-Internet .sticky-header .wrapp-header {
			height: <?php echo esc_html( $sticky_header_height ); ?>px;
        }

       /*.sticky-header .woodmart-search-full-screen .woodmart-search-wrapper {
            height:calc(100vh - <?php echo esc_html( $sticky_header_height ); ?>px);
        }

        .admin-bar .sticky-header .woodmart-search-full-screen .woodmart-search-wrapper {
            height:calc(100vh - 32px - <?php echo esc_html( $sticky_header_height ); ?>px);
        }*/

        .site-logo img {
            max-width: <?php echo esc_html( $logo_img_width ); ?>px;
        } 

        .main-header .site-logo img {  
            max-height: <?php echo esc_html( $header_height ); ?>px;
            padding-top: <?php echo esc_html( $logo_padding['padding-top'] ); ?>;
            padding-right: <?php echo esc_html( $logo_padding['padding-right'] ); ?>;
            padding-bottom: <?php echo esc_html( $logo_padding['padding-bottom'] ); ?>;
            padding-left: <?php echo esc_html( $logo_padding['padding-left'] ); ?>;
        }

        <?php if( $header != 'menu-top' ): ?>
        
            /* And for sticky header logo also */
            .act-scroll .site-logo img,
            .header-clone .site-logo img {
                max-height: <?php echo esc_html( $sticky_header_height ); ?>px;
            } 

        <?php endif; ?>


        .main-nav .menu-item-design-full-width .sub-menu-dropdown,
        .header-menu-top .navigation-wrap .main-nav .sub-menu-dropdown,
        .header-menu-top .woodmart-search-dropdown > .woodmart-search-wrapper,
        .header-menu-top .woodmart-shopping-cart .dropdown-cart,
        .header-menu-top .woodmart-header-links .sub-menu-dropdown {
            margin-top: <?php echo esc_html( ($header_height / 2) - 20); ?>px;
        }

        .main-nav .menu-item-design-full-width .sub-menu-dropdown:after,
        .header-menu-top .navigation-wrap .main-nav .sub-menu-dropdown:after,
        .header-menu-top .woodmart-search-dropdown > .woodmart-search-wrapper:after,
        .header-menu-top .woodmart-shopping-cart .dropdown-cart:after,
        .header-menu-top .woodmart-header-links .sub-menu-dropdown:after {
            height: <?php echo esc_html( ($header_height / 2) - 20); ?>px;
        } 


        .act-scroll .main-nav .menu-item .sub-menu-dropdown,
        .act-scroll .woodmart-search-dropdown > .woodmart-search-wrapper,
        .act-scroll .woodmart-shopping-cart .dropdown-cart,
        .act-scroll .woodmart-header-links .sub-menu-dropdown,
        .act-scroll.header-menu-top .navigation-wrap .main-nav .sub-menu-dropdown,
        .act-scroll.header-menu-top .woodmart-search-dropdown > .woodmart-search-wrapper {
            margin-top: <?php echo esc_html( ($sticky_header_height / 2) - 20); ?>px;
        }

        .act-scroll .main-nav .menu-item .sub-menu-dropdown:after,
        .act-scroll .woodmart-search-dropdown > .woodmart-search-wrapper:after,
        .act-scroll .woodmart-shopping-cart .dropdown-cart:after,
        .act-scroll .woodmart-header-links .sub-menu-dropdown:after,
        .act-scroll.header-menu-top .navigation-wrap .main-nav .sub-menu-dropdown:after,
        .act-scroll.header-menu-top .woodmart-search-dropdown > .woodmart-search-wrapper:after {
            height: <?php echo esc_html( ($sticky_header_height / 2) - 20); ?>px;
        }

        <?php if ( $logo_responsive ) : ?>
            @media (min-width: 768px) and (max-width: 1023px) {
                .site-logo img {
                    max-width: <?php echo esc_html( $logo_img_width_tablet ); ?>px;
                } 

                .main-header .site-logo img {
                    padding-top: <?php echo esc_html( $logo_padding_tablet['padding-top'] ); ?>;
                    padding-right: <?php echo esc_html( $logo_padding_tablet['padding-right'] ); ?>;
                    padding-bottom: <?php echo esc_html( $logo_padding_tablet['padding-bottom'] ); ?>;
                    padding-left: <?php echo esc_html( $logo_padding_tablet['padding-left'] ); ?>;
                }   
            }
            @media (max-width: 767px) {
                .site-logo img {
                    max-width: <?php echo esc_html( $logo_img_width_mobile ); ?>px;
                }

                .main-header .site-logo img {
                    padding-top: <?php echo esc_html( $logo_padding_mobile['padding-top'] ); ?>;
                    padding-right: <?php echo esc_html( $logo_padding_mobile['padding-right'] ); ?>;
                    padding-bottom: <?php echo esc_html( $logo_padding_mobile['padding-bottom'] ); ?>;
                    padding-left: <?php echo esc_html( $logo_padding_mobile['padding-left'] ); ?>;                       
                }    
            }
        <?php endif; ?>

        <?php if( $widgets_scroll ): ?>
            .woodmart-woocommerce-layered-nav .woodmart-scroll-content {
                max-height: <?php echo ($widgets_height); ?>px;
            }
        <?php endif; ?>  

        /* Page headings settings for heading overlap. Calculate on the header height base */

        .woodmart-header-overlap .title-size-default,
        .woodmart-header-overlap .title-size-small,
        .woodmart-header-overlap .title-shop.without-title.title-size-default,
        .woodmart-header-overlap .title-shop.without-title.title-size-small {
            padding-top: <?php echo ($header_height + 40);  ?>px;
        }


        .woodmart-header-overlap .title-shop.without-title.title-size-large,
        .woodmart-header-overlap .title-size-large {
            padding-top: <?php echo ($header_height + 120);  ?>px;
        }

		<?php if ( !empty( $custom_product_background ) ): ?>
		.single-product .site-content{
			background-color: <?php echo esc_html( $custom_product_background ); ?> !important;
		}
		<?php endif ?>

        @media (max-width: 1024px) {

            /* Header height for these layouts based on it's menu links line height */
            .wrapp-header {
                min-height: <?php echo esc_html( $mobile_header_height ); ?>px;
            } 

	        /* Header height browser IE */ 

	        .browser-Internet .wrapp-header {
	        	height: <?php echo esc_html( $mobile_header_height ); ?>px;
	        }

            /* Limit logo image height for mobile according to mobile header height */
            .main-header .site-logo img {
                max-height: <?php echo esc_html( $mobile_header_height ); ?>px;
            }

            .woodmart-shopping-cart,
            .mobile-nav-icon {
            	height: <?php echo esc_html( $mobile_header_height ); ?>px;
            }

            /* And for sticky header logo also */
            .act-scroll .site-logo img,
            .header-clone .site-logo img {
                max-height: <?php echo esc_html( $mobile_header_height ); ?>px;
            } 

            .act-scroll .wrapp-header,
            .sticky-header .wrapp-header {
                min-height: <?php echo esc_html( $mobile_header_height ); ?>px;
            }

	        /* Stiky header height browser IE */ 

	        .browser-Internet .act-scroll .wrapp-header,
	        .browser-Internet .sticky-header .wrapp-header {
				height: <?php echo esc_html( $mobile_header_height ); ?>px;
	        }

            /* Page headings settings for heading overlap. Calculate on the MOBILE header height base */
            .woodmart-header-overlap .title-size-default,
            .woodmart-header-overlap .title-size-small,
            .woodmart-header-overlap .title-shop.without-title.title-size-default,
            .woodmart-header-overlap .title-shop.without-title.title-size-small {
                padding-top: <?php echo ($mobile_header_height + 20);  ?>px;
            }

            .woodmart-header-overlap .title-shop.without-title.title-size-large,
            .woodmart-header-overlap .title-size-large {
                padding-top: <?php echo ($mobile_header_height + 60);  ?>px;
            }

         }
 
        <?php 
        if( $custom_css != '' ) {
            echo ($custom_css);
        }
        if( $css_desktop != '' ) {
            echo '@media (min-width: 1024px) { ' . ($css_desktop) . ' }'; 
        }
        if( $css_tablet != '' ) {
            echo '@media (min-width: 768px) and (max-width: 1023px) {' . ($css_tablet) . ' }'; 
        }
        if( $css_wide_mobile != '' ) {
            echo '@media (min-width: 481px) and (max-width: 767px) { ' . ($css_wide_mobile) . ' }'; 
        }
        if( $css_mobile != '' ) {
            echo '@media (max-width: 480px) { ' . ($css_mobile) . ' }'; 
        }

        return ob_get_clean();
	} 
}
// **********************************************************************// 
// Header classes
// **********************************************************************// 
if ( ! function_exists( 'woodmart_get_header_classes' ) ) {
	function woodmart_get_header_classes( $header ){
		$header_class = 'main-header';
		$sticky_class = '';
		$header_bg = woodmart_get_opt( 'header_background' );
		$header_overlap_opt = woodmart_get_opt( 'header-overlap' );
		$header_has_bg = ( ! empty( $header_bg['background-color'] ) || ! empty( $header_bg['background-image'] ) );
		$header_overlap = false;

		// If header type is SHOP and overlap option is enabled
		if( ( $header == 'shop' || $header == 'split' || $header == 'simple' ) && $header_overlap_opt ) {
			$header_overlap = true;
		}

		$header_class .= ( $header_has_bg ) ? ' header-has-bg' : ' header-has-no-bg';
		$header_class .= ( $header_overlap ) ? ' header-overlap' : '';
		$header_class .= ' header-' . $header;
		$header_class .= ' icons-design-' . woodmart_get_opt( 'icons_design' );
		$header_class .= ' header-color-' . woodmart_get_opt( 'header_color_scheme' );
		$mobile_class  = 'header-mobile-' . woodmart_get_opt( 'header_mobile' );
		$header_class .= ' ' . $mobile_class;
		$sticky_class .= $mobile_class . ' header-color-' . woodmart_get_opt( 'header_color_scheme' );

		echo 'class="' . esc_attr( $header_class ) . '" data-sticky-class="' . esc_attr( $sticky_class ) . '"';
	}
}

// **********************************************************************// 
// Get typekit fonts
// **********************************************************************// 
if ( ! function_exists( 'woodmart_get_typekit_fonts' ) ) {
	function woodmart_get_typekit_fonts() {
		global $woodmart_options;
		if ( !empty( $woodmart_options['typekit_fonts'] ) ) {
			$fonts_string = explode( ',', $woodmart_options['typekit_fonts'] );
			$fonts_array['Custom-Fonts'] = array_combine( $fonts_string, $fonts_string );
			return $fonts_array;
		}else{
			return array();
		}
	}
	add_filter( 'redux/woodmart_options/field/typography/custom_fonts', 'woodmart_get_typekit_fonts' );
}

// **********************************************************************// 
// Is share button enable
// **********************************************************************// 
if ( ! function_exists( 'woodmart_is_social_link_enable' ) ) {
	function woodmart_is_social_link_enable( $type ) {
		$result = false;
		if ( $type == 'share' && ( woodmart_get_opt('share_fb') || woodmart_get_opt('share_twitter') || woodmart_get_opt('share_google') || woodmart_get_opt('share_pinterest') || woodmart_get_opt('share_ok') || woodmart_get_opt('share_whatsapp') || woodmart_get_opt('social_email') ) ) {
			$result = true;
		}
		if  ( $type == 'follow' && ( woodmart_get_opt('fb_link') || woodmart_get_opt('twitter_link') || woodmart_get_opt('google_link') || woodmart_get_opt('isntagram_link') || woodmart_get_opt('pinterest_link') || woodmart_get_opt('youtube_link') || woodmart_get_opt('tumblr_link') || woodmart_get_opt('linkedin_link') || woodmart_get_opt('vimeo_link') || woodmart_get_opt('flickr_link') || woodmart_get_opt('github_link') || woodmart_get_opt('dribbble_link') || woodmart_get_opt('behance_link') || woodmart_get_opt('soundcloud_link') || woodmart_get_opt('spotify_link') || woodmart_get_opt('ok_link') ) ) {
			$result = true;
		}
		return $result;
	}
}

// **********************************************************************// 
// Print script tag with content
// **********************************************************************// 
if ( ! function_exists( 'woodmart_add_inline_script' ) ) {
	function woodmart_add_inline_script( $key, $content, $position = 'after' ) {
		
		$out = '';
		$tag = 'script';
		$attributes = 'type="text/javascript"';

		$out .= '<' . $tag . ' ' . $attributes . '>';
		$out .= $content;
		$out .= '</' . $tag . '>';


		echo $out;
	}
}


