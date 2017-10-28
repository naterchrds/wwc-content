<?php if ( ! defined('WOODMART_THEME_DIR')) exit('No direct script access allowed');

/**
 * Main Theme class that initialize all
 * other classes like assets, layouts, options
 *
 * Also includes files with theme functions
 * template tags, 3d party plugins etc.
 */
class WOODMART_Theme {

	/**
	 * Classes array to register in WOODMART_Registery object
	 * @var array
	 */
	private $register_classes = array();

	/**
	 * Files array to include from inc/ folder
	 * @var array
	 */
	private $files_include = array();

	/**
	 * Array of files to include in admin area
	 * @var array
	 */
	private $admin_files_include = array();

	/**
	 * Call init methods
	 */
	public function __construct() {

		$this->register_classes = array(
			'notices',
			'options',
			'metaboxes',
			'layout',
			'import',
			'swatches',
			'search',
			'catalog',
			'maintenance',
			'api',
		);	

		$this->files_include = array(
			'functions',
			'theme-setup',
			'template-tags',
			'shortcodes',
			'woocommerce',
			'woocommerce/attributes-meta-boxes',
			'woocommerce/product-360-view',
			'vc-config',
			'settings',
			'widgets',
			'configs/assets',
		);	

		$this->admin_files_include = array(
			'admin/dashboard/dashboard',
			'admin/init',
			'admin/functions',
		);	


		$this->third_party_plugins = array(
			'plugin-activation/class-tgm-plugin-activation',
			'nav-menu-images/nav-menu-images',
			'wph-widget-class',
		);		

		$this->_third_party_plugins();
		$this->_core_plugin_classes();
		$this->_include_files();
		$this->_register_classes();

		if( is_admin() ) {
			$this->_include_admin_files();
		}

	}

	/**
	 * Register classes in WOODMART_Registry
	 * 
	 */
	private function _register_classes() {

		foreach ($this->register_classes as $class) {
			WOODMART_Registry::getInstance()->$class;
		}

	}

	/**
	 * Include files fron inc/ folder
	 * 
	 */
	private function _include_files() {

		foreach ($this->files_include as $file) {
			$path = get_parent_theme_file_path( WOODMART_FRAMEWORK . '/' . $file . '.php');
			if( file_exists( $path ) ) {
				require_once $path;
			}
		}

	}

	/**
	 * Include files in admin area
	 * 
	 */
	private function _include_admin_files() {

		foreach ($this->admin_files_include as $file) {
			$path = get_parent_theme_file_path( WOODMART_FRAMEWORK . '/' . $file . '.php');
			if( file_exists( $path ) ) {
				require_once $path;
			}
		}

	}

	/**
	 * Register 3d party plugins
	 * 
	 */
	private function _third_party_plugins() {

		foreach ($this->third_party_plugins as $file) {
			$path = get_parent_theme_file_path( WOODMART_3D . '/' . $file . '.php');
			if( file_exists( $path ) ) {
				require_once $path;
			}
		}

	}

	private function _core_plugin_classes() {
		if ( class_exists( 'WOODMART_Auth' ) ) {
			$file_path = array(
				'vendor/opauth/twitteroauth/twitteroauth',
				'vendor/autoload'
			);
			foreach ( $file_path as $file ) {
				$path = apply_filters('woodmart_require', WOODMART_PT_3D . $file . '.php');
				if( file_exists( $path ) ) {
					require_once $path;
				}
			}
			$this->register_classes[] = 'auth';
		}
	}

}