<?php 

if (isset($_POST['buyNow'])) {
	$name             = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
	$email            = isset($_POST['email']) ? sanitize_text_field($_POST['email']) : '';
	$mobile           = isset($_POST['mobile']) ? sanitize_text_field($_POST['mobile']) : '';
	$billing_address  = isset($_POST['billing_address']) ? sanitize_text_field($_POST['billing_address']) : '';
	$billing_city     = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : '';
	$pincode          = isset($_POST['pincode']) ? sanitize_text_field($_POST['pincode']) : '';
	$shipping_address = isset($_POST['shipping_address']) ? sanitize_text_field($_POST['shipping_address']) : '';
	$shipping_city    = isset($_POST['shipping_city']) ? sanitize_text_field($_POST['shipping_city']) : '';
	$shipping_pincode = isset($_POST['shipping_pincode']) ? sanitize_text_field($_POST['shipping_pincode']) : '';
	$shipping_data    = array('pincode'=>$shipping_pincode, 'address'=>$shipping_address,'city'=>$shipping_city);
	$billing_data     = array('name'=>$name, 'mobile'=>$mobile , 'email'=>$email,'address'=>$billing_address,'city'=>$billing_city, 'pincode'=>$pincode,);
	$total            = 0;
	$payment_method   = $_POST['cod'];
   // echo $payment_method;

	if (!empty($_SESSION['cart'])) {
		foreach ($_SESSION['cart'] as $key=>$value) {
			$total = $total + ( $_SESSION['cart'][$key]['qty']*$_SESSION['cart'][$key]['price'] );
		}
	   // echo $total;
	}
	$shipping_data = json_encode($shipping_data);
	$billing_data  = json_encode($billing_data);
	$wpdb->insert( 
		'wp_ced_order',
		array( 
			'user_id'=> get_current_user_id(),
			'shipping_adderss' => $shipping_data,
			'billing_adderss' => $billing_data,
			'amount' => $total,
			'product' => json_encode($_SESSION['cart']),
			'payment_method' => $payment_method,
		)
	);
	$id =  get_current_user_id();
	update_user_meta($id, 'cartdata', '');

	if (!empty($_SESSION['cart'])) {
		foreach ($_SESSION['cart'] as $key =>$value) {
			$Inventory = get_post_meta($value['id'], 'Inventory', 1 );
			$Inventory = $Inventory - $value['qty'];
			update_post_meta($value['id'], 'Inventory', $Inventory);
		}
	}
	// echo '<pre>';
	//print_r($_SESSION['cart']);
	unset($_SESSION['cart']);
	header('Location:../order/');
}
get_header(); 
?>
<div class="container">
<form id="checkoutForm" action="" method="post">
	<h2 class="text-center">Checkout</h2>
	<div class="row">
		<div class="col-lg-6">
			<h3>Billing Address</h3>
			<label for="fname"><i class="fa fa-user"></i> Full Name</label>
			<input type="text" id="name" name="name" placeholder="" required>
			<small class="nameErr"></small></br>
			<label for="email"><i class="fa fa-envelope"></i> Email</label>
			<input type="text" id="email" name="email" placeholder="john@example.com" required>
			<small class="emailErr"></small></br>
			<label for="mobile"><i class="fa fa-envelope"></i> Mobile</label>
			<input type="number"  id="mobile" name="mobile" placeholder="" required>
			<small class="mobileErr"></small></br>
			<label for="billing_address"><i class="fa fa-address-card-o"></i> Address</label>
			<input type="text" id="billing_address" name="billing_address" placeholder="" required>
			<small class="addressErr"></small></br>
			<label for="city"><i class="fa fa-institution"></i> City</label>
			<input type="text" id="city" name="city" placeholder="" required>
			<small class="cityErr"></small></br>
			<label for="pincode"><i class="fa fa-institution"></i> Pincode</label>
			<input type="number" id="pincode" name="pincode" placeholder="" required>
			<small class="pincodeErr"></small></br>
			<label>
				<input type="checkbox" id="check" name="check">  Shipping address same as billing
			</label>
			<h3>Shipping Address</h3>
			<label for="shipping_address"><i class="fa fa-address-card-o"></i> Address</label>
			<input type="text" id="shipping_address" name="shipping_address" placeholder="" required>
			<small class="shippingAddressErr"></small></br>
			<label for="city"><i class="fa fa-institution"></i> City</label>
			<input type="text" id="shipping_city" name="shipping_city" placeholder="" required>
			<label for="shipping_pincode"><i class="fa fa-institution"></i> Pincode</label>
			<small class="shipping_cityErr"></small></br>
			<input type="number" id="shipping_pincode" name="shipping_pincode" placeholder="" required>
			<small class="shipping_pincodeErr"></small></br>
			<h3>Payment Method</h3>
			<label><input type="radio" name="cod" value="cash on delivery" required> Cash on Delivery </label></br>
			<?php if (!empty($_SESSION['cart'])) { ?>
				<input type="submit" name="buyNow" id="checkout" value="Continue to checkout" class="btn btn-success">
			<?php } ?>
		</div>
		<div class="col-lg-6">
		<table class="table">
			<tr>
				<th>Image</th>
				<th>Title</th>
				<th>Quantity</th>
				<th>Price</th>
				<th>Total</th>
			<tr>
			<?php
			if (!empty($_SESSION['cart'])) {
				foreach ($_SESSION['cart'] as $key =>$value) {
					?>
						<tr><td class="image"><img src=<?php echo esc_url($value['src']); ?>></td>
						<td><?php echo esc_attr($value['title']); ?></td>
						<td><?php echo esc_attr($value['qty']); ?></td>
						<td><?php echo esc_attr($value['price']); ?></td>
						<td><?php echo esc_attr($value['qty'])*esc_attr($value['price']); ?></td>
					<?php 
				}
			}
			?>
			</table>
			<?php
			if (!empty($_SESSION['cart'])) {
				$total = 0;
				foreach ($_SESSION['cart'] as $key =>$value) {
					$total = $total + $value['qty']*$value['price'];
				}
				echo 'Total Price =$' . $total;
			}
			?>
		</div>
	</div>
</form>
<?php get_footer(); ?>
