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
		global $wpdb;
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

		if(!get_page_by_title('checkout')) {
			$checkout = array(
				'post_title'    => 'checkout' ,
				'post_content'  => '',
				'post_status'   => 'publish',
				'post_author'   => get_current_user_id(),
				'post_type'     => 'page',
			);
			wp_insert_post( $checkout );
		}

		if(!get_page_by_title('order')) {
			$order = array(
				'post_title'    => 'order' ,
				'post_content'  => '',
				'post_status'   => 'publish',
				'post_author'   => get_current_user_id(),
				'post_type'     => 'page',
			);
			wp_insert_post( $order );
		}

		$table_name = $wpdb->prefix . 'ced_order';
	
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`user_id` int(11) NOT NULL,
			`shipping_adderss` JSON  NOT NULL,
			`billing_adderss` JSON  NOT NULL,
			`amount` varchar(55),
			`product` JSON,
			`payment_method` varchar(55),
			`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
}