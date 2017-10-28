<?php if ( ! defined('WOODMART_THEME_DIR')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------------------------
 * Theme dashbaord
 * ------------------------------------------------------------------------------------------------
 */
if( ! class_exists( 'WOODMART_Dashboard' ) ) {
	class WOODMART_Dashboard {

		public $page_name = 'woodmart_dashboard';

		public $tabs;

		public $current_tab = 'home';

		public function __construct() {
			$this->tabs = array(
				'home' => esc_html__( 'Base import', 'woodmart' ), 
				'additional' => esc_html__( 'Additional pages', 'woodmart' ), 
			);

			add_action( 'admin_menu', array( $this, 'menu_page' ) );

		}
		public function menu_page() {
			
			if( ! woodmart_get_opt( 'dummy_import' ) ) return;

			$addMenuPage = 'add_me' . 'nu_page';
			$addMenuPage( 
				esc_html__( 'Dummy Content', 'woodmart' ), 
				esc_html__( 'Dummy Content', 'woodmart' ), 
				'manage_options', 
				$this->page_name, 
				array( $this, 'dashboard' ),
				WOODMART_ASSETS . '/images/theme-admin-icon.png', 
				62 
			);
		}

		public function get_tabs() {
			return $this->tabs;
		}

		public function get_current_tab() {
			return $this->current_tab;
		}

		public function set_current_tab( $tab ) {
			$this->current_tab = $tab;
		}

		public function dashboard() {
			$tab = 'home';
			if( isset( $_GET['tab'] ) && ! empty( $_GET['tab'] ) ) {
				$tab = trim( $_GET['tab'] );

				if( ! isset( $this->tabs[ $tab ] ) ) $tab = 'home';

				$this->set_current_tab( $tab );
			} 
			
			$this->show_page( 'tabs/' . $tab );
		}

		public function tab_url( $tab ) {
			if( ! isset( $this->tabs[ $tab ] ) ) $tab = 'home';
			return admin_url( 'admin.php?page=' . $this->page_name . '&tab=' . $tab );
		}

		public function show_page( $name = 'home') {

			$this->show_part( 'header' );
			$this->show_part( $name );
			$this->show_part( 'footer' );

		}

		public function show_part( $name, $data = array() ) {
			include_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/admin/dashboard/views/' . $name . '.php');
		}

		public function get_version() {
			$theme = wp_get_theme();
			$v = $theme->get('Version');
			$v_data = explode('.', $v);
			return $v_data[0].'.'.$v_data[1];
		}

	}

	$woodmart_dashboard = new WOODMART_Dashboard();
}