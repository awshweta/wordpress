<?php 
$r = false;
if(empty($_SESSION['cart'])){
    $_SESSION['cart']= array();
    $r=true;
}
else{
    $r=false;
}
$message = "";
?>

<?php
if(isset($_POST['addToCart'])) {
    $id =  get_current_user_id();
    //echo $id;
    $Inventory = get_post_meta(get_the_ID(), 'Inventory', 1 );
    $title = get_the_title();
    $image = isset($_POST['image']) ? $_POST['image'] :"";
    $price = isset($_POST['price']) ? $_POST['price'] :"";
    $pid = $post->ID;
    $qty =1;
    $a = false;
    $b = false;
    $arr = array('id'=>$pid, 'title'=> $title, 'src'=>$image, 'price'=>$price, 'qty'=>$qty);
    foreach ($_SESSION['cart'] as $key =>$value) {
        if ($value['title']== $title) {
            $_SESSION["cart"][$key]["qty"]=$_SESSION["cart"][$key]["qty"]+1;
            $message = "Quantity updated successfully";
            $a=true;
            break;
        }
    }
    if($a == false) {
        array_push($_SESSION['cart'],$arr);
        $message = "Product added to cart successfully";
    }
}

get_header(); ?>
<div class="success"><?php echo $message; ?></div>
<div class="post">
<form method="post">
    <table class="table">
    <tr>
        <th>Image</th>
        <th>Title</th>
        <th>Description</th>
        <th>Price</th>
    </tr>
    <tr>
    <input type="hidden" name="title" Value="<?php echo get_the_title(); ?>">
    <input type="hidden" name="image" Value="<?php  echo  get_the_post_thumbnail_url( get_the_ID() ); ?>">
    
    <td><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft border' ) );?></td>
    <td><h2 class="title"><a href="<?php the_permalink(); ?>"><?php  the_title(); ?></a></h2></td>
    <td><?php the_content(); ?></td>
    <td><?php 
            if(get_post_meta(get_the_ID(), 'discountPrice', 1 ) > 0 || get_post_meta(get_the_ID(), 'discountPrice', 1 ) != "") {
                echo get_post_meta(get_the_ID(), 'discountPrice', 1 ); ?>
                <input type="hidden" name="price" Value="<?php  echo get_post_meta(get_the_ID(), 'discountPrice', 1 ); ?>">
            <?php }
            else {
                echo get_post_meta(get_the_ID(), 'Price', 1 ); ?>
                <input type="hidden" name="price" Value="<?php  echo get_post_meta(get_the_ID(), 'Price', 1 ); ?>">
           <?php } ?>
    </td>
    <?php $Inventory = get_post_meta(get_the_ID(), 'Inventory', 1 );
    if( $Inventory == 0 ) { ?>
        <td><input type="submit" name="addToCart" Value="Add To Cart" disabled></td>
    <?php } else { ?>
        <td><input type="submit" name="addToCart" Value="Add To Cart"></td>
   <?php } ?>
    </tr>
</table>
</form>
</div> 
<?php get_footer(); ?>


