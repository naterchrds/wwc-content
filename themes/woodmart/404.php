<?php
/**
 * The template for displaying 404 pages (Not Found)
 */

get_header(); ?>

<div class="site-content col-md-12" role="main">

	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Not Found', 'woodmart' ); ?></h1>
	</header>

	<div class="page-wrapper">
		<div class="page-content">
			<h2><?php esc_html_e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'woodmart' ); ?></h2>
			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'woodmart' ); ?></p>

			<?php get_search_form(); ?>
		</div><!-- .page-content -->
	</div><!-- .page-wrapper -->

</div><!-- .site-content -->

<?php get_footer(); ?>