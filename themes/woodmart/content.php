<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 */

global $woodmart_loop;

// Partrs config array
$parts = array(
	'media' => true,
	'title' => true,
	'meta' => true,
	'text' => true,
	'btn' =>  true,
);

if ( ! empty( $woodmart_loop['parts'] ) )
	$parts = wp_parse_args( $woodmart_loop['parts'], $parts );

// Store loop count we're currently on
if ( empty( $woodmart_loop['loop'] ) )
	$woodmart_loop['loop'] = 0;

// Increase loop count
$woodmart_loop['loop']++;

if ( empty( $woodmart_loop['blog_design'] ) )
	$woodmart_loop['blog_design'] = woodmart_get_opt( 'blog_design' );

$blog_design = $woodmart_loop['blog_design'];

$classes = array();

if( is_single() ) {
	$classes[] = 'post-single-page';
} else {
	$classes[] = 'blog-design-' . $blog_design;
	$classes[] = 'blog-post-loop';
	if( $blog_design == 'chess' ) {
		$classes[] = 'blog-design-small-images';
	}
}

if( ! is_single() )
	$classes[] = 'blog-style-' . woodmart_get_opt( 'blog_style' );


if ( empty( $woodmart_loop['columns'] ) )
	$woodmart_loop['columns'] = woodmart_get_opt( 'blog_columns' );

$columns = $woodmart_loop['columns'];

if( is_single() ) {
	$blog_design = 'default';
}

if( $blog_design == 'masonry' && ! is_single() )
	$classes[] = woodmart_get_grid_el_class($woodmart_loop['loop'], $columns, false, 12 );


if( get_the_title() == '' )
	$classes[] = 'post-no-title';

$gallery_slider = apply_filters( 'woodmart_gallery_slider', true );
$gallery = array();

if( get_post_format() == 'gallery' && $gallery_slider ) {
	$gallery = get_post_gallery(false, false);
}

$random = 'carousel-' . rand(100,999);

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<div class="article-inner">
		<?php if ( $blog_design == 'default-alt' || is_single() ): ?>
			<?php if ( $parts['meta'] && get_the_category_list( ', ' ) ): ?>
				<div class="meta-post-categories"><?php echo get_the_category_list( ', ' ); ?></div>
			<?php endif ?>

			<?php if ( is_single() && $parts['title'] ) : ?>
				<h3 class="entry-title"><?php the_title(); ?></h3>
			<?php elseif( $parts['title'] ) : ?>
				<h3 class="entry-title">
					<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h3>
			<?php endif; // is_single() ?>

			<?php if ( $parts['meta'] ): ?>
				<div class="entry-meta woodmart-entry-meta">
					<?php woodmart_post_meta(array(
						'labels' => 1,
						'author' => 1,
						'author_ava' => 1,
						'date' => 0,
						'edit' => 0,
						'comments' => ( ! is_single() ) ? 1 : 0,
						'short_labels' => 0
					)); ?>
				</div><!-- .entry-meta -->
			<?php endif ?>
		<?php endif ?>
		<header class="entry-header">
			<?php if ( ( has_post_thumbnail() || ! empty( $gallery['src'] ) ) && ! post_password_required() && ! is_attachment() && $parts['media'] ) : ?>
				<figure id="<?php echo esc_attr( $random ); ?>" class="entry-thumbnail">
					<?php if( get_post_format() == 'gallery' && $gallery_slider && ! empty( $gallery['src'] ) ): ?>
						<div class="post-gallery-slider owl-carousel <?php echo woodmart_owl_items_per_slide(1); ?>">
							<?php 
								foreach ($gallery['src'] as $src) {
									?>
										<div> 
											<img src="<?php echo esc_attr( $src ); ?>">
										</div>
									<?php
								}
							?>
						</div>
						<?php 
							woodmart_owl_carousel_init( array(
								'carousel_id' => $random,
								'slides_per_view' => 1,
								'hide_pagination_control' => 'yes',
								'carousel_js_inline' => 'yes'
							) );
						 ?>
					<?php elseif ( ! is_single() ): ?>

						<div class="post-img-wrapp">
							<a href="<?php echo esc_url( get_permalink() ); ?>">
								<?php echo woodmart_get_post_thumbnail( 'large' ); ?>
							</a>
						</div>
						<div class="post-image-mask">
							<span></span>
						</div>
						
					<?php else: ?>
						<?php the_post_thumbnail(); ?>
					<?php endif ?>

				</figure>
			<?php endif; ?>
			<?php woodmart_post_date(); ?>

		</header><!-- .entry-header -->

		<div class="article-body-container">
			<?php if ( $blog_design != 'default-alt' && ! is_single() ): ?>

				<?php if ( $parts['meta'] && get_the_category_list( ', ' ) ): ?>
					<div class="meta-categories-wrapp"><div class="meta-post-categories"><?php echo get_the_category_list( ', ' ); ?></div></div>
				<?php endif ?>

				<?php if ( is_single() && $parts['title'] ) : ?>
					<h3 class="entry-title"><?php the_title(); ?></h3>
				<?php elseif( $parts['title'] ) : ?>
					<h3 class="entry-title">
						<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h3>
				<?php endif; // is_single() ?>

				<?php if ( $parts['meta'] && ! is_single() ): ?>
					<div class="entry-meta woodmart-entry-meta">
						<?php woodmart_post_meta(array(
							'labels' => 1,
							'author' => 1,
							'author_ava' => 1,
							'date' => false,
							'edit' => 0,
							'comments' => 1,
							'short_labels' => ( $blog_design == 'masonry' || $blog_design == 'small-images' || $blog_design == 'chess' )
						)); ?>
					</div><!-- .entry-meta -->
					<?php if ( woodmart_is_social_link_enable( 'share' ) ): ?>
						<div class="hovered-social-icons">
							<?php if( function_exists( 'woodmart_shortcode_social' ) ) echo woodmart_shortcode_social( array('size' => 'small', 'color' => 'light' ) ); ?>
						</div>
					<?php endif ?>
				<?php endif ?>
			<?php endif ?>

			<?php if ( is_search() && $parts['text'] && get_post_format() != 'gallery' ) : // Only display Excerpts for Search ?>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->
			<?php elseif( $parts['text'] ) : ?>
				<div class="entry-content woodmart-entry-content">
					<?php woodmart_get_content( $parts['btn'], is_single() ); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'woodmart' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
				</div><!-- .entry-content -->
			<?php endif; ?>

			<?php if ( $blog_design == 'default-alt' && ! is_single() ): ?>
				<div class="share-with-lines">
					<span class="left-line"></span>
					<?php if ( woodmart_is_social_link_enable( 'share' ) ): ?>
						<?php if( function_exists( 'woodmart_shortcode_social' ) ) echo woodmart_shortcode_social( array( 'style' => 'bordered', 'size' => 'small', 'form' => 'circle' ) ); ?>
					<?php endif ?>
					<span class="right-line"></span>
				</div>
			<?php endif; ?>

			<?php if ( is_single() && get_the_author_meta( 'description' ) ) : ?>
				<footer class="entry-author">
					<?php get_template_part( 'author-bio' ); ?>
				</footer><!-- .entry-author -->
			<?php endif; ?>
		</div>
	</div>
</article><!-- #post -->