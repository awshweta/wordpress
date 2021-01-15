<?php 
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once  ABSPATH . 'wp-admin/includes/class-wp-list-table.php' ;
}

class Display_order_table extends WP_List_Table {

	public $items;
	public $_column_headers;
	public $columns;
	
	/**
	 * prepare_items
	 *
	 * @return void
	 */
	public function prepare_items() {
		$per_page     = $this->get_items_per_page( 'users_per_page', 5 );
		$current_page = $this->get_pagenum();
		$total_items  = self::record_count();

		$this->set_pagination_args( [
			'total_items' => $total_items, //WE have to calculate the total number of items
			'per_page'    => $per_page //WE have to determine how many items to show on a page
		] );
		$columns               = $this->get_columns();
		$hidden                = array();
		$sortable              = $this->get_sortable_columns();
		$this->_column_headers =array($columns, $hidden, $sortable);
		$order_table_data      = $this->get_order( $per_page, $current_page );
		$array                 = array();
		$product               = '';
		if (!empty($order_table_data)) {
			foreach ($order_table_data as $key=>$value) {
				$prod_id = '';  
				$ship    = json_decode($value['shipping_adderss']);
				$bill    = json_decode($value['billing_adderss']);
				$product = json_decode($value['product']);
				if (!empty($product)) {
					foreach ($product as $prod_key=>$prod_value) {
						$prod_id .= 'id = ' . esc_attr($prod_value->id) . ' & title = ' . esc_attr($prod_value->title) . '</br>';
					}
				}
				$array[] = array('id'=>esc_attr($value['id']),'customer_detail'=>esc_attr($bill->name) . ', ' . esc_attr($bill->email) . ', ' . esc_attr($bill->mobile),'address'=>esc_attr($bill->address) . ', ' . esc_attr($bill->city) . ', ' . esc_attr($bill->pincode),'amount'=>esc_attr($value['amount']),'product'=>$prod_id,'payment_method'=>esc_attr($value['payment_method']),'date'=>esc_attr($value['date']));
			}
		}
		$this->items = $array;
	}

	/**
	* Columns to make sortable.
	*
	* @return array
	*/
	public function get_sortable_columns() {
		$sortable_columns = array(
		'user_id' => array( 'user_id', true ),
		);
	
	return $sortable_columns;
	}
	
	/**
	 * column_default
	 *
	 * @param  mixed $item
	 * @param  mixed $column_name
	 * @return void
	 */
	function column_default( $item, $column_name ) {
		switch ( $column_name ) { 
			case 'id':
			case 'customer_detail':
			case 'address':
			case 'amount':
			case 'product':
			case 'payment_method':
			case 'date':
				return $item[ $column_name ];
			default:
				return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
		}
	}
	  
	/**
	 *  Associative array of columns
	 *
	 * @return array
	 */
	function get_columns() {
		$columns = [
			'id' => __( 'Order id' ),
			'customer_detail'    => __( 'Customer_detail' ),
			'address'    => __( 'Address'),
			'amount' =>	 __( 'Amount' ),
			'product'=> __( 'Order Item' ),
			'payment_method' =>  __( 'Payment Method' ),
			'date' =>  __( 'Date' )
		];

		return $columns;
	}

	/**
	 * Retrieve customer’s data from the database
	 *
	 * @param int $per_page
	 * @param int $page_number
	 *
	 * @return mixed
	 */
	
	public function get_order( $per_page = 5, $page_number = 1 ) {

		global $wpdb;
	
		$sql = 'SELECT * FROM wp_ced_order';
	
		if ( ! empty( $_REQUEST['orderby'] ) ) {
		$sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
		$sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
		}
	
		$sql .= " LIMIT $per_page";
	
		$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;
	
	
		$result = $wpdb->get_results( $sql, 'ARRAY_A' );
	
		return $result;
	}

	/**
	 * Returns the count of records in the database.
	 *
	 * @return null|string
	 */
	public static function record_count() {
		global $wpdb;

		$sql = 'SELECT COUNT(*) FROM wp_ced_order';

		return $wpdb->get_var( $sql );
	}
}
