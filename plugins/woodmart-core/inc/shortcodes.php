<?php 
add_shortcode( 'woodmart_responsive_text_block', 'woodmart_shortcode_responsive_text_block' );
add_shortcode( 'woodmart_title', 'woodmart_shortcode_title' );
add_shortcode( 'woodmart_button', 'woodmart_shortcode_button' );
add_shortcode( 'woodmart_popup', 'woodmart_shortcode_popup' );
add_shortcode( 'woodmart_instagram', 'woodmart_shortcode_instagram' );
add_shortcode( 'woodmart_brands', 'woodmart_shortcode_brands' );
add_shortcode( 'woodmart_google_map', 'woodmart_shortcode_google_map' );
add_shortcode( 'woodmart_portfolio', 'woodmart_shortcode_portfolio' );
add_shortcode( 'woodmart_blog', 'woodmart_shortcode_blog' );
remove_shortcode('gallery');
add_shortcode( 'gallery', 'woodmart_gallery_shortcode' );
add_shortcode( 'woodmart_gallery', 'woodmart_images_gallery_shortcode' );
add_shortcode( 'woodmart_categories', 'woodmart_shortcode_categories' );
add_shortcode( 'woodmart_counter', 'woodmart_shortcode_animated_counter' );
add_shortcode( 'team_member', 'woodmart_shortcode_team_member' );
add_shortcode( 'testimonials', 'woodmart_shortcode_testimonials' );
add_shortcode( 'testimonial', 'woodmart_shortcode_testimonial' );
add_shortcode( 'extra_menu', 'woodmart_shortcode_extra_menu' );
add_shortcode( 'extra_menu_list', 'woodmart_shortcode_extra_menu_list' );
add_shortcode( 'pricing_tables', 'woodmart_shortcode_pricing_tables' );
add_shortcode( 'pricing_plan', 'woodmart_shortcode_pricing_plan' );
add_shortcode( 'products_tabs', 'woodmart_shortcode_products_tabs' );
add_shortcode( 'products_tab', 'woodmart_shortcode_products_tab' );
add_shortcode( 'woodmart_mega_menu', 'woodmart_shortcode_mega_menu' );
add_shortcode( 'user_panel', 'woodmart_shortcode_user_panel' );
add_shortcode( 'author_area', 'woodmart_shortcode_author_area' );
add_shortcode( 'promo_banner', 'woodmart_shortcode_promo_banner' );
add_shortcode( 'banners_carousel', 'woodmart_shortcode_banners_carousel' );
add_shortcode( 'woodmart_info_box', 'woodmart_shortcode_info_box' );
add_shortcode( 'woodmart_3d_view', 'woodmart_shortcode_3d_view' );
add_shortcode( 'woodmart_menu_price', 'woodmart_shortcode_menu_price' );
add_shortcode( 'woodmart_countdown_timer', 'woodmart_shortcode_countdown_timer' );
add_shortcode( 'social_buttons', 'woodmart_shortcode_social' );
add_shortcode( 'woodmart_posts_teaser', 'woodmart_shortcode_posts_teaser' );
add_shortcode( 'woodmart_products', 'woodmart_shortcode_products' );
add_shortcode( 'html_block', 'woodmart_html_block_shortcode' );
add_shortcode( 'woodmart_ajax_search', 'woodmart_ajax_search' );
add_shortcode( 'woodmart_row_divider', 'woodmart_row_divider' );
add_shortcode( 'woodmart_twitter', 'woodmart_twitter' );

if( function_exists( 'vc_add_shortcode_param' ) && apply_filters( 'woodmart_gradients_enabled', true ) ) {
	vc_add_shortcode_param( 'woodmart_gradient', 'woodmart_add_gradient_type' );
}


/**
* ------------------------------------------------------------------------------------------------
* Products widget shortcode
* ------------------------------------------------------------------------------------------------
*/
class WOODMART_ShortcodeProductsWidget{
	
	function __construct(){
		add_shortcode( 'woodmart_shortcode_products_widget', array( $this, 'woodmart_shortcode_products_widget' ) );
	}
	public function add_category_order($query_args){
		$ids = explode( ',', $this->ids );
		if ( !empty( $ids[0] ) ) {
			$query_args['tax_query'][] = array(
				'taxonomy' => 'product_cat',
				'field'    => 'id',
				'terms'    => $ids,
			);
		}
		return $query_args;
	}

	public function woodmart_shortcode_products_widget( $atts ){
		$output = $title = $el_class = '';
		extract( shortcode_atts( array(
			'title' => __( 'Products', 'woodmart' ),
			'ids' => '',
			'el_class' => ''
		), $atts ) );
		
		$this->ids = $ids;
		$output = '<div class="widget_products' . $el_class . '">';
		$type = 'WC_Widget_Products';

		$args = array('widget_id' => rand(10,99));

		ob_start();
		add_filter( 'woocommerce_products_widget_query_args', array( $this, 'add_category_order' ) );
		the_widget( $type, $atts, $args );
		remove_filter( 'woocommerce_products_widget_query_args', array( $this, 'add_category_order' ) );
		$output .= ob_get_clean();

		$output .= '</div>';

		return $output;

	}
}
$woodmart_shortcode_products_widget = new WOODMART_ShortcodeProductsWidget();