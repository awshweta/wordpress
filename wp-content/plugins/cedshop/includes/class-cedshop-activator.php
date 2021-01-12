<?php

/**
 * Fired during plugin activation
 *
 * @link       shop
 * @since      1.0.0
 *
 * @package    Cedshop
 * @subpackage Cedshop/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Cedshop
 * @subpackage Cedshop/includes
 * @author     Shweta Awasthi <shwetaawasthi@cedcoss.com>
 */
class Cedshop_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
	
		if(!get_page_by_title('Shop')) {
			$shop = array(
				'post_title'    => 'Shop' ,
				'post_content'  => '[product]',
				'post_status'   => 'publish',
				'post_author'   => get_current_user_id(),
				'post_type'     => 'page',
			);

			wp_insert_post( $shop );
		}
		
		if(!get_page_by_title('Cart')) {
			$cart = array(
				'post_title'    => 'Cart' ,
				'post_content'  => '[cart]',
				'post_status'   => 'publish',
				'post_author'   => get_current_user_id(),
				'post_type'     => 'page',
			);
			wp_insert_post( $cart );
		}
	}
}