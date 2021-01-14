<?php if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}


class Ced_subscribe extends WP_List_Table {
    public $item;
    public $_column_headers;
    public $columns;

	/** Class constructor */
	public function __construct() {

		parent::__construct( [
			'singular' => __( 'customer', 'sp' ), //singular name of the listed records
			'plural'   => __( 'customers', 'sp' ), //plural name of the listed records
			'ajax'     => false //should this table support ajax?

		] );

    }

    public function data_fatched() {
        $args = array(
        'post_type' => '',
        'post_status' => 'publish',
        'fields' => 'ids',
        'meta_query' => array(
        array(
        'key' => 'ced_subscribe',
        'compare' => 'exist'
        ),
        ),
        );
        
        $result_query = new WP_Query( $args );
        $ID_array = $result_query->posts;
        // print_r($result_query);
        
        return $ID_array;
      }


    public function prepare_items() {

          $per_page     = $this->get_items_per_page( 'users_per_page', 5 );
          $current_page = $this->get_pagenum();
          $total_items  = self::record_count();
          
          $data = $this->data_fatched();
          echo "<pre>";
          //print_r($data);
          $arr = array();
          echo "</br>";
          foreach($data as $val) {
            //echo $val;
            $value = get_post_meta($val, 'ced_subscribe');
            $title = get_the_title($val);

             foreach($value as $k=>$v) {
               foreach($v as $key=> $ans) {
                $arr[] = array('email' => $ans, 'title' => $title , 'id'=> $val );
               }
             }
            // print_r($arr);
          }

		// $this->set_pagination_args( [
        // 'total_items' => $total_items, //WE have to calculate the total number of items
        // 'per_page'    => $per_page //WE have to determine how many items to show on a page
        // ] );
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers =array($columns, $hidden, $sortable);
        $this->items = $arr;
        print_r($this->items);
	}

    function column_default( $item, $column_name ) {
        switch( $column_name ) { 
          case 'email':
          case 'title':
            case 'id':
            return $item[ $column_name ];
          default:
            return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
        }
      }
    /**
     * Retrieve customer’s data from the database
     *
     * @param int $per_page
     * @param int $page_number
     *
     * @return mixed
     */
    
   

	/** Text displayed when no customer data is available */
	public function no_items() {
		_e( 'No users avaliable.', 'sp' );
    }
    
    /**
	 *  Associative array of columns
	 *
	 * @return array
	 */
	function get_columns() {
		$columns = [
            'cb' => '<input type="checkbox" />',
			'email' => __( 'email', 'sp' ),
            'title'    => __( 'title', 'sp' ),
            'id'    => __( 'id', 'sp' )
		];

		return $columns;
    }

 
    public function get_sortable_columns() {
        $sortable_columns = array(
        'name' => array( 'name', true ),
        );
        
        return $sortable_columns;
    }

    function column_name( $item ) {

        // create a nonce
        $delete_nonce = wp_create_nonce( 'sp_delete_customer' );
        
        $title = '<strong>' . $item['name'] . '</strong>';
        
        $actions = [
        'delete' => sprintf( '<a href="?page=%s&action=%s&customer=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['id'] ), $delete_nonce )
        ];
        
        return $title . $this->row_actions( $actions );
    }
    
}