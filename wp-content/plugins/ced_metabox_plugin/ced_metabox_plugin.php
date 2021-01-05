<?php
 
/**
 * Plugin Name:       second-plugin
 * Plugin URI:        https://wordpress/wp-content/plugins/plugin-first/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.6
 * Requires PHP:      7.2
 * Author:            Shweta Awasthi
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       second-plugin
 * Domain Path:       /languages
 * Text Domain:       second-plugin
 */


// Custom meta box (2-1-2021)
function wporg_cedbox( $post ) {
    ?>
    <label for="wporg_field">Custom meta Box</label>
    <input type="text" name="color" id="color" value="<?php echo get_post_meta(get_the_ID(), 'colors', 1 ); ?>">
    <?php
}

function wporg_ced_metabox() {
    $screens= get_option('customcolors');
    //$screens = [ 'post' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'wporg_metabox_id',              // Unique ID
            'Meta Box Title',      // Box title
            'wporg_cedbox',  // Content callback, must be of type callable
            $screen                           // Post type
        );
        
    }
    
}

function savedata( int $post_id ) {
    if ( array_key_exists( 'color', $_POST ) ) {
        update_post_meta(
            $post_id,
            'colors',
            $_POST['color']
        );
    }
}
add_option('customcolors');
add_action( 'add_meta_boxes', 'wporg_ced_metabox' );
add_action( 'save_post', 'savedata' );

function wporg_cedoptions() {
    ?>
    <div class="wrap">
      <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
      <form  method="post">
        <?php
        // output security fields for the registered setting "wporg_options"
        settings_fields( 'wporg_options' );
        $args = array(
            'public'   => true,
            '_builtin' => false
        );
        
        $output = 'names'; // 'names' or 'objects' (default: 'names')
        $operator = 'or'; // 'and' or 'or' (default: 'and')
        
        $post_types = get_post_types( $args, $output, $operator );
       // print_r($post_types);
        
        foreach ( $post_types  as $post_type ) {
            
        if(is_array($post_types)){
            if (in_array($post_type, get_option('customcolors'))) { //check if Post Type checkbox is     checked and display as check if so
                $checked = "checked='checked'";
            }
        else {
                $checked = "";
            }
        } else{
            $checked = "";
        }?>
                <input type="checkbox" name="posttype[]" value="<?php echo $post_type; ?>"<?php echo $checked ?> /> <?php echo $post_type ?></br>
            <?php
        } ?>
        <input type="submit" name="submit" value="save">
        <?php        
        // output setting sections and their fields
        // (sections are registered for "wporg", each field is registered to a specific section)
       // do_settings_sections( 'wporg' );
        // output save settings button
       // submit_button( __( 'Save Settings', 'textdomain' ) );
        ?>
      </form>
    </div>
<?php
}

if(isset($_POST['submit'])) {
    $postval = isset($_POST['posttype']) ? $_POST['posttype'] :"";
    update_option('customcolors', $postval);
}

// add menu and submenu (29-12-2020)
function wporg_options_cedmenu() {
    add_menu_page(
        'Ced secondMenu', //menu title
        'Ced secondMenu', //menu name
        'manage_options', // capabality
        'secondMenu', //slug
        'wporg_cedoptions', //function
        0, 
        5 //position
    );
}
add_action( 'admin_menu', 'wporg_options_cedmenu' );


