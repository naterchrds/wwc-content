<?php

add_action( 'wp_enqueue_scripts', 'woodmart_child_enqueue_styles', 1000 );

function woodmart_child_enqueue_styles() {
	if( woodmart_get_opt( 'minified_css' ) ) {
		wp_enqueue_style( 'woodmart-style', get_template_directory_uri() . '/style.min.css', array('bootstrap') );
	} else {
		wp_enqueue_style( 'woodmart-style', get_template_directory_uri() . '/style.css', array('bootstrap') );
	}

    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('bootstrap') );
}

function wpb_load_fa() {
 
wp_enqueue_style( 'wpb-fa', 'https://use.fontawesome.com/releases/v5.0.8/css/all.css' );
 
}
 
add_action( 'wp_enqueue_scripts', 'wpb_load_fa' );