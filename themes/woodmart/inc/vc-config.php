<?php if ( ! defined('WOODMART_THEME_DIR')) exit('No direct script access allowed');

if( ! function_exists( 'woodmart_vc_extra_classes' ) ) {

	if( defined( 'VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG' ) ) {
		add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'woodmart_vc_extra_classes', 30, 3 );
	}

	function woodmart_vc_extra_classes( $class, $base, $atts ) {

		if( ! empty( $atts['woodmart_color_scheme'] ) ) {
			$class .= ' color-scheme-' . $atts['woodmart_color_scheme'];
		}
		if( ! empty( $atts['text_larger'] ) ) {
			$class .= ' text-larger';
		}
		if( ! empty( $atts['woodmart_sticky_column'] ) ) {
			$class .= ' woodmart-sticky-column';
		}
		if( ! empty( $atts['woodmart_parallax'] ) ) {
			$class .= ' woodmart-parallax';
		}
		if( ! empty( $atts['woodmart_disable_overflow'] ) ) {
			$class .= ' woodmart-disable-overflow';
		}
		if( ! empty( $atts['woodmart_gradient_switch'] ) && apply_filters( 'woodmart_gradients_enabled', true ) ) {
			$class .= ' woodmart-row-gradient-enable';
		}
		if( ! empty( $atts['woodmart_bg_position'] ) ) {
			$class .= ' woodmart-bg-' . $atts['woodmart_bg_position'];
		}
		if( ! empty( $atts['woodmart_text_align'] ) ) {
			$class .= ' text-' . $atts['woodmart_text_align'];
		}

		if( ! empty( $atts['woodmart_hide_large'] ) ) {
			$class .= ' hidden-lg';
		}
		if( ! empty( $atts['woodmart_hide_medium'] ) ) {
			$class .= ' hidden-md';
		}
		if( ! empty( $atts['woodmart_hide_small'] ) ) {
			$class .= ' hidden-sm';
		}
		if( ! empty( $atts['woodmart_hide_extra_small'] ) ) {
			$class .= ' hidden-xs';
		}

		return $class;
	}

}

if( ! function_exists( 'woodmart_add_field_to_video' ) ) { 
	function woodmart_add_field_to_video() {

	    $vc_video_new_params = array(
	         
	        array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Add poster to video', 'woodmart' ),
				'param_name' => 'image_poster_switch',
				'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
				'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' )
			),
	        array(
	            'type' => 'attach_image',
				'heading' => esc_html__( 'Image', 'woodmart' ),
				'param_name' => 'poster_image',
				'value' => '',
				'description' => esc_html__( 'Select image from media library.', 'woodmart' ),
	            'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
				'dependency' => array(
					'element' => 'image_poster_switch',
					'value' => array( 'yes' ),
				) 
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Image size', 'woodmart' ),
				'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
				'param_name' => 'img_size',
				'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.', 'woodmart' ),
				'dependency' => array(
					'element' => 'image_poster_switch',
					'value' => array( 'yes' ),
				)
			),      
	     
	    );
	     
	    vc_add_params( 'vc_video', $vc_video_new_params ); 
	}      
	add_action( 'vc_after_init', 'woodmart_add_field_to_video' ); 
}

if( ! function_exists( 'woodmart_section_title_color_variation' ) ) {

	function woodmart_section_title_color_variation() {
		$variation = array(
			esc_html__( 'Default', 'woodmart' ) => 'default',
			esc_html__( 'Primary color', 'woodmart' ) => 'primary',
			esc_html__( 'Alternative color', 'woodmart' ) => 'alt',
			esc_html__( 'Black', 'woodmart' ) => 'black',
			esc_html__( 'White', 'woodmart' ) => 'white',
		);
		$variation2 = array( esc_html__( 'Gradient', 'woodmart' ) => 'gradient' );
		if ( apply_filters( 'woodmart_gradients_enabled', true ) ) {
			$variation = array_merge( $variation, $variation2 ); 
		}
		return $variation;
	}

}

if( ! function_exists( 'woodmart_title_gradient_picker' ) ) {

	function woodmart_title_gradient_picker() {
		$title_color = array(
			'type' => 'woodmart_gradient',
			'param_name' => 'woodmart_color_gradient',
			'heading' => esc_html__( 'Gradient title color', 'woodmart' ),
			'dependency' => array(
				'element' => 'color',
				'value' => array( 'gradient' ),
			) 
		);
		if ( !apply_filters( 'woodmart_gradients_enabled', true ) ) $title_color = false;
		return $title_color;
	}

}


if( ! function_exists( 'woodmart_vc_map_shortcodes' ) ) {

	add_action( 'vc_before_init', 'woodmart_vc_map_shortcodes' );

	function woodmart_vc_map_shortcodes() {

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Parallax option
		 * ------------------------------------------------------------------------------------------------
		 */

		$attributes = array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Woodmart parallax', 'woodmart' ),
			'param_name' => 'woodmart_parallax',
			'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
			'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
		);

		vc_add_param( 'vc_row', $attributes );
		vc_add_param( 'vc_section', $attributes );
		vc_add_param( 'vc_column', $attributes );
		
		/**
		 * ------------------------------------------------------------------------------------------------
		 * Gradient option
		 * ------------------------------------------------------------------------------------------------
		 */
		if( apply_filters( 'woodmart_gradients_enabled', true ) ) {
			$woodmart_gradient_switch = array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'woodmart gradient', 'woodmart' ),
				'param_name' => 'woodmart_gradient_switch',
				'group' => esc_html__( 'woodmart Extras', 'woodmart' ),
				'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' )
			);

			$woodmart_color_gradient = array(
				'type' => 'woodmart_gradient',
				'param_name' => 'woodmart_color_gradient',
				'group' => esc_html__( 'woodmart Extras', 'woodmart' ),
				'dependency' => array(
					'element' => 'woodmart_gradient_switch',
					'value' => array( 'yes' ),
				) 
			);


			vc_add_param( 'vc_row', $woodmart_gradient_switch );
			vc_add_param( 'vc_section', $woodmart_gradient_switch );

			vc_add_param( 'vc_row', $woodmart_color_gradient );
			vc_add_param( 'vc_section', $woodmart_color_gradient );
		}

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Background position
		 * ------------------------------------------------------------------------------------------------
		 */

		$woodmart_bg_position = array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Background position', 'woodmart' ),
			'param_name' => 'woodmart_bg_position',
			'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
			'value' => array(
				esc_html__( 'None', 'woodmart' ) => '',
				esc_html__( 'Left top', 'woodmart' ) => 'left-top',
				esc_html__( 'Left center', 'woodmart' ) => 'left-center',
				esc_html__( 'Left bottom', 'woodmart' ) => 'left-bottom',
				esc_html__( 'Right top', 'woodmart' ) => 'right-top',
				esc_html__( 'Right center', 'woodmart' ) => 'right-center',
				esc_html__( 'Right bottom', 'woodmart' ) => 'right-bottom',
				esc_html__( 'Center top', 'woodmart' ) => 'center-top',
				esc_html__( 'Center center', 'woodmart' ) => 'center-center',
				esc_html__( 'Center bottom', 'woodmart' ) => 'center-bottom',
			),
		);

		vc_add_param( 'vc_row', $woodmart_bg_position );
		vc_add_param( 'vc_section', $woodmart_bg_position );
		vc_add_param( 'vc_column', $woodmart_bg_position );

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Text align
		 * ------------------------------------------------------------------------------------------------
		 */

		$woodmart_text_align = array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Text align', 'woodmart' ),
			'param_name' => 'woodmart_text_align',
			'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
			'value' => array(
				esc_html__( 'choose', 'woodmart' ) => '',
				esc_html__( 'Left', 'woodmart' ) => 'left',
				esc_html__( 'Center', 'woodmart' ) => 'center',
				esc_html__( 'Right', 'woodmart' ) => 'right',
			),
		);

		vc_add_param( 'vc_column', $woodmart_text_align );

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Hide option
		 * ------------------------------------------------------------------------------------------------
		 */

		$woodmart_hide_large = array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Hide on large', 'woodmart' ),
			'param_name' => 'woodmart_hide_large',
			'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
			'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
		);

		$woodmart_hide_medium = array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Hide on medium', 'woodmart' ),
			'param_name' => 'woodmart_hide_medium',
			'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
			'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
		);

		$woodmart_hide_small = array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Hide on small', 'woodmart' ),
			'param_name' => 'woodmart_hide_small',
			'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
			'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
		);

		$woodmart_hide_extra_small = array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Hide on extra small', 'woodmart' ),
			'param_name' => 'woodmart_hide_extra_small',
			'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
			'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
		);

		vc_add_param( 'vc_empty_space', $woodmart_hide_large );
		vc_add_param( 'vc_empty_space', $woodmart_hide_medium );
		vc_add_param( 'vc_empty_space', $woodmart_hide_small );
		vc_add_param( 'vc_empty_space', $woodmart_hide_extra_small );


		$post_types_list = array();
		$post_types_list[] = array( 'post', esc_html__( 'Post', 'woodmart' ) );
		$post_types_list[] = array( 'ids', esc_html__( 'List of IDs', 'woodmart' ) );

		/**
		 * ------------------------------------------------------------------------------------------------
		 *  Add new element to VC: Woodmart responsive text block [woodmart_responsive_text_block]
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map( array(
			'name' => esc_html__( 'Responsive text block', 'woodmart' ),
			'base' => 'woodmart_responsive_text_block',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/text-blox-res.svg',
			'params' => array(
				array(
					'type' => 'textarea_html',
					'holder' => 'div',
					'heading' => esc_html__( 'Text', 'woodmart' ),
					'param_name' => 'content'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Text font', 'woodmart' ),
					'param_name' => 'font',
					'value' => array(
						esc_html__( 'Heading', 'woodmart' ) => 'primary',
						esc_html__( 'Text', 'woodmart' ) => 'text',
						esc_html__( 'Alternative', 'woodmart' ) => 'alt',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Font size', 'woodmart' ),
					'param_name' => 'size',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Small', 'woodmart' ) => 'small',
						esc_html__( 'Medium', 'woodmart' ) => 'medium',
						esc_html__( 'Large', 'woodmart' ) => 'large',
						esc_html__( 'Extra Large', 'woodmart' ) => 'extra-large',
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Font weight', 'woodmart' ),
					'param_name' => 'font_weight',
					'value' => array(
						'',100,200,300,400,500,600,700,800,900
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Desktop text size ( > 1024px )', 'woodmart' ),
					'param_name' => 'desktop_text_size',
					'description' => esc_html__( 'Only number without px.', 'woodmart' ),
					'group' => esc_html__( 'Custom size', 'woodmart' ),
					'dependency' => array(
						'element' => 'size',
						'value' => array( 'custom' ),
					) 
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Tablet text size ( < 1024px )', 'woodmart' ),
					'param_name' => 'tablet_text_size',
					'description' => esc_html__( 'Only number without px.', 'woodmart' ),
					'group' => esc_html__( 'Custom size', 'woodmart' ),
					'dependency' => array(
						'element' => 'size',
						'value' => array( 'custom' ),
					) 	
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Mobile text size ( < 767px )', 'woodmart' ),
					'param_name' => 'mobile_text_size',
					'description' => esc_html__( 'Only number without px.', 'woodmart' ),
					'group' => esc_html__( 'Custom size', 'woodmart' ),
					'dependency' => array(
						'element' => 'size',
						'value' => array( 'custom' ),
					) 
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Text align', 'woodmart' ),
					'param_name' => 'align',
					'value' => array(
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Left', 'woodmart' ) => 'left',
						esc_html__( 'Right', 'woodmart' ) => 'right',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Text width', 'woodmart' ),
					'param_name' => 'content_width',
					'value' => array(
						'100%' => '100',
						'90%' => '90',
						'80%' => '80',
						'70%' => '70',
						'60%' => '60',
						'50%' => '50',
						'40%' => '40',
						'30%' => '30',
						'20%' => '20',
						'10%' => '10',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Color scheme', 'woodmart' ),
					'param_name' => 'color_scheme',
					'value' => array(
						'' => '',
						esc_html__( 'Light', 'woodmart' ) => 'light',
						esc_html__( 'Dark', 'woodmart' ) => 'dark',
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Custom color', 'woodmart' ),
					'param_name' => 'color',
					'dependency' => array(
						'element' => 'color_scheme',
						'value' => array( 'custom' ),
					) 
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				),
				array(
					'type' => 'css_editor',
					'heading' => esc_html__( 'CSS box', 'woodmart' ),
					'param_name' => 'css',
					'group' => esc_html__( 'Design Options', 'woodmart' )
				),
			),
		));
		
		/**
		* ------------------------------------------------------------------------------------------------
		* Add new element to VC: Woodmart Twitter [woodmart_twitter]
		* ------------------------------------------------------------------------------------------------
		*/
		vc_map( array(
			'name' => esc_html__( 'Twitter', 'woodmart' ),
			'base' => 'woodmart_twitter',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/twitter.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Twitter Name (without @ symbol)', 'woodmart' ),
					'param_name' => 'name',
					'value' => 'Twitter'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Number of Tweets', 'woodmart' ),
					'param_name' => 'num_tweets',
					'value' => 5
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Consumer Key', 'woodmart' ),
					'param_name' => 'consumer_key',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Consumer Secret', 'woodmart' ),
					'param_name' => 'consumer_secret',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Access Token', 'woodmart' ),
					'param_name' => 'access_token',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Access Token Secret', 'woodmart' ),
					'param_name' => 'accesstoken_secret',
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show your avatar image', 'woodmart' ),
					'param_name' => 'show_avatar',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Size of Avatar (default: 48)', 'woodmart' ),
					'param_name' => 'avatar_size',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Exclude Replies', 'woodmart' ),
					'param_name' => 'exclude_replies',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
				),
			),
		));


		/**
		 * ------------------------------------------------------------------------------------------------
		 * Gradient option
		 * ------------------------------------------------------------------------------------------------
		 */
		if( apply_filters( 'woodmart_gradients_enabled', true ) ) {
			$woodmart_gradient_switch = array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Woodmart gradient', 'woodmart' ),
				'param_name' => 'woodmart_gradient_switch',
				'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
				'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' )
			);

			$woodmart_color_gradient = array(
				'type' => 'woodmart_gradient',
				'param_name' => 'woodmart_color_gradient',
				'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
				'dependency' => array(
					'element' => 'woodmart_gradient_switch',
					'value' => array( 'yes' ),
				) 
			);


			vc_add_param( 'vc_row', $woodmart_gradient_switch );
			vc_add_param( 'vc_section', $woodmart_gradient_switch );

			vc_add_param( 'vc_row', $woodmart_color_gradient );
			vc_add_param( 'vc_section', $woodmart_color_gradient );
		}

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Disable overflow
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_add_param( 'vc_row', array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Disable "overflow:hidden;"', 'woodmart' ),
			'param_name' => 'woodmart_disable_overflow',
			'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
			'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
		) );

		/**
		* ------------------------------------------------------------------------------------------------
		* Add new element to VC: Ajax Search [woodmart_ajax_search]
		* ------------------------------------------------------------------------------------------------
		*/
		vc_map( array(
			'name' => esc_html__( 'AJAX Search', 'woodmart' ),
			'base' => 'woodmart_ajax_search',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/ajax-search.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Number of products to show', 'woodmart' ),
					'param_name' => 'number',
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show price', 'woodmart' ),
					'param_name' => 'price',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 ),
					'std' => 1
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show thumbnail', 'woodmart' ),
					'param_name' => 'thumbnail',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 ),
					'std' => 1
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show category', 'woodmart' ),
					'param_name' => 'category',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 ),
					'std' => 1
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__('Search post type', 'woodmart'), 
					'param_name' => 'search_post_type',
					'value' => array(
						esc_html__( 'Product', 'woodmart' ) => 'product',
						esc_html__( 'Post', 'woodmart' ) => 'post',
						esc_html__( 'Portfolio', 'woodmart' ) => 'portfolio',
					)
				),
				woodmart_get_color_scheme_param(),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				),
				array(
					'type' => 'css_editor',
					'heading' => esc_html__( 'CSS box', 'woodmart' ),
					'param_name' => 'css',
					'group' => esc_html__( 'Design Options', 'woodmart' )
				),
			),
		));

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Section divider shortcode
		 * ------------------------------------------------------------------------------------------------
		 */

		 vc_map( array(
				"name" => esc_html__( 'Section divider', 'woodmart'),
				"base" => "woodmart_row_divider",
				'category' => esc_html__( 'Theme elements', 'woodmart' ),
				'description' => esc_html__( 'Divider for sections', 'woodmart' ),
	        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/section-divider.svg',
				"params" => array(
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Position', 'woodmart' ),
						'param_name' => 'position',
						'value' => array(
							esc_html__( 'Top', 'woodmart' ) => 'top',
							esc_html__( 'Bottom', 'woodmart' ) => 'bottom',
						),
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Overlap', 'woodmart' ),
						'param_name' => 'content_overlap',
						'value' => array( esc_html__( 'Enable', 'woodmart' ) => 'enable' )
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Color', 'woodmart' ),
						'param_name' => 'color',
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Style', 'woodmart' ),
						'param_name' => 'style',
						'value' => array(
							esc_html__( 'Waves Small', 'woodmart' ) => 'waves-small',
							esc_html__( 'Waves Wide', 'woodmart' ) => 'waves-wide',
							esc_html__( 'Curved Line', 'woodmart' ) => 'curved-line',
							esc_html__( 'Triangle', 'woodmart' ) => 'triangle',
							esc_html__( 'Clouds', 'woodmart' ) => 'clouds',
							esc_html__( 'Diagonal Right', 'woodmart' ) => 'diagonal-right',
							esc_html__( 'Diagonal Left', 'woodmart' ) => 'diagonal-left',
							esc_html__( 'Half Circle', 'woodmart' ) => 'half-circle',
							esc_html__( 'Paint Stroke', 'woodmart' ) => 'paint-stroke',
						),
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Custom height', 'woodmart' ),
						'param_name' => 'custom_height',
						'dependency' => array(
							'element' => 'style',
							'value' => array( 'curved-line', 'diagonal-right', 'half-circle', 'diagonal-left' )
						),
						'description' => esc_html__( 'Enter divider height (Note: CSS measurement units allowed).', 'woodmart' )
					),
					
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'woodmart' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
					),
				),
			) );

		/**
 		 * ------------------------------------------------------------------------------------------------
 		 * Map title shortcode
 		 * ------------------------------------------------------------------------------------------------
 		 */

		vc_map( array(
			'name' => esc_html__( 'Section title', 'woodmart' ),
			'base' => 'woodmart_title',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Styled title for sections', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/section-title.svg',
			'params' => array(
				array(
					'type' => 'textarea',
					'holder' => 'div',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title'
				),
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Sub title', 'woodmart' ),
					'param_name' => 'subtitle'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Subtitle font', 'woodmart' ),
					'param_name' => 'subtitle_font',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Alternative', 'woodmart' ) => 'alt',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Subtitle style', 'woodmart' ),
					'param_name' => 'subtitle_style',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Background', 'woodmart' ) => 'background',
					),
				),
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Text after title', 'woodmart' ),
					'param_name' => 'after_title',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Title width', 'woodmart' ),
					'param_name' => 'title_width',
					'value' => array(
						'100%' => '100',
						'90%' => '90',
						'80%' => '80',
						'70%' => '70',
						'60%' => '60',
						'50%' => '50',
						'40%' => '40',
						'30%' => '30',
						'20%' => '20',
						'10%' => '10',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Title style', 'woodmart' ),
					'param_name' => 'style',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Simple', 'woodmart' ) => 'simple',
						esc_html__( 'Bordered', 'woodmart' ) => 'bordered',
						esc_html__( 'Underline', 'woodmart' ) => 'underlined',
						esc_html__( 'Underline 2', 'woodmart' ) => 'underlined-2',
						esc_html__( 'Shadow', 'woodmart' ) => 'shadow',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Title color', 'woodmart' ),
					'param_name' => 'color',
					'value' => woodmart_section_title_color_variation()
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Title tag', 'woodmart' ),
					'param_name' => 'tag',
					'value' => array(
						'h1','h2','h3','h4','h5','h6','p','div','span'
					),
					'std' => 'h4'
				),
				woodmart_title_gradient_picker(),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Title size', 'woodmart' ),
					'param_name' => 'size',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Small', 'woodmart' ) => 'small',
						esc_html__( 'Medium', 'woodmart' ) => 'medium',
						esc_html__( 'Large', 'woodmart' ) => 'large',
						esc_html__( 'Extra Large', 'woodmart' ) => 'extra-large',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Title align', 'woodmart' ),
					'param_name' => 'align',
					'value' => array(
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Left', 'woodmart' ) => 'left',
						esc_html__( 'Right', 'woodmart' ) => 'right',
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				),
				array(
					'type' => 'css_editor',
					'heading' => esc_html__( 'CSS box', 'woodmart' ),
					'param_name' => 'css',
					'group' => esc_html__( 'Design Options', 'woodmart' )
				),
			),
		));

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map blog shortcode
		 * ------------------------------------------------------------------------------------------------
		 */
		vc_map( array(
			'name' => esc_html__('Blog', 'woodmart' ),
			'base' => 'woodmart_blog',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Show your blog posts on the page', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/blog.svg',
			'params' => array(
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Data source', 'woodmart' ),
					'param_name' => 'post_type',
					'value' => $post_types_list,
					'description' => esc_html__( 'Select content type for your grid.', 'woodmart' )
				),
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Include only', 'woodmart' ),
					'param_name' => 'include',
					'description' => esc_html__( 'Add posts, pages, etc. by title.', 'woodmart' ),
					'settings' => array(
						'multiple' => true,
						'sortable' => true,
						'groups' => true,
					),
					'dependency' => array(
						'element' => 'post_type',
						'value' => array( 'ids' ),
					),
				),
				// Custom query tab
				array(
					'type' => 'textarea_safe',
					'heading' => esc_html__( 'Custom query', 'woodmart' ),
					'param_name' => 'custom_query',
					'description' => wp_kses(  __( 'Build custom query according to <a href="http://codex.wordpress.org/Function_Reference/query_posts">WordPress Codex</a>.', 'woodmart' ), array(
	                        'a' => array( 
	                            'href' => array(), 
	                            'target' => array()
	                        )
                    	)),
					'dependency' => array(
						'element' => 'post_type',
						'value' => array( 'custom' ),
					),
				),
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Narrow data source', 'woodmart' ),
					'param_name' => 'taxonomies',
					'settings' => array(
						'multiple' => true,
						// is multiple values allowed? default false
						// 'sortable' => true, // is values are sortable? default false
						'min_length' => 1,
						// min length to start search -> default 2
						// 'no_hide' => true, // In UI after select doesn't hide an select list, default false
						'groups' => true,
						// In UI show results grouped by groups, default false
						'unique_values' => true,
						// In UI show results except selected. NB! You should manually check values in backend, default false
						'display_inline' => true,
						// In UI show results inline view, default false (each value in own line)
						'delay' => 500,
						// delay for search. default 500
						'auto_focus' => true,
						// auto focus input, default true
						// 'values' => $taxonomies_for_filter,
					),
					'param_holder_class' => 'vc_not-for-custom',
					'description' => esc_html__( 'Enter categories, tags or custom taxonomies.', 'woodmart' ),
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Items per page', 'woodmart' ),
					'param_name' => 'items_per_page',
					'description' => esc_html__( 'Number of items to show per page.', 'woodmart' ),
					'value' => '10',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Pagination', 'woodmart' ),
					'param_name' => 'pagination',
					'value' => array(
	                    '' => '',
	                    'Pagination' => 'pagination',
	                    '"Load more" button' => 'more-btn',
	                    'Infinit scrolling' => 'infinit',
					),
					'dependency' => array(
						'element' => 'blog_design',
						'value_not_equal_to' => array( 'carousel' ),
					),
				),
				// Design settings
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Blog Design', 'woodmart' ),
					'param_name' => 'blog_design',
					'value' => array(
	                    'Default' => 'default',
	                    'Default alternative' => 'default-alt',
	                    'Small images' => 'small-images',
	                    'Chess' => 'chess',
	                    'Masonry grid' => 'masonry',
	                    'Carousel' => 'carousel'
					),
					'description' => esc_html__( 'You can use different design for your blog styled for the theme', 'woodmart' ),
					'group' => esc_html__( 'Design', 'woodmart' ),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Post style small images', 'woodmart' ),
					'param_name' => 'carousel_small_img',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => esc_html__( 'Design', 'woodmart' ),
					'dependency' => array(
						'element' => 'blog_design',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Images size', 'woodmart' ),
					'group' => esc_html__( 'Design', 'woodmart' ),
					'param_name' => 'img_size',
					'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'woodmart' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Columns', 'woodmart' ),
					'param_name' => 'blog_columns',
					'value' => array(
						2, 3, 4
					),
					'description' => esc_html__( 'Blog items columns', 'woodmart' ),
					'group' => esc_html__( 'Design', 'woodmart' ),
					'dependency' => array(
						'element' => 'blog_design',
						'value' => array( 'masonry' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Title for posts', 'woodmart' ),
					'param_name' => 'parts_title',
					'group' => esc_html__( 'Design', 'woodmart' ),
					'value' => array(
	                    'Show' => 1,
	                    'Hide' => 0,
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Meta information', 'woodmart' ),
					'param_name' => 'parts_meta',
					'group' => esc_html__( 'Design', 'woodmart' ),
					'value' => array(
	                    'Show' => 1,
	                    'Hide' => 0,
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Post text', 'woodmart' ),
					'param_name' => 'parts_text',
					'group' => esc_html__( 'Design', 'woodmart' ),
					'value' => array(
	                    'Show' => 1,
	                    'Hide' => 0,
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Read more button', 'woodmart' ),
					'param_name' => 'parts_btn',
					'group' => esc_html__( 'Design', 'woodmart' ),
					'value' => array(
	                    'Show' => 1,
	                    'Hide' => 0,
					),
				),
				// Data settings
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'woodmart' ),
					'param_name' => 'orderby',
					'value' => array(
						esc_html__( 'Date', 'woodmart' ) => 'date',
						esc_html__( 'Order by post ID', 'woodmart' ) => 'ID',
						esc_html__( 'Author', 'woodmart' ) => 'author',
						esc_html__( 'Title', 'woodmart' ) => 'title',
						esc_html__( 'Last modified date', 'woodmart' ) => 'modified',
						esc_html__( 'Post/page parent ID', 'woodmart' ) => 'parent',
						esc_html__( 'Number of comments', 'woodmart' ) => 'comment_count',
						esc_html__( 'Menu order/Page Order', 'woodmart' ) => 'menu_order',
						esc_html__( 'Meta value', 'woodmart' ) => 'meta_value',
						esc_html__( 'Meta value number', 'woodmart' ) => 'meta_value_num',
						esc_html__( 'Random order', 'woodmart' ) => 'rand',
					),
					'description' => esc_html__( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'woodmart' ),
					'group' => esc_html__( 'Data Settings', 'woodmart' ),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Sorting', 'woodmart' ),
					'param_name' => 'order',
					'group' => esc_html__( 'Data Settings', 'woodmart' ),
					'value' => array(
						esc_html__( 'Descending', 'woodmart' ) => 'DESC',
						esc_html__( 'Ascending', 'woodmart' ) => 'ASC',
					),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'description' => esc_html__( 'Select sorting order.', 'woodmart' ),
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Meta key', 'woodmart' ),
					'param_name' => 'meta_key',
					'description' => esc_html__( 'Input meta key for grid ordering.', 'woodmart' ),
					'group' => esc_html__( 'Data Settings', 'woodmart' ),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency' => array(
						'element' => 'orderby',
						'value' => array( 'meta_value', 'meta_value_num' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Offset', 'woodmart' ),
					'param_name' => 'offset',
					'description' => esc_html__( 'Number of grid elements to displace or pass over.', 'woodmart' ),
					'group' => esc_html__( 'Data Settings', 'woodmart' ),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
					),
				),
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Exclude', 'woodmart' ),
					'param_name' => 'exclude',
					'description' => esc_html__( 'Exclude posts, pages, etc. by title.', 'woodmart' ),
					'group' => esc_html__( 'Data Settings', 'woodmart' ),
					'settings' => array(
						'multiple' => true,
					),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
						'callback' => 'vc_grid_exclude_dependency_callback',
					),
				),

				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Slider speed', 'woodmart' ),
					'param_name' => 'speed',
					'value' => '5000',
					'description' => esc_html__( 'Duration of animation between slides (in ms)', 'woodmart' ),
					'group' => esc_html__( 'Slider options', 'woodmart' ),
					'dependency' => array(
						'element' => 'blog_design',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Slides per view', 'woodmart' ),
					'param_name' => 'slides_per_view',
					'value' => array(
						1,2,3,4
					),
					'description' => esc_html__( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode. Also supports for "auto" value, in this case it will fit slides depending on container\'s width. "auto" mode doesn\'t compatible with loop mode.', 'woodmart' ),
					'group' => esc_html__( 'Slider options', 'woodmart' ),
					'dependency' => array(
						'element' => 'blog_design',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Scroll per page', 'woodmart' ),
					'param_name' => 'scroll_per_page',
					'description' => esc_html__( 'Scroll per page not per item. This affect next/prev buttons and mouse/touch dragging.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => esc_html__( 'Slider options', 'woodmart' ),
					'dependency' => array(
						'element' => 'blog_design',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Slider autoplay', 'woodmart' ),
					'param_name' => 'autoplay',
					'description' => esc_html__( 'Enables autoplay mode.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => esc_html__( 'Slider options', 'woodmart' ),
					'dependency' => array(
						'element' => 'blog_design',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide pagination control', 'woodmart' ),
					'param_name' => 'hide_pagination_control',
					'description' => esc_html__( 'If "YES" pagination control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => esc_html__( 'Slider options', 'woodmart' ),
					'dependency' => array(
						'element' => 'blog_design',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide prev/next buttons', 'woodmart' ),
					'param_name' => 'hide_prev_next_buttons',
					'description' => esc_html__( 'If "YES" prev/next control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => esc_html__( 'Slider options', 'woodmart' ),
					'dependency' => array(
						'element' => 'blog_design',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Slider loop', 'woodmart' ),
					'param_name' => 'wrap',
					'description' => esc_html__( 'Enables loop mode.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => esc_html__( 'Slider options', 'woodmart' ),
					'dependency' => array(
						'element' => 'blog_design',
						'value' => array( 'carousel' ),
					),
				),
	      )

	    ) );

		// Necessary hooks for blog autocomplete fields
		add_filter( 'vc_autocomplete_woodmart_blog_include_callback',	'vc_include_field_search', 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_woodmart_blog_include_render',
			'vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)

		// Narrow data taxonomies
		add_filter( 'vc_autocomplete_woodmart_blog_taxonomies_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
		add_filter( 'vc_autocomplete_woodmart_blog_taxonomies_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

		// Narrow data taxonomies for exclude_filter
		add_filter( 'vc_autocomplete_woodmart_blog_exclude_filter_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
		add_filter( 'vc_autocomplete_woodmart_blog_exclude_filter_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

		add_filter( 'vc_autocomplete_woodmart_blog_exclude_callback',	'vc_exclude_field_search', 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_woodmart_blog_exclude_render', 'vc_exclude_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map social buttons shortcode
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map( array(
			'name' => esc_html__( 'Social buttons', 'woodmart' ),
			'base' => 'social_buttons',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Follow or share buttons', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/social-buttons.svg',
			'params' => array(
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Buttons type', 'woodmart' ),
					'param_name' => 'type',
					'value' => array(
						esc_html__( 'Share', 'woodmart' ) => 'share',
						esc_html__( 'Follow', 'woodmart' ) => 'follow',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Buttons size', 'woodmart' ),
					'param_name' => 'size',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => '',
						esc_html__( 'Small', 'woodmart' ) => 'small',
						esc_html__( 'Large', 'woodmart' ) => 'large',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Buttons style', 'woodmart' ),
					'param_name' => 'style',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => '',
						esc_html__( 'Simple', 'woodmart' ) => 'simple',
						esc_html__( 'Colored', 'woodmart' ) => 'colored',
						esc_html__( 'Colored alternative', 'woodmart' ) => 'colored-alt',
						esc_html__( 'Bordered', 'woodmart' ) => 'bordered',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Buttons form', 'woodmart' ),
					'param_name' => 'form',
					'value' => array(
						esc_html__( 'Circle', 'woodmart' ) => 'circle',
						esc_html__( 'Square', 'woodmart' ) => 'square',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Align', 'woodmart' ),
					'param_name' => 'align',
					'value' => array(
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Left', 'woodmart' ) => 'left',
						esc_html__( 'Right', 'woodmart' ) => 'right',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Color', 'woodmart' ),
					'param_name' => 'color',
					'value' => array(
						esc_html__( 'Dark', 'woodmart' ) => 'dark',
						esc_html__( 'Light', 'woodmart' ) => 'light',
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			),
		));

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map button shortcode
		 * ------------------------------------------------------------------------------------------------
		 */

		$btn_args = array(
			'name' => esc_html__( 'Button', 'woodmart' ),
			'base' => 'woodmart_button',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Simple button in different theme styles', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/button.svg',
			'params' => woodmart_get_button_shortcode_params()
		);

		vc_map( $btn_args );


		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map popup shortcode
		 * ------------------------------------------------------------------------------------------------
		 */


		$woodmart_popup_params = vc_map_integrate_shortcode( $btn_args, '', 'Button', array(
			'exclude' => array(
				'link',
				'el_class'
			),
		));

		vc_map( array(
			'name' => esc_html__( 'Popup', 'woodmart' ),
			'base' => 'woodmart_popup',
			"content_element" => true,
			"as_parent" => array('except' => 'testimonial'),
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Button that shows a popup on click', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/popup.svg',
			'params' => array_merge(array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'ID', 'woodmart' ),
					'param_name' => 'id',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Width', 'woodmart' ),
					'param_name' => 'width',
					'description' => esc_html__( 'Popup width in pixels. For ex.: 800', 'woodmart' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			), $woodmart_popup_params),
		    "js_view" => 'VcColumnView',
		));


		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map Portfolio shortcode
		 * ------------------------------------------------------------------------------------------------
		 */

		$order_by_values = array(
			'',
			esc_html__( 'Date', 'woodmart' ) => 'date',
			esc_html__( 'ID', 'woodmart' ) => 'ID',
			esc_html__( 'Title', 'woodmart' ) => 'title',
			esc_html__( 'Modified', 'woodmart' ) => 'modified',
		);

		$order_way_values = array(
			'',
			esc_html__( 'Descending', 'woodmart' ) => 'DESC',
			esc_html__( 'Ascending', 'woodmart' ) => 'ASC',
		);

		vc_map( array(
			'name' => esc_html__( 'Portfolio', 'woodmart' ),
			'base' => 'woodmart_portfolio',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Showcase your projects or gallery', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/portfolio.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Number of posts per page', 'woodmart' ),
					'param_name' => 'posts_per_page'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'style',
					'value' => array(
	                     esc_html__('Inherit from theme settings', 'woodmart' ) => '',
	                     esc_html__('Show text on mouse over', 'woodmart' ) => 'hover',
	                     esc_html__('Alternative', 'woodmart' ) => 'hover-inverse',
	                     esc_html__('Text under image', 'woodmart' ) => 'text-shown',
	                     esc_html__('Mouse move parallax', 'woodmart' ) => 'parallax',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Columns', 'woodmart' ),
					'param_name' => 'columns',
					'value' => array(
	                     2,
	                     3,
	                     4,
	                     6,
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Space between projects', 'woodmart' ),
					'param_name' => 'spacing',
					'value' => array(
	                     0,
	                     2,
	                     6,
	                     10,
	                     20,
	                     30
					)
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show categories filters', 'woodmart' ),
					'param_name' => 'filters',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Categories', 'woodmart' ),
					'param_name' => 'categories',
					'value' => woodmart_get_projects_cats_array()
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'woodmart' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'save_always' => true,
					'description' => sprintf( wp_kses(  __( 'Select how to sort retrieved projects. More at %s.', 'woodmart' ), array(
	                        'a' => array( 
	                            'href' => array(), 
	                            'target' => array()
	                        )
                    	)), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Sort order', 'woodmart' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'save_always' => true,
					'description' => sprintf( wp_kses(  __( 'Designates the ascending or descending order. More at %s.', 'woodmart' ), array(
	                        'a' => array( 
	                            'href' => array(), 
	                            'target' => array()
	                        )
                    	)), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Pagination', 'woodmart' ),
					'param_name' => 'pagination',
					'value' => array(
	                    '' => '',
	                    'Pagination' => 'pagination',
	                    '"Load more" button' => 'load_more',
	                    'Infinit' => 'infinit',
	                    'Disable' => 'disable',
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			),
		));


		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map Google Map shortcode
		 * ------------------------------------------------------------------------------------------------
		 */
		vc_map( array(
			'name' => esc_html__( 'Google Map', 'woodmart' ),
			'base' => 'woodmart_google_map',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			"as_parent" => array('except' => 'testimonial'),
			"content_element" => true,
		    "js_view" => 'VcColumnView',
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/google-maps.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Latitude (required)', 'woodmart' ),
					'param_name' => 'lat',
					'description' => 'You can use <a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">this service</a> to get coordinates of your location'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Longitude (required)', 'woodmart' ),
					'param_name' => 'lon'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Google API key (required)', 'woodmart' ),
					'param_name' => 'google_key',
					'description' => wp_kses( __('Obtain API key <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">here</a> to use our Google Map VC element.', 'woodmart'), array(
                        'a' => array( 
                            'href' => array(), 
                            'target' => array()
                        )
                    ) )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title'
				),
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Text on marker', 'woodmart' ),
					'param_name' => 'marker_text'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Zoom', 'woodmart' ),
					'param_name' => 'zoom',
					'description' => 'Zoom level when focus the marker<br> 0 - 19'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Height', 'woodmart' ),
					'param_name' => 'height',
					'description' => 'Default: 400'
				),
				array(
					'type' => 'textarea_raw_html',
					'heading' => esc_html__( 'Styles (JSON)', 'woodmart' ),
					'param_name' => 'style_json',
					'description' => 'Styled maps allow you to customize the presentation of the standard Google base maps, changing the visual display of such elements as roads, parks, and built-up areas.<br>
You can find more Google Maps styles on the website: <a target="_blank" href="http://snazzymaps.com/">Snazzy Maps</a><br>
Just copy JSON code and paste it here<br>
For example:<br>
[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}]
					'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Zoom with mouse wheel', 'woodmart' ),
					'param_name' => 'scroll',
					'value' => array(
						'' => '',
						esc_html__( 'Yes', 'woodmart' ) => 'yes',
						esc_html__( 'No', 'woodmart' ) => 'no',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Content on the map vertical position', 'woodmart' ),
					'param_name' => 'content_vertical',
					'value' => array(
						'' => '',
						esc_html__( 'Top', 'woodmart' ) => 'top',
						esc_html__( 'Middle', 'woodmart' ) => 'middle',
						esc_html__( 'Bottom', 'woodmart' ) => 'bottom',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Content on the map horizontal position', 'woodmart' ),
					'param_name' => 'content_horizontal',
					'value' => array(
						'' => '',
						esc_html__( 'Left', 'woodmart' ) => 'left',
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Right', 'woodmart' ) => 'right',
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Content width', 'woodmart' ),
					'param_name' => 'content_width',
					'description' => 'Default: 300'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Map mask', 'woodmart' ),
					'param_name' => 'mask',
					'value' => array(
						'' => '',
						esc_html__( 'Dark', 'woodmart' ) => 'dark',
						esc_html__( 'Light', 'woodmart' ) => 'light',
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			),
		));


		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map Mega Menu shortcode
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map( array(
			'name' => esc_html__( 'Mega Menu widget', 'woodmart' ),
			'base' => 'woodmart_mega_menu',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Categories mega menu widget', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/mega-menu-widget.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Choose Menu', 'woodmart' ),
					'param_name' => 'nav_menu',
					'value' => woodmart_get_menus_array()
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Title Color', 'woodmart' ),
					'param_name' => 'color'
				),
				woodmart_get_color_scheme_param(),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			),
		));


		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map Counter shortcode
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map( array(
			'name' => esc_html__( 'Animated Counter', 'woodmart' ),
			'base' => 'woodmart_counter',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/animated-counter.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Label', 'woodmart' ),
					'param_name' => 'label'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Actual value', 'woodmart' ),
					'param_name' => 'value',
					'description' => esc_html__('Our final point. For ex.: 95', 'woodmart' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Size', 'woodmart' ),
					'param_name' => 'size',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => '',
						esc_html__( 'Small', 'woodmart' ) => 'small',
						esc_html__( 'Large', 'woodmart' ) => 'large',
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			),
		));

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map Team Member Shortcode
		 * ------------------------------------------------------------------------------------------------
		 */


		vc_map( array(
			'name' => esc_html__( 'Team Member', 'woodmart' ),
			'base' => 'team_member',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Display information about some person', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/information-box.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Name', 'woodmart' ),
					'param_name' => 'name',
					'value' => '',
					'description' => esc_html__( 'User name', 'woodmart' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'position',
					'value' => '',
					'description' => esc_html__( 'User title', 'woodmart' )
				),
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'User Avatar', 'woodmart' ),
					'param_name' => 'image',
					'value' => '',
					'description' => esc_html__( 'Select image from media library.', 'woodmart' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Image size', 'woodmart' ),
					'param_name' => 'img_size',
					'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'woodmart' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Align', 'woodmart' ),
					'param_name' => 'align',
					'value' => array(
						esc_html__( 'Left', 'woodmart' ) => 'left',
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Right', 'woodmart' ) => 'right',
					),
				),
				woodmart_get_color_scheme_param(),
				array(
					'type' => 'textarea_html',
					'heading' => esc_html__( 'Text', 'woodmart' ),
					'param_name' => 'content',
					'description' => esc_html__( 'You can add some member bio here.', 'woodmart' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Facebook link', 'woodmart' ),
					'param_name' => 'facebook',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Twitter link', 'woodmart' ),
					'param_name' => 'twitter',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Google+ link', 'woodmart' ),
					'param_name' => 'google_plus',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Linkedin link', 'woodmart' ),
					'param_name' => 'linkedin',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Skype link', 'woodmart' ),
					'param_name' => 'skype',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Instagram link', 'woodmart' ),
					'param_name' => 'instagram',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Layout', 'woodmart' ),
					'param_name' => 'layout',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'With hover', 'woodmart' ) => 'hover',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Social buttons size', 'woodmart' ),
					'param_name' => 'size',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => '',
						esc_html__( 'Small', 'woodmart' ) => 'small',
						esc_html__( 'Large', 'woodmart' ) => 'large',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Layout', 'woodmart' ),
					'param_name' => 'layout',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'With hover', 'woodmart' ) => 'hover',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Social buttons style', 'woodmart' ),
					'param_name' => 'style',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => '',
						esc_html__( 'Simple', 'woodmart' ) => 'simple',
						esc_html__( 'Colored', 'woodmart' ) => 'colored',
						esc_html__( 'Colored alternative', 'woodmart' ) => 'colored-alt',
						esc_html__( 'Bordered', 'woodmart' ) => 'bordered',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Social buttons form', 'woodmart' ),
					'param_name' => 'form',
					'value' => array(
						esc_html__( 'Circle', 'woodmart' ) => 'circle',
						esc_html__( 'Square', 'woodmart' ) => 'square',
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			),
		));



		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map WC Products widget
		 * ------------------------------------------------------------------------------------------------
		 */


		vc_map( array(
			'name' => esc_html__( 'WC products widget', 'woodmart' ),
			'base' => 'woodmart_shortcode_products_widget',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Categories mega menu widget', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/wc-product-widget.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Number of products to show', 'woodmart' ),
					'param_name' => 'number',
					'value' => array(
						1,
						2,
						3,
						4,
						5,
						6,
						7
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Show', 'woodmart' ),
					'param_name' => 'show',
					'value' => array(
						esc_html__( 'All Products', 'woodmart' ) => '',
						esc_html__( 'Featured Products', 'woodmart' ) => 'featured',
						esc_html__( 'On-sale Products', 'woodmart' ) => 'onsale',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'woodmart' ),
					'param_name' => 'orderby',
					'value' => array(
						esc_html__( 'Date', 'woodmart' ) => 'date',
						esc_html__( 'Price', 'woodmart' ) => 'price',
						esc_html__( 'Random', 'woodmart' ) => 'rand',
						esc_html__( 'Sales', 'woodmart' ) => 'sales',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order', 'woodmart' ),
					'param_name' => 'order',
					'value' => array(
						esc_html__( 'ASC', 'woodmart' ) => 'asc',
						esc_html__( 'DESC', 'woodmart' ) => 'desc',
					),
				),
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Categories', 'woodmart' ),
					'param_name' => 'ids',
					'settings' => array(
						'multiple' => true,
						'sortable' => true,
					),
					'save_always' => true,
					'description' => esc_html__( 'List of product categories', 'woodmart' ),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide free products', 'woodmart' ),
					'param_name' => 'hide_free',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show hidden products', 'woodmart' ),
					'param_name' => 'show_hidden',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				),
			),
		));

		//Filters For autocomplete param:
		//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
		add_filter( 'vc_autocomplete_woodmart_shortcode_products_widget_ids_callback', 'woodmart_productCategoryCategoryAutocompleteSuggester', 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_woodmart_shortcode_products_widget_ids_render', 'woodmart_productCategoryCategoryRenderByIdExact', 10, 1 );

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map testimonial shortcode
		 * ------------------------------------------------------------------------------------------------
		 */
		vc_map( array(
			'name' => esc_html__( 'Testimonials', 'woodmart' ),
			'base' => 'testimonials',
			"as_parent" => array('only' => 'testimonial'),
			"content_element" => true,
			"show_settings_on_create" => false,
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'User testimonials slider or grid', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/testimonials.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title',
					'value' => '',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Layout', 'woodmart' ),
					'param_name' => 'layout',
					'value' => array(
						esc_html__( 'Slider', 'woodmart' ) => 'slider',
						esc_html__( 'Grid', 'woodmart' ) => 'grid',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'style',
					'value' => array(
						esc_html__( 'Standard', 'woodmart' ) => 'standard',
						esc_html__( 'Boxed', 'woodmart' ) => 'boxed',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Align', 'woodmart' ),
					'param_name' => 'align',
					'value' => array(
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Left', 'woodmart' ) => 'left',
						esc_html__( 'Right', 'woodmart' ) => 'right',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Columns', 'woodmart' ),
					'param_name' => 'columns',
					'value' => array(
						1,2,3,4,5,6
					),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'grid' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Slides per view', 'woodmart' ),
					'param_name' => 'slides_per_view',
					'value' => array(
						1,2,3,4,5,6,7,8
					),
					'group' => 'Slider',
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'slider' ),
					),
					'description' => esc_html__( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode.', 'woodmart' )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Slider autoplay', 'woodmart' ),
					'param_name' => 'autoplay',
					'description' => esc_html__( 'Enables autoplay mode.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => 'Slider',
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'slider' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Slider speed', 'woodmart' ),
					'param_name' => 'speed',
					'value' => '5000',
					'description' => esc_html__( 'Duration of animation between slides (in ms)', 'woodmart' ),
					'group' => 'Slider',
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'slider' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide pagination control', 'woodmart' ),
					'param_name' => 'hide_pagination_control',
					'description' => esc_html__( 'If "YES" pagination control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => 'Slider',
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'slider' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide prev/next buttons', 'woodmart' ),
					'param_name' => 'hide_prev_next_buttons',
					'description' => esc_html__( 'If "YES" prev/next control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => 'Slider',
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'slider' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Slider loop', 'woodmart' ),
					'param_name' => 'wrap',
					'description' => esc_html__( 'Enables loop mode.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => 'Slider',
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'slider' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				),
			),
		    "js_view" => 'VcColumnView'
		));

		vc_map( array(
			'name' => esc_html__( 'Testimonial', 'woodmart' ),
			'base' => 'testimonial',
			'class' => '',
			"as_child" => array('only' => 'testimonials'),
			"content_element" => true,
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'User testimonial', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/testimonials.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Name', 'woodmart' ),
					'param_name' => 'name',
					'value' => '',
					'description' => esc_html__( 'User name', 'woodmart' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title',
					'value' => '',
					'description' => esc_html__( 'User title', 'woodmart' )
				),
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'User Avatar', 'woodmart' ),
					'param_name' => 'image',
					'value' => '',
					'description' => esc_html__( 'Select image from media library.', 'woodmart' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Image size', 'woodmart' ),
					'param_name' => 'img_size',
					'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'woodmart' )
				),
				array(
					'type' => 'textarea_html',
					'holder' => 'div',
					'heading' => esc_html__( 'Text', 'woodmart' ),
					'param_name' => 'content'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			)
		));

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Extra menu for mega navigation dropdown
		 * ------------------------------------------------------------------------------------------------
		 */
		vc_map( array(
			'name' => esc_html__( 'Extra menu list', 'woodmart' ),
			'base' => 'extra_menu',
			"as_parent" => array('only' => 'extra_menu_list'),
			"content_element" => true,
			"show_settings_on_create" => true,
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Create a menu list for your mega menu dropdown', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/extra-menu-list.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title',
					'value' => '',
				),
				array(
					'type' => 'vc_link',
					'heading' => esc_html__( 'Link', 'woodmart'),
					'param_name' => 'link',
					'description' => esc_html__( 'Enter URL if you want this parent menu item to have a link.', 'woodmart' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Label text (optional)', 'woodmart' ),
					'param_name' => 'label_text',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Label (optional)', 'woodmart' ),
					'param_name' => 'label',
					'value' => array(
						esc_html__( 'Primary Color', 'woodmart' ) => 'primary',
						esc_html__( 'Secondary', 'woodmart' ) => 'secondary',
						esc_html__( 'Red', 'woodmart' ) => 'red',
						esc_html__( 'Green', 'woodmart' ) => 'green',
						esc_html__( 'Blue', 'woodmart' ) => 'blue',
						esc_html__( 'Orange', 'woodmart' ) => 'orange',
						esc_html__( 'Grey', 'woodmart' ) => 'grey',
						esc_html__( 'Black', 'woodmart' ) => 'black',
						esc_html__( 'White', 'woodmart' ) => 'white',
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				),
			),
		    "js_view" => 'VcColumnView'
		));

		vc_map( array(
			'name' => esc_html__( 'Extra menu list item', 'woodmart' ),
			'base' => 'extra_menu_list',
			'class' => '',
			"as_child" => array('only' => 'extra_menu'),
			"content_element" => true,
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'A link for your extra menu list', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/extra-menu-list-item.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title',
					'value' => '',
				),
				array(
					'type' => 'vc_link',
					'heading' => esc_html__( 'Link', 'woodmart'),
					'param_name' => 'link',
					'description' => esc_html__( 'Enter URL if you want this parent menu item to have a link.', 'woodmart' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Label text (optional)', 'woodmart' ),
					'param_name' => 'label_text',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Label (optional)', 'woodmart' ),
					'param_name' => 'label',
					'value' => array(
						esc_html__( 'Primary Color', 'woodmart' ) => 'primary',
						esc_html__( 'Secondary', 'woodmart' ) => 'secondary',
						esc_html__( 'Red', 'woodmart' ) => 'red',
						esc_html__( 'Green', 'woodmart' ) => 'green',
						esc_html__( 'Blue', 'woodmart' ) => 'blue',
						esc_html__( 'Orange', 'woodmart' ) => 'orange',
						esc_html__( 'grey', 'woodmart' ) => 'grey',
						esc_html__( 'Black', 'woodmart' ) => 'black',
						esc_html__( 'White', 'woodmart' ) => 'white',
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				),
			)
		));


		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map pricing tables shortcode
		 * ------------------------------------------------------------------------------------------------
		 */
		vc_map( array(
			'name' => esc_html__( 'Pricing tables', 'woodmart' ),
			'base' => 'pricing_tables',
			"as_parent" => array('only' => 'pricing_plan'),
			"content_element" => true,
			"show_settings_on_create" => false,
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Show your pricing plans', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/pricing-tables.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			),
		    "js_view" => 'VcColumnView'
		));

		vc_map( array(
			'name' => esc_html__( 'Price plan', 'woodmart' ),
			'base' => 'pricing_plan',
			'class' => '',
			"as_child" => array('only' => 'pricing_tables'),
			"content_element" => true,
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Price option', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/price-plan.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Pricing plan name', 'woodmart' ),
					'param_name' => 'name',
					'value' => '',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Price value', 'woodmart' ),
					'param_name' => 'price_value',
					'value' => '',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Price suffix', 'woodmart' ),
					'param_name' => 'price_suffix',
					'value' => 'per month',
					'description' => esc_html__( 'For example: per month', 'woodmart' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Price currency', 'woodmart' ),
					'param_name' => 'currency',
					'value' => '',
					'description' => esc_html__( 'For example: $', 'woodmart' )
				),
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Featured list', 'woodmart' ),
					'param_name' => 'features_list',
					'description' => esc_html__( 'Start each feature text from a new line', 'woodmart' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Button type', 'woodmart' ),
					'param_name' => 'button_type',
					'value' => array(
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
						esc_html__( 'Product "add to cart"', 'woodmart' ) => 'product',
					),
					'description' => esc_html__( 'Set your custom link for button or allow users to add some product to cart', 'woodmart' )
				),
				array(
					'type' => 'vc_link',
					'heading' => esc_html__( 'Button link', 'woodmart'),
					'param_name' => 'link',
					'description' => esc_html__( 'Enter URL if you want this box to have a link.', 'woodmart' ),
					'dependency' => array(
						'element' => 'button_type',
						'value' => array( 'custom' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Button label', 'woodmart' ),
					'param_name' => 'button_label',
					'value' => '',
					'dependency' => array(
						'element' => 'button_type',
						'value' => array( 'custom' ),
					),
				),
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Select identificator', 'woodmart' ),
					'param_name' => 'id',
					'description' => esc_html__( 'Input product ID or product SKU or product title to see suggestions', 'woodmart' ),
					'dependency' => array(
						'element' => 'button_type',
						'value' => array( 'product' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Label text', 'woodmart' ),
					'param_name' => 'label',
					'value' => '',
					'description' => esc_html__( 'For example: Best option!', 'woodmart' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Label color', 'woodmart' ),
					'param_name' => 'label_color',
					'value' => array(
						'' => '',
						esc_html__( 'Red', 'woodmart' ) => 'red',
						esc_html__( 'Green', 'woodmart' ) => 'green',
						esc_html__( 'Blue', 'woodmart' ) => 'blue',
						esc_html__( 'Yellow', 'woodmart' ) => 'yellow',
					)
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Best option', 'woodmart' ),
					'param_name' => 'best_option',
					'description' => esc_html__( 'If "YES" this table will be highlighted', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'style',
					'value' => array(
						'' => '',
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Alternate', 'woodmart' ) => 'alt',
					)
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			)
		));
		// Necessary hooks for blog autocomplete fields
		add_filter( 'vc_autocomplete_pricing_plan_id_callback',	'vc_include_field_search', 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_pricing_plan_id_render', 'vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)


		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map instagram shortcode
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map(array(
			'name' => esc_html__( 'Instagram', 'woodmart' ),
			'base' => 'woodmart_instagram',
			'class' => '',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Instagram photos', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/instagram.svg',
			'params' =>  woodmart_get_instagram_params()
		));


		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map brands shortcode
		 * ------------------------------------------------------------------------------------------------
		 */


		$order_by_values = array(
			'',
			esc_html__( 'Name', 'woodmart' ) => 'name',
			esc_html__( 'Slug', 'woodmart' ) => 'slug',
			esc_html__( 'Term ID', 'woodmart' ) => 'term_id',
			esc_html__( 'ID', 'woodmart' ) => 'id',
			esc_html__( 'As IDs or slugs provided order', 'woodmart' ) => 'include',
		);

		$order_way_values = array(
			'',
			esc_html__( 'Descending', 'woodmart' ) => 'DESC',
			esc_html__( 'Ascending', 'woodmart' ) => 'ASC',
		);


		vc_map(array(
			'name' => esc_html__( 'Brands', 'woodmart' ),
			'base' => 'woodmart_brands',
			'class' => '',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Brands carousel/grid', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/brands.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Number', 'woodmart' ),
					'param_name' => 'number',
					'description' => esc_html__( 'The `number` field is used to display the number of brands.', 'woodmart' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'woodmart' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'save_always' => true,
					'description' => sprintf( wp_kses(  __( 'Select how to sort retrieved brands. More at %s.', 'woodmart' ), array(
	                        'a' => array( 
	                            'href' => array(), 
	                            'target' => array()
	                        )
                    	)), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Sort order', 'woodmart' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'save_always' => true,
					'description' => sprintf( wp_kses(  __( 'Designates the ascending or descending order. More at %s.', 'woodmart' ), array(
	                        'a' => array( 
	                            'href' => array(), 
	                            'target' => array()
	                        )
                    	)), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Image hover', 'woodmart' ),
					'param_name' => 'hover',
					'save_always' => true,
					'value' => array(
						'Default' => 'default',
						'Simple' => 'simple',
						'Alternate' => 'alt',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Brand style', 'woodmart' ),
					'param_name' => 'brand_style',
					'save_always' => true,
					'value' => array(
						'Default' => 'default',
						'Bordered' => 'bordered',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Layout', 'woodmart' ),
					'value' => 4,
					'param_name' => 'style',
					'save_always' => true,
					'value' => array(
						'Carousel' => 'carousel',
						'Grid' => 'grid',
						'Links List' => 'list',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Slides per view', 'woodmart' ),
					'param_name' => 'per_row',
					'value' => array(
						1,2,3,4,5,6,7,8
					),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'carousel' ),
					),
					'description' => esc_html__( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode.', 'woodmart' )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide pagination control', 'woodmart' ),
					'param_name' => 'hide_pagination_control',
					'description' => esc_html__( 'If "YES" pagination control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide prev/next buttons', 'woodmart' ),
					'param_name' => 'hide_prev_next_buttons',
					'description' => esc_html__( 'If "YES" prev/next control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Slider loop', 'woodmart' ),
					'param_name' => 'wrap',
					'description' => esc_html__( 'Enables loop mode.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Columns', 'woodmart' ),
					'value' => 3,
					'param_name' => 'columns',
					'save_always' => true,
					'description' => esc_html__( 'How much columns grid', 'woodmart' ),
					'value' => array(
						'',
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5,
						'6' => 6,
					),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'grid', 'list' ),
					),
				),
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Brands', 'woodmart' ),
					'param_name' => 'ids',
					'settings' => array(
						'multiple' => true,
						'sortable' => true,
					),
					'save_always' => true,
					'description' => esc_html__( 'List of product brands to show. Leave empty to show all', 'woodmart' ),
				)
			)
		));

		//Filters For autocomplete param:
		//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
		add_filter( 'vc_autocomplete_woodmart_brands_ids_callback', 'woodmart_productBrandsAutocompleteSuggester', 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_woodmart_brands_ids_render', 'woodmart_productBrandsRenderByIdExact', 10, 1 );

		if( ! function_exists( 'woodmart_productBrandsAutocompleteSuggester' ) ) {
			function woodmart_productBrandsAutocompleteSuggester( $query, $slug = false ) {
				global $wpdb;
				$cat_id = (int) $query;
				$query = trim( $query );

				$attribute = woodmart_get_opt( 'brands_attribute' );

				$post_meta_infos = $wpdb->get_results(
					$wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
								FROM {$wpdb->term_taxonomy} AS a
								INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
								WHERE a.taxonomy = '%s' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )",
								$attribute,
						$cat_id > 0 ? $cat_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

				$result = array();
				if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
					foreach ( $post_meta_infos as $value ) {
						$data = array();
						$data['value'] = $slug ? $value['slug'] : $value['id'];
						$data['label'] = esc_html__( 'Id', 'woodmart' ) . ': ' .
						                 $value['id'] .
						                 ( ( strlen( $value['name'] ) > 0 ) ? ' - ' . esc_html__( 'Name', 'woodmart' ) . ': ' .
						                                                      $value['name'] : '' ) .
						                 ( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . esc_html__( 'Slug', 'woodmart' ) . ': ' .
						                                                      $value['slug'] : '' );
						$result[] = $data;
					}
				}

				return $result;
			}
		}

		if( ! function_exists( 'woodmart_productBrandsRenderByIdExact' ) ) {
			function woodmart_productBrandsRenderByIdExact( $query ) {
				global $wpdb;
				$query = $query['value'];
				$cat_id = (int) $query;
				$attribute = woodmart_get_opt( 'brands_attribute' );
				$term = get_term( $cat_id, $attribute );

				return woodmart_productCategoryTermOutput( $term );
			}
		}

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map Author Widget shortcode
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map(array(
			'name' => esc_html__( 'Author area', 'woodmart' ),
			'base' => 'author_area',
			'class' => '',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Widget for author information', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/author-area.svg',
			'params' =>  woodmart_get_author_area_params()
		));

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map promo banner shortcode
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map(array(
			'name' => esc_html__( 'Promo Banner', 'woodmart' ),
			'base' => 'promo_banner',
			'class' => '',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Promo image with text and hover effect', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/promo-banner.svg',
			'params' =>  woodmart_get_banner_params()
		));

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map banners carousel shortcode
		 * ------------------------------------------------------------------------------------------------
		 */
		vc_map( array(
			'name' => esc_html__( 'Banners carousel', 'woodmart' ),
			'base' => 'banners_carousel',
			"as_parent" => array('only' => 'promo_banner'),
			"content_element" => true,
			"show_settings_on_create" => true,
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Show your banners as a carousel', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/banners-carousel.svg',
			'params' => array(
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Slides per view', 'woodmart' ),
					'param_name' => 'slides_per_view',
					'value' => array(
						1,2,3,4,5,6,7,8
					),
					'description' => esc_html__( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode.', 'woodmart' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Slider spacing', 'woodmart' ),
					'param_name' => 'slider_spacing',
					'value' => array(
						30,20,10,6,2,0
					),

					'description' => esc_html__( 'Set the interval numbers that you want to display between slider items.', 'woodmart' )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Slider autoplay', 'woodmart' ),
					'param_name' => 'autoplay',
					'description' => esc_html__( 'Enables autoplay mode.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Slider speed', 'woodmart' ),
					'param_name' => 'speed',
					'value' => '5000',
					'description' => esc_html__( 'Duration of animation between slides (in ms)', 'woodmart' ),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide pagination control', 'woodmart' ),
					'param_name' => 'hide_pagination_control',
					'description' => esc_html__( 'If "YES" pagination control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide prev/next buttons', 'woodmart' ),
					'param_name' => 'hide_prev_next_buttons',
					'description' => esc_html__( 'If "YES" prev/next control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Slider loop', 'woodmart' ),
					'param_name' => 'wrap',
					'description' => esc_html__( 'Enables loop mode.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				),
			),
		    "js_view" => 'VcColumnView'
		));


		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map 3D view slider
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map(array(
			'name' => esc_html__( '360 degree view', 'woodmart' ),
			'base' => 'woodmart_3d_view',
			'class' => '',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Showcase your product as 3D model', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/360-degree.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title',
				),
				array(
					'type' => 'attach_images',
					'heading' => esc_html__( 'Images', 'woodmart' ),
					'param_name' => 'images',
					'value' => '',
					'description' => esc_html__( 'Select images from media library.', 'woodmart' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			)
		));


		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map images gallery shortcode
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map(array(
			'name' => esc_html__( 'Images gallery', 'woodmart' ),
			'base' => 'woodmart_gallery',
			'class' => '',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Images grid/carousel', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/images-gallery.svg',
			'params' => array(
				array(
					'type' => 'attach_images',
					'heading' => esc_html__( 'Images', 'woodmart' ),
					'param_name' => 'images',
					'value' => '',
					'description' => esc_html__( 'Select images from media library.', 'woodmart' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Image size', 'woodmart' ),
					'param_name' => 'img_size',
					'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'woodmart' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'View', 'woodmart' ),
					'value' => 4,
					'param_name' => 'view',
					'save_always' => true,
					'value' => array(
						'Default grid' => 'grid',
						'Masonry grid' => 'masonry',
						'Carousel' => 'carousel',
						'Justified gallery' => 'justified',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Space between images', 'woodmart' ),
					'param_name' => 'spacing',
					'value' => array(
						0, 2, 6, 10, 20, 30
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Slides per view', 'woodmart' ),
					'param_name' => 'slides_per_view',
					'value' => array(
						1,2,3,4,5,6,7,8
					),
					'dependency' => array(
						'element' => 'view',
						'value' => array( 'carousel' ),
					),
					'description' => esc_html__( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode.', 'woodmart' )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide pagination control', 'woodmart' ),
					'param_name' => 'hide_pagination_control',
					'description' => esc_html__( 'If "YES" pagination control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'dependency' => array(
						'element' => 'view',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide prev/next buttons', 'woodmart' ),
					'param_name' => 'hide_prev_next_buttons',
					'description' => esc_html__( 'If "YES" prev/next control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'dependency' => array(
						'element' => 'view',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Slider loop', 'woodmart' ),
					'param_name' => 'wrap',
					'description' => esc_html__( 'Enables loop mode.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'dependency' => array(
						'element' => 'view',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Columns', 'woodmart' ),
					'value' => 3,
					'param_name' => 'columns',
					'save_always' => true,
					'description' => esc_html__( 'How much columns grid', 'woodmart' ),
					'value' => array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'6' => 6,
					),
					'dependency' => array(
						'element' => 'view',
						'value' => array( 'grid', 'masonry' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'On click action', 'woodmart' ),
					'param_name' => 'on_click',
					'value' => array(
						'' => '',
						'Lightbox' => 'lightbox',
						'Custom link' => 'links',
						'None' => 'none'
					)
				),
				array(
					'type' => 'exploded_textarea_safe',
					'heading' => esc_html__( 'Custom links', 'woodmart' ),
					'param_name' => 'custom_links',
					'description' => esc_html__( 'Enter links for each slide (Note: divide links with linebreaks (Enter)).', 'woodmart' ),
					'dependency' => array(
						'element' => 'on_click',
						'value' => array( 'links' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Open in new tab', 'woodmart' ),
					'save_always' => true,
					'param_name' => 'target_blank',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'default' => 'yes',
					'dependency' => array(
						'element' => 'on_click',
						'value' => array( 'links' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Show captions on in lightbox', 'woodmart' ),
					'save_always' => true,
					'param_name' => 'caption',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'default' => 'yes'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			)
		));

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map menu price element
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map(array(
			'name' => esc_html__( 'Menu price', 'woodmart' ),
			'base' => 'woodmart_menu_price',
			'class' => '',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Showcase your menu', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/menu-price.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Description', 'woodmart' ),
					'param_name' => 'description',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Price', 'woodmart' ),
					'param_name' => 'price',
				),
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Image', 'woodmart' ),
					'param_name' => 'img_id',
					'value' => '',
					'description' => esc_html__( 'Select images from media library.', 'woodmart' )
				),
				array(
					'type' => 'vc_link',
					'heading' => esc_html__( 'Link', 'woodmart'),
					'param_name' => 'link',
					'description' => esc_html__( 'Enter URL if you want this box to have a link.', 'woodmart' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			)
		));


		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map countdown timer
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map(array(
			'name' => esc_html__( 'Countdown timer', 'woodmart' ),
			'base' => 'woodmart_countdown_timer',
			'class' => '',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Shows countdown timer', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/countdown-timer.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Date', 'woodmart' ),
					'param_name' => 'date',
					'description' => esc_html__( 'Final date in the format Y/m/d. For example 2017/12/12', 'woodmart' )
				),
				woodmart_get_color_scheme_param(),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Size', 'woodmart' ),
					'param_name' => 'size',
					'value' => array(
						'' => '',
						esc_html__( 'Small', 'woodmart' ) => 'small',
						esc_html__( 'Medium', 'woodmart' ) => 'medium',
						esc_html__( 'Large', 'woodmart' ) => 'large',
						esc_html__( 'Extra Large', 'woodmart' ) => 'xlarge',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Align', 'woodmart' ),
					'param_name' => 'align',
					'value' => array(
						'' => '',
						esc_html__( 'left', 'woodmart' ) => 'left',
						esc_html__( 'center', 'woodmart' ) => 'center',
						esc_html__( 'right', 'woodmart' ) => 'right',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'style',
					'value' => array(
						'' => '',
						esc_html__( 'Standard', 'woodmart' ) => 'standard',
						esc_html__( 'Transparent', 'woodmart' ) => 'transparent',
						esc_html__( 'Primary color', 'woodmart' ) => 'active',
					)
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			)
		));

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Information box with image (icon)
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map(array(
			'name' => esc_html__( 'Information box', 'woodmart' ),
			'base' => 'woodmart_info_box',
			'class' => '',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Show some brief information', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/information-box.svg',
			'params' => array(
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Icon type', 'woodmart' ),
					'param_name' => 'icon_type',
					'value' => array(
						esc_html__( 'Icon', 'woodmart' ) => 'icon',
						esc_html__( 'Text', 'woodmart' ) => 'text',
					),
				),
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Image', 'woodmart' ),
					'param_name' => 'image',
					'value' => '',
					'description' => esc_html__( 'Select image from media library.', 'woodmart' ),
					'dependency' => array(
						'element' => 'icon_type',
						'value' => array( 'icon' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Image size', 'woodmart' ),
					'param_name' => 'img_size',
					'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'woodmart' ),
					'dependency' => array(
						'element' => 'icon_type',
						'value' => array( 'icon' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Icon text', 'woodmart' ),
					'param_name' => 'icon_text',
					'dependency' => array(
						'element' => 'icon_type',
						'value' => array( 'text' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Icon text size', 'woodmart' ),
					'param_name' => 'icon_text_size',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Small', 'woodmart' ) => 'small',
						esc_html__( 'Large', 'woodmart' ) => 'large',
					),
					'dependency' => array(
						'element' => 'icon_type',
						'value' => array( 'text' ),
					),
				),
				array(
					'type' => 'vc_link',
					'heading' => esc_html__( 'Link', 'woodmart'),
					'param_name' => 'link',
					'description' => esc_html__( 'Enter URL if you want this box to have a link.', 'woodmart' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Button text', 'woodmart' ),
					'param_name' => 'btn_text',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Button position', 'woodmart' ),
					'param_name' => 'btn_position',
					'value' => array(
						esc_html__( 'Show on hover', 'woodmart' ) => 'hover',
						esc_html__( 'Static', 'woodmart' ) => 'static',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Button color', 'woodmart' ),
					'param_name' => 'btn_color',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Primary color', 'woodmart' ) => 'primary',
						esc_html__( 'Alternative color', 'woodmart' ) => 'alt',
						esc_html__( 'Black', 'woodmart' ) => 'black',
						esc_html__( 'White', 'woodmart' ) => 'white',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Button style', 'woodmart' ),
					'param_name' => 'btn_style',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Bordered', 'woodmart' ) => 'bordered',
						esc_html__( 'Link button', 'woodmart' ) => 'link',
						esc_html__( 'Round', 'woodmart' ) => 'round',
						esc_html__( '3D', 'woodmart' ) => '3d',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Button size', 'woodmart' ),
					'param_name' => 'btn_size',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Extra Small', 'woodmart' ) => 'extra-small',
						esc_html__( 'Small', 'woodmart' ) => 'small',
						esc_html__( 'Large', 'woodmart' ) => 'large',
						esc_html__( 'Extra Large', 'woodmart' ) => 'extra-large',
					),
				),
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title',
					'holder' => 'div',
				),
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Sub title', 'woodmart' ),
					'param_name' => 'subtitle'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Subtitle color', 'woodmart' ),
					'param_name' => 'subtitle_color',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Primary', 'woodmart' ) => 'primary',
						esc_html__( 'Alternative', 'woodmart' ) => 'alt',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Subtitle style', 'woodmart' ),
					'param_name' => 'subtitle_style',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Background', 'woodmart' ) => 'background',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Title size', 'woodmart' ),
					'param_name' => 'title_size',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Small', 'woodmart' ) => 'small',
						esc_html__( 'Large', 'woodmart' ) => 'large',
						esc_html__( 'Extra Large', 'woodmart' ) => 'extra-large',
					),
				),
				array(
					'type' => 'textarea_html',
					'holder' => 'div',
					'heading' => esc_html__( 'Brief content', 'woodmart' ),
					'param_name' => 'content',
					'description' => esc_html__( 'Add here few words to your banner image.', 'woodmart' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Text alignment', 'woodmart' ),
					'param_name' => 'alignment',
					'value' => array(
						esc_html__( 'Align left', 'woodmart' ) => '',
						esc_html__( 'Align right', 'woodmart' ) => 'right',
						esc_html__( 'Align center', 'woodmart' ) => 'center'
					),
					'description' => esc_html__( 'Select image alignment.', 'woodmart' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Image alignment', 'woodmart' ),
					'param_name' => 'image_alignment',
					'value' => array(
						esc_html__( 'Top', 'woodmart' ) => 'top',
						esc_html__( 'Left', 'woodmart' ) => 'left',
						esc_html__( 'Right', 'woodmart' ) => 'right'
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Box style', 'woodmart' ),
					'param_name' => 'style',
					'value' => array(
						esc_html__( 'Base', 'woodmart' ) => 'base',
						esc_html__( 'Bordered', 'woodmart' ) => 'border',
						esc_html__( 'Shadow', 'woodmart' ) => 'shadow',
					)
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'SVG animation', 'woodmart' ),
					'param_name' => 'svg_animation',
					'description' => esc_html__( 'By default, your SVG files will be not animated. If you want you can activate the animation.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
				),
				woodmart_get_color_scheme_param(),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Information box inline', 'woodmart' ),
					'param_name' => 'info_box_inline',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
				),
				array(
					'type' => 'css_editor',
					'heading' => esc_html__( 'CSS box', 'woodmart' ),
					'param_name' => 'css',
					'group' => esc_html__( 'Design Options', 'woodmart' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			)
		));

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Add options to columns and text block
		 * ------------------------------------------------------------------------------------------------
		 */

		add_action( 'init', 'woodmart_update_vc_column');

		if( ! function_exists( 'woodmart_update_vc_column' ) ) {
			function woodmart_update_vc_column() {
				if(!function_exists('vc_map')) return;
				vc_remove_param( 'vc_column', 'el_class' );

		        vc_add_param( 'vc_column', woodmart_get_color_scheme_param() );

		        vc_add_param( 'vc_column', array(
					'type' => 'checkbox',
					'group' => esc_html__( 'Woodmart Extras', 'woodmart' ),
					'heading' => esc_html__( 'Enable sticky column', 'woodmart' ),
		            'description' => esc_html__( 'Also enable equal columns height for the parent row to make it work', 'woodmart' ),
					'param_name' => 'woodmart_sticky_column'
				) );
		        vc_add_param( 'vc_column', array(
		            'type' => 'textfield',
		            'heading' => esc_html__( 'Extra class name', 'woodmart' ),
		            'param_name' => 'el_class',
		            'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
		        ) );

				vc_remove_param( 'vc_column_text', 'el_class' );

		        vc_add_param( 'vc_column_text', woodmart_get_color_scheme_param() );

		        vc_add_param( 'vc_column_text', array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Text larger', 'woodmart' ),
					'param_name' => 'text_larger',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
				) );

		        vc_add_param( 'vc_column_text', array(
		            'type' => 'textfield',
		            'heading' => esc_html__( 'Extra class name', 'woodmart' ),
		            'param_name' => 'el_class',
		            'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
		        ) );
			}
		}


		/**
		 * ------------------------------------------------------------------------------------------------
		 * Add new element to VC: Categories [woodmart_categories]
		 * ------------------------------------------------------------------------------------------------
		 */


		$order_by_values = array(
			'',
			esc_html__( 'Date', 'woodmart' ) => 'date',
			esc_html__( 'ID', 'woodmart' ) => 'ID',
			esc_html__( 'Author', 'woodmart' ) => 'author',
			esc_html__( 'Title', 'woodmart' ) => 'title',
			esc_html__( 'Modified', 'woodmart' ) => 'modified',
			esc_html__( 'Comment count', 'woodmart' ) => 'comment_count',
			esc_html__( 'Menu order', 'woodmart' ) => 'menu_order',
			esc_html__( 'As IDs or slugs provided order', 'woodmart' ) => 'include',
		);

		$order_way_values = array(
			'',
			esc_html__( 'Descending', 'woodmart' ) => 'DESC',
			esc_html__( 'Ascending', 'woodmart' ) => 'ASC',
		);

		vc_map( array(
			'name' => esc_html__( 'Product categories', 'woodmart' ),
			'base' => 'woodmart_categories',
			'class' => '',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Product categories grid', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/product-categories.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Number', 'woodmart' ),
					'param_name' => 'number',
					'description' => esc_html__( 'The `number` field is used to display the number of categories.', 'woodmart' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'woodmart' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'save_always' => true,
					'description' => sprintf( wp_kses(  __( 'Select how to sort retrieved categories. More at %s.', 'woodmart' ), array(
	                        'a' => array( 
	                            'href' => array(), 
	                            'target' => array()
	                        )
                    	)), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Sort order', 'woodmart' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'save_always' => true,
					'description' => sprintf( wp_kses(  __( 'Designates the ascending or descending order. More at %s.', 'woodmart' ), array(
	                        'a' => array( 
	                            'href' => array(), 
	                            'target' => array()
	                        )
                    	)), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Layout', 'woodmart' ),
					'value' => 4,
					'param_name' => 'style',
					'save_always' => true,
					'description' => esc_html__( 'Try out our creative styles for categories block', 'woodmart' ),
					'value' => array(
						'Default' => 'default',
						'Masonry' => 'masonry',
						'Masonry (with first wide)' => 'masonry-first',
						'Carousel' => 'carousel',
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Categories design', 'woodmart' ),
					'description' => esc_html__( 'Overrides option from Theme Settings -> Shop', 'woodmart' ),
					'param_name' => 'categories_design',
					'value' => array_merge( array( 'Inherit' => '' ), array_flip( woodmart_get_config( 'categories-designs' ) ) ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Space between categories', 'woodmart' ),
					'param_name' => 'spacing',
					'value' => array(
						30,20,10,6,2,0
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Slides per view', 'woodmart' ),
					'param_name' => 'slides_per_view',
					'value' => array(
						1,2,3,4,5,6,7,8
					),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'carousel' ),
					),
					'description' => esc_html__( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode.', 'woodmart' )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide pagination control', 'woodmart' ),
					'param_name' => 'hide_pagination_control',
					'description' => esc_html__( 'If "YES" pagination control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide prev/next buttons', 'woodmart' ),
					'param_name' => 'hide_prev_next_buttons',
					'description' => esc_html__( 'If "YES" prev/next control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Slider loop', 'woodmart' ),
					'param_name' => 'wrap',
					'description' => esc_html__( 'Enables loop mode.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Columns', 'woodmart' ),
					'value' => 4,
					'param_name' => 'columns',
					'save_always' => true,
					'description' => esc_html__( 'How much columns grid', 'woodmart' ),
					'value' => array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'6' => 6,
					),
					'dependency' => array(
						'element' => 'style',
						'value' => array( 'masonry', 'default' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide empty', 'woodmart' ),
					'param_name' => 'hide_empty',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'std'         => 'yes',
				),
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Categories', 'woodmart' ),
					'param_name' => 'ids',
					'settings' => array(
						'multiple' => true,
						'sortable' => true,
					),
					'save_always' => true,
					'description' => esc_html__( 'List of product categories', 'woodmart' ),
				)
			)
		) );

		//Filters For autocomplete param:
		//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
		add_filter( 'vc_autocomplete_woodmart_categories_ids_callback', 'woodmart_productCategoryCategoryAutocompleteSuggester', 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_woodmart_categories_ids_render', 'woodmart_productCategoryCategoryRenderByIdExact', 10, 1 );

		if( ! function_exists( 'woodmart_productCategoryCategoryAutocompleteSuggester' ) ) {
			function woodmart_productCategoryCategoryAutocompleteSuggester( $query, $slug = false ) {
				global $wpdb;
				$cat_id = (int) $query;
				$query = trim( $query );
				$post_meta_infos = $wpdb->get_results(
					$wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
								FROM {$wpdb->term_taxonomy} AS a
								INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
								WHERE a.taxonomy = 'product_cat' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )",
						$cat_id > 0 ? $cat_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

				$result = array();
				if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
					foreach ( $post_meta_infos as $value ) {
						$data = array();
						$data['value'] = $slug ? $value['slug'] : $value['id'];
						$data['label'] = esc_html__( 'Id', 'woodmart' ) . ': ' .
						                 $value['id'] .
						                 ( ( strlen( $value['name'] ) > 0 ) ? ' - ' . esc_html__( 'Name', 'woodmart' ) . ': ' .
						                                                      $value['name'] : '' ) .
						                 ( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . esc_html__( 'Slug', 'woodmart' ) . ': ' .
						                                                      $value['slug'] : '' );
						$result[] = $data;
					}
				}

				return $result;
			}
		}
		if( ! function_exists( 'woodmart_productCategoryCategoryRenderByIdExact' ) ) {
			function woodmart_productCategoryCategoryRenderByIdExact( $query ) {
				global $wpdb;
				$query = $query['value'];
				$cat_id = (int) $query;
				$term = get_term( $cat_id, 'product_cat' );

				return woodmart_productCategoryTermOutput( $term );
			}
		}

		if( ! function_exists( 'woodmart_productCategoryTermOutput' ) ) {
			function woodmart_productCategoryTermOutput( $term ) {
				$term_slug = $term->slug;
				$term_title = $term->name;
				$term_id = $term->term_id;

				$term_slug_display = '';
				if ( ! empty( $term_sku ) ) {
					$term_slug_display = ' - ' . esc_html__( 'Sku', 'woodmart' ) . ': ' . $term_slug;
				}

				$term_title_display = '';
				if ( ! empty( $product_title ) ) {
					$term_title_display = ' - ' . esc_html__( 'Title', 'woodmart' ) . ': ' . $term_title;
				}

				$term_id_display = esc_html__( 'Id', 'woodmart' ) . ': ' . $term_id;

				$data = array();
				$data['value'] = $term_id;
				$data['label'] = $term_id_display . $term_title_display . $term_slug_display;

				return ! empty( $data ) ? $data : false;
			}
		}

		/**
		 * ------------------------------------------------------------------------------------------------
		 * Add new element to VC: Products [woodmart_products]
		 * ------------------------------------------------------------------------------------------------
		 */

		vc_map( woodmart_get_products_shortcode_map_params() );

		// Necessary hooks for blog autocomplete fields
		add_filter( 'vc_autocomplete_woodmart_products_include_callback',	'vc_include_field_search', 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_woodmart_products_include_render',
			'vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)

		// Narrow data taxonomies
		add_filter( 'vc_autocomplete_woodmart_products_taxonomies_callback', 'woodmart_vc_autocomplete_taxonomies_field_search', 10, 1 );
		add_filter( 'vc_autocomplete_woodmart_products_taxonomies_render', 'woodmart_vc_autocomplete_taxonomies_field_render', 10, 1 );

		// Narrow data taxonomies for exclude_filter
		add_filter( 'vc_autocomplete_woodmart_products_exclude_filter_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
		add_filter( 'vc_autocomplete_woodmart_products_exclude_filter_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

		add_filter( 'vc_autocomplete_woodmart_products_exclude_callback',	'vc_exclude_field_search', 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_woodmart_products_exclude_render', 'vc_exclude_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)


		/**
		 * ------------------------------------------------------------------------------------------------
		 * Map products tabs shortcode
		 * ------------------------------------------------------------------------------------------------
		 */
		vc_map( array(
			'name' => esc_html__( 'AJAX Products tabs', 'woodmart' ),
			'base' => 'products_tabs',
			"as_parent" => array('only' => 'products_tab'),
			"content_element" => true,
			"show_settings_on_create" => true,
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Product tabs for your marketplace', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/ajax-products-tabs.svg',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title',
				),
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Icon image', 'woodmart' ),
					'param_name' => 'image',
					'value' => '',
					'description' => esc_html__( 'Select image from media library.', 'woodmart' )
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Tabs color', 'woodmart' ),
					'param_name' => 'color'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Design', 'woodmart' ),
					'param_name' => 'design',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Simple', 'woodmart' ) => 'simple',
					)
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			),
		    "js_view" => 'VcColumnView'
		));

		$woodmart_prdoucts_params = vc_map_integrate_shortcode( woodmart_get_products_shortcode_map_params(), '', '', array(
			'exclude' => array(
			),
		));

		vc_map( array(
			'name' => esc_html__( 'Products tab', 'woodmart' ),
			'base' => 'products_tab',
			'class' => '',
			"as_child" => array('only' => 'products_tabs'),
			"content_element" => true,
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Products block', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/product-categories.svg',
			'params' => array_merge( array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title for the tab', 'woodmart' ),
					'param_name' => 'title',
					'value' => '',
				)
			), $woodmart_prdoucts_params )
		));

		// Necessary hooks for blog autocomplete fields
		add_filter( 'vc_autocomplete_products_tab_include_callback',	'vc_include_field_search', 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_products_tab_include_render',
			'vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)

		// Narrow data taxonomies
		add_filter( 'vc_autocomplete_products_tab_taxonomies_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
		add_filter( 'vc_autocomplete_products_tab_taxonomies_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

		// Narrow data taxonomies for exclude_filter
		add_filter( 'vc_autocomplete_products_tab_exclude_filter_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
		add_filter( 'vc_autocomplete_products_tab_exclude_filter_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

		add_filter( 'vc_autocomplete_products_tab_exclude_callback',	'vc_exclude_field_search', 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_products_tab_exclude_render', 'vc_exclude_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)



		/**
		 * ------------------------------------------------------------------------------------------------
		 * Update images carousel parameters
		 * ------------------------------------------------------------------------------------------------
		 */
		add_action( 'init', 'woodmart_update_vc_images_carousel');

		if( ! function_exists( 'woodmart_update_vc_images_carousel' ) ) {
			function woodmart_update_vc_images_carousel() {
				if(!function_exists('vc_map')) return;
				vc_remove_param( 'vc_images_carousel', 'mode' );
				vc_remove_param( 'vc_images_carousel', 'partial_view' );
				vc_remove_param( 'vc_images_carousel', 'el_class' );

		        vc_add_param( 'vc_images_carousel', array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Add spaces between images', 'woodmart' ),
					'param_name' => 'spaces',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' )
				) );

		        vc_add_param( 'vc_images_carousel', array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Specific design', 'woodmart' ),
					'param_name' => 'design',
		            'description' => esc_html__( 'With this option your gallery will be styled in a different way, and sizes will be changed.', 'woodmart' ),
					'value' => array(
						'' => 'none',
						esc_html__( 'Iphone', 'woodmart' ) => 'iphone',
						esc_html__( 'MacBook', 'woodmart' ) => 'macbook',
					)
				) );

		        vc_add_param( 'vc_images_carousel', array(
		            'type' => 'textfield',
		            'heading' => esc_html__( 'Extra class name', 'woodmart' ),
		            'param_name' => 'el_class',
		            'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
		        ) );
			}
		}

	}
}


if( ! function_exists( 'woodmart_get_button_shortcode_params' ) ) {
	function woodmart_get_button_shortcode_params() {
		return apply_filters( 'woodmart_get_button_shortcode_params', array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title'
				),
				array(
					'type' => 'vc_link',
					'heading' => esc_html__( 'Link', 'woodmart' ),
					'param_name' => 'link'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Button color', 'woodmart' ),
					'param_name' => 'color',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Primary color', 'woodmart' ) => 'primary',
						esc_html__( 'Alternative color', 'woodmart' ) => 'alt',
						esc_html__( 'Black', 'woodmart' ) => 'black',
						esc_html__( 'White', 'woodmart' ) => 'white',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Button style', 'woodmart' ),
					'param_name' => 'style',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Bordered', 'woodmart' ) => 'bordered',
						esc_html__( 'Link button', 'woodmart' ) => 'link',
						esc_html__( 'Round', 'woodmart' ) => 'round',
						esc_html__( '3D', 'woodmart' ) => '3d',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Button size', 'woodmart' ),
					'param_name' => 'size',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Extra Small', 'woodmart' ) => 'extra-small',
						esc_html__( 'Small', 'woodmart' ) => 'small',
						esc_html__( 'Large', 'woodmart' ) => 'large',
						esc_html__( 'Extra Large', 'woodmart' ) => 'extra-large',
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Full width', 'woodmart' ),
					'param_name' => 'full_width',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Button inline', 'woodmart' ),
					'param_name' => 'button_inline',
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Align', 'woodmart' ),
					'param_name' => 'align',
					'value' => array(
						'' => '',
						esc_html__( 'left', 'woodmart' ) => 'left',
						esc_html__( 'center', 'woodmart' ) => 'center',
						esc_html__( 'right', 'woodmart' ) => 'right',
					),
					'dependency' => array(
						'element' => 'button_inline',
						'value_not_equal_to' => array( 'yes' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			)
		);
	}
}


if( ! function_exists( 'woodmart_get_products_shortcode_params' ) ) {
	function woodmart_get_products_shortcode_map_params() {
		return array(
			'name' => esc_html__( 'Products (grid or carousel)', 'woodmart' ),
			'base' => 'woodmart_products',
			'class' => '',
			'category' => esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Animated carousel with posts', 'woodmart' ),
        	'icon'            => WOODMART_ASSETS . '/images/vc-icon/products-grid-or-carousel.svg',
			'params' => woodmart_get_products_shortcode_params()
		);
	}
}

if( ! function_exists( 'woodmart_get_products_shortcode_params' ) ) {
	function woodmart_get_products_shortcode_params() {
		return apply_filters( 'woodmart_get_products_shortcode_params', array(
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Grid or carousel', 'woodmart' ),
					'param_name' => 'layout',
					'value' =>  array(
						array( 'grid', esc_html__( 'Grid', 'woodmart' ) ),
						array( 'carousel', esc_html__( 'Carousel', 'woodmart' ) ),

					),
					'description' => esc_html__( 'Show products in standard grid or via slider carousel', 'woodmart' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Data source', 'woodmart' ),
					'param_name' => 'post_type',
					'value' =>  array(
						array( 'product', esc_html__( 'All Products', 'woodmart' ) ),
						array( 'featured', esc_html__( 'Featured Products', 'woodmart' ) ),
						array( 'sale', esc_html__( 'Sale Products', 'woodmart' ) ),
						array( 'bestselling', esc_html__( 'Bestsellers', 'woodmart' ) ),
						array( 'ids', esc_html__( 'List of IDs', 'woodmart' ) )

					),
					'description' => esc_html__( 'Select content type for your grid.', 'woodmart' )
				),
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Include only', 'woodmart' ),
					'param_name' => 'include',
					'description' => esc_html__( 'Add products by title.', 'woodmart' ),
					'settings' => array(
						'multiple' => true,
						'sortable' => true,
						'groups' => true,
					),
					'dependency' => array(
						'element' => 'post_type',
						'value' => array( 'ids' ),
					),
				),
				// Custom query tab
				array(
					'type' => 'textarea_safe',
					'heading' => esc_html__( 'Custom query', 'woodmart' ),
					'param_name' => 'custom_query',
					'description' => wp_kses(  __( 'Build custom query according to <a href="http://codex.wordpress.org/Function_Reference/query_posts">WordPress Codex</a>.', 'woodmart' ), array(
	                        'a' => array( 
	                            'href' => array(), 
	                            'target' => array()
	                        )
                    	)),
					'dependency' => array(
						'element' => 'post_type',
						'value' => array( 'custom' ),
					),
				),
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Categories or tags', 'woodmart' ),
					'param_name' => 'taxonomies',
					'settings' => array(
						'multiple' => true,
						// is multiple values allowed? default false
						// 'sortable' => true, // is values are sortable? default false
						'min_length' => 1,
						// min length to start search -> default 2
						// 'no_hide' => true, // In UI after select doesn't hide an select list, default false
						'groups' => true,
						// In UI show results grouped by groups, default false
						'unique_values' => true,
						// In UI show results except selected. NB! You should manually check values in backend, default false
						'display_inline' => true,
						// In UI show results inline view, default false (each value in own line)
						'delay' => 500,
						// delay for search. default 500
						'auto_focus' => true,
						// auto focus input, default true
					),
					'param_holder_class' => 'vc_not-for-custom',
					'description' => esc_html__( 'Enter categories, tags or custom taxonomies.', 'woodmart' ),
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Items per page', 'woodmart' ),
					'param_name' => 'items_per_page',
					'description' => esc_html__( 'Number of items to show per page.', 'woodmart' ),
					'value' => '10',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Pagination', 'woodmart' ),
					'param_name' => 'pagination',
					'value' => array(
	                    '' => '',
	                    '"Load more" button' => 'more-btn',
	                    'Infinit scrolling' => 'infinit',
	                    'Arrows' => 'arrows',
					),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'grid' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__('Masonry grid', 'woodmart'), 
					'param_name' => 'products_masonry',
					'description' => esc_html__('Products may have different sizes', 'woodmart'),
					'value' => array(
	                    '' => '',
	                    'Enable' => 'enable',
	                    'Disable' => 'disable',
					),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'grid' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__('Products grid with different sizes', 'woodmart'), 
					'param_name' => 'products_different_sizes',
					'value' => array(
	                    '' => '',
	                    'Enable' => 'enable',
	                    'Disable' => 'disable',
					),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'grid' ),
					),
				),
				// Design settings
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Products hover', 'woodmart' ),
					'param_name' => 'product_hover',
					'value' => array_merge( array( 'Inherit' => '' ), array_flip( woodmart_get_config( 'product-hovers' ) ) ),
					'group' => esc_html__( 'Design', 'woodmart' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Columns', 'woodmart' ),
					'param_name' => 'columns',
					'value' => array(
						2, 3, 4, 6
					),
					'description' => esc_html__( 'Columns', 'woodmart' ),
					'group' => esc_html__( 'Design', 'woodmart' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'grid' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Space between products', 'woodmart' ),
					'param_name' => 'spacing',
					'value' => array(
						'', 30,20,10,6,2,0
					),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'grid' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Images size', 'woodmart' ),
					'group' => esc_html__( 'Design', 'woodmart' ),
					'param_name' => 'img_size',
					'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'woodmart' )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Sale countdown', 'woodmart' ),
					'description' => esc_html__( 'Countdown to the end sale date will be shown. Be sure you have set final date of the product sale price.', 'woodmart' ),
					'param_name' => 'sale_countdown',
					'value' => 1,
					'group' => esc_html__( 'Design', 'woodmart' ),
				),
				// Carousel settings
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Slider speed', 'woodmart' ),
					'param_name' => 'speed',
					'value' => '5000',
					'description' => esc_html__( 'Duration of animation between slides (in ms)', 'woodmart' ),
					'group' => esc_html__( 'Carousel Settings', 'woodmart' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Slides per view', 'woodmart' ),
					'param_name' => 'slides_per_view',
					'value' => array(
						1,2,3,4,5,6,7,8
					),
					'description' => esc_html__( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode. Also supports for "auto" value, in this case it will fit slides depending on container\'s width. "auto" mode doesn\'t compatible with loop mode.', 'woodmart' ),
					'group' => esc_html__( 'Carousel Settings', 'woodmart' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Scroll per page', 'woodmart' ),
					'param_name' => 'scroll_per_page',
					'description' => esc_html__( 'Scroll per page not per item. This affect next/prev buttons and mouse/touch dragging.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => esc_html__( 'Carousel Settings', 'woodmart' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Slider autoplay', 'woodmart' ),
					'param_name' => 'autoplay',
					'description' => esc_html__( 'Enables autoplay mode.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => esc_html__( 'Carousel Settings', 'woodmart' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide pagination control', 'woodmart' ),
					'param_name' => 'hide_pagination_control',
					'description' => esc_html__( 'If "YES" pagination control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => esc_html__( 'Carousel Settings', 'woodmart' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Hide prev/next buttons', 'woodmart' ),
					'param_name' => 'hide_prev_next_buttons',
					'description' => esc_html__( 'If "YES" prev/next control will be removed', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => esc_html__( 'Carousel Settings', 'woodmart' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'carousel' ),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Slider loop', 'woodmart' ),
					'param_name' => 'wrap',
					'description' => esc_html__( 'Enables loop mode.', 'woodmart' ),
					'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
					'group' => esc_html__( 'Carousel Settings', 'woodmart' ),
					'dependency' => array(
						'element' => 'layout',
						'value' => array( 'carousel' ),
					),
				),
				// Data settings
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'woodmart' ),
					'param_name' => 'orderby',
					'value' => array(
						'',
						esc_html__( 'Date', 'woodmart' ) => 'date',
						esc_html__( 'Order by post ID', 'woodmart' ) => 'ID',
						esc_html__( 'Author', 'woodmart' ) => 'author',
						esc_html__( 'Title', 'woodmart' ) => 'title',
						esc_html__( 'Last modified date', 'woodmart' ) => 'modified',
						esc_html__( 'Number of comments', 'woodmart' ) => 'comment_count',
						esc_html__( 'Menu order/Page Order', 'woodmart' ) => 'menu_order',
						esc_html__( 'Meta value', 'woodmart' ) => 'meta_value',
						esc_html__( 'Meta value number', 'woodmart' ) => 'meta_value_num',
						esc_html__( 'Matches same order you passed in via the include parameter.', 'woodmart') => 'post__in',
						esc_html__( 'Random order', 'woodmart' ) => 'rand',
						esc_html__( 'Price', 'woodmart' ) => 'price',
					),
					'description' => esc_html__( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'woodmart' ),
					'group' => esc_html__( 'Data Settings', 'woodmart' ),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'custom' ),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Sorting', 'woodmart' ),
					'param_name' => 'order',
					'group' => esc_html__( 'Data Settings', 'woodmart' ),
					'value' => array(
						'',
						esc_html__( 'Descending', 'woodmart' ) => 'DESC',
						esc_html__( 'Ascending', 'woodmart' ) => 'ASC',
					),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'description' => esc_html__( 'Select sorting order.', 'woodmart' ),
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Meta key', 'woodmart' ),
					'param_name' => 'meta_key',
					'description' => esc_html__( 'Input meta key for grid ordering.', 'woodmart' ),
					'group' => esc_html__( 'Data Settings', 'woodmart' ),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency' => array(
						'element' => 'orderby',
						'value' => array( 'meta_value', 'meta_value_num' ),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Offset', 'woodmart' ),
					'param_name' => 'offset',
					'description' => esc_html__( 'Number of grid elements to displace or pass over.', 'woodmart' ),
					'group' => esc_html__( 'Data Settings', 'woodmart' ),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
					),
				),
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Exclude', 'woodmart' ),
					'param_name' => 'exclude',
					'description' => esc_html__( 'Exclude posts, pages, etc. by title.', 'woodmart' ),
					'group' => esc_html__( 'Data Settings', 'woodmart' ),
					'settings' => array(
						'multiple' => true,
					),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency' => array(
						'element' => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
						'callback' => 'vc_grid_exclude_dependency_callback',
					),
				),
			)
		);
	}
}


if( ! function_exists( 'woodmart_get_color_scheme_param' ) ) {
	function woodmart_get_color_scheme_param() {
		return apply_filters( 'woodmart_get_color_scheme_param', array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Color Scheme', 'woodmart' ),
			'param_name' => 'woodmart_color_scheme',
			'value' => array(
				esc_html__( 'choose', 'woodmart' ) => '',
				esc_html__( 'Light', 'woodmart' ) => 'light',
				esc_html__( 'Dark', 'woodmart' ) => 'dark',
			),
		) );
	}
}


if( ! function_exists( 'woodmart_get_user_panel_params' ) ) {
	function woodmart_get_user_panel_params() {
		return apply_filters( 'woodmart_get_user_panel_params', array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'woodmart' ),
				'param_name' => 'title',
			)
		));
	}
}

if( ! function_exists( 'woodmart_get_author_area_params' ) ) {
	function woodmart_get_author_area_params() {
		return apply_filters( 'woodmart_get_author_area_params', array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'woodmart' ),
				'param_name' => 'title',
			),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Image', 'woodmart' ),
				'param_name' => 'image',
				'value' => '',
				'description' => esc_html__( 'Select image from media library.', 'woodmart' )
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Image size', 'woodmart' ),
				'param_name' => 'img_size',
				'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'woodmart' )
			),
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => esc_html__( 'Author bio', 'woodmart' ),
				'param_name' => 'content',
				'description' => esc_html__( 'Add here few words to your author info.', 'woodmart' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text alignment', 'woodmart' ),
				'param_name' => 'alignment',
				'value' => array(
					esc_html__( 'Align left', 'woodmart' ) => '',
					esc_html__( 'Align right', 'woodmart' ) => 'right',
					esc_html__( 'Align center', 'woodmart' ) => 'center'
				),
				'description' => esc_html__( 'Select image alignment.', 'woodmart' )
			),
			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'Author link', 'woodmart'),
				'param_name' => 'link',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Link text', 'woodmart'),
				'param_name' => 'link_text',
			),
			woodmart_get_color_scheme_param(),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Extra class name', 'woodmart' ),
				'param_name' => 'el_class',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
			)
		));
	}
}


if( ! function_exists( 'woodmart_get_banner_params' ) ) {
	function woodmart_get_banner_params() {
		return apply_filters( 'woodmart_get_banner_params', array(
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Image', 'woodmart' ),
				'param_name' => 'image',
				'value' => '',
				'description' => esc_html__( 'Select image from media library.', 'woodmart' )
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Image size', 'woodmart' ),
				'param_name' => 'img_size',
				'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'woodmart' )
			),
			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'Banner link', 'woodmart'),
				'param_name' => 'link',
				'description' => esc_html__( 'Enter URL if you want this banner to have a link.', 'woodmart' )
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Button text', 'woodmart' ),
				'param_name' => 'btn_text',
				'group' => esc_html__( 'Buttons', 'woodmart' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Button position', 'woodmart' ),
				'param_name' => 'btn_position',
				'group' => esc_html__( 'Buttons', 'woodmart' ),
				'value' => array(
					esc_html__( 'Show on hover', 'woodmart' ) => 'hover',
					esc_html__( 'Static', 'woodmart' ) => 'static',
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Button color', 'woodmart' ),
				'param_name' => 'btn_color',
				'group' => esc_html__( 'Buttons', 'woodmart' ),
				'value' => array(
					esc_html__( 'Default', 'woodmart' ) => 'default',
					esc_html__( 'Primary color', 'woodmart' ) => 'primary',
					esc_html__( 'Alternative color', 'woodmart' ) => 'alt',
					esc_html__( 'Black', 'woodmart' ) => 'black',
					esc_html__( 'White', 'woodmart' ) => 'white',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Button style', 'woodmart' ),
				'param_name' => 'btn_style',
				'group' => esc_html__( 'Buttons', 'woodmart' ),
				'value' => array(
					esc_html__( 'Default', 'woodmart' ) => 'default',
					esc_html__( 'Bordered', 'woodmart' ) => 'bordered',
					esc_html__( 'Link button', 'woodmart' ) => 'link',
					esc_html__( 'Round', 'woodmart' ) => 'round',
					esc_html__( '3D', 'woodmart' ) => '3d',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Button size', 'woodmart' ),
				'param_name' => 'btn_size',
				'group' => esc_html__( 'Buttons', 'woodmart' ),
				'value' => array(
					esc_html__( 'Default', 'woodmart' ) => 'default',
					esc_html__( 'Extra Small', 'woodmart' ) => 'extra-small',
					esc_html__( 'Small', 'woodmart' ) => 'small',
					esc_html__( 'Large', 'woodmart' ) => 'large',
					esc_html__( 'Extra Large', 'woodmart' ) => 'extra-large',
				),
			),
			array(
				'type' => 'textarea',
				'heading' => esc_html__( 'Title', 'woodmart' ),
				'param_name' => 'title',
				'group' => esc_html__( 'Title', 'woodmart' ),
				'holder' => 'div',
			),
			array(
				'type' => 'textarea',
				'heading' => esc_html__( 'Subtitle', 'woodmart' ),
				'group' => esc_html__( 'Title', 'woodmart' ),
				'param_name' => 'subtitle'
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Subtitle color', 'woodmart' ),
				'group' => esc_html__( 'Title', 'woodmart' ),
				'param_name' => 'subtitle_color',
				'value' => array(
					esc_html__( 'Default', 'woodmart' ) => 'default',
					esc_html__( 'Primary', 'woodmart' ) => 'primary',
					esc_html__( 'Alternative', 'woodmart' ) => 'alt',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Subtitle style', 'woodmart' ),
				'group' => esc_html__( 'Title', 'woodmart' ),
				'param_name' => 'subtitle_style',
				'value' => array(
					esc_html__( 'Default', 'woodmart' ) => 'default',
					esc_html__( 'Background', 'woodmart' ) => 'background',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Title size', 'woodmart' ),
				'group' => esc_html__( 'Title', 'woodmart' ),
				'param_name' => 'title_size',
				'value' => array(
					esc_html__( 'Default', 'woodmart' ) => 'default',
					esc_html__( 'Small', 'woodmart' ) => 'small',
					esc_html__( 'Large', 'woodmart' ) => 'large',
					esc_html__( 'Extra Large', 'woodmart' ) => 'extra-large',
				),
			),
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => esc_html__( 'Banner content', 'woodmart' ),
				'param_name' => 'content',
				'description' => esc_html__( 'Add here few words to your banner image.', 'woodmart' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text alignment', 'woodmart' ),
				'group' => esc_html__( 'Positioning', 'woodmart' ),
				'param_name' => 'text_alignment',
				'value' => array(
					esc_html__( 'Align left', 'woodmart' ) => '',
					esc_html__( 'Align right', 'woodmart' ) => 'right',
					esc_html__( 'Align center', 'woodmart' ) => 'center'
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Content horizontal alignment', 'woodmart' ),
				'param_name' => 'horizontal_alignment',
				'group' => esc_html__( 'Positioning', 'woodmart' ),
				'value' => array(
					esc_html__( 'Left', 'woodmart' ) => '',
					esc_html__( 'Center', 'woodmart' ) => 'center',
					esc_html__( 'Right', 'woodmart' ) => 'right'
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Content vertical alignment', 'woodmart' ),
				'param_name' => 'vertical_alignment',
				'group' => esc_html__( 'Positioning', 'woodmart' ),
				'value' => array(
					esc_html__( 'Top', 'woodmart' ) => '',
					esc_html__( 'Middle', 'woodmart' ) => 'middle',
					esc_html__( 'Bottom', 'woodmart' ) => 'bottom'
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Hover effect', 'woodmart' ),
				'param_name' => 'hover',
				'value' => array(
					esc_html__( 'Zoom image', 'woodmart' ) => 'zoom',
					esc_html__( 'Parallax', 'woodmart' ) => 'parallax',
					esc_html__( 'Background', 'woodmart' ) => 'background',
					esc_html__( 'Bordered', 'woodmart' ) => 'border',
					esc_html__( 'Zoom reverse', 'woodmart' ) => 'zoom-reverse',
					esc_html__( 'Disable', 'woodmart' ) => 'none',
				),
				'description' => esc_html__( 'Set beautiful hover effects for your banner.', 'woodmart' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Content style', 'woodmart' ),
				'param_name' => 'style',
				'value' => array(
					esc_html__( 'Default', 'woodmart' ) => '',
					esc_html__( 'Color mask', 'woodmart' ) => 'mask',
					esc_html__( 'Mask with shadow', 'woodmart' ) => 'shadow',
					esc_html__( 'Bordered', 'woodmart' ) => 'border',
					esc_html__( 'Rectangular background', 'woodmart' ) => 'background',
				),
				'description' => esc_html__( 'You can use some of our predefined styles for your banner content.', 'woodmart' )
			),
			woodmart_get_color_scheme_param(),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Increase spaces', 'woodmart' ),
				'param_name' => 'increase_spaces',
				'description' => esc_html__( 'Suggest to use this option if you have large banners. Padding will be set in percentage to your screen width.', 'woodmart' ),
				'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Extra class name', 'woodmart' ),
				'param_name' => 'el_class',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
			)
		));
	}
}

if( ! function_exists( 'woodmart_get_instagram_params' ) ) {
	function woodmart_get_instagram_params() {
		return apply_filters( 'woodmart_get_instagram_params', array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'woodmart' ),
				'param_name' => 'title',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Username', 'woodmart' ),
				'param_name' => 'username',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Number of photos', 'woodmart' ),
				'param_name' => 'number',
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Photo size', 'woodmart' ),
				'param_name' => 'size',
				'value' => array(
					esc_html__( 'Thumbnail', 'woodmart' ) => 'thumbnail',
					esc_html__( 'Large', 'woodmart' ) => 'large',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Open link in', 'woodmart' ),
				'param_name' => 'target',
				'value' => array(
					esc_html__( 'Current window (_self)', 'woodmart' ) => '_self',
					esc_html__( 'New window (_blank)', 'woodmart' ) => '_blank',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Link text', 'woodmart' ),
				'param_name' => 'link',
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Design', 'woodmart' ),
				'param_name' => 'design',
				'skip_in' => 'widget',
				'value' => array(
					esc_html__( 'Default', 'woodmart' ) => '',
					esc_html__( 'Grid', 'woodmart' ) => 'grid',
					esc_html__( 'Slider', 'woodmart' ) => 'slider'
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Photos per row', 'woodmart' ),
				'param_name' => 'per_row',
				'skip_in' => 'widget',
				'description' => esc_html__('Number of photos per row for grid design or items in slider per view.', 'woodmart' ),
				'value' => array(
					1,
					2,
					3,
					4,
					5,
					6,
					7,
					8,
					9,
					10,
					11,
					12
				)
			),
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => esc_html__( 'Instagram text', 'woodmart' ),
				'param_name' => 'content',
				'skip_in' => 'widget',
				'description' => esc_html__( 'Add here few words about your instagram profile.', 'woodmart' )
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Add spaces between photos', 'woodmart' ),
				'skip_in' => 'widget',
				'param_name' => 'spacing',
				'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Rounded corners for images', 'woodmart' ),
				'skip_in' => 'widget',
				'param_name' => 'rounded',
				'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Hide likes and comments', 'woodmart' ),
				'skip_in' => 'widget',
				'param_name' => 'hide_mask',
				'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 1 )
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Hide pagination control', 'woodmart' ),
				'param_name' => 'hide_pagination_control',
				'description' => esc_html__( 'If "YES" pagination control will be removed', 'woodmart' ),
				'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
				'skip_in' => 'widget',
				'dependency' => array(
					'element' => 'design',
					'value' => array( 'slider' ),
				),
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Hide prev/next buttons', 'woodmart' ),
				'param_name' => 'hide_prev_next_buttons',
				'description' => esc_html__( 'If "YES" prev/next control will be removed', 'woodmart' ),
				'value' => array( esc_html__( 'Yes, please', 'woodmart' ) => 'yes' ),
				'skip_in' => 'widget',
				'dependency' => array(
					'element' => 'design',
					'value' => array( 'slider' ),
				),
			),
		));
	}
}

// Add other product attributes
if( ! function_exists( 'woodmart_vc_autocomplete_taxonomies_field_search' ) ) {
	function woodmart_vc_autocomplete_taxonomies_field_search( $search_string ) {
		$vc_filter_by = vc_post_param( 'vc_filter_by', '' );
		$vc_taxonomies_types = strlen( $vc_filter_by ) > 0 ? array( $vc_filter_by ) : array_keys( vc_taxonomies_types() );

		$brands_attribute = woodmart_get_opt( 'brands_attribute' );

		if( $brands_attribute ) {
			array_push($vc_taxonomies_types, $brands_attribute);
		}


		$vc_taxonomies = get_terms( $vc_taxonomies_types, array(
			'hide_empty' => false,
			'search' => $search_string,
		) );
		if ( is_array( $vc_taxonomies ) && ! empty( $vc_taxonomies ) ) {
			foreach ( $vc_taxonomies as $t ) {
				if ( is_object( $t ) ) {
					$data[] = vc_get_term_object( $t );
				}
			}
		}

		return $data;
	}
}

if( ! function_exists( 'woodmart_vc_autocomplete_taxonomies_field_render' ) ) {
	function woodmart_vc_autocomplete_taxonomies_field_render( $term ) {
		$vc_taxonomies_types = vc_taxonomies_types();

		$brands_attribute = woodmart_get_opt( 'brands_attribute' );

		if( $brands_attribute ) {
			$vc_taxonomies_types[ $brands_attribute ] = $brands_attribute;
		}

		$terms = get_terms( array_keys( $vc_taxonomies_types ), array(
			'include' => array( $term['value'] ),
			'hide_empty' => false,
		) );
		$data = false;
		if ( is_array( $terms ) && 1 === count( $terms ) ) {
			$term = $terms[0];
			$data = vc_get_term_object( $term );
		}

		return $data;
	}
}


// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_woodmart_popup extends WPBakeryShortCodesContainer {

    }
}

if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_testimonials extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_testimonial extends WPBakeryShortCode {

    }
}

if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_extra_menu extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_extra_menu_list extends WPBakeryShortCode {

    }
}

if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_banners_carousel extends WPBakeryShortCodesContainer {

    }
}

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_pricing_tables extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_pricing_plan extends WPBakeryShortCode {

    }
}

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_products_tabs extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_products_tab extends WPBakeryShortCode {

    }
}

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_woodmart_carousel extends WPBakeryShortCodesContainer {}
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_woodmart_carousel_item extends WPBakeryShortCode {}
}


// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_woodmart_google_map extends WPBakeryShortCodesContainer {

    }
}

/**
* Add gradient to VC 
*/
if( ! function_exists( 'woodmart_add_gradient_type' ) && apply_filters( 'woodmart_gradients_enabled', true ) ) {
	function woodmart_add_gradient_type( $settings, $value ) {
		return woodmart_get_gradient_field( $settings['param_name'], $value, true );
	}
}