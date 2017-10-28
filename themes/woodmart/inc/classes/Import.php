<?php if ( ! defined('WOODMART_THEME_DIR')) exit('No direct script access allowed');

/**
 * WOODMART_Import
 *
 */

class WOODMART_Import {
	
	private $_woodmart_versions = array();

	private $_response;

	private $_version;

	private $_process = array();

	public function __construct() {

		$this->_woodmart_versions = woodmart_get_config( 'versions' );

		$this->_response = WOODMART_Registry::getInstance()->ajaxresponse;

		add_action( 'wp_ajax_woodmart_import_data', array( $this, 'import_action' ) ); 

		if( isset( $_GET['clean_data'] ) ) $this->clean_imported_version_data();

	}

	public function admin_import_screen( $type = false ) {
		$btn_label = esc_html__( 'Import page', 'woodmart' );
		$activate_label = '';
		?>
			<div class="wrap metabox-holder woodmart-import-page">

				<?php if ( ! function_exists( 'is_shop' ) ): ?>
					<p class="woodmart-notice">
						<?php 
							printf(
								__('To import data properly we recommend you to install <strong><a href="%s">WooCommerce</a></strong> plugin', 'woodmart'), 
								esc_url( add_query_arg( 'page', urlencode( 'tgmpa-install-plugins' ), self_admin_url( 'themes.php' ) ) )
							); 
						?>
					</p>
				<?php endif ?>

				<?php if( $this->_required_plugins() ): ?>
					<p class="woodmart-warning">
						<?php 
							printf(
								__('You need to install the following plugins to use our import function: <strong><a href="%s">%s</a></strong>', 'woodmart'), 
								esc_url( add_query_arg( 'page', urlencode( 'tgmpa-install-plugins' ), self_admin_url( 'themes.php' ) ) ),
								implode(', ', $this->_required_plugins()) 
							); 
						?>
					</p>
				<?php endif; ?>

				<form action="#" method="post" class="woodmart-import-form">

					<div class="woodmart-response"></div>

					<?php if ( $type == 'base' ): ?>
						<?php 

							$btn_label = esc_html__( 'Import base data', 'woodmart' );
							$activate_label = esc_html__( 'Activate base version', 'woodmart' );

							if( $this->is_version_imported('base') ) $btn_label = $activate_label;

							$this->page_preview(); 

							$list = $this->_woodmart_versions;

							$all = 'base';

							foreach ($list as $slug => $version) {
								if( $slug == $all ) continue;
								$all .= ','.$slug;
							}

						?>

						<div class="import-form-fields">

						<input type="hidden" class="woodmart_version" name="woodmart_version" value="base">
						<!-- <input type="hidden" class="woodmart_versions" name="woodmart_versions" value="furniture,food,organic"> -->
						<input type="hidden" class="woodmart_versions" name="woodmart_versions" value="<?php echo esc_attr( $all ); ?>">
						
						<?php if( ! $this->is_version_imported('base') ): ?>
							
							<div class="full-import-box">

								<fieldset>
									<legend>Recommended</legend>
									<label for="full_import">
										<input type="checkbox" id="full_import" name="full_import" value="yes" checked="checked">
										Include all pages and versions
									</label>
									<br>
									<small>
										By checking this option you will get <strong>ALL pages and versions</strong>
										imported in one click.
									</small>
								</fieldset>
							
							</div>

						<?php endif ?>

					<?php else: ?>
						<?php 

							if( $type == 'version' ) $btn_label = esc_html__( 'Set up version', 'woodmart' );

							$this->versions_select( $type ); 
						?>
					<?php endif ?>


					<?php if ( ! $this->_required_plugins() ): ?>
						<p class="submit">
							<input type="submit" name="woodmart-submit" id="woodmart-submit" class="button button-primary" value="<?php echo esc_attr( $btn_label ); ?>" data-activate="<?php echo esc_attr( $btn_label ); ?>">
						</p>
					<?php endif ?>

					<div class="woodmart-import-progress animated" data-progress="0">
						<div style="width: 0;"></div>
					</div>

					</div><!-- .import-form-fields -->

				</form>

			</div>
		<?php
	}

	public function base_import_screen() {
		$this->admin_import_screen( 'base' );
	}

	public function versions_import_screen() {
		$this->admin_import_screen( 'version' );
	}

	public function pages_import_screen() {
		$this->admin_import_screen( 'page' );
	}

	public function elements_import_screen() {
		$this->admin_import_screen( 'element' );
	}

	public function shops_import_screen() {
		$this->admin_import_screen( 'shop' );
	}

	public function products_import_screen() {
		$this->admin_import_screen( 'product' );
	}

	public function versions_select( $type = false ) {
		$first_version = 'base';

		$list = $this->_woodmart_versions;

		if( $type ) {
			$list = array_filter( $this->_woodmart_versions, function( $el ) use($type) {
				return $type == $el['type'];
			});

			// reset($array);
			$first_version = key($list);
		}

		$this->page_preview( $first_version );
		$list = array_reverse($list);
		?>
			<div class="import-form-fields">
			<select class="woodmart_version" name="woodmart_version">
				<option>--select--</option>
				<?php foreach ($list as $key => $value): ?>
					<option value="<?php echo esc_attr( $key ); ?>" data-imported="<?php echo ($this->is_version_imported( $key )) ? 'yes' : 'no'; ?>"><?php echo esc_html( $value['title'] ); ?></option>
				<?php endforeach ?>
			</select>
		<?php
	}

	public function page_preview( $version = 'base' ) {
		?>
			<div class="page-preview">
				<img src="<?php echo WOODMART_DUMMY; ?>/<?php echo esc_attr( $version ); ?>/preview.jpg" data-dir="<?php echo WOODMART_DUMMY; ?>" alt="" />
			</div>
		<?php
	}

	public function import_action() {

		if( empty( $_GET['woodmart_version'] ) ) $this->_response->send_fail_msg( 'Wrong version name' );

		$versions = explode( ',', sanitize_text_field( $_GET['woodmart_version'] ) );

		$sequence = false;

		if( isset( $_GET['sequence'] ) && $_GET['sequence'] == 'true'  ) {
			$sequence = true;
		}

		foreach ($versions as $version) {
			$this->_version = $version;
			if( empty( $version ) ) continue;

			// What exactly do we want to import? XML, options...?
			
			$this->_process = explode(',', $this->_woodmart_versions[$this->_version]['process']);

			$type = $this->_woodmart_versions[$this->_version]['type'];

			if( $sequence && $type == 'version') $this->_process = array('xml', 'sliders', 'page_menu');
			if( $sequence && ( $type == 'shop' || $type == 'product' ) ) $this->_process = array();
			if( $sequence && $version == 'base') $this->_process = array('xml', 'home', 'shop', 'menu', 'widgets', 'options', 'sliders', 'before', 'after');

			if( $this->is_version_imported() ) {
				$this->_response->add_msg( 'Page content was imported previously' );
				foreach (array('xml', 'sliders', 'before', 'after') as $val) {
					if( ( $key = array_search($val, $this->_process ) ) !== false ) {
						unset( $this->_process[ $key ] );
					}
				}
			}

			// Run import of all elements defined in $_process
			$import = new WOODMART_Importversion( $this->_version, $this->_process );
			$import->run_import();

			$this->add_imported_version();
		}

		$this->_response->send_response();

	}

	public function get_imported_versions_css_classes() {
		$versions = $this->imported_versions();
		$class = implode( ' imported-', $versions);
		if( ! empty( $class ) ) $class = ' imported-' . $class;
		return $class;
	}

	public function imported_versions() {
		$data = get_option('woodmart_imported_versions');
		if( empty( $data ) ) $data = array();
		return $data;
	}

	public function add_imported_version( $version = false ) {
		if( ! $version ) $version = $this->_version;
		$imported = $this->imported_versions();
		if( $this->is_version_imported() ) return;
		$imported[] = $version;
		return update_option( 'woodmart_imported_versions', $imported );
	}

	public function is_version_imported( $version = false ) {
		if( ! $version ) $version = $this->_version;
		$imported = $this->imported_versions();
		return in_array( $version, $imported);
	}

	public function clean_imported_version_data(){
		return delete_option( 'woodmart_imported_versions' );
	}

	private function _required_plugins() {
		$plugins = array();

		if( ! class_exists('Redux') ) {
			$plugins[] = 'Redux Framework';
		}

		if( ! class_exists('CMB2') ) {
			$plugins[] = 'CMB2';
		}

		if( ! class_exists('RevSlider') ) {
			$plugins[] = 'Revolution Slider';
		}

		if( ! class_exists('WOODMART_Post_Types') ) {
			$plugins[] = 'Woodmart Core';
		}

		if( ! empty( $plugins ) ) {
			return $plugins;
		}

		return false;
	}

	private function _get_version_folder( $version = false ) {
		if( ! $version ) $version = $this->_version;

		return $this->_file_path . $this->_version . '/';
	}

}