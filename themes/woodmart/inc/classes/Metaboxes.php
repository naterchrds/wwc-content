<?php if ( ! defined('WOODMART_THEME_DIR')) exit('No direct script access allowed');

/**
 * Add metaboxesto pages and posts
 * uses CMB plugins
 * 
 */

/*
    to fix image uploads for taxonomies
    add to file CMB2hookup.php
    line 197
    if ( in_array( $hook, array( 'edit-tags.php', 'post.php', 'post-new.php', 'page-new.php', 'page.php' ), true ) ) {

 */
class WOODMART_Metaboxes {
    /**
     * Options slug for Redux Framework
     * @var string
     */
    private $opt_name = "woodmart_options";


    /**
     * Add actions
     * 
     */
    public function __construct() {

        //add_action( 'init', array( $this, 'load_cmb_plugin' ), 199 );

        add_action( 'cmb2_init', array( $this, 'load_cmb_plugin' ), 199 );
        add_action( 'cmb2_init', array( $this, 'pages_metaboxes' ), 10000 );
        add_action( 'cmb2_init', array( $this, 'product_metaboxes' ), 10000 );
        add_action( 'cmb2_init', array( $this, 'product_categories' ), 10000 );
        add_action( 'cmb2_init', array( $this, 'posts_categories' ), 10000 );

        add_action("redux/metaboxes/{$this->opt_name}/boxes", array( $this, 'metaboxes' ) );
    }

    /**
     * Require CMB plugin files
     * 
     */
    public function load_cmb_plugin() {
        if ( function_exists( 'new_cmb2_box' ) ) {
            require_once get_parent_theme_file_path( WOODMART_3D . '/Taxonomy_MetaData/Taxonomy_MetaData_CMB2.php' );
        }
    }

    /**
     * Register all custom metaboxes with CMB2 API
     */
    public function pages_metaboxes() {
        global $woodmart_transfer_options, $woodmart_prefix;

        // Start with an underscore to hide fields from custom fields list
        $woodmart_prefix = '_woodmart_';
        
        $woodmart_metaboxes = new_cmb2_box( array(
            // 'cmb_styles' => false, // false to disable the CMB stylesheet
            // 'closed'     => true, // true to keep the metabox closed by default
            'id' => 'page_metabox',
            'title' => 'Page Setting (custom metabox from theme)',
            'object_types' => array('page', 'post', 'portfolio'), // post type
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true, // Show field names on the left
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => 'Custom sidebar for this page',
            'id'      => $woodmart_prefix . 'custom_sidebar',
            'type'    => 'select',
            'options' => woodmart_get_sidebars_array()
        ) );

        $woodmart_transfer_options = array( 
            'main_layout',
            'sidebar_width',
            'header',
            'header-overlap',
            'header_color_scheme',
            'page-title-size',
        );

        foreach ($woodmart_transfer_options as $field) {
            if( class_exists('Redux') ){
                $cmb_field = $this->redux2cmb_field( $field );
                $woodmart_metaboxes->add_field( $cmb_field );
            }
        }

        $woodmart_metaboxes->add_field( array(
            'name'    => 'Disable Page title',
            'desc'    => 'You can hide page heading for this page',
            'id'      => $woodmart_prefix . 'title_off',
            'type'    => 'checkbox',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name' => 'Image for page heading',
            'desc' => 'Upload an image',
            'id' => $woodmart_prefix . 'title_image',
            'type' => 'file',
            'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
        ) );


        $woodmart_metaboxes->add_field( array(
            'name' => 'Page heading background color',
            'desc' => 'Upload an image',
            'id' => $woodmart_prefix . 'title_bg_color',
            'type' => 'colorpicker',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => 'Text color for heading',
            'id'      => $woodmart_prefix . 'title_color',
            'type'    => 'radio_inline',
            'options' => array(
                'default' => esc_html__( 'Inherit', 'woodmart' ),
                'light' => 'Light', 
                'dark' => 'Dark',
            ),
            'default' => 'default'
        ) );


        $woodmart_metaboxes->add_field( array(
            'name'    => 'Open categories menu',
            'desc'    => 'Always shows categories navigation on this page',
            'id'      => $woodmart_prefix . 'open_categories',
            'type'    => 'checkbox',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => 'Disable footer',
            'desc'    => 'You can disable footer for this page',
            'id'      => $woodmart_prefix . 'footer_off',
            'type'    => 'checkbox',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => 'Disable prefooter',
            'desc'    => 'You can disable prefooter for this page',
            'id'      => $woodmart_prefix . 'prefooter_off',
            'type'    => 'checkbox',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => 'Disable copyrights',
            'desc'    => 'You can disable copyrights for this page',
            'id'      => $woodmart_prefix . 'copyrights_off',
            'type'    => 'checkbox',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => 'Disable top-bar',
            'desc'    => 'You can disable top-bar for this page',
            'id'      => $woodmart_prefix . 'top_bar_off',
            'type'    => 'checkbox',
        ) );
    }

    /**
     * Metaboxes for products
     */
    public function product_metaboxes() {
        global $woodmart_prefix, $woodmart_transfer_options;

        // Start with an underscore to hide fields from custom fields list
        $woodmart_prefix = '_woodmart_';
        $taxonomies_list = array( '' => 'Select' );
        $taxonomies = get_taxonomies(); 
        foreach ( $taxonomies as $taxonomy ) {
            $taxonomies_list[$taxonomy] = $taxonomy;
        }

        $woodmart_metaboxes = new_cmb2_box( array(
            // 'cmb_styles' => false, // false to disable the CMB stylesheet
            // 'closed'     => true, // true to keep the metabox closed by default
            'id' => 'product_metabox',
            'title' => 'Product Setting (custom metabox from theme)',
            'object_types' => array('product'), // post type
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true, // Show field names on the left
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => 'Hide related products',
            'desc'    => 'You can hide related products on this page',
            'id'      => $woodmart_prefix . 'related_off',
            'type'    => 'checkbox',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__('Hide tabs headings', 'woodmart'), 
            'desc'    => 'Description and Additional information',
            'id'      => $woodmart_prefix . 'hide_tabs_titles',
            'type'    => 'checkbox',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__('Grid swatch attribute to display', 'woodmart'), 
            'desc' => esc_html__('Choose attribute that will be shown on products grid for this particular product', 'woodmart'),
            'id'      => $woodmart_prefix . 'swatches_attribute',
            'type'    => 'select',
            'options' => $taxonomies_list
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__('Product video URL', 'woodmart'), 
            'desc'    => 'Vimeo or YouTube video url. For example: https://www.youtube.com/watch?v=1zPYW6Ipgok',
            'id'      => $woodmart_prefix . 'product_video',
            'type'    => 'text',
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => esc_html__('Instagram product hashtag', 'woodmart'), 
            'desc'    => 'Insert tag that will be used to display images from instagram from your customers. For example: <strong>#nike_rush_run</strong>',
            'id'      => $woodmart_prefix . 'product_hashtag',
            'type'    => 'text',
        ) );

        $woodmart_local_transfer_options = array( 
            'single_product_style',
            'thums_position',
            'product_design',
            'main_layout',
            'sidebar_width',
            'product-background'
        );

        foreach ($woodmart_local_transfer_options as $field) {
            if( class_exists('Redux') ){
                $cmb_field = $this->redux2cmb_field( $field );
                $woodmart_metaboxes->add_field( $cmb_field );
            }
        }

        $woodmart_metaboxes->add_field( array(
            'name'    => 'Custom sidebar for this product',
            'id'      => $woodmart_prefix . 'custom_sidebar',
            'type'    => 'select',
            'options' => woodmart_get_sidebars_array()
        ) );

        $blocks = array_flip(woodmart_get_static_blocks_array());

        $blocks = (array)'None' + $blocks;

        $woodmart_metaboxes->add_field( array(
            'name'    => 'Extra content block',
            'desc'    => 'You can create some extra content with Visual Composer (in Admin panel / HTML Blocks / Add new) and add it to this product',
            'id'      => $woodmart_prefix . 'extra_content',
            'type'    => 'select',
            'options' => $blocks
        ) );

        $woodmart_metaboxes->add_field( array(
            'name'    => 'Extra content position',
            'id'      => $woodmart_prefix . 'extra_position',
            'type'    => 'radio_inline',
            'options' => array(
                'after' => esc_html__( 'After content', 'woodmart' ),
                'before' => esc_html__( 'Before content', 'woodmart' ),
                'prefooter' => esc_html__( 'Prefooter', 'woodmart' ),
            ),
            'default' => 'after'
        ) );

        $woodmart_transfer_options = array_merge( $woodmart_transfer_options, $woodmart_local_transfer_options );
        
    }

    public function posts_categories() {
        if( ! class_exists('Redux') ) return;

        $blog_design_field = $this->redux2cmb_field( 'blog_design' );

        $blog_design_field['name'] .= ' for this category';

        $cmb_term = new_cmb2_box( array(
            'id'               => 'cat_options',
            'object_types'     => array( 'term' ), 
            'taxonomies'       => array( 'category' ), 
            'new_term_section' => true, // Will display in the "Add New Category" section
        ) );

        $cmb_term->add_field($blog_design_field);

    }

    public function product_categories() {
        /**
         * Instantiate our taxonomy meta class
         */

        $cmb_term = cmb2_get_metabox( array(
            'id'               => 'product_cat_options',
            'object_types'     => array( 'term' ), 
            'taxonomies'       => array( 'product_cat' ), 
            'new_term_section' => true, // Will display in the "Add New Category" section
        ), woodmart_get_current_term_id(), 'term' );

        $cmb_term->add_field( array(
            'name' => 'Image for category heading',
            'desc' => 'Upload an image',
            'id' => 'title_image',
            'type' => 'file',
            'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
        ));

        $cmb_term->add_field(array(
            'name' => 'Image (icon) for categories navigation on the shop page',
            'desc' => 'Upload an image',
            'id' => 'category_icon',
            'type' => 'file',
            'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
        ));
        
        $cmb_term->add_field(array(
            'name' => 'Icon to display in the main menu (or any other menu through the site)',
            'desc' => 'Upload an image',
            'id' => 'category_icon_alt',
            'type' => 'file',
            'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
        ));

    }
    /**
     * Transfer function from redux to CMB2
     * @param  string $field      field slug in Redux options
     * @return array  $cmb_field  CMB compatible field config array
     */
    public function redux2cmb_field( $field ) {

       if( ! class_exists('Redux') ) return;

        $prefix = '_woodmart_';

        $field = Redux::getField($this->opt_name, $field);

        $options = array();
        
        switch ($field['type']) {
            case 'image_select':
                $type = 'radio_inline';
                $options = ( ! empty( $field['options'] ) ) ? array_merge( array('default' => array('title' => 'Inherit') ), $field['options'] ) : array();
                ( count( $options ) > 4 )? $type = 'select' : '';
                foreach ($options as $key => $option) {
                    $options[$key] = ( isset( $options[$key]['alt'] ) ) ? $options[$key]['alt'] : $options[$key]['title'];
                }
            break;

            case 'button_set':
                $type = 'radio_inline';
                $options['default'] = 'Inherit';
                foreach ($field['options'] as $key => $value) {
                    $options[$key] = $value;
                }
            break;

            case 'select':
                $type = 'select';
                $options['inherit'] = 'Inherit';
                foreach ($field['options'] as $key => $value) {
                    $options[$key] = $value;
                }
            break;

            case 'switch':
                $type = 'checkbox';
            break;

            case 'background':
                $type = 'colorpicker';
            break;
            
            default:
                $type = $field['type'];
            break;
        }

        $cmb_field = array(
            'id' => $prefix . $field['id'],
            'type' => $type,
            'name' => $field['title'],
            'options' => $options,
        );

        return $cmb_field;
    }

    public function metaboxes($metaboxes) {
        // Declare your sections
        $boxSections = array();
        $boxSections[] = array(
            'title' => 'Performance',
            'id' => 'performance',
            'icon' => 'el-icon-cog',
            'fields' => array (
                array (         
                    'id'       => 'product-background',
                    'type'     => 'background',
                    'title'    => esc_html__('Product background', 'woodmart'),
                    'subtitle' => esc_html__('Set background for your products page. You can also specify different background for particular products while editing it.', 'woodmart'),
                    'output'   => array('.single-product-content')
                ),
            ),
        );
 
        // Declare your metaboxes
        $metaboxes = array();
        $metaboxes[] = array(
            'id'            => 'sidebar',
            'title'         => esc_html__( 'Sidebar', 'woodmart' ),
            'post_types'    => array( 'product' ),
            'position'      => 'normal', // normal, advanced, side
            'priority'      => 'high', // high, core, default, low - Priorities of placement
            'sections'      => $boxSections,
        );
 
        return $metaboxes;
    }

}