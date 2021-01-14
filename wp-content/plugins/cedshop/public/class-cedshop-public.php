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
		session_start();
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
		$message = "";
		
		if(isset($_POST['delete'])) {
			$userid =  get_current_user_id();
			$deleteId = $_POST['delete'];
			//echo $deleteId;
			if(!empty($_SESSION['cart'])) {
				foreach ($_SESSION['cart'] as $key =>$value) {
					if($value['id'] == $deleteId) {
						//echo $value['id'];
						unset($_SESSION['cart'][$key]);
						$message = "<p class='text-danger'>Product deleted Successfully<p>";
					}
				}
				update_user_meta( $userid, 'cartdata', $_SESSION['cart']);
			}
		}

		if(isset($_POST['deleteSessiondata'])) {

			$deleteId = $_POST['deleteSessiondata'];
			//echo $deleteId;
			if(!empty($_SESSION['cart'])) {
				foreach ($_SESSION['cart'] as $key =>$value) {
					if($value['id'] == $deleteId) {
						//echo $value['id'];
						unset($_SESSION['cart'][$key]);
						$message = "<p class='text-danger'>Product deleted Successfully<p>";
					}
				}
				asort($_SESSION['cart']);
			}
		}

		if(isset($_POST['editSessiondata'])) {

			$editId = $_POST['editSessiondata'];
			$qty = $_POST['qty'.$editId.''];
			//echo $qty;
			if(!empty($_SESSION['cart'])) {
				foreach ($_SESSION['cart'] as $key =>$value) {
					$Inventory = get_post_meta($value['id'], 'Inventory', 1 );
					if($value['id'] == $editId) {
						if($Inventory < $_SESSION['cart'][$key]['qty']) {
							$message = "More than ".$Inventory." product not available";
							break;
						}else  {
							if($Inventory >= $qty) {
								$_SESSION['cart'][$key]['qty'] = $qty;
								$message = "Quantity updated Successfully";
							}
							else {
								$message = "More than ".$Inventory." product not available";
							}
						}
					}
				}
			}
		}

		if(isset($_POST['edit'])) {
			$userid =  get_current_user_id();
			$cart = get_user_meta($userid,'cartdata',true); 
			$editId = sanitize_text_field($_POST['edit']);
			$qty = sanitize_text_field($_POST['qty'.$editId.'']);
			//echo $qty;
			//unset($_SESSION['cart']);
			if(!empty($_SESSION['cart'])) {
				foreach ($_SESSION['cart'] as $key =>$value) {
					if($value['id'] == $editId) {
						$Inventory = get_post_meta($value['id'], 'Inventory', 1 );
						if($Inventory < $_SESSION['cart'][$key]['qty']) {
							$message = "More than ".$Inventory." product not available";
							break;
						}else  {
							if($Inventory >= $qty) {
								$_SESSION['cart'][$key]['qty'] = $qty;
								$message = "Quantity updated Successfully";
							}
							else {
								$message = "More than ".$Inventory." product not available";
							}
						}
					}
				}
				$cart = $_SESSION['cart'];
				update_user_meta( $userid, 'cartdata', $cart);
			}
		}

		if(is_user_logged_in() == true) {
			$id =  get_current_user_id();
			$total = 0;
			$cart = get_user_meta($id,'cartdata',true); ?>
			<div class="success"><?php echo $message ; ?></div>
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
						<td><input type="number" min="1" name="qty<?php echo esc_attr($v['id']);?>" value="<?php echo esc_attr($v['qty']); ?>" required></td>
						<td><?php echo esc_attr($v['price']); ?></td>
						<td><?php echo  esc_attr($v['qty'])*esc_attr($v['price']); ?></td>
						<td><button type="submit" name="delete" class="btn btn-danger" value="<?php echo esc_attr($v['id']);?>">Delete</button></td>
						<td><button type="submit" name="edit" class="btn btn-success" value="<?php echo esc_attr($v['id']);?>">Edit</button></td></tr>
					<?php }
				}
				?>
				</table>
				<?php 
				if(!empty($cart)) {
					foreach( $cart as $k=>$v ) {
						$total = $total + $v['qty']*$v['price'];
					}
					echo '<h4>Total Price = '.$total.'<h4>';
				} 
				?>
				</br>
				<?php if(!empty($cart)) { ?>
					<button type="submit" name="checkout" formaction ="../checkout/" class="btn btn-success">Checkout</button></td>
				<?php } ?>
			</form>
			<?php
		}
		else {
			$total = 0;
			//session_start(); ?>
			<div class="success"><?php echo $message ; ?></div>
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
				if(!empty($_SESSION['cart'])) {
					foreach ($_SESSION['cart'] as $key =>$value) {
						?>
						<tr><td class="image"><img src=<?php echo $value['src'];?>></td>
						<td><?php echo $value['title']; ?></td>
						<td><input type="number" min="1" name="qty<?php echo $value['id'];?>" value="<?php echo $value['qty']; ?>" required></td>
						<td><?php echo $value['price']; ?></td>
						<td><?php echo $value['qty']*$value['price']; ?></td>
						<td><button type="submit" name="deleteSessiondata" class="btn btn-danger" value="<?php echo $value['id'];?>">Delete</button></td>
						<td><button type="submit" name="editSessiondata" class="btn btn-success" value="<?php echo $value['id'];?>">Edit</button></td></tr>
					<?php }
				}
				?>
			</table>
			<?php 
			if(!empty($_SESSION['cart'])) {
				foreach ($_SESSION['cart'] as $key =>$value) {
					$total = $total + $value['qty']*$value['price'];
				}
				echo 'Total Price ='.$total;
			}
			if(!empty($_SESSION['cart'])) { ?>
					</br><button type="submit" name="checkout" formaction ="../checkout/" class="btn btn-success">Checkout</button></td>
			<?php } ?>
			</form>
			<?php	
		}
	}	
	
	/**
	 * This function is used for insert cart data in db
	 * ced_add_session_data_to_cart
	 *
	 * @return void
	 */
	public function ced_add_session_data_to_cart() {
		if(is_user_logged_in() == true) {
			$id =  get_current_user_id();
			if(!empty($_SESSION['cart'])) {
				$cartdata = $_SESSION['cart'];
				update_user_meta( $id, 'cartdata', $cartdata);
			}
		}
	}

	/**
	 * This function is used for display all product
	 * ced_display_all_product
	 * 
	 * @return void
	 */
	public function ced_display_all_product( ) {
		
		$loop = new WP_Query( array('posts_per_page'=>4,
		'post_type'=>'products',
		'paged' => !empty(get_query_var('page')) ? get_query_var('page') : 1
		)); 

		//var_dump(get_query_var('page'));
		//print_r($loop);
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
		'current' => max( 1, get_query_var('page') ),
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

	/**
	 * This function is used for include checkout page
	 * ced_include_ceckout_page
	 *
	 * @return void
	 */
	public function ced_include_ceckout_page($template) {
		//echo get_query_var('pagename');
		 if(get_query_var('pagename') == 'checkout' ) {
			 $file_name = 'checkout.php';
			 $template = plugin_dir_path( __FILE__ ) . '/partials/' . $file_name;
			 return $template;
		 }
		 return $template;
	}
	public function ced_include_order_page($template) {
		if(get_query_var('pagename') == 'order' ) {
			$file_name = 'order.php';
			$template = plugin_dir_path( __FILE__ ) . '/partials/' . $file_name;
			return $template;
		}
		return $template;

	}
}
