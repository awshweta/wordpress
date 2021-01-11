<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       shop
 * @since      1.0.0
 *
 * @package    Cedshop
 * @subpackage Cedshop/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Cedshop
 * @subpackage Cedshop/public
 * @author     Shweta Awasthi <shwetaawasthi@cedcoss.com>
 */
class Cedshop_Public {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cedshop-public.css', array(), $this->version, 'all' );
	
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
		 * defined in Cedshop_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cedshop_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cedshop-public.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * This function is used for display Cart Product
	 * ced_display_all_cart_product
	 *
	 * @return void
	 */
	public function ced_display_all_cart_product() {
		if(isset($_POST['delete'])) {
			$userid =  get_current_user_id();
			$cart = get_user_meta($userid,'cartdata',true); 
			$deleteId = $_POST['delete'];
			//echo $deleteId;
			if(!empty($cart)) {
				foreach( $cart as $k=>$v ) {
					if($v['id'] == $deleteId) {
						echo $v['id'];
						unset($cart[$k]);
					}
				}
				update_user_meta( $userid, 'cartdata', $cart);
			}
		}

		if(isset($_POST['edit'])) {
			$userid =  get_current_user_id();
			$cart = get_user_meta($userid,'cartdata',true); 
			$editId = $_POST['edit'];
			$qty = $_POST['qty'.$editId.''];
			if(!empty($cart)) {
				foreach( $cart as $k=>$v ) {
					if($v['id'] == $editId) {
						$cart[$k]['qty'] = $qty;
					}
				}
				update_user_meta( $userid, 'cartdata', $cart);
			}
		}

		$id =  get_current_user_id();
		$total = 0;
		$cart = get_user_meta($id,'cartdata',true); ?>
		<form method="post">
			<table class="table">
			<tr>
				<th>Image</th>
				<th>Title</th>
				<th>Quantity</th>
				<th>Price</th>
				<th>Total</th>
				<th>Action</th>
			<tr>
			<?php
			if(!empty($cart)) {
				foreach( $cart as $k=>$v ) { 
					 ?>
					<tr><td class="image"><img src=<?php echo esc_url($v['src']);?>></td>
					<td><?php echo esc_attr($v['title']); ?></td>
					<td><input type="number" min="0" name="qty<?php echo esc_attr($v['id']);?>" value="<?php echo esc_attr($v['qty']); ?>" required></td>
					<td><?php echo esc_attr($v['price']); ?></td>
					<td><?php echo  esc_attr($v['qty'])*esc_attr($v['price']); ?></td>
					<td><button type="submit" name="delete" class="btn btn-danger" value="<?php echo esc_attr($v['id']);?>">Delete</button></td>
					<td><button type="submit" name="edit" class="btn btn-success" value="<?php echo esc_attr($v['id']);?>">Edit</button></td></tr>
				<?php }
			} ?>
			</table>
		</form>
	<?php
		if(!empty($cart)) {
			foreach( $cart as $k=>$v ) {
				$total = $total + $v['qty']*$v['price'];
			}
			echo 'Total Price ='.$total;
		}
	}	

	/**
	 * This function is used for display all product
	 * ced_display_all_product
	 * 
	 * @return void
	 */
	public function ced_display_all_product( ) {
		if(get_query_var('paged') == 0) {
			$loop = new WP_Query( array('posts_per_page'=>1,
			'post_type'=>'products',
			'paged' => get_query_var('paged') ? get_query_var('paged') : 1
			)); 
		}
		else {
			$loop = new WP_Query( array('posts_per_page'=>1,
			'post_type'=>'products',
			'paged' => get_query_var('page') ? get_query_var('page') : 1
			)); 
		}
		$loop = new WP_Query( array('posts_per_page'=>1,
		'post_type'=>'products',
		'paged' => get_query_var('page') ? get_query_var('page') : 1
		)); 
		print_r(get_query_var('paged'));
		while ( $loop->have_posts() ) : 
			$loop->the_post();
		the_title('<h2 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h2>' );
		?>
		<div class="entry-content">
			<div class="post">
				<p><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft border' ) );?><?php the_content();
				if(get_post_meta(get_the_ID(), 'discountPrice', 1 ) > 0 || get_post_meta(get_the_ID(), 'discountPrice', 1 ) != "") {
					echo get_post_meta(get_the_ID(), 'discountPrice', 1 );
				}
				else {
					echo get_post_meta(get_the_ID(), 'Price', 1 ); 
				} ?></p>
			</div>
		</div>
		<?php endwhile;
		echo paginate_links(array(
		'current' => max( 1, get_query_var('paged') ),
		'total' => $loop->max_num_pages
		));
	}
	
	/**
	 * This function is used for display product in single page
	 * ced_single_page
	 *
	 * @param  mixed $single
	 * @return void
	 */
	public function ced_single_page($single) {
		if(is_single() && get_post_type() == "products") {
			return  ABSPATH . 'wp-content/plugins/cedshop/public/partials/single-products.php';
		}
		else {
			return $single;
		}
	}
}
