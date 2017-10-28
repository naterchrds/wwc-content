<?php
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

$classes = array();

$classes[] = 'blog-post-loop';
$classes[] = 'post-slide';
$classes[] = ( $woodmart_loop['blog_design'] == 'carousel_small_img' ) ? 'blog-design-small-images' : 'blog-design-masonry';
$classes[] = 'blog-style-' . woodmart_get_opt( 'blog_style' );


if( get_the_title() == '' )
	$classes[] = 'post-no-title';

$random = rand(100,999);

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<div class="article-inner">
		<header class="entry-header">
			<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() && $parts['media'] ) : ?>
				<figure class="entry-thumbnail">
					<div class="post-img-wrapp">
						<a href="<?php echo esc_url( get_permalink() ); ?>">
							<?php echo woodmart_get_post_thumbnail( 'large' ); ?>
						</a>
					</div>
					<div class="post-image-mask">
						<span></span>
					</div>
				</figure>
			<?php endif; ?>

			<?php woodmart_post_date(); ?>
		</header><!-- .entry-header -->

		<div class="article-body-container">
			<?php if ( $parts['meta'] && get_the_category_list( ', ' ) ): ?>
				<div class="meta-categories-wrapp"><div class="meta-post-categories"><?php echo get_the_category_list( ', ' ); ?></div></div>
			<?php endif ?>

			<?php if( $parts['title'] ) : ?>
				<h3 class="entry-title">
					<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h3>
			<?php endif; // is_single() ?>
			
			<div class="entry-meta woodmart-entry-meta">
				<?php woodmart_post_meta(array(
					'labels' => 1,
					'author' => 1,
					'author_ava' => 1,
					'date' => 0,
					'edit' => 0,
					'comments' => 1,
					'short_labels' => 0
				)); ?>
			</div><!-- .entry-meta -->
			<?php if ( woodmart_is_social_link_enable( 'share' ) ): ?>
				<div class="hovered-social-icons">
					<?php if( function_exists( 'woodmart_shortcode_social' ) ) echo woodmart_shortcode_social( array('size' => 'small', 'color' => 'light' ) ); ?>
				</div>	
			<?php endif ?>

			<?php if( $parts['text'] ) : ?>
				<div class="entry-content post-entry-content">
					<?php woodmart_get_content( $parts['btn'] ); ?>
				</div><!-- .entry-content -->
			<?php endif; ?>
		</div>
	</div>
</article><!-- #post -->