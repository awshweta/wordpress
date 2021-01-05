<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       Cedcoss
 * @since      1.0.0
 *
 * @package    Cedboiler
 * @subpackage Cedboiler/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Cedboiler
 * @subpackage Cedboiler/public
 * @author     Shweta Awasthi <shwetaawasthi@cedcoss.com>
 */
class Cedboiler_Public {

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

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		
		wp_enqueue_style('bootstrap4', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
		wp_enqueue_script( 'boot1','https://code.jquery.com/jquery-3.3.1.slim.min.js');
		wp_enqueue_script( 'boot2','https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js');
		wp_enqueue_script( 'boot2','https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js');
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cedboiler-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cedboiler-public.js', array( 'jquery' ), $this->version, false );

	}
	public function ced_show_metabox_value($content) {
		if(is_single()) {
			$id=get_the_ID();
			$value = get_post_meta($id, 'addbrand', 1 );
			return $content.'<span class="text-success display-4">'.$value.'</span>';
		}
		else {
			return $content;
		}

	}

}

//echo "fghds";