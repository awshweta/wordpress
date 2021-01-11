<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       shop
 * @since      1.0.0
 *
 * @package    Cedshop
 * @subpackage Cedshop/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cedshop
 * @subpackage Cedshop/admin
 * @author     Shweta Awasthi <shwetaawasthi@cedcoss.com>
 */
class Cedshop_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	public $discountErr;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cedshop_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cedshop_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cedshop-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cedshop_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cedshop_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cedshop-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * Create Custom Post Type
	 * ced_custom_post_type
	 *
	 * @return void
	 */
	public function ced_custom_post_type() {
		$labels = array(
			'name'                => 'Products',
			'singular_name'       => 'Products',
			'rewrite' => array('slug' => 'Products' ),
			'menu_name'           => __('Products' ),
			'all_items'           => __( 'All Products'),
			'view_item'           => __( 'View Products' ),
			'add_new_item'        => __( 'Add New Products' ),
			'add_new'             => __( 'Add New' ),
			'edit_item'           => __( 'Edit Products')
			
		);
			
		$args = array(
			'description'         => __('Products news and reviews' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor','thumbnail', 'comments', 'revisions' ),
			'taxonomies'          => array( '' ),
			'hierarchical'        => true,
			'public'              => true,
			'has_archive'         => true,
		
		);
		register_post_type( "Products", $args );
	}

	/**
	 * create Custom meta box (8-1-2021)
	 * ced_metabox_form
	 *
	 * 
	 * @return void
	 */
	public function ced_metabox_form(  ) {
		?>
		<label for="wporg_field">Inventory</label>
			<input type="number" min="0" name="inventory" id="inventory" value="<?php echo get_post_meta(get_the_ID(),"Inventory",1);?>" required>
		<?php
	}

	/**
	 * ced_metabox
	 *
	 * @return void
	 */
	public function ced_metabox() {
		$screen = "Products";
		add_meta_box(
			'ced_metabox_id',              // Unique ID
			'Inventory',      // Box title
			array( $this, 'ced_metabox_form' ),  // Content callback, must be of type callable
			$screen                           // Post type
		);	

		add_meta_box(
			'ced_metabox_price_id',              // Unique ID
			'Price',      // Box title
			array( $this, 'ced_metabox_priceform' ),  // Content callback, must be of type callable
			$screen                           // Post type
		);
	}
	
	/**
	 * save_metabox_data
	 *
	 * @param  mixed $post_id
	 * @return void
	 */
	public function save_metabox_data( $post_id ) {
			if ( array_key_exists( 'inventory', $_POST ) ) {
				update_post_meta(
					$post_id,
					'Inventory',
					$_POST['inventory']
				);
			}
			if ( array_key_exists( 'regularPrice', $_POST ) ) {
				update_post_meta(
					$post_id,
					'Price',
					$_POST['regularPrice']
				);
			}
			if ( array_key_exists( 'discountedPrice', $_POST ) ) {
				if($_POST['regularPrice'] > $_POST['discountedPrice']) {
					update_post_meta(
						$post_id,
						'discountPrice',
						$_POST['discountedPrice']
					);
				}
			}
	}

	/**
	 * ced_metabox_priceform
	 *
	 * 
	 * @return void
	 */
	public function ced_metabox_priceform( ) {
		?>
		<div  class="discount">
			<label for="wporg_field">Regular Price</label>
			<input type="number" min="0"  name="regularPrice" id="regularPrice" value="<?php echo get_post_meta(get_the_ID(),"Price",1);?>" required></br>
			<label for="wporg_field">Discounted Price</label>
			<input type="number" min="0"  name="discountedPrice" id="discountedPrice" value="<?php echo get_post_meta(get_the_ID(),"discountPrice",1);?>">
			<small class="disErr"></small>
		</div>
		<?php
	}

	
	/**
	 * This function is used for create taxonomy
	 * ced_register_taxonomy
	 *
	 * @return void
	 */
	function ced_register_taxonomy() {
		$labels = array(
			'name'              =>  'Category',
			'singular_name'     =>  'Category',
			'search_items'      => __( 'Search Category' ),
			'all_items'         => __( 'All Category' ),
			'edit_item'         => __( 'Edit Category' ),
			'update_item'       => __( 'Update Category' ),
			'add_new_item'      => __( 'Add New Category' ),
			'new_item_name'     => __( 'New Category Name' ),
			'menu_name'         => __( 'category' ),
		);
		$args   = array(
			'hierarchical'      => true, // make it hierarchical (like categories)
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => [ 'slug' => 'Category' ],
		);
		register_taxonomy( 'cat', ['products' ], $args );

   }
   
   /**
	* This function is used for support feature image
    * ced_theme_support
    *
    * @return void
    */
   public function ced_theme_support() {

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Custom background color.
		add_theme_support(
			'custom-background',
			array(
				'default-color' => 'f5efe0',
			)
		);

		// Set content-width.
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 580;
		}

		/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
		add_theme_support( 'post-thumbnails' );

		// Set post thumbnail size.
		set_post_thumbnail_size( 1200, 9999 );

		// Add custom image size used in Cover Template.
		add_image_size( 'twentytwenty-fullscreen', 1980, 9999 );

		// Custom logo.
		$logo_width  = 120;
		$logo_height = 90;

		// If the retina setting is active, double the recommended width and height.
		if ( get_theme_mod( 'retina_logo', false ) ) {
			$logo_width  = floor( $logo_width * 2 );
			$logo_height = floor( $logo_height * 2 );
		}

		add_theme_support(
			'custom-logo',
			array(
				'height'      => $logo_height,
				'width'       => $logo_width,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

		/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
				'navigation-widgets',
			)
		);

	}
}
