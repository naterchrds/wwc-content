<?php if ( ! defined('WOODMART_THEME_DIR')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------------------------
 * Array of versions for dummy content import section
 * ------------------------------------------------------------------------------------------------
 */

return apply_filters( 'woodmart_get_versions_to_import', array(
	'dark' => array(
		'title' => 'Dark',
		'process' => 'xml,home,options,widgets,sliders',
		'type' => 'version'
	),
	'base-rtl' => array(
		'title' => 'Base rtl',
		'process' => 'xml,home,options,widgets,sliders',
		'type' => 'version'
	),
	'watches' => array(
		'title' => 'Watches',
		'process' => 'xml,home,options,widgets,sliders',
		'type' => 'version'
	),
	'about-me' => array(
		'title' => 'About Me',
		'process' => 'xml,page_menu',
		'type' => 'page',
		'parent_menu_title' => 'Pre-Built Layouts',
	),
	'about-us-2' => array(
		'title' => 'About Us 2',
		'process' => 'xml,page_menu',
		'type' => 'page',
		'parent_menu_title' => 'Pre-Built Layouts',
	),
	'about-us' => array(
		'title' => 'About Us',
		'process' => 'xml,page_menu',
		'type' => 'page',
		'parent_menu_title' => 'Pre-Built Layouts',
	),
	'top-rated-products' => array(
		'title' => 'Top Rated Products',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'WooCommerce',
	),
	'sale-products' => array(
		'title' => 'Sale Products',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'WooCommerce',
	),
	'products-categories' => array(
		'title' => 'Products Categories',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'WooCommerce',
	),
	'products-category' => array(
		'title' => 'Products Category',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'WooCommerce',
	),
	'products-by-id' => array(
		'title' => 'Products by ID',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'WooCommerce',
	),
	'single-product' => array(
		'title' => 'Single Product',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'WooCommerce',
	),
	'featured-products' => array(
		'title' => 'Featured Products',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'WooCommerce',
	),
	'recent-products' => array(
		'title' => 'Recent Products',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'WooCommerce',
	),
	'gradients' => array(
		'title' => 'Gradients',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'More Elements',
	),
	'section-dividers' => array(
		'title' => 'Section Dividers',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'More Elements',
	),
	'brands-element' => array(
		'title' => 'Brands Element',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'More Elements',
	),
	'button-with-popup' => array(
		'title' => 'Button with popup',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'More Elements',
	),
	'ajax-products-tabs' => array(
		'title' => 'AJAX products tabs',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'More Elements',
	),
	'animated-counter' => array(
		'title' => 'Animated counter',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'More Elements',
	),
	'products-widgets' => array(
		'title' => 'Products widgets',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'More Elements',
	),
	'products-grid' => array(
		'title' => 'Products grid',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'More Elements',
	),
	'blog-element' => array(
		'title' => 'Blog element',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'Xtemos Elements',
	),
	'blog-element' => array(
		'title' => 'Blog element',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'Xtemos Elements',
	),
	'portfolio-element' => array(
		'title' => 'Portfolio element',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'Xtemos Elements',
	),
	'menu-price' => array(
		'title' => 'Menu price',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'Xtemos Elements',
	),
	'360-degree-view' => array(
		'title' => '360 degree view',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'Xtemos Elements',
	),
	'countdown-timer' => array(
		'title' => 'Countdown timer',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'Xtemos Elements',
	),
	'testimonials' => array(
		'title' => 'Testimonials',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'Theme Elements',
	),
	'team-member' => array(
		'title' => 'Team member',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'Theme Elements',
	),
	'social-buttons' => array(
		'title' => 'Social Buttons',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'Theme Elements',
	),
	'instagram' => array(
		'title' => 'Instagram',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'Theme Elements',
	),
	'google-maps' => array(
		'title' => 'Google maps',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'Theme Elements',
	),
	'banners' => array(
		'title' => 'Banners',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'Theme Elements',
	),
	'carousels-sliders' => array(
		'title' => 'Carousels / sliders',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'Theme Elements',
	),
	'titles' => array(
		'title' => 'Titles',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'Theme Elements',
	),	
	'images-gallery' => array(
		'title' => 'Images gallery',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'Xtemos Elements',
	),	
	'pricing-tables' => array(
		'title' => 'Pricing Tables',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'Xtemos Elements',
	),		
	'infobox' => array(
		'title' => 'Infobox',
		'process' => 'xml,page_menu',
		'type' => 'element',
		'parent_menu_title' => 'Xtemos Elements',
	),	
	'maintenance-3' => array(
		'title' => 'Maintenance 3',
		'process' => 'xml',
		'type' => 'page'
	),
	'maintenance-2' => array(
		'title' => 'Maintenance 2',
		'process' => 'xml',
		'type' => 'page'
	),
	'maintenance' => array(
		'title' => 'Maintenance',
		'process' => 'xml',
		'type' => 'page'
	),
	'our-team' => array(
		'title' => 'Our Team',
		'process' => 'xml,page_menu',
		'type' => 'page',
		'parent_menu_title' => 'Pre-Built Layouts',
	),
	'faqs-2' => array(
		'title' => 'FAQs 2',
		'process' => 'xml,page_menu',
		'type' => 'page',
		'parent_menu_title' => 'Pre-Built Layouts',
	),
	'faqs' => array(
		'title' => 'FAQs',
		'process' => 'xml,page_menu',
		'type' => 'page',
		'parent_menu_title' => 'Pre-Built Pages',
	),
	'contact-us-4' => array(
		'title' => 'Contact Us 4',
		'process' => 'xml,page_menu',
		'type' => 'page',
		'parent_menu_title' => 'Pre-Built Pages',
	),
	'contact-us-3' => array(
		'title' => 'Contact Us 3',
		'process' => 'xml,page_menu',
		'type' => 'page',
		'parent_menu_title' => 'Pre-Built Pages',
	),
	'contact-us-2' => array(
		'title' => 'Contact Us 2',
		'process' => 'xml,page_menu',
		'type' => 'page',
		'parent_menu_title' => 'Pre-Built Pages',
	),
	'contact-us' => array(
		'title' => 'Contact Us',
		'process' => 'xml,page_menu',
		'type' => 'page',
		'parent_menu_title' => 'Pre-Built Pages',
	),
	'landing' => array(
		'title' => 'Landing',
		'process' => 'xml,home,options,widgets,sliders',
		'type' => 'version'
	),
	'lookbook' => array(
		'title' => 'Lookbook',
		'process' => 'xml,home,options,widgets,sliders',
		'type' => 'version'
	),
	'fullscreen' => array(
		'title' => 'Fullscreen',
		'process' => 'xml,home,options,widgets,sliders',
		'type' => 'version'
	),
	'video' => array(
		'title' => 'Video',
		'process' => 'xml,home,options,widgets,sliders',
		'type' => 'version'
	),
	'grid' => array(
		'title' => 'Grid',
		'process' => 'xml,home,options,widgets,sliders',
		'type' => 'version'
	),
	'boxed' => array(
		'title' => 'Boxed',
		'process' => 'xml,home,options,widgets,sliders',
		'type' => 'version'
	),
	'infinite-scrolling' => array(
		'title' => 'Infinite Scrolling',
		'process' => 'xml,home,options,widgets,sliders',
		'type' => 'version'
	),
	'parallax' => array(
		'title' => 'Parallax',
		'process' => 'xml,home,options,widgets,sliders',
		'type' => 'version'
	),
	'basic' => array(
		'title' => 'Basic',
		'process' => 'xml,home,options,widgets,sliders',
		'type' => 'version'
	),
	'categories' => array(
		'title' => 'Categories',
		'process' => 'xml,home,options,widgets,sliders',
		'type' => 'version'
	),
	'cars' => array(
		'title' => 'Cars',
		'process' => 'xml,home,options,widgets,sliders',
		'type' => 'version'
	),
	'furniture' => array(
		'title' => 'Furniture',
		'process' => 'xml,home,options,widgets,sliders',
		'type' => 'version'
	),
	'electronics' => array(
		'title' => 'Electronics',
		'process' => 'xml,home,options,widgets,sliders',
		'type' => 'version'
	),
	'fashion-color' => array(
		'title' => 'Fashion Color',
		'process' => 'xml,home,options,widgets,sliders',
		'type' => 'version'
	),
	'fashion-flat' => array(
		'title' => 'Fashion Flat',
		'process' => 'xml,home,options,widgets,sliders',
		'type' => 'version'
	),	
	'fashion' => array(
		'title' => 'Fashion',
		'process' => 'xml,home,options,widgets,sliders',
		'type' => 'version'
	),
	'minimalism' => array(
		'title' => 'Minimalism',
		'process' => 'xml,home,options,widgets,sliders',
		'type' => 'version'
	),
	'base' => array(
		'title' => 'Base content (required)',
		'process' => 'xml,home,shop,menu,widgets,options,sliders,before,after',
		'type' => 'base'
	),
) );