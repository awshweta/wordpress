<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       Cedcoss
 * @since      1.0.0
 *
 * @package    Cedboiler
 * @subpackage Cedboiler/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cedboiler
 * @subpackage Cedboiler/admin
 * @author     Shweta Awasthi <shwetaawasthi@cedcoss.com>
 */
class Cedboiler_Admin {

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
	public $r;

	/**
	 * Initialize the class and set its properties.
	 *2
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
		 * defined in Cedboiler_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cedboiler_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cedboiler-admin.css', array(), $this->version, 'all' );

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
		 * defined in Cedboiler_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cedboiler_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jQuery.js', array( 'jquery' ),  true );
		wp_enqueue_script( 'ced_handler', plugin_dir_url( __FILE__ ) . 'js/custom.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cedboiler-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script('ced_handler', 'ajax_object',
			array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			)
		);

	}


	public function ced_boiler_menu() {
		?>
		<div class="wrapper">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form  method="post">
        <?php
        // output security fields for the registered setting "wporg_options"
        settings_fields( 'wporg_options' );
        $args = array(
            'public'   => true,
            '_builtin' => false
        );
        
        $output = 'names'; // 'names' or 'objects' (default: 'names')
        $operator = 'or'; // 'and' or 'or' (default: 'and')
        $checked = "";
        $post_types = get_post_types( $args, $output, $operator );
	   // print_r($post_types);
	   if(is_array($post_types)){

        foreach ( $post_types  as $k=>$post_type ) {
        
            if (in_array($post_type, get_option('customcolors'))) { //check if Post Type checkbox is     checked and display as check if so
				$checked = "checked='checked'";
				
            }
			else 
			{
				$checked = "";
			}
			// }
		//  else{
		// 		$checked = "";
			?>
                <input type="checkbox" class="post" name="posttype[]" value="<?php echo $post_type; ?>"<?php echo $checked;?> /> <?php echo $post_type ?></br>
            <?php
		} ?>
        <input type="button" data-post="<?php print_r(get_post_types( $args, $output, $operator )); ?>" class="save" name="submit" value="save">
		<?php 
	   }       
        // output setting sections and their fields
        // (sections are registered for "wporg", each field is registered to a specific section)
       // do_settings_sections( 'wporg' );
        // output save settings button
       // submit_button( __( 'Save Settings', 'textdomain' ) );
        ?>
      </form>
		</div>
	<?php
	}

	public function ced_boiler_submenu() {
		?>
		<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

		</div>
	<?php
	}

	// add menu and submenu (3-1-2021)
	public function ced_menu_page() {
		add_menu_page(
			'Ced boiler Menu', //menu title
			'Ced boiler Menu', //menu name
			'manage_options', // capabality
			'boilermenu', //slug
			array( $this, 'ced_boiler_menu' ), //function
			0, 
			5 //position
		);

		add_submenu_page(
			'boilermenu',  // parent slug
			'Boiler Submenu1', //menu title
			'Boiler Submenu1', //menu name
			'manage_options', // capabality
			'boilersubmenu1', //slug
			array( $this, 'ced_boiler_submenu' ) //function
		);
	}

	public function ced_custom_metabox( $post ) {
		?>
		<label for="wporg_field">brand meta Box</label>
		<input type="text" name="brand" id="brand" value="<?php echo get_post_meta(get_the_ID() ,'addbrand' , 1); ?>">
		<?php
	}
	

	public function ced_metabox() {
		$screens = ['post'];
		foreach ( $screens as $screen ) {
			add_meta_box(
				'ced_metabox_id',              // Unique ID
				'brands',      // Box title
				array( $this, 'ced_custom_metabox' ),  // Content callback, must be of type callable
				$screen                           // Post type
			);
		}
	}
	
	public function savemetabox( int $post_id ) {
		if ( array_key_exists( 'brand', $_POST ) ) {
			update_post_meta(
				$post_id,
				'addbrand',
				$_POST['brand']
			);
		}
	}

	public function ced_admin_notice__success() {
		?>
		<div class="notice notice-success is-dismissible">
			<p><?php _e( 'Done!', 'sample-text-domain' ); ?></p>
		</div>
		<?php
	}

	public function ced_admin_notice__error() {
		$class = 'notice notice-error';
		$message = __( 'An error has occurred.', 'sample-text-domain' );
	 
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
	}

		public function ced_save_post() {
			//$postval = array();
			$postval =  $_POST['selectedPost'];
			update_option('customcolors', $postval);
			print_r($postval);
			foreach ( $postval  as $post_type ) {
				
					if (in_array($post_type, get_option('customcolors'))) { //check if Post Type checkbox is     checked and display as check if so
						//$this->ced_admin_notice__success();
						$this->r = true;
					}
					else {
						$this->r = false;
					}
			}
			if( $this->r == true ) {
				echo "update successfully";
			}
			else {
				echo "Not updated";
			}
		}

}