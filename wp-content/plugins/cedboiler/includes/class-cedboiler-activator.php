<?php

/**
 * Fired during plugin activation
 *
 * @link       Cedcoss
 * @since      1.0.0
 *
 * @package    Cedboiler
 * @subpackage Cedboiler/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Cedboiler
 * @subpackage Cedboiler/includes
 * @author     Shweta Awasthi <shwetaawasthi@cedcoss.com>
 */
class Cedboiler_Activator {


	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function activate() {

		if(!in_array('hello.php' , (array) get_option( 'active_plugins', array() ), true )) {
			wp_die('<pre>Plugin Not Activated</pre>');
			deactivate_plugins( 'cedboiler/cedboiler.php' ); 
		}

	}


}
