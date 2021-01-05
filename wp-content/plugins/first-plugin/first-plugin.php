<?php
 
/**
 * Plugin Name:       first-plugin
 * Plugin URI:        https://wordpress/wp-content/plugins/plugin-first/
 * Description:       Handle the basics with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.6
 * Requires PHP:      7.2
 * Author:            Shweta Awasthi
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       first-plugin
 * Domain Path:       /languages
 * Text Domain:       first-plugin
 */

 // bootstrap link (30-12-2020)
function cedBootstrapstyle() 
{
    wp_enqueue_style('bootstrap4', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    wp_enqueue_script( 'boot1','https://code.jquery.com/jquery-3.3.1.slim.min.js');
    wp_enqueue_script( 'boot2','https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js');
    wp_enqueue_script( 'boot2','https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js');

}
add_action( 'wp_enqueue_scripts', 'cedBootstrapstyle' );

//change more to click to read (29-12-2020)
function ced_more_link() {
    return '<a class="more-link" href="' . get_permalink() . '">Click to Read!</a>';
}
add_filter( 'the_content_more_link', 'ced_more_link' );

// Custom meta box (2-1-2021)
function wporg_custom_cedbox( $post ) {
    ?>
    <label for="wporg_field">Custom meta Box</label>
    <input type="text" name="color" id="color" value="<?php echo get_post_meta(get_the_ID() ,'colors' , 1); ?>">
    <?php
}

function wporg_add_ced_metabox() {
    $screens = get_option('customcolors');
    foreach ( $screens as $screen ) {
        add_meta_box(
            'wporg_metabox_id',              // Unique ID
            'Meta Box Title',      // Box title
            'wporg_custom_cedbox',  // Content callback, must be of type callable
            $screen                           // Post type
        );
    }
}

function save( int $post_id ) {
    if ( array_key_exists( 'color', $_POST ) ) {
        update_post_meta(
            $post_id,
            'colors',
            $_POST['color']
        );
    }
}

add_action( 'add_meta_boxes', 'wporg_add_ced_metabox' );
add_action( 'save_post', 'save' );

 //create table (30-12-2020)
function ced_createTable() {
    global $wpdb;
    $ced_db_version = '5.6';

	$table_name = $wpdb->prefix . 'ced_user';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` Varchar(55) NOT NULL,
		`email` Varchar(55) NOT NULL,
		`mobile` varchar(55)  NOT NULL,
        `password` varchar(55),
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    $table_name = $wpdb->prefix . 'ced_subscribe';
	
	$charset_collate = $wpdb->get_charset_collate();

	$ced_sql = "CREATE TABLE $table_name (
		`id` int(11) NOT NULL AUTO_INCREMENT,
        `post_id` int(11) NOT NULL,
		`email` Varchar(55) NOT NULL,
        `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $ced_sql );

	add_option( 'ced_db_version', $ced_db_version );
}
register_activation_hook( __FILE__, 'ced_createTable' );

// custom post (29-12-2020)
function ced_post() {
    register_post_type( 'blog',
        array(
            'labels' => array(
                'name' =>   'Blog', 
                'singular_name' =>  'Blog',
                'rewrite' => array('slug' => 'Blog'),
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Blog',
                'edit' => 'Edit',
                'edit_item' => 'Edit Blog',
                'new_item' => 'New Blog',
                'view' => 'View',
                'view_item' => 'View Blog',
                'search_items' => 'Search Blog',
                'not_found' => 'No Blog found',
                'not_found_in_trash' => 'No Blog found in Trash',
                'parent' => 'Parent Blog'
            ),
            
           
           
            //'taxonomies'          => array( 'genres' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'can_export'          => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'show_in_rest' => true,
            'public' => true,
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail', 'custom-fields' ),
            'taxonomies' => array( '' ),
            //'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
            'has_archive' => true
        )
    );
}

add_action( 'init', 'ced_post');


// display ced_user table  (30-12-2020)
function wporg_options_page_html() {
   
    ?>
    <div class="wrap">
      <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <?php
            // global $wpdb;
            // $html ="
            // <table border='' class='table table-bordered' width=100%>
            // <thead>
            //     <tr>
            //     <th>Name</th>
            //     <th>Email</th>
            //     <th>Mobile</th>
            //     <th>Password</th>
            //     </tr>
            // </thead>";
            // $result = $wpdb->get_results("SELECT * FROM wp_ced_user");
            // foreach($result as $wp_ced_user){
            //     $html .= "<tr  class='text-center'><td>".$wp_ced_user->name."</td>
            //     <td>".$wp_ced_user->email."</td>
            //     <td>".$wp_ced_user->mobile."</td>
            //     <td>".$wp_ced_user->password."</td>
            //     </tr>";
            // }
            // $html .="
            // </table>";
            // echo $html; ?>
      <form action="options.php" method="post">
        <?php
        // output security fields for the registered setting "wporg_options"
        settings_fields( 'wporg_options' );
        require_once("Ced_user_data/Ced_user_data.php");
        $user = new Ced_users_List();
        $user->prepare_items();
        $user->display();
        
        // output setting sections and their fields
        // (sections are registered for "wporg", each field is registered to a specific section)
        do_settings_sections( 'wporg' );
        // output save settings button
        submit_button( __( 'Save Settings', 'textdomain' ) );
        ?>
      </form>
    </div>
<?php
}


function wporg_options_html() {
    ?>
    <div class="wrap">
      <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
      <form action="options.php" method="post">
        <?php
        // output security fields for the registered setting "wporg_options"
        settings_fields( 'wporg_options' );
        require_once("ced_subscribe/Ced_subscribe.php");
        $user = new Ced_subscribe();
        $user->prepare_items();
        $user->display();
        
        // output setting sections and their fields
        // (sections are registered for "wporg", each field is registered to a specific section)
        do_settings_sections( 'wporg' );
        // output save settings button
        submit_button( __( 'Save Settings', 'textdomain' ) );
        ?>
      </form>
    </div>
<?php
}

// add menu and submenu (29-12-2020)
function wporg_options_cedpage() {
    add_menu_page(
        'Ced Menu', //menu title
        'Ced Menu', //menu name
        'manage_options', // capabality
        'menu', //slug
        'wporg_options_page_html', //function
        0, 
        5 //position
    );

    add_menu_page(
        'Ced Mymenu', //menu title
        'Ced Mymenu', //menu name
        'manage_options', // capabality
        'mymenu', //slug
        'wporg_options_html', //function
        0, 
        5 //position
    );

    add_submenu_page(
        'menu',  // parent slug
        'Submenu1', //menu title
        'Ced Submenu1', //menu name
        'manage_options', // capabality
        'submenu1', //slug
        'wporg_options_page_html' //function
    );
}
add_action( 'admin_menu', 'wporg_options_cedpage' );

// form using Sortcode (30-12-2020)
if(isset($_POST['submit'])) {
    $name = isset($_POST['name']) ? $_POST['name'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : "";
    $pass = isset($_POST['pass']) ? $_POST['pass'] : "";
    $pass = md5($pass);
    sanitize_text_field( $name );
    sanitize_text_field( $email );
    sanitize_text_field( $mobile );
    sanitize_text_field( $pass );
    $table_name = $wpdb->prefix . 'ced_user';
	
	$wpdb->insert( 
		$table_name,
		array( 
			'name' => $name, 
			'email' => $email, 
            'mobile' => $mobile, 
            'password' => $pass,
		) 
	);
}

// create form using sortcode (30-12-2020)
function input_fields(  ) {
    ?> 
    <form method="POST">
    <div class="form-group row">
        <label for="name" class="col-sm-2  col-form-label">Username: </label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="name" placeholder="Enter username" name="name" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-2  col-form-label">Email: </label>
        <div class="col-sm-8">
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="mobile" class="col-sm-2  col-form-label">Mobile: </label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="mobile" placeholder="Enter mobile" name="mobile" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="pass" class="col-sm-2  col-form-label">Password: </label>
        <div class="col-sm-8">
            <input type="password" class="form-control" id="pass" placeholder="Enter password" name="pass" required>
        </div>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Register</button>
  </form>
    <?php
}
add_shortcode( 'add_fields', 'input_fields' ); 

// Custom Widget 

class wpb_subscribe extends WP_Widget {
    function __construct() {
        parent::__construct(
        
        // Base ID of your widget
        'wpb_subscribe', 
        
        // Widget name will appear in UI
        __('subscribe now', 'wpb_subscribe_domain'), 
        
        // Widget description
        array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'wpb_subscribe_domain' ), ) 
        );
    }
    
    // Creating widget front-end
    
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if ( ! empty( $title ) ) 
            if ( is_single()) {  
                if (in_array(get_post_type(), $instance['posttype'])) { 
                    echo $args['before_title'] . $title . $args['after_title']; ?>
                   <form method="POST"><div>
                    <label for="email" class="">Email: </label>
                    <input type="hidden" class="" id="id" name="id" value="<?php echo get_the_ID(); ?>">
                    <input type="email" class="" id="email" placeholder="Enter email" name="email" required>
                    </div></br>
                    <button type="submit" name="subscribe" class="btn btn-primary">subscribe</button>
                    </form></br>
                   <?php  
                }
            } 

        // This is where you run the code and display the output
         //echo $args['after_widget'];
    }
            
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
         else {
             $title = __( 'New title', 'wpb_subscribe_domain' );
         }
         $checked = "";

        
           $instance['posttype'];
   
        
            
        // Widget admin form
        ?>
        <?php
        $args = array(
        'public'   => true,
        '_builtin' => false
        );
        
        $output = 'names'; // 'names' or 'objects' (default: 'names')
        $operator = 'or'; // 'and' or 'or' (default: 'and')
        
        $post_types = get_post_types( $args, $output, $operator );
        
        if ( $post_types ) { // If there are any custom public post types.
            foreach ( $post_types  as $post_type ) {
                 if($post_type == "attachment" || $post_type == "wpforms") {
                     continue;
                 }
                 else {
                    if(is_array( $instance['posttype'])){
                        if (in_array($post_type, $instance['posttype'])) { //check if Post Type checkbox is     checked and display as check if so
                            $checked = "checked='checked'";
                        }
                       else {
                            $checked = "";
                        }
                    } else{
                        $checked = "";
                    }
                    ?>
                        <input id="<?php echo $this->get_field_id('posttype') . $post_type; ?>" name="<?php echo $this->get_field_name('posttype[]'); ?>" type="checkbox" value="<?php echo $post_type; ?>" <?php echo $checked ?> /> <?php echo $post_type ?>
                    <?php
                 }
                
            } ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>
            <?php  }
    }
        
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['posttype'] = isset( $new_instance['posttype'] ) ? $new_instance['posttype'] : false;
        return $instance;
    }
     
// Class wpb_widget ends here
} 
if(isset($_POST['subscribe'])) {
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $id = $_POST['id'];
    sanitize_text_field( $email );
    sanitize_text_field( $id );

    $arr = array();
    $val= get_post_meta($id, 'ced_subscribe' , 1);
    if(!empty($val)) {
        $val[] = $email;
    }
    else {
        $val = array($email);
    }
    update_post_meta($id , 'ced_subscribe' , $val);

    // $table_name = $wpdb->prefix . 'ced_subscribe';
	
	// $wpdb->insert( 
	// 	$table_name,
	// 	array( 
    //         'email' => $email, 
    //         'post_id' => $id,
	// 	) 
	// );
}
        
// Register and load the widget
function wpb_subscribe_load_widget() {
    register_widget( 'wpb_subscribe' );
}
add_action( 'widgets_init', 'wpb_subscribe_load_widget' );

?>



