<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div>
		<label class="screen-reader-text" for="s"><?php esc_html_x( 'Search for:', 'label', 'woodmart' ); ?></label>
		<input type="text" placeholder="<?php echo esc_attr_x( 'Search', 'submit button', 'woodmart' ); ?>" value="<?php echo get_search_query(); ?>" name="s" id="s" />
		<input type="hidden" name="post_type" id="post_type" value="<?php echo esc_attr( woodmart_get_opt('search_post_type') ); ?>">
		<button type="submit" id="searchsubmit"><?php echo esc_html_x( 'Search', 'submit button', 'woodmart' ); ?></button>
	</div>
</form>