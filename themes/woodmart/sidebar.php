<?php
/**
 * The sidebar containing the secondary widget area
 *
 * Displays on posts and pages.
 *
 * If no active widgets are in this sidebar, hide it completely.
 */

$sidebar_class = woodmart_get_sidebar_class();

$sidebar_name = woodmart_get_sidebar_name();

if( $sidebar_class == 'col-sm-0' )  return;

?>
<aside class="sidebar-container <?php echo esc_attr( $sidebar_class ); ?> area-<?php echo esc_attr( $sidebar_name ); ?>" role="complementary">
	<div class="woodmart-close-sidebar-btn"><span><?php esc_html_e( 'Close', 'woodmart' ); ?></span></div>
	<div class="sidebar-inner woodmart-sidebar-scroll">
		<div class="widget-area woodmart-sidebar-content">
			<?php do_action( 'woodmart_before_sidebar_area' ); ?>
			<?php dynamic_sidebar( $sidebar_name ); ?>
			<?php do_action( 'woodmart_after_sidebar_area' ); ?>
		</div><!-- .widget-area -->
	</div><!-- .sidebar-inner -->
</aside><!-- .sidebar-container -->
