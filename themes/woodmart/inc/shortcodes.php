<?php if ( ! defined('ABSPATH')) exit('No direct script access allowed');
/**
* ------------------------------------------------------------------------------------------------
* Woodmart responsive text block shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_responsive_text_block' ) ) {
	function woodmart_shortcode_responsive_text_block( $atts, $content ) {
		extract( shortcode_atts( array(
			'text' 	 => 'Title',
			'font' 	 => 'primary',
			'font_weight' => '',
			'content_width' => '100',
			'color_scheme' => '',
			'color' => '',
			'size' 	 => 'default',
			'align' 	 => 'center',
			'el_class' 	 => '',
			'desktop_text_size' 	 => '',
			'tablet_text_size' 	 => '',
			'mobile_text_size' 	 => '',
			'css'		 => '',
		), $atts) );

		$text_class = $text_wrapper_class = '';

		$text_id = 'woodmart-text-block-id-' . uniqid();

		$text_wrapper_class .= ' color-scheme-' . $color_scheme;
		$text_wrapper_class .= ' woodmart-title-size-' . $size;
		$text_wrapper_class .= ' woodmart-title-width-' . $content_width;
		$text_wrapper_class .= ' text-' . $align;
		$text_class .= ' font-'. $font;
		$text_class .= ' woodmart-font-weight-'. $font_weight;

		if( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$text_wrapper_class .= ' ' . vc_shortcode_custom_css_class( $css );
		}

		if( $el_class != '' ) {
			$text_wrapper_class .= ' ' . $el_class;
		}
		ob_start();
		?>	
			<?php if ( $size == 'custom' || $color_scheme == 'custom' ): ?>
				<style>
					<?php if ( $desktop_text_size || $color ): ?>
					
						#<?php echo esc_attr( $text_id ); ?> .woodmart-text-block {
							<?php if ( $desktop_text_size ): ?>
								font-size: <?php echo esc_attr( $desktop_text_size ); ?>px;
								line-height: <?php echo esc_attr( $desktop_text_size + 12 ); ?>px;
							<?php endif ?>
							<?php if ( $color ): ?>
								color: <?php echo esc_attr( $color ); ?>;
							<?php endif ?>
						}

					<?php endif ?>
					
					<?php if ( $tablet_text_size ): ?>
						@media (max-width: 1024px) {
							#<?php echo esc_attr( $text_id ); ?> .woodmart-text-block {
								font-size: <?php echo esc_attr( $tablet_text_size ); ?>px;
								line-height: <?php echo esc_attr( $tablet_text_size + 12 ); ?>px;
							}
						}
					<?php endif ?>

					<?php if ( $mobile_text_size ): ?>
						@media (max-width: 767px) {
							#<?php echo esc_attr( $text_id ); ?> .woodmart-text-block {
								font-size: <?php echo esc_attr( $mobile_text_size ); ?>px;
								line-height: <?php echo esc_attr( $mobile_text_size + 12 ); ?>px;
							}
						}
					<?php endif ?>

				</style>
			<?php endif ?>
			<div id="<?php echo esc_attr( $text_id ) ;?>" class="woodmart-text-block-wrapper<?php echo esc_attr( $text_wrapper_class ) ;?>">
				<div class="woodmart-title-container woodmart-text-block<?php echo esc_attr( $text_class ) ;?>">
					<?php echo do_shortcode( $content ); ?>
				</div>
			</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;

	}
}

/**
* ------------------------------------------------------------------------------------------------
* Section title shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_title' ) ) {
	function woodmart_shortcode_title( $atts ) {
		extract( shortcode_atts( array(
			'title' 	 => 'Title',
			'subtitle' 	 => '',
			'after_title'=> '',
			'link' 	 	 => '',
			'color' 	 => 'default',
			'woodmart_color_gradient' 	 => '',
			'style'   	 => 'default',
			'size' 		 => 'default',
			'subtitle_font' => 'default',
			'subtitle_style' => 'default',
			'align' 	 => 'center',
			'el_class' 	 => '',
			'css'		 => '',
			'tag'        => 'h4',
			'title_width' => '100'
		), $atts) );

		$output = $attrs = '';

		$title_class = $subtitle_class  = '';

		$title_class .= ' woodmart-title-color-' . $color;
		$title_class .= ' woodmart-title-style-' . $style;
		$title_class .= ' woodmart-title-size-' . $size;
		$title_class .= ' woodmart-title-width-' . $title_width;
		$title_class .= ' text-' . $align;

		$subtitle_class .= ' font-'. $subtitle_font;
		$subtitle_class .= ' style-'. $subtitle_style;

		$separator = '<span class="title-separator"><span></span></span>';

		if( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$title_class .= ' ' . vc_shortcode_custom_css_class( $css );
		}

		if( $el_class != '' ) {
			$title_class .= ' ' . $el_class;
		}

		$gradient_style = ( $color == 'gradient' ) ? 'style="' . woodmart_get_gradient_css( $woodmart_color_gradient ) . ';"' : '' ;

		$output .= '<div class="title-wrapper' . esc_attr( $title_class ) . '">';

			if( $subtitle != '' ) {
				$output .= '<div class="title-subtitle' . esc_attr( $subtitle_class ) . '">' . $subtitle . '</div>';
			}


			$output .= '<div class="liner-continer"> <span class="left-line"></span> <'. $tag .' class="woodmart-title-container title" ' . $gradient_style . '>' . $title . $separator . '</'. $tag .'> <span class="right-line"></span> </div>';

			if( $after_title != '' ) {
				$output .= '<div class="title-after_title">' . $after_title . '</div>';
			}

		$output .= '</div>';

		return $output;

	}

	
}


/**
* ------------------------------------------------------------------------------------------------
* Buttons shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_button' ) ) {
	function woodmart_shortcode_button( $atts, $popup = false ) {
		extract( shortcode_atts( array(
			'title' 	 => 'GO',
			'link' 	 	 => '',
			'color' 	 => 'default',
			'style'   	 => 'default',
			'size' 		 => 'default',
			'align' 	 => 'center',
			'button_inline' => 'no',
			'full_width' => 'no',
			'el_class' 	 => '',
		), $atts) );

		$attributes = woodmart_get_link_attributes( $link, $popup );

		$btn_class = 'btn';

		$wrap_class = 'woodmart-button-wrapper';

		$btn_class .= ' btn-color-' . $color;
		$btn_class .= ' btn-style-' . $style;
		$btn_class .= ' btn-size-' . $size;
		if( $full_width == 'yes' ) $btn_class .= ' btn-full-width';

		$wrap_class .= ' text-' . $align;
		if( $button_inline == 'yes' ) $wrap_class .= ' btn-inline';

		if( $el_class != '' ) $btn_class .= ' ' . $el_class;

		$attributes .= ' class="' . $btn_class . '"';

		$output = '<div class="' . esc_attr( $wrap_class ) . '"><a ' . $attributes . '>' . esc_html ( $title ) . '</a></div>';

		return $output;

	}

	
}



/**
* ------------------------------------------------------------------------------------------------
* Content in popup
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_popup' ) ) {
	function woodmart_shortcode_popup( $atts, $content = '' ) {
		$output = '';
		$parsed_atts = shortcode_atts( array(
			'id' 	 	 => 'my_popup',
			'title' 	 => 'GO',
			'link' 	 	 => '',
			'color' 	 => 'default',
			'style'   	 => 'default',
			'size' 		 => 'default',
			'align' 	 => 'center',
			'button_inline' => 'no',
			'width' 	 => 800,
			'el_class' 	 => '',
		), $atts) ;

		extract( $parsed_atts );

		$parsed_atts['link'] = 'url:#' . esc_attr( $id ) . '|||';
		$parsed_atts['el_class'] = 'woodmart-open-popup';

		$output .= woodmart_shortcode_button( $parsed_atts , true );

		$output .= '<div id="' . esc_attr( $id ) . '" class="mfp-with-anim woodmart-content-popup mfp-hide" style="max-width:' . esc_attr( $width ) . 'px;"><div class="woodmart-popup-inner">' . do_shortcode( $content ) . '</div></div>';

		return $output;

	}

	
}

/**

* ------------------------------------------------------------------------------------------------
* instagram shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_instagram' ) ) {
	function woodmart_shortcode_instagram( $atts, $content = '' ) {
		$output = '';
		extract(shortcode_atts( array(
			'title' => '',
			'username' => 'flickr',
			'number' => 9,
			'size' => 'medium',
			'target' => '_self',
			'link' => '',
			'design' => 'grid',
			'spacing' => 0,
			'rounded' => 0,
			'per_row' => 3,
			'hide_mask' => 0,
			'hide_pagination_control' => '',
			'hide_prev_next_buttons' => ''
		), $atts ));

		$carousel_id = 'carousel-' . rand(100,999);

		ob_start();

		$class = 'instagram-widget';

		if( $design != '' ) {
			$class .= ' instagram-' . $design;
		}

		if( $spacing == 1 ) {
			$class .= ' instagram-with-spaces';
		}

		if( $rounded == 1 ) {
			$class .= ' instagram-rounded';
		}

		$class .= ' instagram-per-row-' . $per_row;

		echo '<div id="' . esc_attr( $carousel_id ) . '" class="' . esc_attr( $class ) . '">';

		if(!empty($title)) { echo '<h3 class="title">' . $title . '</h3>'; };

		if ($username != '') {

			if ( ! empty( $content ) ): ?>
				<div class="instagram-content">
					<div class="instagram-content-inner">
						<?php echo do_shortcode( $content ); ?>
					</div>
				</div>
			<?php endif;

			$media_array = woodmart_scrape_instagram($username, $number);

			if ( is_wp_error($media_array) ) {

			   echo esc_html( $media_array->get_error_message() );

			} else {

				?><div class="instagram-pics <?php if( $design == 'slider') echo 'owl-carousel ' . woodmart_owl_items_per_slide( $per_row ); ?>"><?php
				foreach ($media_array as $item) {
					$image = (! empty( $item[$size] )) ? $item[$size] : $item['thumbnail'];
					$result = '<div class="instagram-picture">
						<div class="wrapp-picture">
							<a href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'"></a>
							<img src="'. esc_url( $image ) .'" />';
							if ( $hide_mask == 0 ) {
								$result .= '<div class="hover-mask">
								<span class="instagram-likes"><span>' . woodmart_pretty_number( $item['likes'] ) . '</span></span>
								<span class="instagram-comments"><span>' . woodmart_pretty_number( $item['comments'] ) . '</span></span></div>';
							}
					$result .= '
						</div>
					</div>';
					echo ( $result );
				}
				?></div><?php
			}
		}

		if ($link != '') {
			?><p class="clear"><a href="//instagram.com/<?php echo trim($username); ?>" rel="me" target="<?php echo esc_attr( $target ); ?>"><?php echo esc_html($link); ?></a></p><?php
		}

		if( $design == 'slider' ) {

			woodmart_owl_carousel_init( array(
				'carousel_id' => $carousel_id,
				'hide_pagination_control' => $hide_pagination_control,
				'hide_prev_next_buttons' => $hide_prev_next_buttons,
				'slides_per_view' => $per_row
			) );
		}

		echo '</div>';

		$output = ob_get_contents();
		ob_end_clean();

		return $output;

	}

	
}

if( ! function_exists( 'woodmart_pretty_number' ) ) {
	function woodmart_pretty_number( $x = 0 ) {
		$x = (int) $x;

		if( $x > 1000000 ) {
			return floor( $x / 1000000 ) . 'M';
		}

		if( $x > 10000 ) {
			return floor( $x / 1000 ) . 'k';
		}
		return $x;
	}
}

if( ! function_exists( 'woodmart_scrape_instagram' ) ) {
	function woodmart_scrape_instagram($username, $slice = 9) {
		$username = strtolower( $username );
		$by_hashtag = ( substr( $username, 0, 1) == '#' );
		if ( false === ( $instagram = get_transient( 'instagram-media-new-'.sanitize_title_with_dashes( $username ) ) ) ) {
			$request_param = ( $by_hashtag ) ? 'explore/tags/' . substr( $username, 1) : trim( $username );
			$remote = wp_remote_get( 'https://instagram.com/'. $request_param );
			if ( is_wp_error( $remote ) )
				return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'woodmart' ) );
			if ( 200 != wp_remote_retrieve_response_code( $remote ) )
				return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'woodmart' ) );
			$shards = explode( 'window._sharedData = ', $remote['body'] );
			$insta_json = explode( ';</script>', $shards[1] );
			$insta_array = json_decode( $insta_json[0], TRUE );
			if ( !$insta_array )
				return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'woodmart' ) );
			// old style
			if ( isset( $insta_array['entry_data']['UserProfile'][0]['userMedia'] ) ) {
				$images = $insta_array['entry_data']['UserProfile'][0]['userMedia'];
				$type = 'old';
			// new style
			} else if ( isset( $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] ) ) {
				$images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
				$type = 'new';
			} elseif( $by_hashtag && isset( $insta_array['entry_data']['TagPage'][0]['tag']['media']['nodes'] ) ) {
				$images = $insta_array['entry_data']['TagPage'][0]['tag']['media']['nodes'];
				$type = 'new';
			} else {
				return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'woodmart' ) );
			}

			if ( !is_array( $images ) )
				return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'woodmart' ) );
			$instagram = array();
			switch ( $type ) {
				case 'old':
					foreach ( $images as $image ) {
						if ( $image['user']['username'] == $username ) {
							$image['link']						  = $image['link'];
							$image['images']['thumbnail']		   = preg_replace( "/^http:/i", "", $image['images']['thumbnail'] );
							$image['images']['standard_resolution'] = preg_replace( "/^http:/i", "", $image['images']['standard_resolution'] );
							$image['images']['low_resolution']	  = preg_replace( "/^http:/i", "", $image['images']['low_resolution'] );
							$instagram[] = array(
								'description'   => $image['caption']['text'],
								'link'		  	=> $image['link'],
								'time'		  	=> $image['created_time'],
								'comments'	  	=> $image['comments']['count'],
								'likes'		 	=> $image['likes']['count'],
								'thumbnail'	 	=> $image['images']['thumbnail'],
								'large'		 	=> $image['images']['standard_resolution'],
								'small'		 	=> $image['images']['low_resolution'],
								'type'		  	=> $image['type']
							);
						}
					}
				break;
				default:
					foreach ( $images as $image ) {
						$image['thumbnail_src'] = preg_replace( "/^https:/i", "", $image['thumbnail_src'] );
						$image['thumbnail'] = str_replace( 's640x640', 's160x160', $image['thumbnail_src'] );
						$image['medium'] = str_replace( 's640x640', 's320x320', $image['thumbnail_src'] );
						$image['large'] = $image['thumbnail_src'];
						$image['display_src'] = preg_replace( "/^https:/i", "", $image['display_src'] );
						if ( $image['is_video'] == true ) {
							$type = 'video';
						} else {
							$type = 'image';
						}
						$caption = esc_html__( 'Instagram Image', 'woodmart' );
						if ( ! empty( $image['caption'] ) ) {
							$caption = $image['caption'];
						}
						$instagram[] = array(
							'description'   => $caption,
							'link'		  	=> '//instagram.com/p/' . $image['code'],
							'time'		  	=> $image['date'],
							'comments'	  	=> $image['comments']['count'],
							'likes'		 	=> $image['likes']['count'],
							'thumbnail'	 	=> $image['thumbnail'],
							'medium'		=> $image['medium'],
							'large'			=> $image['large'],
							'original'		=> $image['display_src'],
							'type'		  	=> $type
						);
					}
				break;
			}
			// do not set an empty transient - should help catch private or empty accounts
			if ( ! empty( $instagram ) ) {
				$instagram = woodmart_compress( maybe_serialize( $instagram ) );
				set_transient( 'instagram-media-new-'.sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS*2 ) );
			}
		}
		if ( ! empty( $instagram ) ) {
			$instagram = maybe_unserialize( woodmart_decompress( $instagram ) );
			return array_slice( $instagram, 0, $slice );
		} else {
			return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'woodmart' ) );
		}
	}
}

if( !function_exists( 'woodmart_instagram_images_only' ) ) {
	function woodmart_instagram_images_only($media_item) {
		if ($media_item['type'] == 'image')
			return true;

		return false;
	}
}


/**
* ------------------------------------------------------------------------------------------------
* Brands carousel/grid/list shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_brands' ) ) {
	function woodmart_shortcode_brands( $atts, $content = '' ) {
		$output = '';
		$parsed_atts = shortcode_atts( array_merge( woodmart_get_owl_atts(), array(
			'title' => '',
			'username' => 'flickr',
			'number' => 20,
			'hover' => 'default',
			'target' => '_self',
			'link' => '',
			'ids' => '',
			'style' => 'carousel',
			'brand_style' => 'default',
			'per_row' => 3,
			'columns' => 3,
			'orderby' => 'name',
			'order' => 'ASC',
			'orderby' => '',
		) ), $atts );

		extract( $parsed_atts );

		$carousel_id = 'brands_' . rand(1000,9999);

		$attribute = woodmart_get_opt( 'brands_attribute' );

		if( empty( $attribute ) || ! taxonomy_exists( $attribute ) ) return '<p>' . esc_html_e('You must select your brand attribute in Theme Settings -> Shop -> Brands', 'woodmart' ) . '</p>';

		ob_start();

		$class = 'brands-widget slider-' . $carousel_id;

		if( $style != '' ) {
			$class .= ' brands-' . $style;
		}

		$class .= ' brands-hover-' . $hover;
		$class .= ' brands-columns-' . $columns;
		$class .= ' brands-style-' . $brand_style;

		echo '<div id="'. esc_attr( $carousel_id ) . '" class="' . esc_attr( $class ) . '">';

		if(!empty($title)) { echo '<h3 class="title">' . $title . '</h3>'; };

		$args = array(
			'taxonomy' => $attribute,
			'hide_empty' => false,
			'orderby' => $orderby,
			'order' => $order,
			'number' => $number
		);


		if( ! empty( $ids ) ) {
			$args['include'] = explode(',', $ids);
		}

		$brands = get_terms( $args);

		$link = get_post_type_archive_link( 'product' );
		
		echo '<div class="brands-items-wrapper ' . ( ( $style == 'carousel' ) ? 'owl-carousel ' . woodmart_owl_items_per_slide( $per_row ) : '' ) . '">';

 		if( ! is_wp_error( $brands ) && count( $brands ) > 0 ) {
			foreach ($brands as $key => $brand) {
				$image = woodmart_tax_data( $attribute, $brand->term_id, 'image' );

				$filter_name = 'filter_' . sanitize_title( str_replace( 'pa_', '', $attribute ) );

				$attr_link = apply_filters('woodmart_permalink', add_query_arg( $filter_name, $brand->slug, $link ));

				echo '<div class="brand-item">';
					echo '<a href="' . esc_url( $attr_link ) . '">';
					if( $style == 'list' || empty( $image ) ) {
						echo '<span class="brand-title-wrap">' . $brand->name . '</span>';
					} else {
						echo '<img src="' . esc_url( $image ) . '" title="' . esc_attr( $brand->slug ) . '" alt="' . esc_attr( $brand->slug ) . '" />';
					}
					echo '</a>';
				echo '</div>';
			}
		}

		if( $style == 'carousel' ) {
			$parsed_atts['autoplay'] = false;
			$parsed_atts['wrap'] = $wrap;
			$parsed_atts['scroll_per_page'] = true;
			$parsed_atts['carousel_id'] = $carousel_id;
			$parsed_atts['slides_per_view'] = $per_row;

			woodmart_owl_carousel_init( $parsed_atts );
		}

		echo '</div></div>';

		$output = ob_get_contents();
		ob_end_clean();

		return $output;

	}

	
}

/**
* ------------------------------------------------------------------------------------------------
* Google Map shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_google_map' ) ) {
	function woodmart_shortcode_google_map( $atts, $content ) {
		$output = '';
		extract(shortcode_atts( array(
			'title' => '',
			'lat' => 45.9,
			'lon' => 10.9,
			'style_json' => '',
			'zoom' => 15,
			'height' => 400,
			'scroll' => 'no',
			'mask' => '',
			'marker_text' => '',
			'content_vertical' => 'top',
			'content_horizontal' => 'left',
			'content_width' => 300,
			'google_key' => woodmart_get_opt( 'google_map_api_key' ),
			'el_class' => ''
		), $atts ));

		wp_enqueue_script( 'maplace' );
		wp_enqueue_script( 'google.map.api', 'https://maps.google.com/maps/api/js?key=' . $google_key . '', array(), '', false );
			

		$el_class .= ' content-vertical-' . $content_vertical;
		$el_class .= ' content-horizontal-' . $content_horizontal;

		if( $mask != '' ) {
			$el_class .= ' map-mask-' . $mask;
		}

		$id = rand(100,999);

		$marker_content = '<h3 style="min-width:300px; text-align:center; margin:15px;">'. $title .'</h3>';
		$marker_content .= $marker_text;

		ob_start();

		?>

			<?php if ( ! empty( $content ) ): ?>		
				<div class="google-map-container <?php echo esc_attr( $el_class ); ?> map-container-with-content" style="height:<?php echo esc_attr( $height ); ?>px;">

					<div class="woodmart-google-map-wrapper">
						<div class="woodmart-google-map with-content google-map-<?php echo esc_attr( $id ); ?>"></div>
					</div>
					<div class="woodmart-google-map-content-wrap">
						<div class="woodmart-google-map-content" style="max-width: <?php echo esc_attr( $content_width ); ?>px;">
							<?php echo do_shortcode( $content ); ?>
						</div>
					</div>

				</div>
			<?php else: ?>

				<div class="google-map-container <?php echo esc_attr( $el_class );?>"  style="height:<?php echo esc_attr( $height ); ?>px;">

					<div class="woodmart-google-map-wrapper">
						<div class="woodmart-google-map without-content google-map-<?php echo esc_attr( $id ); ?>"></div>
					</div>

				</div>

			<?php endif ?>
		<?php
		wp_add_inline_script( 'woodmart-theme', woodmart_google_map_init_js( $atts, $id ), 'after' );
		$output = ob_get_contents();
		ob_end_clean();

		return $output;


	}
}

if( ! function_exists( 'woodmart_google_map_init_js' ) ) {
	function woodmart_google_map_init_js( $atts, $id ) {
		$output = '';
		extract(shortcode_atts( array(
			'title' => '',
			'lat' => 45.9,
			'lon' => 10.9,
			'style_json' => '',
			'zoom' => 15,
			'scroll' => 'no',
		), $atts ));
		ob_start();
		?>
			jQuery(document).ready(function() {

				new Maplace({
					locations: [
					    {
							lat: <?php echo esc_js( $lat ); ?>,
							lon: <?php echo esc_js( $lon ); ?>,
							title: '<?php echo esc_js( $title ); ?>',
					        <?php if( $title != '' && empty( $content ) ): ?>
					        	html: <?php echo json_encode( $marker_content ); ?>, 
					        <?php endif; ?>
					        icon: '<?php echo WOODMART_ASSETS . '/images/google-icon.svg';  ?>' ,
					        animation: google.maps.Animation.DROP
					    }
					],
					controls_on_map: false,
					title: '<?php echo esc_js( $title ); ?>',
				    map_div: '.google-map-<?php echo esc_js( $id ); ?>',
				    start: 1,
				    map_options: {
				        zoom: <?php echo esc_js( $zoom ); ?>,
				        scrollwheel: <?php echo ($scroll == 'yes') ? 'true' : 'false'; ?>
				    },
				    <?php if($style_json != ''): ?>
				    styles: {
				        '<?php esc_html_e('Custom style', 'woodmart') ?>': <?php echo rawurldecode( woodmart_decompress($style_json, true) ); ?>
				    }
				    <?php endif; ?>
				}).Load();

			});
		<?php
		return ob_get_clean();
	}
}

/**
* ------------------------------------------------------------------------------------------------
* Portfolio shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_portfolio' ) ) {
	function woodmart_shortcode_portfolio( $atts ) {
		global $woodmart_portfolio_loop;
		$output = $title = $el_class = '';
		$parsed_atts = shortcode_atts( array(
			'posts_per_page' => woodmart_get_opt( 'portoflio_per_page' ),
			'filters' => false,
			'categories' => '',
			'style' => woodmart_get_opt( 'portoflio_style' ),
			'columns' => woodmart_get_opt( 'projects_columns' ),
			'spacing' => woodmart_get_opt( 'portfolio_spacing' ),
			'full_width' => woodmart_get_opt( 'portfolio_full_width' ),
			'pagination' => woodmart_get_opt( 'portfolio_pagination' ),
			'ajax_page' => '',
			'orderby' => 'post_date',
			'order' => 'DESC',
			'portfolio_location' => '',
			'el_class' => ''
		), $atts );

		extract( $parsed_atts );

		$encoded_atts = json_encode( $parsed_atts );

		// Load masonry script JS
		wp_enqueue_script( 'images-loaded' );
		//wp_enqueue_script( 'masonry' );
		wp_enqueue_script( 'isotope' );

		$is_ajax = (defined( 'DOING_AJAX' ) && DOING_AJAX);
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		if( $ajax_page > 1 ) $paged = $ajax_page;

		$s = false;

		if( isset( $_REQUEST['s'] ) ) {
			$s = sanitize_text_field( $_REQUEST['s'] );
		}

		$args = array(
			'post_type' => 'portfolio',
			'posts_per_page' => $posts_per_page,
			'orderby' => $orderby,
			'order' => $order,
			'paged' => $paged
		);

		if( $s ) {
			$args['s'] = $s;
		}
 
		if( get_query_var('project-cat') != '' ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'project-cat',
					'field'    => 'slug',
					'terms'    => get_query_var('project-cat')
				),
			);
		}

		if( $categories != '' ) {

			$args['tax_query'] = array(
				array(
					'taxonomy' => 'project-cat',
					'field'    => 'term_id',
					'operator' => 'IN',
					'terms'    => $categories
				),
			);
		}

		if ( get_post_type() == 'portfolio' ) {
			$filters = woodmart_get_opt( 'portoflio_filters' );
		}

		if( empty($style) ) $style = woodmart_get_opt( 'portoflio_style' );

		$woodmart_portfolio_loop['columns'] = $columns;
		$woodmart_portfolio_loop['style'] = $style;

		$query = new WP_Query( $args );

		ob_start();

		?>

			<?php if ( ! $is_ajax ): ?>
			<div class="<?php echo ($portfolio_location == 'page') ? 'site-content page-portfolio ' : ''; ?>portfolio-layout-<?php echo ($full_width) ? 'full-width' : 'boxed'; ?> col-sm-12" role="main">
			<?php endif ?>

				<?php if ( $query->have_posts() ) : ?>
					<?php if ( ! $is_ajax ): ?>
						<div class="row portfolio-spacing-<?php echo esc_attr( $spacing ); ?> <?php if( $full_width ) echo 'vc_row vc_row-fluid vc_row-no-padding" data-vc-full-width="true" data-vc-full-width-init="true" data-vc-stretch-content="true'; ?>">

							<?php if ( ! is_tax() && $filters && ! $s ): ?>
								<?php 
									$cats = get_terms( 'project-cat', array( 'parent' => $categories ) );
									if( ! is_wp_error( $cats ) && ! empty( $cats ) ) {
										?>
										<div class="col-sm-12 portfolio-filter">
											<ul class="masonry-filter list-inline text-center">
												<li><a href="#" data-filter="*" class="filter-active"><?php esc_html_e('All', 'woodmart'); ?></a></li>
											<?php
											foreach ($cats as $key => $cat) {
												?>
													<li><a href="#" data-filter=".proj-cat-<?php echo esc_attr( $cat->slug ); ?>"><?php echo esc_html( $cat->name ); ?></a></li>
												<?php
											}
											?>
											</ul>
										</div>
										<?php
									}
								 ?>

							<?php endif ?>

							<div class="clear"></div>

							<div class="masonry-container woodmart-portfolio-holder" data-atts="<?php echo esc_attr( $encoded_atts ); ?>" data-source="shortcode" data-paged="1">
					<?php endif ?>

							<?php /* The loop */ ?>
							<?php while ( $query->have_posts() ) : $query->the_post(); ?>
								<?php get_template_part( 'content', 'portfolio' ); ?>
							<?php endwhile; ?>

					<?php if ( ! $is_ajax ): ?>
								</div>
							</div>

						<div class="vc_row-full-width"></div>

						<?php
							if ( $query->max_num_pages > 1 && !$is_ajax && $pagination != 'disable' ) {
								?>
							    	<div class="portfolio-footer">
							    		<?php if ( $pagination == 'infinit' || $pagination == 'load_more'): ?>
							    			<a href="#" class="btn woodmart-load-more woodmart-portfolio-load-more load-on-<?php echo ($pagination == 'load_more') ? 'click' : 'scroll'; ?>"><span class="load-more-label"><?php esc_html_e('Load more posts', 'woodmart'); ?></span><span class="load-more-loading"><?php esc_html_e('Loading...', 'woodmart'); ?></span></a>
						    			<?php else: ?>
							    			<?php query_pagination( $query->max_num_pages ); ?>
							    		<?php endif ?>
							    	</div>
							    <?php
							}
						?>
					<?php endif ?>

				<?php elseif ( ! $is_ajax ) : ?>
					<?php get_template_part( 'content', 'none' ); ?>
				<?php endif; ?>

			<?php if ( ! $is_ajax ): ?>
			</div><!-- .site-content -->
			<?php endif ?>
		<?php

		$output .= ob_get_clean();

		wp_reset_postdata();

	    if( $is_ajax ) {
	    	$output =  array(
	    		'items' => $output,
	    		'status' => ( $query->max_num_pages > $paged ) ? 'have-posts' : 'no-more-posts'
	    	);
	    }

		return $output;
	}

	
}


if( ! function_exists( 'woodmart_get_portfolio_shortcode_ajax' ) ) {
	add_action( 'wp_ajax_woodmart_get_portfolio_shortcode', 'woodmart_get_portfolio_shortcode_ajax' );
	add_action( 'wp_ajax_nopriv_woodmart_get_portfolio_shortcode', 'woodmart_get_portfolio_shortcode_ajax' );
	function woodmart_get_portfolio_shortcode_ajax() {
		if( ! empty( $_POST['atts'] ) ) {
			$atts = $_POST['atts'];
			$paged = (empty($_POST['paged'])) ? 2 : (int) $_POST['paged'] + 1;
			$atts['ajax_page'] = $paged;

			$data = woodmart_shortcode_portfolio($atts);

			echo json_encode( $data );

			die();
		}
	}
}


/**
* ------------------------------------------------------------------------------------------------
* Blog shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_blog' ) ) {
	function woodmart_shortcode_blog( $atts ) {
		global $woodmart_loop;
	    $parsed_atts = shortcode_atts( array(
	        'post_type'  => 'post',
	        'include'  => '',
	        'custom_query'  => '',
	        'taxonomies'  => '',
	        'pagination'  => '',
	        'parts_title'  => true,
	        'parts_meta'  => true,
	        'parts_text'  => true,
	        'parts_btn'  => true,
	        'items_per_page'  => 12,
	        'offset'  => '',
	        'orderby'  => 'date',
	        'order'  => 'DESC',
	        'meta_key'  => '',
	        'exclude'  => '',
	        'class'  => '',
	        'ajax_page' => '',
	        'img_size' => 'medium',
	        'blog_design'  => 'default',
	        'blog_columns'  => woodmart_get_opt( 'blog_columns' ),
			'speed' => '5000',
			'slides_per_view' => '1',
			'wrap' => '',
			'autoplay' => 'no',
			'hide_pagination_control' => '',
			'hide_prev_next_buttons' => '',
			'scroll_per_page' => 'yes',
			'carousel_small_img' => ''
	    ), $atts );

	    extract( $parsed_atts );

	    $encoded_atts = json_encode( $parsed_atts );

	    $is_ajax = (defined( 'DOING_AJAX' ) && DOING_AJAX);

	    $output = '';

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		if( $ajax_page > 1 ) $paged = $ajax_page;

	    $args = array(
	    	'post_type' => 'post',
	    	'status' => 'published',
	    	'paged' => $paged,
	    	'posts_per_page' => $items_per_page
		);

		if( $post_type == 'ids' && $include != '' ) {
			$args['post__in'] = explode(',', $include);
		}

		if( ! empty( $exclude ) ) {
			$args['post__not_in'] = explode(',', $exclude);
		}

		if( ! empty( $taxonomies ) ) {
			$taxonomy_names = get_object_taxonomies( 'post' );
			$terms = get_terms( $taxonomy_names, array(
				'orderby' => 'name',
				'include' => $taxonomies
			));

			if( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
				$args['tax_query'] = array('relation' => 'OR');
				foreach ($terms as $key => $term) {
					$args['tax_query'][] = array(
				        'taxonomy' => $term->taxonomy,
				        'field' => 'slug',
				        'terms' => array( $term->slug ),
				        'include_children' => true,
				        'operator' => 'IN'
					);
				}
			}
		}

		if( ! empty( $order ) ) {
			$args['order'] = $order;
		}

		if( ! empty( $offset ) ) {
			$args['offset'] = $offset;
		}

		if( ! empty( $meta_key ) ) {
			$args['meta_key'] = $meta_key;
		}

		if( ! empty( $orderby ) ) {
			$args['orderby'] = $orderby;
		}

	    $blog_query = new WP_Query($args);

	    ob_start();

	    $woodmart_loop['blog_design'] = $blog_design;

	    if ( $carousel_small_img == 'yes' ) $woodmart_loop['blog_design'] = 'carousel_small_img'; 

	    $woodmart_loop['img_size'] = $img_size;

	    $woodmart_loop['columns'] = $blog_columns;

	    $woodmart_loop['loop'] = 0;

	    $woodmart_loop['parts']['title'] = $parts_title;
	    $woodmart_loop['parts']['meta'] = $parts_meta;
	    $woodmart_loop['parts']['text'] = $parts_text;
	    if( ! $parts_btn )
	    	$woodmart_loop['parts']['btn'] = false;

	    if( $blog_design == 'carousel' ) {
	    	echo woodmart_generate_posts_slider($parsed_atts, $blog_query);
	    } else {
		    if ($blog_design == 'masonry') {
		    	$class .= ' masonry-container';
		    }

		    $class .= ' blog-pagination-' . $pagination;

		    if(!$is_ajax) echo '<div class="woodmart-blog-holder row ' . esc_attr( $class ) . '" data-paged="1" data-atts="' . esc_attr( $encoded_atts ) . '" data-source="shortcode">';

			while ( $blog_query->have_posts() ) {
				$blog_query->the_post();

				get_template_part( 'content' );
			}

	    	if(!$is_ajax) echo '</div>';

			if ( $blog_query->max_num_pages > 1 && !$is_ajax && $pagination ) {
				?>
			    	<div class="blog-footer">
			    		<?php if ( $pagination == 'infinit' || $pagination == 'more-btn'): ?>
			    			<a href="#" class="btn woodmart-load-more woodmart-blog-load-more load-on-<?php echo ($pagination == 'more-btn') ? 'click' : 'scroll'; ?>"><span class="load-more-label"><?php esc_html_e('Load more posts', 'woodmart'); ?></span><span class="load-more-loading"><?php esc_html_e('Loading...', 'woodmart'); ?></span></a>
		    			<?php else: ?>
			    			<?php query_pagination( $blog_query->max_num_pages ); ?>
			    		<?php endif ?>
			    	</div>
			    <?php
			}

	    }

	    unset( $woodmart_loop );

	    wp_reset_postdata();

	    woodmart_reset_loop();

	    $output .= ob_get_clean();

	    ob_flush();

	    if( $is_ajax ) {
	    	$output =  array(
	    		'items' => $output,
	    		'status' => ( $blog_query->max_num_pages > $paged ) ? 'have-posts' : 'no-more-posts'
	    	);
	    }

	    return $output;

	}

	
}
if( ! function_exists( 'woodmart_get_blog_shortcode_ajax' ) ) {
	add_action( 'wp_ajax_woodmart_get_blog_shortcode', 'woodmart_get_blog_shortcode_ajax' );
	add_action( 'wp_ajax_nopriv_woodmart_get_blog_shortcode', 'woodmart_get_blog_shortcode_ajax' );
	function woodmart_get_blog_shortcode_ajax() {
		if( ! empty( $_POST['atts'] ) ) {
			$atts = $_POST['atts'];
			$paged = (empty($_POST['paged'])) ? 2 : (int) $_POST['paged'] + 1;
			$atts['ajax_page'] = $paged;

			$data = woodmart_shortcode_blog($atts);

			echo json_encode( $data );

			die();
		}
	}
}


/**
* ------------------------------------------------------------------------------------------------
* Override WP default gallery
* ------------------------------------------------------------------------------------------------
*/


if( ! function_exists( 'woodmart_gallery_shortcode' ) ) {

	function woodmart_gallery_shortcode( $attr ) {
		$post = get_post();

		static $instance = 0;
		$instance++;

		if ( ! empty( $attr['ids'] ) ) {
			// 'ids' is explicitly ordered, unless you specify otherwise.
			if ( empty( $attr['orderby'] ) ) {
				$attr['orderby'] = 'post__in';
			}
			$attr['include'] = $attr['ids'];
		}

		/**
		 * Filter the default gallery shortcode output.
		 *
		 * If the filtered output isn't empty, it will be used instead of generating
		 * the default gallery template.
		 *
		 * @since 2.5.0
		 *
		 * @see gallery_shortcode()
		 *
		 * @param string $output The gallery output. Default empty.
		 * @param array  $attr   Attributes of the gallery shortcode.
		 */
		$output = apply_filters( 'post_gallery', '', $attr );
		if ( $output != '' ) {
			return $output;
		}

		$html5 = current_theme_supports( 'html5', 'gallery' );
		$atts = shortcode_atts( array(
			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post ? $post->ID : 0,
			'itemtag'    => $html5 ? 'figure'     : 'dl',
			'icontag'    => $html5 ? 'div'        : 'dt',
			'captiontag' => $html5 ? 'figcaption' : 'dd',
			'columns'    => 3,
			'size'       => 'thumbnail',
			'include'    => '',
			'exclude'    => '',
			'link'       => ''
		), $attr, 'gallery' );

		$atts['link'] = 'file';

		$id = intval( $atts['id'] );

		if ( ! empty( $atts['include'] ) ) {
			$_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} elseif ( ! empty( $atts['exclude'] ) ) {
			$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
		} else {
			$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
		}

		if ( empty( $attachments ) ) {
			return '';
		}

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment ) {
				$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
			}
			return $output;
		}

		$itemtag = tag_escape( $atts['itemtag'] );
		$captiontag = tag_escape( $atts['captiontag'] );
		$icontag = tag_escape( $atts['icontag'] );
		$valid_tags = wp_kses_allowed_html( 'post' );
		if ( ! isset( $valid_tags[ $itemtag ] ) ) {
			$itemtag = 'dl';
		}
		if ( ! isset( $valid_tags[ $captiontag ] ) ) {
			$captiontag = 'dd';
		}
		if ( ! isset( $valid_tags[ $icontag ] ) ) {
			$icontag = 'dt';
		}

		$columns = intval( $atts['columns'] );
		$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
		$float = is_rtl() ? 'right' : 'left';

		$selector = "gallery-{$instance}";

		$gallery_style = '';

		/**
		 * Filter whether to print default gallery styles.
		 *
		 * @since 3.1.0
		 *
		 * @param bool $print Whether to print default gallery styles.
		 *                    Defaults to false if the theme supports HTML5 galleries.
		 *                    Otherwise, defaults to true.
		 */
		if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
			$gallery_style = "
			<style type='text/css'>
				#{$selector} {
					margin: auto;
				}
				#{$selector} .gallery-item {
					float: {$float};
					margin-top: 10px;
					text-align: center;
					width: {$itemwidth}%;
				}
				#{$selector} img {
					max-width:100%;
				}
				#{$selector} .gallery-caption {
					margin-left: 0;
				}
			</style>\n\t\t";
		}

		$size_class = sanitize_html_class( $atts['size'] );
		$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

		/**
		 * Filter the default gallery shortcode CSS styles.
		 *
		 * @since 2.5.0
		 *
		 * @param string $gallery_style Default CSS styles and opening HTML div container
		 *                              for the gallery shortcode output.
		 */
		$output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

		$rows_width = $thumbs_heights = array();
		$row_i = 0;

		$i = 0;
		foreach ( $attachments as $id => $attachment ) {

			$attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
			if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
				$image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
			} elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
				$image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
			} else {
				$image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
			}
			$image_meta  = wp_get_attachment_metadata( $id );

			$orientation = '';
			if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
				$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
			}

			$output .= "
					$image_output";
			if ( false && $captiontag && trim($attachment->post_excerpt) ) {
				$output .= "
					<{$captiontag} class='wp-caption-text gallery-caption' id='$selector-$id'>
					" . wptexturize($attachment->post_excerpt) . "
					</{$captiontag}>";
			}

			if($i % $columns == 0) {
				$row_i++;
			}

			$thumb = wp_get_attachment_image_src($id, $atts['size']);

			$thumbs_heights[] = $thumb[2];

		}


		ob_start();


		$rowHeight = 250;
		$maxRowHeight = min($thumbs_heights);

		if( $maxRowHeight < $rowHeight) {
			$rowHeight = $maxRowHeight;
		}

		wp_add_inline_script('woodmart-theme', 'jQuery( document ).ready(function() {
					jQuery("#' . esc_js( $selector ) . '").justifiedGallery({
						rowHeight: ' . esc_js( $rowHeight ) . ',
						maxRowHeight: ' . esc_js( $maxRowHeight ) . ',
						margins: 1
					});
				});', 'after');
		
		$output .= ob_get_clean();

		$output .= "
			</div>\n";

		return $output;
	}

}

/**
* ------------------------------------------------------------------------------------------------
* New gallery shortcode
* ------------------------------------------------------------------------------------------------
*/
if( ! function_exists( 'woodmart_images_gallery_shortcode' )) {
	function woodmart_images_gallery_shortcode($atts) {
		$output = $class = '';

		$parsed_atts = shortcode_atts( array_merge( woodmart_get_owl_atts(), array(
			'ids'        => '',
			'images'     => '',
			'columns'    => 3,
			'size'       => '',
			'img_size'   => 'medium',
			'link'       => '',
			'spacing' 	 => 30,
			'on_click'   => 'lightbox',
			'target_blank' => false,
			'custom_links' => '',
			'view'		 => 'grid',
			'caption'    => false,
			'el_class' 	 => ''
		) ), $atts );

		extract( $parsed_atts );


		// Override standard wordpress gallery shortcodes

		if ( ! empty( $atts['ids'] ) ) {
			$atts['images'] = $atts['ids'];
		}

		if ( ! empty( $atts['size'] ) ) {
			$atts['img_size'] = $atts['size'];
		}

		extract( $atts );

		$carousel_id = 'gallery_' . rand(100,999);

		$images = explode(',', $images);

		$class .= ' ' . $el_class;
		if( $view != 'justified' ){
			$class .= ' woodmart-spacing-' . $spacing;
			$class .= ' gallery-spacing-' . $spacing;
		} 
		$class .= ' columns-' . $columns;
		$class .= ' view-' . $view;

		if( 'lightbox' === $on_click ) {
			$class .= ' photoswipe-images';
		}

		if ( 'links' === $on_click && function_exists( 'vc_value_from_safe' ) ) {
			$custom_links = vc_value_from_safe( $custom_links );
			$custom_links = explode( ',', $custom_links );
		}

		ob_start(); ?>
			<div id="<?php echo esc_attr( $carousel_id ); ?>" class="woodmart-images-gallery<?php echo esc_attr( $class ); ?>">
				<div class="gallery-images <?php if ( $view == 'carousel' ) echo 'owl-carousel ' . woodmart_owl_items_per_slide( $slides_per_view ); ?>">
					<?php if ( count($images) > 0 ): ?>
						<?php $i=0; foreach ($images as $img_id):
							$i++;
							$attachment = get_post( $img_id );
							$title = trim( strip_tags( $attachment->post_title ) );
							$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => 'woodmart-gallery-image image-' . $i ) );
							$link = $img['p_img_large']['0'];
							if( 'links' === $on_click ) {
								$link = (isset( $custom_links[$i-1] ) ? $custom_links[$i-1] : '' );
							}
							?>
							<div class="woodmart-gallery-item">
								<?php if ( $on_click != 'none' ): ?>
								<a href="<?php echo esc_url( $link ); ?>" data-index="<?php echo esc_attr( $i ); ?>" data-width="<?php echo esc_attr( $img['p_img_large']['1'] ); ?>" data-height="<?php echo esc_attr( $img['p_img_large']['2'] ); ?>" <?php if( $target_blank ): ?>target="_blank"<?php endif; ?> <?php if( $caption ): ?>title="<?php echo esc_attr( $title ); ?>"<?php endif; ?>>
								<?php endif ?>
									<?php echo wp_kses( $img['thumbnail'], array( 'img' => array('class' => true,'width' => true,'height' => true,'src' => true,'alt' => true) ) );?>
								<?php if ( $on_click != 'none' ): ?>
								</a>
								<?php endif ?>
							</div>
						<?php endforeach ?>
					<?php endif ?>
				</div>
			</div>
			<?php if ( $view == 'carousel' ):

				$parsed_atts['carousel_id'] = $carousel_id;
				woodmart_owl_carousel_init( $parsed_atts );

			elseif ( $view == 'masonry' ): 

				wp_add_inline_script('woodmart-theme', 'jQuery( document ).ready(function( $ ) {
	                if (typeof($.fn.isotope) == "undefined" || typeof($.fn.imagesLoaded) == "undefined") return;
	                var $container = $(".view-masonry .gallery-images");

	                // initialize Masonry after all images have loaded
	                $container.imagesLoaded(function() {
	                    $container.isotope({
	                        gutter: 0,
	                        isOriginLeft: ! $("body").hasClass("rtl"),
	                        itemSelector: ".woodmart-gallery-item"
	                    });
	                });
				});', 'after');

			elseif ( $view == 'justified' ): 

				wp_add_inline_script('woodmart-theme', 'jQuery( document ).ready(function( $ ) {
					$("#' . esc_js( $carousel_id ) . ' .gallery-images").justifiedGallery({
						margins: 1
					});
				});', 'after');

			endif ?>
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;

	}

	
}
/**
* ------------------------------------------------------------------------------------------------
* Categories grid shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_categories' )) {
	function woodmart_shortcode_categories($atts, $content) {
		global $woocommerce_loop;
		$extra_class = '';

		$parsed_atts = shortcode_atts( array_merge( woodmart_get_owl_atts(), array(
			'title' => esc_html__( 'Categories', 'woodmart' ),
			'number'     => null,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'columns'    => '4',
			'hide_empty' => 'yes',
			'parent'     => '',
			'style'      => 'default',
			'ids'        => '',
			'categories_design' => woodmart_get_opt( 'categories_design' ),
			'spacing' => 30,
			'style'      => 'default',
			'el_class' => ''
		) ), $atts );

		extract( $parsed_atts );

		if ( isset( $ids ) ) {
			$ids = explode( ',', $ids );
			$ids = array_map( 'trim', $ids );
		} else {
			$ids = array();
		}

		$hide_empty = ( $hide_empty == 'yes' || $hide_empty == 1 ) ? 1 : 0;

		// get terms and workaround WP bug with parents/pad counts
		$args = array(
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => $hide_empty,
			'include'    => $ids,
			'pad_counts' => true,
			'child_of'   => $parent
		);

		$product_categories = get_terms( 'product_cat', $args );

		if ( '' !== $parent ) {
			$product_categories = wp_list_filter( $product_categories, array( 'parent' => $parent ) );
		}

		if ( $hide_empty ) {
			foreach ( $product_categories as $key => $category ) {
				if ( $category->count == 0 ) {
					unset( $product_categories[ $key ] );
				}
			}
		}

		if ( $number ) {
			$product_categories = array_slice( $product_categories, 0, $number );
		}


		$columns = absint( $columns );

		if( $style == 'masonry' ) {
			$extra_class = 'categories-masonry';
		}

		if( $style == 'masonry-first' ) {
			$woocommerce_loop['different_sizes'] = array(1);
			$extra_class = 'categories-masonry';
			$columns = 4;
		}

		if( $categories_design != 'inherit' ) {
			$woocommerce_loop['categories_design'] = $categories_design;
		}

		$extra_class .= ' woodmart-spacing-' . $spacing;
		$extra_class .= ' products-spacing-' . $spacing;

		$woocommerce_loop['columns'] = $columns;
		$woocommerce_loop['style'] = $style;

		$carousel_id = 'carousel-' . rand(100,999);

		ob_start();

		// Reset loop/columns globals when starting a new loop
		$woocommerce_loop['loop'] = '';

		if ( $product_categories ) {

			if( $style == 'carousel' ) {
				?>

				<div id="<?php echo esc_attr( $carousel_id ); ?>" class="vc_carousel_container">
					<div class="owl-carousel carousel-items <?php echo woodmart_owl_items_per_slide( $slides_per_view ); ?>">
						<?php foreach ( $product_categories as $category ): ?>
							<div class="category-item">
								<?php
									wc_get_template( 'content-product_cat.php', array(
										'category' => $category
									) );
								?>
							</div>
						<?php endforeach; ?>
					</div>
				</div> <!-- end #<?php echo esc_html( $carousel_id ); ?> -->

				<?php
					$parsed_atts['carousel_id'] = $carousel_id;
					woodmart_owl_carousel_init( $parsed_atts );
			} else {

				foreach ( $product_categories as $category ) {
					wc_get_template( 'content-product_cat.php', array(
						'category' => $category
					) );
				}
			}

		}

		unset($woocommerce_loop['different_sizes']);

		woocommerce_reset_loop();

		if( $style == 'carousel' ) {
			return '<div class="products woocommerce categories-style-'. esc_attr( $style ) . ' ' . esc_attr( $extra_class ) . '">' . ob_get_clean() . '</div>';
		} else {
			return '<div class="products woocommerce row categories-style-'. esc_attr( $style ) . ' ' . esc_attr( $extra_class ) . ' columns-' . $columns . '">' . ob_get_clean() . '</div>';
		}

	}

	

}


/**
* ------------------------------------------------------------------------------------------------
* Counter shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_animated_counter' )) {
	function woodmart_shortcode_animated_counter($atts) {
		$output = $label = $el_class = '';
		extract( shortcode_atts( array(
			'label' => '',
			'value' => 100,
			'time' => 1000,
			'size' => 'default',
			'el_class' => ''
		), $atts ) );

		$el_class .= ' counter-' . $size;

		ob_start();
		?>
			<div class="woodmart-counter <?php echo esc_attr( $el_class ); ?>">
				<span class="counter-value" data-state="new" data-final="<?php echo esc_attr( $value ); ?>"><?php echo esc_attr( $value ); ?></span>
				<?php if ($label != ''): ?>
					<span class="counter-label"><?php echo esc_html( $label ); ?></span>
				<?php endif ?>
			</div>

		<?php
		$output .= ob_get_clean();


		return $output;

	}

	

}

/**
* ------------------------------------------------------------------------------------------------
* Team member shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_team_member' )) {
	function woodmart_shortcode_team_member($atts, $content = "") {
		$output = $title = $el_class = '';
		extract( shortcode_atts( array(
	        'align' => 'left',
	        'name' => '',
	        'position' => '',
	        'twitter' => '',
	        'facebook' => '',
	        'google_plus' => '',
	        'skype' => '',
	        'linkedin' => '',
	        'instagram' => '',
	        'image' => '',
	        'img_size' => '270x170',
			'style' => 'default', // circle colored
			'size' => 'default', // circle colored
			'form' => 'circle',
			'woodmart_color_scheme' => 'dark',
			'layout' => 'default',
			'el_class' => ''
		), $atts ) );

		$el_class .= ' member-layout-' . $layout;
		$el_class .= ' color-scheme-' . $woodmart_color_scheme;

		$img_id = preg_replace( '/[^\d]/', '', $image );

		$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => 'team-member-avatar-image' ) );

	    $socials = '';

        if ($linkedin != '' || $twitter != '' || $facebook != '' || $skype != '' || $google_plus != '' || $instagram != '') {
            $socials .= '<div class="member-social"><div class="woodmart-social-icons icons-design-' . esc_attr( $style ) . ' icons-size-' . esc_attr( $size ) .' social-form-' . esc_attr( $form ) .'">';
                if ($facebook != '') {
                    $socials .= '<div class="woodmart-social-icon social-facebook"><a href="'.esc_url( $facebook ).'"><i class="fa fa-facebook"></i></a></div>';
                }
                if ($twitter != '') {
                    $socials .= '<div class="woodmart-social-icon social-twitter"><a href="'.esc_url( $twitter ).'"><i class="fa fa-twitter"></i></a></div>';
                }
                if ($google_plus != '') {
                    $socials .= '<div class="woodmart-social-icon social-google-plus"><a href="'.esc_url( $google_plus ).'"><i class="fa fa-google-plus"></i></a></div>';
                }
                if ($linkedin != '') {
                    $socials .= '<div class="woodmart-social-icon social-linkedin"><a href="'.esc_url( $linkedin ).'"><i class="fa fa-linkedin"></i></a></div>';
                }
                if ($skype != '') {
                    $socials .= '<div class="woodmart-social-icon social-skype"><a href="'.esc_url( $skype ).'"><i class="fa fa-skype"></i></a></div>';
                }
                if ($instagram != '') {
                    $socials .= '<div class="woodmart-social-icon social-instagram"><a href="'.esc_url( $instagram ).'"><i class="fa fa-instagram"></i></a></div>';
                }
            $socials .= '</div></div>';
        }

	    $output .= '<div class="team-member text-' . esc_attr( $align ) . ' '. esc_attr( $el_class ) .'">';

		    if(@$img['thumbnail'] != ''){

	            $output .= '<div class="member-image-wrapper"><div class="member-image">';
	                $output .=  $img['thumbnail'];
	            $output .= '</div></div>';
		    }

	        $output .= '<div class="member-details">';
	            if($name != ''){
	                $output .= '<h4 class="member-name">' . ( $name ) . '</h4>';
	            }
			    if($position != ''){
				    $output .= '<span class="member-position">' . ( $position ) . '</span>';
			    }
			    $output .= '<div class="member-bio">';
			    $output .= do_shortcode($content);
			    $output .=  '</div>';

	    		$output .= $socials;

	    	$output .= '</div>';



	    $output .= '</div>';


	    return $output;
	}

	

}

/**
* ------------------------------------------------------------------------------------------------
* Testimonials shortcodes
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_testimonials' ) ) {
	function woodmart_shortcode_testimonials($atts = array(), $content = null) {
		$output = $class = $autoplay = '';

		$parsed_atts = shortcode_atts( array_merge( woodmart_get_owl_atts(), array(
			'layout' => 'slider', // grid slider
			'style' => 'standard', // standard boxed
			'align' => 'center', // left center
			'columns' => 3,
			'name' => '',
			'title' => '',
			'el_class' => ''
		) ), $atts );

		extract( $parsed_atts );

		$class .= ' testimonials-' . $layout;
		$class .= ' testimon-style-' . $style;
		$class .= ' testimon-columns-' . $columns;
		$class .= ' testimon-align-' . $align;

		if( $layout == 'slider' ) $class .= ' owl-carousel ' . woodmart_owl_items_per_slide( $slides_per_view );

		$class .= ' ' . $el_class;

		$carousel_id = 'carousel-' . rand( 1000, 10000);

		ob_start(); ?>
			<div id="<?php echo esc_attr( $carousel_id ); ?>" class="testimonials-wrapper">
				<?php if ( $title != '' ): ?>
					<h2 class="title slider-title"><?php echo esc_html( $title ); ?></h2>
				<?php endif ?>
				<div class="testimonials<?php echo esc_attr( $class ); ?>" >
					<?php echo do_shortcode( $content ); ?>
				</div>
			</div>

			<?php
				if( $layout == 'slider' ) {
					$parsed_atts['carousel_id'] = $carousel_id;
					woodmart_owl_carousel_init( $parsed_atts );
				}

			 ?>

		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	
}


if( ! function_exists( 'woodmart_shortcode_testimonial' ) ) {
	function woodmart_shortcode_testimonial($atts, $content) {
		if( ! function_exists( 'wpb_getImageBySize' ) ) return;
		$output = $class = '';
		extract(shortcode_atts( array(
			'image' => '',
			'img_size' => '100x100',
			'name' => '',
			'title' => '',
			'el_class' => ''
		), $atts ));

		$img_id = preg_replace( '/[^\d]/', '', $image );

		$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => 'testimonial-avatar-image' ) );

		$class .= ' ' . $el_class;

		ob_start(); ?>

			<div class="testimonial<?php echo esc_attr( $class ); ?>" >
				<div class="testimonial-inner">
					<?php if ( $img['thumbnail'] != ''): ?>
						<div class="testimonial-avatar">
							<?php echo wp_kses( $img['thumbnail'], array( 'img' => array('class' => true,'width' => true,'height' => true,'src' => true,'alt' => true) ) );?>
						</div>
					<?php endif ?>

					<div class="testimonial-content">
						<?php echo do_shortcode( $content ); ?>
						<footer>
							<?php echo esc_html( $name ); ?>
							<?php if ( $title ): ?>
								<span><?php echo esc_html( $title ); ?></span>
							<?php endif ?>
						</footer>
					</div>					
				</div>
			</div>

		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	
}

/**
* ------------------------------------------------------------------------------------------------
* Extra menu (part of the mega menu)
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_extra_menu' ) ) {
	function woodmart_shortcode_extra_menu($atts = array(), $content = null) {
		$output = $class = $liclass = $label_out = '';
		extract(shortcode_atts( array(
			'link' => '',
			'title' => '',
			'label' => 'primary',
			'label_text' => '',
			'el_class' => ''
		), $atts ));

		$label_out = woodmart_get_menu_label_tag( $label, $label_text );
		$liclass .= woodmart_get_menu_label_class( $label );
		$attributes = woodmart_get_link_attributes( $link );

		$class .= ' ' . $el_class;

		ob_start(); ?>

			<ul class="sub-menu<?php echo esc_attr( $class ); ?>" >
				<li class="<?php echo esc_attr( $liclass ); ?>"><a <?php echo ( $attributes ); ?>><span><?php echo esc_html( $title ); ?></span><?php echo ($label_out); ?></a>
					<ul class="sub-sub-menu">
						<?php echo do_shortcode( $content ); ?>
					</ul>
				</li>
			</ul>

		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	
}


if( ! function_exists( 'woodmart_shortcode_extra_menu_list' ) ) {
	function woodmart_shortcode_extra_menu_list($atts, $content) {
		if( ! function_exists( 'wpb_getImageBySize' ) ) return;
		$output = $class = $label_out = '';
		extract(shortcode_atts( array(
			'link' => '',
			'title' => '',
			'label' => 'primary',
			'label_text' => '',
			'el_class' => ''
		), $atts ));


		$label_out = woodmart_get_menu_label_tag( $label, $label_text );
		$class .= woodmart_get_menu_label_class( $label );
		$attributes = woodmart_get_link_attributes( $link );

		$class .= ' ' . $el_class;

		ob_start(); ?>

			<li class="<?php echo esc_attr( $class ); ?>"><a <?php echo ( $attributes ); ?>><span><?php echo ( $title ); ?></span><?php echo ( $label_out ); ?></a></li>

		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	
}
if( ! function_exists( 'woodmart_vc_get_link_attr' ) ) {
	function woodmart_vc_get_link_attr( $link ) {
		$link = ( '||' === $link ) ? '' : $link;
		if( function_exists( 'vc_build_link' ) ){
			$link = vc_build_link( $link );
		}
		return $link;
	}
}

if( ! function_exists( 'woodmart_get_link_attributes' ) ) {
	function woodmart_get_link_attributes( $link, $popup = false ) {
		//parse link
		$link = woodmart_vc_get_link_attr( $link );
		$use_link = false;
		if ( strlen( $link['url'] ) > 0 ) {
			$use_link = true;
			$a_href = apply_filters( 'woodmart_extra_menu_url', $link['url'] );
			if ( $popup ) $a_href = $link['url'];
			$a_title = $link['title'];
			$a_target = $link['target'];
		}

		$attributes = array();

		if ( $use_link ) {
			$attributes[] = 'href="' . trim( $a_href ) . '"';
			$attributes[] = 'title="' . esc_attr( trim( $a_title ) ) . '"';
			if ( ! empty( $a_target ) ) {
				$attributes[] = 'target="' . esc_attr( trim( $a_target ) ) . '"';
			}
		}

		$attributes = implode( ' ', $attributes );

		return $attributes;
	}
}


if( ! function_exists( 'woodmart_get_menu_label_tag' ) ) {
	function woodmart_get_menu_label_tag( $label, $label_text ) {
		if( empty( $label_text ) ) return '';
		$label_out = '<span class="menu-label menu-label-' . $label . '">' . esc_attr( $label_text ) . '</span>';
		return $label_out;
	}
}


if( ! function_exists( 'woodmart_get_menu_label_class' ) ) {
	function woodmart_get_menu_label_class( $label ) {
		$class = '';
		$class .= ' item-with-label';
		$class .= ' item-label-' . $label;
		return $class;
	}
}


/**
* ------------------------------------------------------------------------------------------------
* Pricing tables shortcodes
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_pricing_tables' ) ) {
	function woodmart_shortcode_pricing_tables($atts = array(), $content = null) {
		$output = $class = $autoplay = '';
		extract(shortcode_atts( array(
			'el_class' => ''
		), $atts ));

		$class .= ' ' . $el_class;

		ob_start(); ?>
			<div class="pricing-tables-wrapper">
				<div class="pricing-tables<?php echo esc_attr( $class ); ?>" >
					<?php echo do_shortcode( $content ); ?>
				</div>
			</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	
}

if( ! function_exists( 'woodmart_shortcode_pricing_plan' ) ) {
	function woodmart_shortcode_pricing_plan($atts, $content) {
		global $wpdb, $post;
		if( ! function_exists( 'wpb_getImageBySize' ) ) return;
		$output = $class = '';
		extract(shortcode_atts( array(
			'name' => '',
			'price_value' => '',
			'price_suffix' => 'per month',
			'currency' => '',
			'features_list' => '',
			'label' => '',
			'label_color' => 'red',
			'link' => '',
			'button_label' => '',
			'button_type' => 'custom',
			'id' => '',
			'style' => 'default',
			'best_option' => '',
			'el_class' => ''
		), $atts ));

		$attributes = woodmart_get_link_attributes( $link );

		$class .= ' ' . $el_class;

		if( ! empty( $label ) ) {
			$class .= ' price-with-label label-color-' . $label_color;
		}

		if( $best_option == 'yes' ) {
			$class .= ' price-highlighted';
		}

		$class .= ' price-style-' . $style;


		$features = explode(PHP_EOL, $features_list);

		$product = false;

		if( $button_type == 'product' && ! empty( $id ) ) {
			$product_data = get_post( $id );
			$product = is_object( $product_data ) && in_array( $product_data->post_type, array( 'product', 'product_variation' ) ) ? wc_setup_product_data( $product_data ) : false;
		}

		ob_start(); ?>

			<div class="woodmart-price-table<?php echo esc_attr( $class ); ?>" >
				<div class="woodmart-plan">
					<div class="woodmart-plan-name">
						<span class="woodmart-plan-title"><?php echo  $name; ?></span>
					</div>
				</div>
				<div class="woodmart-plan-inner">
					<?php if ( ! empty( $label ) ): ?>
						<div class="price-label"><span><?php echo  $label; ?></span></div>
					<?php endif ?>
					<div class="woodmart-plan-price">
						<?php if ( $currency ): ?>
							<span class="woodmart-price-currency">
								<?php echo  $currency; ?>
							</span>
						<?php endif ?>

						<?php if ( $price_value ): ?>
							<span class="woodmart-price-value">
								<?php echo  $price_value; ?>
							</span>
						<?php endif ?>

						<?php if ( $price_suffix ): ?>
							<span class="woodmart-price-suffix">
								<?php echo  $price_suffix; ?>
							</span>
						<?php endif ?>
					</div>
					<?php if ( !empty( $features[0] ) ): ?>
						<div class="woodmart-plan-features">
							<?php foreach ($features as $value): ?>
								<div class="woodmart-plan-feature">
									<?php echo  $value; ?>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif ?>
					<div class="woodmart-plan-footer">
						<?php if ( $button_type == 'product' && $product ): ?>
							<?php woocommerce_template_loop_add_to_cart(  ); ?>
						<?php else: ?>
							<?php if ( $button_label ): ?>
								<a <?php echo ( $attributes ); ?> class="button price-plan-btn"><?php echo  $button_label; ?></a>
							<?php endif ?>
						<?php endif ?>
					</div>
				</div>
			</div>

		<?php
		$output = ob_get_contents();
		ob_end_clean();

		if ( $button_type == 'product' ) {
			// Restore Product global in case this is shown inside a product post
			wc_setup_product_data( $post );
		}


		return $output;
	}

	
}



/**
* ------------------------------------------------------------------------------------------------
* Products tabs shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_products_tabs' ) ) {
	function woodmart_shortcode_products_tabs($atts = array(), $content = null) {
		if( ! function_exists( 'wpb_getImageBySize' ) ) return;
		$output = $class = $autoplay = '';
		extract(shortcode_atts( array(
			'title' => '',
			'image' => '',
			'design' => 'default',
			'color' => '#83b735',
			'el_class' => ''
		), $atts ));

		$img_id = preg_replace( '/[^\d]/', '', $image );

		$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => 'full', 'class' => 'tabs-icon' ) );

	    // Extract tab titles
	    preg_match_all( '/products_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
	    $tab_titles = array();

	    if ( isset( $matches[1] ) ) {
	      	$tab_titles = $matches[1];
	    }

	    $tabs_nav = '';
	    $first_tab_title = '';
	    $tabs_nav .= '<ul class="products-tabs-title">';
	    $_i = 0;
	    foreach ( $tab_titles as $tab ) {
	    	$_i++;
			$tab_atts = shortcode_parse_atts( $tab[0] );
			$tab_atts['carousel_js_inline'] = 'yes';
			$encoded_atts = json_encode( $tab_atts );
			if( $_i == 1 && isset( $tab_atts['title'] ) ) $first_tab_title = $tab_atts['title'];
			$class = ( $_i == 1 ) ? ' active-tab-title' : '';
			if ( isset( $tab_atts['title'] ) ) {
				$tabs_nav .= '<li data-atts="' . esc_attr( $encoded_atts ) . '" class="' . esc_attr( $class ) . '"><span class="tab-label">' . $tab_atts['title'] . '</span></li>';
			}
	    }
	    $tabs_nav .= '</ul>';

		$tabs_id = rand(999,9999);

		$class .= ' tabs-' . $tabs_id;

		$class .= ' tabs-design-' . $design;

		$class .= ' ' . $el_class;

		ob_start(); ?>
			<div class="woodmart-products-tabs<?php echo esc_attr( $class ); ?>">
				<div class="woodmart-tabs-header">
					<div class="woodmart-tabs-loader"></div>
					<?php if ( ! empty( $title ) ): ?>
						<div class="tabs-name">
							<?php echo wp_kses( $img['thumbnail'], array( 'img' => array('class' => true,'width' => true,'height' => true,'src' => true,'alt' => true) ) );?> <?php echo ($title); ?>
						</div>
					<?php endif; ?>
					<div class="tabs-navigation-wrapper">
						<span class="open-title-menu"><?php echo ($first_tab_title); ?></span>
						<?php
							echo ($tabs_nav);
						?>
					</div>
				</div>
				<?php
					if ( isset( $tab_titles[0][0] ) ) {
						$first_tab_atts = shortcode_parse_atts( $tab_titles[0][0] );
						echo woodmart_shortcode_products_tab( $first_tab_atts );
					}
				?>
				<style type="text/css">
					.tabs-<?php echo esc_html( $tabs_id ); ?>.tabs-design-simple .tabs-name {
						border-color: <?php echo esc_html( $color ); ?>
					}

					.tabs-<?php echo esc_html( $tabs_id ); ?>.tabs-design-default .products-tabs-title .tab-label:after {
						    background-color: <?php echo esc_html( $color ); ?>
					}

					.tabs-<?php echo esc_html( $tabs_id ); ?>.tabs-design-simple .products-tabs-title li.active-tab-title,
					.tabs-<?php echo esc_html( $tabs_id ); ?>.tabs-design-simple .owl-nav > div:hover,
					.tabs-<?php echo esc_html( $tabs_id ); ?>.tabs-design-simple .wrap-loading-arrow > div:not(.disabled):hover  {
						color: <?php echo esc_html( $color ); ?>
					}
				</style>
			</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	
}

if( ! function_exists( 'woodmart_shortcode_products_tab' ) ) {
	function woodmart_shortcode_products_tab($atts) {
		global $wpdb, $post;
		if( ! function_exists( 'wpb_getImageBySize' ) ) return;
		$output = $class = '';

	    $is_ajax = (defined( 'DOING_AJAX' ) && DOING_AJAX);

		$parsed_atts = shortcode_atts( array_merge( array(
			'title' => '',
		), woodmart_get_default_product_shortcode_atts()), $atts );

		extract( $parsed_atts );

		$parsed_atts['carousel_js_inline'] = 'yes';
		$parsed_atts['force_not_ajax'] = 'yes';

		ob_start(); ?>
			<?php if(!$is_ajax): ?>
				<div class="woodmart-tab-content<?php echo esc_attr( $class ); ?>" >
			<?php endif; ?>

				<?php
					echo woodmart_shortcode_products( $parsed_atts );
				 ?>
			<?php if(!$is_ajax): ?>
				</div>
			<?php endif; ?>
		<?php
		$output = ob_get_clean();

	    if( $is_ajax ) {
	    	$output =  array(
	    		'html' => $output
	    	);
	    }

	    return $output;
	}

	
}

if( ! function_exists( 'woodmart_get_products_tab_ajax' ) ) {
	add_action( 'wp_ajax_woodmart_get_products_tab_shortcode', 'woodmart_get_products_tab_ajax' );
	add_action( 'wp_ajax_nopriv_woodmart_get_products_tab_shortcode', 'woodmart_get_products_tab_ajax' );
	function woodmart_get_products_tab_ajax() {
		if( ! empty( $_POST['atts'] ) ) {
			$atts = $_POST['atts'];
			$data = woodmart_shortcode_products_tab($atts);
			echo json_encode( $data );
			die();
		}
	}
}

/**
* ------------------------------------------------------------------------------------------------
* Mega Menu widget
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_mega_menu' )) {
	function woodmart_shortcode_mega_menu($atts, $content) {
		$output = $title_html = '';
		extract(shortcode_atts( array(
			'title' => '',
			'nav_menu' => '',
			'style' => '',
			'color' => '',
			'woodmart_color_scheme' => 'light',
			'el_class' => ''
		), $atts ));

		$class = $el_class;

		if( $title != '' ) {
			$title_html = '<h5 class="widget-title color-scheme-' . esc_attr( $woodmart_color_scheme ) . '">' . esc_html ( $title ). '</h5>';
		}

		$widget_id = 'widget-' . rand(100,999);

		ob_start(); ?>

			<div id="<?php echo esc_attr( $widget_id ); ?>" class="widget_nav_mega_menu shortcode-mega-menu <?php echo esc_attr( $class ); ?>">

				<?php echo ( $title_html ); ?>

				<div class="woodmart-navigation vertical-navigation">
					<?php
						wp_nav_menu( array(
							'fallback_cb' => '',
							'menu' => $nav_menu,
							'walker' => new WOODMART_Mega_Menu_Walker()
						) );
					?>
				</div>
			</div>

			<?php if ( $color != '' ): ?>
				<style type="text/css">
					#<?php echo esc_attr( $widget_id ); ?> {
						border-color: <?php echo esc_attr($color); ?>
					}
					#<?php echo esc_attr( $widget_id ); ?> .widget-title {
						background-color: <?php echo esc_attr($color); ?>
					}
				</style>
			<?php endif ?>

		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;

	}

	

}


/**
* ------------------------------------------------------------------------------------------------
* Widget user panel
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_user_panel' )) {
	function woodmart_shortcode_user_panel($atts) {
		if( ! woodmart_woocommerce_installed() ) return;
		$click = $output = $title_out = $class = '';
		extract(shortcode_atts( array(
			'title' => '',
		), $atts ));

		$class .= ' ';

		$user = wp_get_current_user();

		ob_start(); ?>

			<div class="woodmart-user-panel<?php echo esc_attr( $class ); ?>">

				<?php if ( ! is_user_logged_in() ): ?>
					<?php printf( wp_kses( __('Please, <a href="%s">log in</a>', 'woodmart'), array(
							'a' => array(
								'href' => array()
							)
						) ), get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>
				<?php else: ?>


					<div class="user-avatar">
						<?php echo get_avatar( $user->ID, 92 ); ?>
					</div>

					<div class="user-info">
						<span><?php printf( wp_kses( __('Welcome, <strong>%s</strong>', 'woodmart'), array(
								'strong' => array()								
							) ), $user->user_login ) ?></span>
						<a href="<?php echo esc_url( wp_logout_url( home_url('/') ) ); ?>" class="logout-link"><?php esc_html_e('Logout', 'woodmart'); ?></a>
					</div>

				<?php endif ?>


			</div>


		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	
}



/**
* ------------------------------------------------------------------------------------------------
* Widget with author info
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_author_area' )) {
	function woodmart_shortcode_author_area($atts, $content) {
		if( ! function_exists( 'wpb_getImageBySize' ) ) return;
		$click = $output = $title_out = $class = '';
		extract(shortcode_atts( array(
			'title' => '',
			'image' => '',
			'img_size' => '800x600',
			'link' => '',
			'link_text' => '',
			'alignment' => 'left',
			'style' => '',
			'woodmart_color_scheme' => 'dark',
			'el_class' => ''
		), $atts ));

		$img_id = preg_replace( '/[^\d]/', '', $image );

		$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => 'author-area-image' ) );


		$class .= ' text-' . $alignment;
		$class .= ' color-scheme-' . $woodmart_color_scheme;
		$class .= ' ' . $el_class;

		if( $title != '' ) {
			$title_out = '<h3 class="title author-title">' . esc_html( $title ) . '</h3>';
		}

		if( $link != '') {
			$attributes = woodmart_get_link_attributes( $link );
			$link = '<a ' . $attributes . '>' . esc_html( $link_text ) . '</a>';
		}

		ob_start(); ?>

			<div class="author-area<?php echo esc_attr( $class ); ?>">

				<?php echo ( $title_out ); ?>

				<div class="author-avatar">
					<?php echo wp_kses( $img['thumbnail'], array( 'img' => array('class' => true,'width' => true,'height' => true,'src' => true,'alt' => true) ) );?>
				</div>
				
				<?php if ( $content ): ?>
					<div class="author-info">
						<?php echo do_shortcode( $content ); ?>
					</div>
				<?php endif ?>

				<?php echo ( $link ); ?>

			</div>


		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	
}

/**
* ------------------------------------------------------------------------------------------------
* Promo banner - image with text and hover effect
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_promo_banner' )) {
	function woodmart_shortcode_promo_banner($atts, $content) {
		if( ! function_exists( 'wpb_getImageBySize' ) ) return;
		$click = $output = $class = $subtitle_class = '';
		extract(shortcode_atts( array(
			'image' => '',
			'img_size' => '800x600',
			'link' => '',
			'text_alignment' => 'left',
			'vertical_alignment' => 'top',
			'horizontal_alignment' => 'left',
			'style' => '',
			'hover' => 'zoom',
			'increase_spaces' => '',
			'woodmart_color_scheme' => 'light',
			'btn_text' => '',
			'btn_position' => 'hover',
			'btn_color' 	 => 'default',
			'btn_style'   	 => 'default',
			'btn_size' 		 => 'default',
			'title' 	 => '',
			'subtitle' 	 => '',
			'subtitle_color' 	 => 'default',
			'subtitle_style' 	 => 'default',
			'title_size'  => 'default',
			'el_class' => ''
		), $atts ));

		$images = explode(',', $image);

		if( $link != '') {
			$class .= ' cursor-pointer';
		}

		$class .= ' text-' . $text_alignment;
		$class .= ' vertical-alignment-' . $vertical_alignment;
		$class .= ' horizontal-alignment-' . $horizontal_alignment;
		$class .= ' banner-' . $style;
		$class .= ' hover-' . $hover;
		$class .= ' banner-title-' . $title_size;
		$class .= ' color-scheme-' . $woodmart_color_scheme;
		$class .= ' banner-btn-size-' . $btn_size;
		$class .= ' banner-btn-style-' . $btn_style;
		$subtitle_class .= ' subtitle-color-' . $subtitle_color;
		$subtitle_class .= ' subtitle-style-' . $subtitle_style;

		if( $increase_spaces == 'yes' ) {
			$class .= ' increased-padding';
		}
		$class .= ' ' . $el_class;


		$attributes = woodmart_vc_get_link_attr( $link );

		if( ! empty( $btn_text ) ) {
			$class .= ' with-btn';
			$class .= ' btn-position-' . $btn_position;
		}

		if ( count($images) > 1 ) {
			$class .= ' multi-banner';
		}

        if( $attributes['target'] == ' _blank' ) {
        	$onclick = 'onclick="window.open(\''. esc_url( $attributes['url'] ).'\',\'_blank\')"';
        } else {
        	$onclick = 'onclick="window.location.href=\''. esc_url( $attributes['url'] ).'\'"';
        }

		ob_start(); ?>
		<div class="promo-banner-wrapper">
			<div class="promo-banner<?php echo esc_attr( $class ); ?>" <?php if( ! empty( $link ) ) echo ( $onclick ); ?> >

				<div class="main-wrapp-img">
					<div class="banner-image">
						<?php if ( count($images) > 0 ): ?>
							<?php $i=0; foreach ($images as $img_id): $i++; ?>
								<?php $img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => 'promo-banner-image image-' . $i ) ); ?>
								<?php echo wp_kses( $img['thumbnail'], array( 'img' => array('class' => true,'width' => true,'height' => true,'src' => true,'alt' => true) ) );?>
							<?php endforeach ?>
						<?php endif ?>
					</div>
				</div>

				<div class="wrapper-content-banner">
					<div class="content-banner">
							<div class="baner-title-wrap"><?php
								if( ! empty( $subtitle ) ) {
									echo '<span class="banner-subtitle' . esc_attr( $subtitle_class ) . '">' . $subtitle . '</span>';
								}
								if( ! empty( $title ) ) {
									echo '<h4 class="banner-title">' . $title . '</h4>';
								}
							 ?></div>
						<?php if ( $content ): ?>
							<div class="banner-inner">
								<?php
									echo do_shortcode( $content );
								?>
							</div>
						<?php endif ?>
						<?php
							if( ! empty( $btn_text ) ) {
								echo '<div class="banner-btn-wrapper">';
								echo woodmart_shortcode_button( array(
										'title' 	 => $btn_text,
										'link' 	 	 => $link,
										'color' 	 => $btn_color,
										'style'   	 => $btn_style,
										'size' 		 => $btn_size,
										'align'  	 => $text_alignment,
									) );
								echo '</div>';
							}
						?>
					</div>
				</div>

			</div>
		</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	

}


if( ! function_exists( 'woodmart_shortcode_banners_carousel' ) ) {
	function woodmart_shortcode_banners_carousel($atts = array(), $content = null) {
		$output = $class = $autoplay = '';

		$parsed_atts = shortcode_atts( array_merge( woodmart_get_owl_atts(), array(
			'slider_spacing' => 30,
			'dragEndSpeed' => 600,
			'el_class' => '',
		) ), $atts );

		extract( $parsed_atts );

		$class .= ' ' . $el_class;
		$class .= ' ' . woodmart_owl_items_per_slide( $slides_per_view );

		$carousel_id = 'carousel-' . rand(100,999);

		ob_start(); ?>
			<div id="<?php echo esc_attr( $carousel_id ); ?>" class="banners-carousel-wrapper banners-spacing-<?php echo esc_attr( $slider_spacing ); ?>  woodmart-spacing-<?php echo esc_attr( $slider_spacing ); ?> banners-per-view-<?php echo esc_attr($slides_per_view); ?>">
				<div class="owl-carousel banners-carousel<?php echo esc_attr( $class ); ?>" >
					<?php echo do_shortcode( $content ); ?>
				</div>
			</div>

			<?php

				$parsed_atts['carousel_id'] = $carousel_id;
				woodmart_owl_carousel_init( $parsed_atts );

			 ?>

		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	
}


/**
* ------------------------------------------------------------------------------------------------
* Info box
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_info_box' )) {
	function woodmart_shortcode_info_box($atts, $content) {
		if( ! function_exists( 'wpb_getImageBySize' ) ) return;
		$click = $output = $class = $text_class = $subtitle_class = '';
		extract(shortcode_atts( array(
			'image' => '',
			'icon_type' => 'icon',
			'icon_text' => '',
			'icon_text_size' => 'default',
			'img_size' => '800x600',
			'link' => '',
			'alignment' => 'left',
			'image_alignment' => 'top',
			'style' => '',
			'hover' => '',
			'woodmart_color_scheme' => 'dark',
			'css' => '',
			'btn_text' => '',
			'btn_position' => 'hover',
			'btn_color' 	 => 'default',
			'btn_style'   	 => 'default',
			'btn_size' 		 => 'default',
			'title' 	 => '',
			'subtitle' 	 => '',
			'subtitle_color' 	 => 'default',
			'subtitle_style' 	 => 'default',
			'svg_animation' => '',
			'info_box_inline' => '',
			'title_size'  => 'default',
			'el_class' => ''
		), $atts ));


		$images = explode(',', $image);

		if( $link != '') {
			$class .= ' cursor-pointer';
		}

		$class .= ' woodmart-info-box';
		$class .= ' text-' . $alignment;
		$class .= ' box-title-' . $title_size;
		$class .= ' icon-alignment-' . $image_alignment;
		$class .= ' box-' . $style;
		$subtitle_class .= ' subtitle-style-' . $subtitle_style;
		$subtitle_class .= ' subtitle-color-' . $subtitle_color;
		// $class .= ' hover-' . $hover;
		$class .= ' color-scheme-' . $woodmart_color_scheme;
		if( $svg_animation == 'yes' ) $class .= ' with-animation';
		$text_class .= ( $icon_type == 'icon' ) ? ' with-icon' : ' with-text text-size-'. $icon_text_size;
		$class .= ( $el_class ) ? ' ' . $el_class : '';

		$attributes = woodmart_vc_get_link_attr( $link );
		if ( count($images) > 1 ) {
			$class .= ' multi-icons';
		}

		if( $info_box_inline == 'yes' ) $class .= ' info-box-inline';

		if( ! empty( $btn_text ) ) {
			$class .= ' with-btn';
			$class .= ' btn-position-' . $btn_position;
		}

		if( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$class .= ' ' . vc_shortcode_custom_css_class( $css );
		}

		$rand = "svg-" . rand(1000,9999);

		$sizes = explode( 'x', $img_size );

		$width = $height = 128;
		if( count( $sizes ) == 2 ) {
			$width = $sizes[0];
			$height = $sizes[1];
		}
        if( $attributes['target'] == ' _blank' ) {
        	$onclick = 'window.open("'. esc_url( $attributes['url'] ).'","_blank")';
        } else {
        	$onclick = 'window.location.href="'. esc_url( $attributes['url'] ).'"';
        }

		ob_start(); ?>
			<div class="<?php echo esc_attr( $class ); ?>" <?php if( ! empty( $attributes['url'] ) ): ?> onclick="<?php echo esc_js( $onclick ); ?>" <?php endif; ?> >
				<?php if ( $images[0] || $icon_text ): ?>
					<div class="box-icon-wrapper <?php echo esc_attr( $text_class ); ?>">
						<div class="info-box-icon">

						<?php if ( $icon_type == 'icon' ): ?>

							<?php $i=0; foreach ($images as $img_id): $i++; ?>
								<?php $img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => 'info-icon image-' . $i ) ); ?>
								<?php
									$src = $img['p_img_large'][0];
									if( substr($src, -3, 3) == 'svg' ) {
										if ( $svg_animation == 'yes' ) {
											wp_add_inline_script('woodmart-theme', 'jQuery(document).ready(function($) {
												new Vivus("' . esc_js( $rand ) . '", {
												    type: "delayed",
												    duration: 200,
												    start: "inViewport",
												    animTimingFunction: Vivus.EASE_OUT
												});
											});', 'after');
										}
										echo '<div class="info-svg-wrapper info-icon" style="width: ' . $width . 'px;height: ' . $height . 'px;">' . woodmart_get_any_svg( $src, $rand ) . '</div>';
									} else {
										echo wp_kses( $img['thumbnail'], array( 'img' => array('class' => true,'width' => true,'height' => true,'src' => true,'alt' => true) ) );
									}
								 ?>
							<?php endforeach ?>								
						<?php else: ?>
							<?php echo esc_attr( $icon_text ); ?>
						<?php endif ?>

						</div>
					</div>
				<?php endif; ?>
				<div class="info-box-content">
					<?php
						if( ! empty( $subtitle ) ) {
							echo '<div class="info-box-subtitle'. esc_attr( $subtitle_class ) .'">' . $subtitle . '</div>';
						}
						if( ! empty( $title ) ) {
							echo '<div class="info-box-title">' . $title . '</div>';
						}
					 ?>
					<div class="info-box-inner">
						<?php
							echo do_shortcode( $content );
						?>
					</div>

					<?php
						if( ! empty( $btn_text ) ) {
							echo '<div class="info-btn-wrapper">';
							echo woodmart_shortcode_button( array(
									'title' 	 => $btn_text,
									'link' 	 	 => $link,
									'color' 	 => $btn_color,
									'style'   	 => $btn_style,
									'size' 		 => $btn_size,
									'align'  	 => $alignment,
								) );
							echo '</div>';
						}
					?>
					
				</div>
			</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	

}


/**
* ------------------------------------------------------------------------------------------------
* 3D view - images in 360 slider
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_3d_view' )) {
	function woodmart_shortcode_3d_view($atts, $content) {
		if( ! function_exists( 'wpb_getImageBySize' ) ) return;
		$click = $output = $class = '';
		extract(shortcode_atts( array(
			'images' => '',
			'img_size' => 'full',
			'title' => '',
			'link' => '',
			'style' => '',
			'el_class' => ''
		), $atts ));

		$id = rand(100,999);

		$images = explode(',', $images);

		if( $link != '') {
			$class .= ' cursor-pointer';
		}

		$class .= ' ' . $el_class;

		$frames_count = count($images);

		if ( $frames_count < 2 ) return;

		$images_js_string = '';

		$width = $height = 0;

		ob_start(); ?>
			<div class="woodmart-threed-view<?php echo esc_attr( $class ); ?> threed-id-<?php echo esc_attr( $id ); ?>" <?php if( ! empty( $link ) ): ?>onclick="window.location.href='<?php echo esc_js( $link ) ?>'"<?php endif; ?> >
				<?php if ( ! empty( $title ) ): ?>
					<h3 class="threed-title"><span><?php echo ($title); ?></span></h3>
				<?php endif ?>
				<ul class="threed-view-images">
					<?php if ( count($images) > 0 ): ?>
						<?php $i=0; foreach ($images as $img_id): $i++; ?>
							<?php
								$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => 'threed-view-image image-' . $i ) );
								$width = $img['p_img_large'][1];
								$height = $img['p_img_large'][2];
								$images_js_string .= "'" . $img['p_img_large'][0] . "'";
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

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	
}


/**
* ------------------------------------------------------------------------------------------------
* Menu price element
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_menu_price' )) {
	function woodmart_shortcode_menu_price($atts, $content) {
		if( ! function_exists( 'wpb_getImageBySize' ) ) return;
		$click = $output = $class = '';
		extract(shortcode_atts( array(
			'img_id' => '',
			'img_size' => 'full',
			'title' => '',
			'description' => '',
			'price' => '',
			'link' => '',
			'el_class' => ''
		), $atts ));


		if( $link != '') {
			$class .= ' cursor-pointer';
		}

		$class .= ' ' . $el_class;

		$attributes = woodmart_vc_get_link_attr( $link );

		if( $attributes['target'] == ' _blank' ) {
        	$onclick = 'onclick="window.open(\''. esc_url( $attributes['url'] ).'\',\'_blank\')"';
        } else {
        	$onclick = 'onclick="window.location.href=\''. esc_url( $attributes['url'] ).'\'"';
        }

		ob_start(); ?>
			<div class="woodmart-menu-price<?php echo esc_attr( $class ); ?>" <?php if( ! empty( $link ) ) echo ( $onclick ); ?> >
				<?php if ($img_id): ?>
					<div class="menu-price-image">
						<?php
							$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => '' ) );
							echo wp_kses( $img['thumbnail'], array( 'img' => array('class' => true,'width' => true,'height' => true,'src' => true,'alt' => true) ) );
						?>
					</div>
				<?php endif ?>
				<div class="menu-price-description-wrapp">
					<div class="menu-price-heading">
						<?php if ( ! empty( $title ) ): ?>
							<h3 class="menu-price-title"><span><?php echo ($title); ?></span></h3>
						<?php endif ?>
						<div class="menu-price-price price"><?php echo ($price); ?></div>
					</div>
					<?php if ( $description ): ?>
						<div class="menu-price-details"><?php echo ($description); ?></div>
					<?php endif ?>
				</div>
			</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	
}

/**
* ------------------------------------------------------------------------------------------------
* Countdown timer
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_countdown_timer' )) {
	function woodmart_shortcode_countdown_timer($atts, $content) {
		if( ! function_exists( 'wpb_getImageBySize' ) ) return;
		$click = $output = $class = '';
		extract(shortcode_atts( array(
			'date' => '2018/12/12',
			'woodmart_color_scheme' => 'dark',
			'size' => 'medium',
			'align' => 'center',
			'style' => 'base',
			'el_class' => ''
		), $atts ));

		$class .= ' ' . $el_class;
		$class .= ' color-scheme-' . $woodmart_color_scheme;
		$class .= ' text-' . $align;
		$class .= ' timer-size-' . $size;
		$class .= ' timer-style-' . $style;

		ob_start(); ?>
			<div class="woodmart-countdown-timer<?php echo esc_attr( $class ); ?>">
				<div class="woodmart-timer" data-end-date="<?php echo esc_attr( $date ) ?>"></div>
			</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	
}

/**
* ------------------------------------------------------------------------------------------------
* Share and follow buttons shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_social' )) {
	function woodmart_shortcode_social($atts) {
		extract(shortcode_atts( array(
			'type' => 'share',
			'align' => 'center',
			'tooltip' => 'no',
			'style' => 'default', // circle colored
			'size' => 'default', // circle colored
			'form' => 'circle',
			'color' => 'dark',
			'el_class' => '',
		), $atts ));

		$target = "_blank";

		$classes = 'woodmart-social-icons';
		$classes .= ' text-' . $align;
		$classes .= ' icons-design-' . $style;
		$classes .= ' icons-size-' . $size;
		$classes .= ' color-scheme-' . $color;
		$classes .= ' social-' . $type;
		$classes .= ' social-form-' . $form;
		$classes .= ( $el_class ) ? $el_class : '';


		$thumb_id = get_post_thumbnail_id();
		$thumb_url = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);

		ob_start();
		?>

			<div class="<?php echo esc_attr( $classes ); ?>">
				<?php if ( ( $type == 'share' && woodmart_get_opt('share_fb') ) || ( $type == 'follow' && woodmart_get_opt( 'fb_link' ) != '')): ?>
					<div class="woodmart-social-icon social-facebook"><a href="<?php echo ($type == 'follow') ? esc_url(woodmart_get_opt( 'fb_link' )) : 'https://www.facebook.com/sharer/sharer.php?u=' . get_the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'woodmart-tooltip'; ?>"><i class="fa fa-facebook"></i><?php esc_html_e('Facebook', 'woodmart') ?></a></div>
				<?php endif ?>

				<?php if ( ( $type == 'share' && woodmart_get_opt('share_twitter') ) || ( $type == 'follow' && woodmart_get_opt( 'twitter_link' ) != '')): ?>
					<div class="woodmart-social-icon social-twitter"><a href="<?php echo ($type == 'follow') ? esc_url(woodmart_get_opt( 'twitter_link' )) : 'http://twitter.com/share?url=' . get_the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'woodmart-tooltip'; ?>"><i class="fa fa-twitter"></i><?php esc_html_e('Twitter', 'woodmart') ?></a></div>
				<?php endif ?>

				<?php if ( ( $type == 'share' && woodmart_get_opt('share_google') ) || ( $type == 'follow' && woodmart_get_opt( 'google_link' ) != '' ) ): ?>
					<div class="woodmart-social-icon social-google"><a href="<?php echo ($type == 'follow') ? esc_url(woodmart_get_opt( 'google_link' )) : 'http://plus.google.com/share?url=' . get_the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'woodmart-tooltip'; ?>"><i class="fa fa-google-plus"></i><?php esc_html_e('Google', 'woodmart') ?></a></div>
				<?php endif ?>

				<?php if ( woodmart_get_opt( 'social_email' ) ): ?>
					<div class="woodmart-social-icon social-email"><a href="mailto:<?php echo '?subject=' . esc_html__('Check this ', 'woodmart') . get_the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'woodmart-tooltip'; ?>"><i class="fa fa-envelope"></i><?php esc_html_e('Email', 'woodmart') ?></a></div>
				<?php endif ?>

				<?php if ( $type == 'follow' && woodmart_get_opt( 'isntagram_link' ) != ''): ?>
					<div class="woodmart-social-icon social-instagram"><a href="<?php echo ($type == 'follow') ? esc_url(woodmart_get_opt( 'isntagram_link' )) : '' . get_the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'woodmart-tooltip'; ?>"><i class="fa fa-instagram"></i><?php esc_html_e('Instagram', 'woodmart') ?></a></div>
				<?php endif ?>

				<?php if ( $type == 'follow' && woodmart_get_opt( 'youtube_link' ) != ''): ?>
					<div class="woodmart-social-icon social-youtube"><a href="<?php echo ($type == 'follow') ? esc_url(woodmart_get_opt( 'youtube_link' )) : '' . get_the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'woodmart-tooltip'; ?>"><i class="fa fa-youtube"></i><?php esc_html_e('YouTube', 'woodmart') ?></a></div>
				<?php endif ?>

				<?php if ( ( $type == 'share' && woodmart_get_opt('share_pinterest') ) || ( $type == 'follow' && woodmart_get_opt( 'pinterest_link' ) != '' ) ): ?>
					<div class="woodmart-social-icon social-pinterest"><a href="<?php echo ($type == 'follow') ? esc_url(woodmart_get_opt( 'pinterest_link' )) : 'http://pinterest.com/pin/create/button/?url=' . get_the_permalink() . '&media=' . $thumb_url[0]; ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'woodmart-tooltip'; ?>"><i class="fa fa-pinterest"></i><?php esc_html_e('Pinterest', 'woodmart') ?></a></div>
				<?php endif ?>

				<?php if ( $type == 'follow' && woodmart_get_opt( 'tumblr_link' ) != ''): ?>
					<div class="woodmart-social-icon social-tumblr"><a href="<?php echo ($type == 'follow') ? esc_url(woodmart_get_opt( 'tumblr_link' )) : '' . get_the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'woodmart-tooltip'; ?>"><i class="fa fa-tumblr"></i><?php esc_html_e('Tumblr', 'woodmart') ?></a></div>
				<?php endif ?>

				<?php if ( $type == 'follow' && woodmart_get_opt( 'linkedin_link' ) != ''): ?>
					<div class="woodmart-social-icon social-linkedin"><a href="<?php echo ($type == 'follow') ? esc_url(woodmart_get_opt( 'linkedin_link' )) : '' . get_the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'woodmart-tooltip'; ?>"><i class="fa fa-linkedin"></i><?php esc_html_e('linkedin', 'woodmart') ?></a></div>
				<?php endif ?>

				<?php if ( $type == 'follow' && woodmart_get_opt( 'vimeo_link' ) != ''): ?>
					<div class="woodmart-social-icon social-vimeo"><a href="<?php echo ($type == 'follow') ? esc_url(woodmart_get_opt( 'vimeo_link' )) : '' . get_the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'woodmart-tooltip'; ?>"><i class="fa fa-vimeo"></i><?php esc_html_e('Vimeo', 'woodmart') ?></a></div>
				<?php endif ?>

				<?php if ( $type == 'follow' && woodmart_get_opt( 'flickr_link' ) != ''): ?>
					<div class="woodmart-social-icon social-flickr"><a href="<?php echo ($type == 'follow') ? esc_url(woodmart_get_opt( 'flickr_link' )) : '' . get_the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'woodmart-tooltip'; ?>"><i class="fa fa-flickr"></i><?php esc_html_e('Flickr', 'woodmart') ?></a></div>
				<?php endif ?>

				<?php if ( $type == 'follow' && woodmart_get_opt( 'github_link' ) != ''): ?>
					<div class="woodmart-social-icon social-github"><a href="<?php echo ($type == 'follow') ? esc_url(woodmart_get_opt( 'github_link' )) : '' . get_the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'woodmart-tooltip'; ?>"><i class="fa fa-github"></i><?php esc_html_e('GitHub', 'woodmart') ?></a></div>
				<?php endif ?>

				<?php if ( $type == 'follow' && woodmart_get_opt( 'dribbble_link' ) != ''): ?>
					<div class="woodmart-social-icon social-dribbble"><a href="<?php echo ($type == 'follow') ? esc_url(woodmart_get_opt( 'dribbble_link' )) : '' . get_the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'woodmart-tooltip'; ?>"><i class="fa fa-dribbble"></i><?php esc_html_e('Dribbble', 'woodmart') ?></a></div>
				<?php endif ?>

				<?php if ( $type == 'follow' && woodmart_get_opt( 'behance_link' ) != ''): ?>
					<div class="woodmart-social-icon social-behance"><a href="<?php echo ($type == 'follow') ? esc_url(woodmart_get_opt( 'behance_link' )) : '' . get_the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'woodmart-tooltip'; ?>"><i class="fa fa-behance"></i><?php esc_html_e('Behance', 'woodmart') ?></a></div>
				<?php endif ?>

				<?php if ( $type == 'follow' && woodmart_get_opt( 'soundcloud_link' ) != ''): ?>
					<div class="woodmart-social-icon ocial-soundcloud"><a href="<?php echo ($type == 'follow') ? esc_url(woodmart_get_opt( 'soundcloud_link' )) : '' . get_the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'woodmart-tooltip'; ?>"><i class="fa fa-soundcloud"></i><?php esc_html_e('Soundcloud', 'woodmart') ?></a></div>
				<?php endif ?>

				<?php if ( $type == 'follow' && woodmart_get_opt( 'spotify_link' ) != ''): ?>
					<div class="woodmart-social-icon social-spotify"><a href="<?php echo ($type == 'follow') ? esc_url(woodmart_get_opt( 'spotify_link' )) : '' . get_the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'woodmart-tooltip'; ?>"><i class="fa fa-spotify"></i><?php esc_html_e('Spotify', 'woodmart') ?></a></div>
				<?php endif ?>

				<?php if ( ( $type == 'share' && woodmart_get_opt('share_ok') ) || ( $type == 'follow' && woodmart_get_opt( 'ok_link' ) != '' ) ): ?>
					<div class="woodmart-social-icon social-ok"><a href="<?php echo ($type == 'follow') ? esc_url(woodmart_get_opt( 'ok_link' )) : 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=
' . get_the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'woodmart-tooltip'; ?>"><i class="fa fa-odnoklassniki"></i><?php esc_html_e('Odnoklassniki', 'woodmart') ?></a></div>
				<?php endif ?>

				<?php if ( $type == 'share' && woodmart_get_opt('share_whatsapp') ): ?>
					<div class="woodmart-social-icon social-whatsapp"><a href="<?php echo ($type == 'follow') ? ( woodmart_get_opt( 'whatsapp_link' )) : 'whatsapp://send?text=' . get_the_permalink(); ?>" target="<?php echo esc_attr( $target ); ?>" class="<?php if( $tooltip == "yes" ) echo 'woodmart-tooltip'; ?>"><i class="fa fa-whatsapp"></i><?php esc_html_e('WhatsApp', 'woodmart') ?></a></div>
				<?php endif ?>

			</div>

		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	
}

/**
* ------------------------------------------------------------------------------------------------
* Shortcode function to display posts teaser
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_posts_teaser' )) {
	function woodmart_shortcode_posts_teaser($atts, $query = false) {
		global $woocommerce_loop;
		$posts_query = $el_class = $args = $my_query = $title_out = $output = '';
		$posts = array();
		extract( shortcode_atts( array(
			'el_class' => '',
			'posts_query' => '',
			'style' => 'default',
			'title' => '',
		), $atts ) );

		if( ! $query && function_exists( 'vc_build_loop_query' ) ) {
			list( $args, $query ) = vc_build_loop_query( $posts_query ); //
		}

		$carousel_id = 'teaser-' . rand(100,999);

		if( $title != '' ) {
			$title_out = '<h3 class="title teaser-title">' . esc_html( $title ) . '</h3>';
		}

		ob_start();

		if($query->have_posts()) {
			echo ( $title_out );
			?>
				<div id="<?php echo esc_html( $carousel_id ); ?>">
					<div class="posts-teaser teaser-style-<?php echo esc_attr( $style ); ?> <?php echo esc_attr( $el_class ); ?>">

						<?php
							$_i = 0;
							while ( $query->have_posts() ) {
								$_i++;
								$query->the_post(); // Get post from query
								?>
									<div class="post-teaser-item teaser-item-<?php echo esc_attr( $_i ); ?>">

										<?php if( has_post_thumbnail() ) {
											?>
												<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_post_thumbnail( ( $_i == 1 ) ? 'large' : 'medium' ); ?></a>
											<?php
										} ?>

										<a href="<?php echo esc_url( get_permalink() ); ?>" class="post-title"><?php the_title(); ?></a>

										<?php woodmart_post_meta(array(
											'author' => 0,
											'labels' => 1,
											'cats' => 0,
											'tags' => 0
										)); ?>

									</div>
								<?php
							}
						?>

					</div> <!-- end posts-teaser -->
				</div> <!-- end #<?php echo esc_html( $carousel_id ); ?> -->
				<?php

		}
		wp_reset_postdata();

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	
}

/**
* ------------------------------------------------------------------------------------------------
* Shortcode function to display posts as a slider or as a grid
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_generate_posts_slider' )) {
	function woodmart_generate_posts_slider($atts, $query = false, $products = false ) {
		global $woocommerce_loop, $woodmart_loop;
		$posts_query = $el_class = $args = $my_query = $speed = '';
		$slides_per_view = $wrap = $scroll_per_page = $title_out = '';
		$autoplay = $hide_pagination_control = $hide_prev_next_buttons = $output = '';
		$posts = array();

		$parsed_atts = shortcode_atts( array_merge( woodmart_get_owl_atts(), array(
			'el_class' => '',
			'posts_query' => '',
	        'product_hover'  => woodmart_get_opt( 'products_hover' ),
	        'img_size' => 'large',
			'title' => '',
		) ), $atts );

		extract( $parsed_atts );

		$woodmart_loop['img_size'] = $img_size;

		if( ! $query && ! $products && function_exists( 'vc_build_loop_query' ) ) {
			list( $args, $query ) = vc_build_loop_query( $posts_query ); //
		}

		$carousel_id = 'carousel-' . rand(100,999);

		if( $title != '' ) {
			$title_out = '<h3 class="title slider-title">' . esc_html( $title ) . '</h3>';
		}

		$woocommerce_loop['product_hover']   = $product_hover;

		ob_start();

		$post_type = ( isset( $query->query['post_type'] ) ) ? $query->query['post_type'] : 'post';

		if( ( $query && $query->have_posts() ) || $products) {
			?>
				<div id="<?php echo esc_attr( $carousel_id ); ?>" class="vc_carousel_container">
					<?php echo ( $title_out ); ?>
					<div class="<?php echo woodmart_owl_items_per_slide( $slides_per_view ); ?> owl-carousel slider-type-<?php echo esc_attr( $post_type ); ?> <?php echo esc_attr( $el_class ); ?>">

						<?php
							if( $products ) {
								foreach ( $products as $product )  {
									woodmart_carousel_query_item(false, $product);
								}
							} else {
								while ( $query->have_posts() ) {
									woodmart_carousel_query_item($query);
								}
							}
							unset( $woocommerce_loop['slider'] );

						?>

					</div> <!-- end product-items -->
				</div> <!-- end #<?php echo esc_html( $carousel_id ); ?> -->

			<?php

				$parsed_atts['carousel_id'] = $carousel_id;
				woodmart_owl_carousel_init( $parsed_atts );

		}
		wp_reset_postdata();
		unset($woodmart_loop['img_size']);

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}

if( ! function_exists( 'woodmart_carousel_query_item' ) ) {
	function woodmart_carousel_query_item( $query = false, $product = false ) {
		global $woocommerce_loop, $post;
		if( $query ) {
			$query->the_post(); // Get post from query
		} else if( $product ) {
			$post_object = get_post( $product->get_id() );
			$post = $post_object;
			setup_postdata( $post );
		}
		?>
			<div class="slide-<?php echo get_post_type(); ?> owl-carousel-item">
				<div class="owl-carousel-item-inner">

					<?php if ( get_post_type() == 'product' || get_post_type() == 'product_variation' && woodmart_woocommerce_installed() ): ?>
						<?php $woocommerce_loop['slider'] = true; ?>
						<?php wc_get_template_part('content-product'); ?>
					<?php elseif( get_post_type() == 'portfolio' ): ?>
						<?php get_template_part( 'content', 'portfolio-slider' ); ?>
					<?php else: ?>
						<?php get_template_part( 'content', 'slider' ); ?>
					<?php endif ?>

				</div>
			</div>
		<?php
	}
}


/**
* ------------------------------------------------------------------------------------------------
* Shortcode function to display posts as a slider or as a grid
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_products' ) ) {
	
	function woodmart_shortcode_products($atts, $query = false) {
		global $woocommerce_loop, $woodmart_loop;
		
	    $parsed_atts = shortcode_atts( woodmart_get_default_product_shortcode_atts(), $atts );

		extract( $parsed_atts );

		$woodmart_loop['img_size'] = $img_size;

		$woocommerce_loop['masonry'] = $products_masonry;
		$woocommerce_loop['different_sizes'] = $products_different_sizes;

	    $is_ajax = (defined( 'DOING_AJAX' ) && DOING_AJAX && $force_not_ajax != 'yes' );

	    $parsed_atts['force_not_ajax'] = 'no'; // :)

	    $encoded_atts = json_encode( $parsed_atts );

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		if( $ajax_page > 1 ) $paged = $ajax_page;

		$ordering_args = WC()->query->get_catalog_ordering_args( $orderby, $order );

		$meta_query   = WC()->query->get_meta_query();

		$tax_query   = WC()->query->get_tax_query();

		if( $post_type == 'featured' ) {
			$tax_query[] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'featured',
				'operator' => 'IN',
			);
		}

		if( $orderby == 'post__in' ) {
			$ordering_args['orderby'] = $orderby;
		}

	    $args = array(
	    	'post_type' 			=> 'product',
	    	'status' 				=> 'published',
			'ignore_sticky_posts' 	=> 1,
	    	'paged' 			  	=> $paged,
			'orderby'             	=> $ordering_args['orderby'],
			'order'               	=> $ordering_args['order'],
	    	'posts_per_page' 		=> $items_per_page,
	    	'meta_query' 			=> $meta_query,
	    	'tax_query'           => $tax_query,
		);

		if( ! empty( $ordering_args['meta_key'] ) ) {
			$args['meta_key'] = $ordering_args['meta_key'];
		}


		if( $post_type == 'ids' && $include != '' ) {
			$args['post__in'] = explode(',', $include);
		}

		if( ! empty( $exclude ) ) {
			$args['post__not_in'] = explode(',', $exclude);
		}

		if( ! empty( $taxonomies ) ) {
			$taxonomy_names = get_object_taxonomies( 'product' );
			$terms = get_terms( $taxonomy_names, array(
				'orderby' => 'name',
				'include' => $taxonomies
			));

			if( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
				$args['tax_query'] = array('relation' => 'OR');

				foreach ($terms as $key => $term) {
					$args['tax_query'][] = array(
				        'taxonomy' => $term->taxonomy,
				        'field' => 'slug',
				        'terms' => array( $term->slug ),
				        'include_children' => true,
				        'operator' => 'IN'
					);
				}
			}
		}

		if( ! empty( $order ) ) {
			$args['order'] = $order;
		}

		if( ! empty( $offset ) ) {
			$args['offset'] = $offset;
		}


		if( $post_type == 'sale' ) {
			$args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
		}

		if( $post_type == 'bestselling' ) {
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = 'total_sales';
		}

		$woocommerce_loop['timer']   = $sale_countdown;
		$woocommerce_loop['product_hover']   = $product_hover;

		$products                    = new WP_Query( $args );

		WC()->query->remove_ordering_args();

		$woocommerce_loop['timer']   = $sale_countdown;
		$woocommerce_loop['product_hover']   = $product_hover;

		// Simple products carousel
		if( $layout == 'carousel' ) return woodmart_generate_posts_slider( $parsed_atts, $products );

		$woocommerce_loop['columns'] = $columns;

		if ( $pagination != 'arrows' ) {
			$woocommerce_loop['loop'] = $items_per_page * ( $paged - 1 );
		}

		$class .= ' pagination-' . $pagination;
		$class .= ' grid-columns-' . $columns;
		if( $woocommerce_loop['masonry'] == 'enable') {
			$class .= ' grid-masonry';
		}

		$class .= ' woodmart-spacing-' . $spacing;
		$class .= ' products-spacing-' . $spacing;

		ob_start();

		if( ! $is_ajax) echo '<div class="woodmart-products-element">';

	    if( ! $is_ajax && $pagination == 'arrows' ) echo '<div class="woodmart-products-loader"></div>';

	    if( ! $is_ajax) echo '<div class="products elements-grid row woodmart-products-holder ' . esc_attr( $class) . '" data-paged="1" data-atts="' . esc_attr( $encoded_atts ) . '" data-source="shortcode">';

		if ( $products->have_posts() ) :
			while ( $products->have_posts() ) :
				$products->the_post();
				wc_get_template_part( 'content', 'product' );
			endwhile;
		endif;

    	if(!$is_ajax) echo '</div>';

		woocommerce_reset_loop();
		wp_reset_postdata();
		woodmart_reset_loop();

		if ( $products->max_num_pages > 1 && !$is_ajax ) {
			?>
		    	<div class="products-footer">
		    		<?php if ($pagination == 'more-btn' || $pagination == 'infinit'): ?>
		    			<a href="#" class="btn woodmart-load-more woodmart-products-load-more load-on-<?php echo ($pagination == 'more-btn') ? 'click' : 'scroll'; ?>"><span class="load-more-label"><?php esc_html_e('Load more products', 'woodmart'); ?></span><span class="load-more-loading"><?php esc_html_e('Loading...', 'woodmart'); ?></span></a>
		    		<?php elseif ($pagination == 'arrows'): ?>
		    			<div class="wrap-loading-arrow">
			    			<div class="woodmart-products-load-prev disabled"><?php esc_html_e('Load previous products', 'woodmart'); ?></div>
			    			<div class="woodmart-products-load-next"><?php esc_html_e('Load next products', 'woodmart'); ?></div>
		    			</div>
		    		<?php endif ?>
		    	</div>
		    <?php
		}

    	if(!$is_ajax) echo '</div>';

		$output = ob_get_clean();

	    if( $is_ajax ) {
	    	$output =  array(
	    		'items' => $output,
	    		'status' => ( $products->max_num_pages > $paged ) ? 'have-posts' : 'no-more-posts'
	    	);
	    }

	    return $output;

	}



}

if( ! function_exists( 'woodmart_get_shortcode_products_ajax' ) ) {
	add_action( 'wp_ajax_woodmart_get_products_shortcode', 'woodmart_get_shortcode_products_ajax' );
	add_action( 'wp_ajax_nopriv_woodmart_get_products_shortcode', 'woodmart_get_shortcode_products_ajax' );
	function woodmart_get_shortcode_products_ajax() {
		if( ! empty( $_POST['atts'] ) ) {
			$atts = $_POST['atts'];
			$paged = (empty($_POST['paged'])) ? 2 : (int) $_POST['paged'];
			$atts['ajax_page'] = $paged;

			$data = woodmart_shortcode_products($atts);

			echo json_encode( $data );

			die();
		}
	}
}

if( ! function_exists( 'woodmart_get_default_product_shortcode_atts' ) ) {
	function woodmart_get_default_product_shortcode_atts() {
		return array(
	        'post_type'  => 'product',
	        'layout' => 'grid',
	        'include'  => '',
	        'custom_query'  => '',
	        'taxonomies'  => '',
	        'pagination'  => '',
	        'items_per_page'  => 12,
			'product_hover'  => woodmart_get_opt( 'products_hover' ),
			'spacing'  => woodmart_get_opt( 'products_spacing' ),
	        'columns'  => 4,
	        'sale_countdown'  => 0,
	        'offset'  => '',
	        'orderby'  => '',
	        'order'  => '',
	        'meta_key'  => '',
	        'exclude'  => '',
	        'class'  => '',
	        'ajax_page' => '',
			'speed' => '5000',
			'slides_per_view' => '1',
			'wrap' => '',
			'autoplay' => 'no',
			'hide_pagination_control' => '',
			'hide_prev_next_buttons' => '',
			'scroll_per_page' => 'yes',
			'carousel_js_inline' => 'no',
	        'img_size' => 'shop_catalog',
	        'force_not_ajax' => 'no',
	        'products_masonry' => woodmart_get_opt( 'products_masonry' ),
			'products_different_sizes' => woodmart_get_opt( 'products_different_sizes' ),
	    );
	}
}

// Register shortcode [html_block id="111"]


if( ! function_exists( 'woodmart_html_block_shortcode' ) ) {
	function woodmart_html_block_shortcode($atts) {
		extract(shortcode_atts(array(
			'id' => 0
		), $atts));

		return woodmart_get_html_block($id);
	}
}

/**
* ------------------------------------------------------------------------------------------------
* Shortcode function to display product reviews as a slider
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_ajax_search' ) ) {
	function woodmart_ajax_search( $atts ) {
		extract( shortcode_atts( array(
			'number' 	 => 3,
			'price' 	 => 1,
			'thumbnail'  => 1,
			'category' 	 => 1,
			'search_post_type' 	 => 'product',
			'woodmart_color_scheme' => 'dark',
			'el_class' 	 => '',
			'css' 	 => '',
		), $atts) );

		
		$class = 'color-'. $woodmart_color_scheme;
		$class .= ' ' . $el_class;
		if( function_exists( 'vc_shortcode_custom_css_class' ) ) $class .= ' ' . vc_shortcode_custom_css_class( $css );

		ob_start();
		?>
			<div class="woodmart-vc-ajax-search woodmart-ajax-search <?php echo esc_attr( $class ); ?>">
		<?php
			$args = array(
				'count' => $number,
				'thumbnail' => $thumbnail,
				'price' => $price,
			);
			woodmart_header_block_search_extended( $search_post_type, $category, true, $args ); 
		?>
			</div>
		<?php

		return ob_get_clean();
	}
	
}

/**
* ------------------------------------------------------------------------------------------------
* Section divider shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_row_divider' ) ) {
	function woodmart_row_divider( $atts ) {
		extract( shortcode_atts( array(
			'position' 	 => 'top',
			'color' 	 => '#e1e1e1',
			'style'   	 => 'waves-small',
			'content_overlap'    => '',
			'custom_height' => '',
			'el_class' 	 => '',
		), $atts) );

		$divider = woodmart_get_svg_content( $style . '-' . $position );
		$divider_id = 'svg-wrap-' . rand(1000,9999);

		$classes = $divider_id;
		$classes .= ' dvr-position-' . $position;
		$classes .= ' dvr-style-' . $style;

		( $content_overlap != '' ) ? $classes .= ' dvr-overlap-enable' : false;
		( $el_class != '' ) ? $classes .= ' ' . $el_class : false ;
		ob_start();
		?>
			<div class="woodmart-row-divider <?php echo esc_attr( $classes ); ?>">
				<?php echo ( $divider ); ?>
				<style>.<?php echo esc_attr( $divider_id ); ?> svg {
						fill: <?php echo esc_html( $color ); ?>;
						<?php echo ( $custom_height ) ? 'height:' . esc_html( $custom_height ) : false ; ?>
					}
				</style>
			</div>
		<?php

		return  ob_get_clean();

	}

	
}
/**
* ------------------------------------------------------------------------------------------------
* Twitter element
* ------------------------------------------------------------------------------------------------
*/
if( ! function_exists( 'woodmart_twitter' ) ) {
	function woodmart_twitter( $atts ) {
		extract( shortcode_atts( array(
			'name' 	 => 'Twitter',
			'num_tweets' 	 => 5,
			'cache_time'   	 => 5,
			'consumer_key'    => '',
			'consumer_secret' => '',
			'access_token' => '',
			'accesstoken_secret' => '',
			'show_avatar' => 0,
			'avatar_size' => '',
			'exclude_replies' => false,
			'el_class' 	 => '',
		), $atts) );

		ob_start();
		
		?>
		<div class="woodmart-twitter-element woodmart-twitter-vc-element <?php if ( $el_class ) echo esc_attr( $el_class );?>">
			<?php woodmart_get_twitts( $atts ); ?>
		</div>
		<?php

		return  ob_get_clean();

	}	
}

/**
* ------------------------------------------------------------------------------------------------
* Timeline shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_timeline_shortcode' ) ) {
	function woodmart_timeline_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'line_color' 	 => '#e1e1e1',
			'dots_color' 	 => '#1e73be',
			'el_class' 	 => '',
		), $atts) );
		$timeline_id = uniqid();

		$classes = 'woodmart-timeline-wrapper';
		$classes .= ' woodmart-timeline-id-' . $timeline_id;

		$line_style = 'background-color: '. $line_color .';';

		( $el_class != '' ) ? $classes .= ' ' . $el_class : false ;
		ob_start();
		?>
		<div class="<?php echo esc_attr( $classes ); ?>">
			<style>
				.woodmart-timeline-id-<?php echo esc_attr ( $timeline_id ); ?> .woodmart-timeline-dot{
					background-color: <?php echo esc_attr( $dots_color ); ?>;
				}
			</style>
			<div class="woodmart-timeline-line" style="<?php echo esc_attr( $line_style ); ?>">
				<span class="dot-start" style="<?php echo esc_attr( $line_style ); ?>"></span>
				<span class="dot-end" style="<?php echo esc_attr( $line_style ); ?>"></span>
			</div>
			<div class="woodmart-timeline">
				<?php echo do_shortcode( $content ); ?>
			</div>
		</div>
		<?php

		return  ob_get_clean();

	}

}

/**
* ------------------------------------------------------------------------------------------------
* Timeline item shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_timeline_item_shortcode' ) ) {
	function woodmart_timeline_item_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'title_primary' 	 => '',
			'title_secondary' 	 => '',
			'content_secondary' 	 => '',
			'image_secondary' => '',
			'img_size' => 'full',
			'position' 	 => 'left',
			'color_bg'   => '',
			'el_class' 	 => '',
		), $atts) );

		$classes = 'woodmart-timeline-item';
		$classes .= ' woodmart-item-position-' . $position;

		$bg_style = 'background-color: '. $color_bg .';';
		$color_style = 'color: '. $color_bg .';';

		$img = wpb_getImageBySize( array( 'attach_id' => $image_secondary, 'thumb_size' => $img_size, 'class' => 'woodmart-timeline-image' ) );

		( $el_class != '' ) ? $classes .= ' ' . $el_class : false ;
		ob_start();
		?>
		<div class="<?php echo esc_attr( $classes ); ?>">

			<div class="woodmart-timeline-dot"></div>

			<div class="timeline-primary" style="<?php echo esc_attr( $bg_style ); ?>">
				<span class="timeline-arrow" style="<?php echo esc_attr( $color_style ); ?>"></span>
				<h4 class="woodmart-timeline-title"><?php echo esc_attr( $title_primary ); ?></h4> 
				<div class="woodmart-timeline-content"><?php echo do_shortcode( $content ); ?></div>
			</div>

			<div class="timeline-secondary" style="<?php echo esc_attr( $bg_style ); ?>">	
				<span class="timeline-arrow" style="<?php echo esc_attr( $color_style ); ?>"></span>
				<?php if ( $image_secondary ): ?>
					<?php echo wp_kses( $img['thumbnail'], array( 'img' => array('class' => true,'width' => true,'height' => true,'src' => true,'alt' => true) ) );?>
				<?php endif ?>
				<h4 class="woodmart-timeline-title"><?php echo esc_attr( $title_secondary ); ?></h4> 
				<div class="woodmart-timeline-content"><?php echo do_shortcode( $content_secondary ); ?></div>
			</div>

		</div>
		<?php

		return  ob_get_clean();

	}

}

/**
* ------------------------------------------------------------------------------------------------
* Timeline breakpoint shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_timeline_breakpoint_shortcode' ) ) {
	function woodmart_timeline_breakpoint_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
			'title' 	 => '',
			'color_bg'      => '',
			'el_class' 	 => '',
		), $atts) );

		$classes = 'woodmart-timeline-breakpoint';

		( $el_class != '' ) ? $classes .= ' ' . $el_class : false ;
		ob_start();
		?>
		<div class="<?php echo esc_attr( $classes ); ?>">
			<span class="woodmart-timeline-breakpoint-title" style="background-color: <?php echo esc_attr( $color_bg ); ?>;"><?php echo esc_attr( $title ); ?></span> 
		</div>
		<?php

		return  ob_get_clean();

	}

}