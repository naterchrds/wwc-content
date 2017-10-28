<?php
/**
 * The default template for displaying content
 */

global $woodmart_portfolio_loop;

$size = 'large';

$classes[] = 'portfolio-entry';

$columns = ( ! empty( $woodmart_portfolio_loop['columns'] ) ) ? $woodmart_portfolio_loop['columns'] : 3;

$classes[] = 'portfolio-single';
$classes[] = 'masonry-item';

$cats = wp_get_post_terms( get_the_ID(), 'project-cat' );

if( ! empty( $cats ) ) {
	foreach ($cats as $key => $cat) {
		$classes[] = 'proj-cat-' . $cat->slug;
	}
}

$classes[] = 'portfolio-' . woodmart_get_opt( 'portoflio_style' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<header class="entry-header">
		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="entry-thumbnail">
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="portfolio-thumbnail">
					<?php the_post_thumbnail( $size ); ?>
				</a>
				<div class="portfolio-image-mask">
					<span></span>
					</div>
				<a href="<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id($post->ID) ) ); ?>" class="portfolio-enlarge" data-rel="mfp[projects-gallery]"><?php esc_html_e('View Large', 'woodmart'); ?></a>
				<?php if ( woodmart_is_social_link_enable( 'share' ) ): ?>
					<div class="social-icons-wrapper">
					<?php if( function_exists( 'woodmart_shortcode_social' ) ) echo woodmart_shortcode_social( array( 'size' => 'small', 'style' => 'default' ) ); ?>
					</div>
				<?php endif ?>
			</figure>
		<?php endif; ?>

		<div class="portfolio-info">
			
			<?php 

				if( ! empty( $cats ) ) {
					?>
					<div class="wrap-meta">
						<ul class="proj-cats-list">
						<?php
						foreach ($cats as $key => $cat) {
							$classes[] = 'proj-cat-' . $cat->slug;
							// get_term_link( $cat, 'project-cat' ); 
							?>
								<li><?php echo esc_html($cat->name); ?></li>
							<?php
						}
						?>
						</ul>
					</div>
					<?php
				}

			 ?>
			 
			<div class="wrap-title">
				<h1 class="entry-title">
					<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h1>
			</div>
		 </div>
	 </header>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

</article><!-- #post -->
