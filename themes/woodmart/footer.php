<?php
/**
 * The template for displaying the footer
 *
 */
?>
<?php if (woodmart_needs_footer()): ?>
	<?php if ( ! woodmart_is_woo_ajax() ): ?>
		</div><!-- .main-page-wrapper --> 
	<?php endif ?>
		</div> <!-- end row -->
	</div> <!-- end container -->
	<?php
		$page_id = woodmart_page_ID();
		$disable_prefooter = get_post_meta( $page_id, '_woodmart_prefooter_off', true );
		$disable_footer = get_post_meta( $page_id, '_woodmart_footer_off', true );
		$disable_copyrights = get_post_meta( $page_id, '_woodmart_copyrights_off', true );
	?>
	<?php if ( woodmart_get_opt( 'prefooter_area' ) != '' && !$disable_prefooter ): ?>
		<div class="woodmart-prefooter">
			<div class="container">
				<?php echo do_shortcode( woodmart_get_opt( 'prefooter_area' ) ); ?>
			</div>
		</div>
	<?php endif ?>
	
	<!-- FOOTER -->
	<footer class="footer-container color-scheme-<?php echo esc_attr( woodmart_get_opt( 'footer-style' ) ); ?>">
		<?php if ( !$disable_footer ): ?>
				<?php get_sidebar( 'footer' ); ?>	
		<?php endif ?>	

		<?php if ( !$disable_copyrights ): ?>
			<div class="copyrights-wrapper copyrights-<?php echo esc_attr( woodmart_get_opt( 'copyrights-layout' ) ); ?>">
				<div class="container">
					<div class="min-footer">
						<div class="col-left">
							<?php if ( woodmart_get_opt( 'copyrights' ) != ''): ?>
								<?php echo do_shortcode( woodmart_get_opt( 'copyrights' ) ); ?>
							<?php else: ?>
								<p>&copy; <?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( home_url('/') ); ?>"><?php bloginfo( 'name' ); ?></a>. <?php esc_html_e( 'All rights reserved', 'woodmart' ) ?></p>
							<?php endif ?>
						</div>
						<?php if ( woodmart_get_opt( 'copyrights2' ) != ''): ?>
							<div class="col-right">
								<?php echo do_shortcode( woodmart_get_opt( 'copyrights2' ) ); ?>
							</div>
						<?php endif ?>
					</div>
				</div>
			</div>
		<?php endif ?>
	</footer>
	<div class="woodmart-close-side"></div>
<?php endif ?>
</div> <!-- end wrapper -->
<?php wp_footer(); ?>
</body>
</html>