<?php if ( ! defined('WOODMART_THEME_DIR')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------------------------
 * Products hover effects
 * ------------------------------------------------------------------------------------------------
 */

return apply_filters( 'woodmart_get_product_hovers', array(
    'base' => 'Show summary on hover', 
    'icons' => 'Icons on hover', 
    'alt' => 'Icons and "add to cart" on hover', 
    'info' => 'Full info on image', 
    'info-alt' => 'Full info on hover', 
    'button' => 'Show button on hover on image', 
	'standard' => 'Standard button',
	'quick' => 'Quick'
) );