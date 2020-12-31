<?php
    function getstyle() 
    {
        wp_enqueue_style( 'style', get_stylesheet_uri() );
    
    }
    add_action( 'wp_enqueue_scripts', 'getstyle' );



    function wpb_custom_new_menu() {
        register_nav_menu('my-custom-menu',__( 'My Custom Menu' ));
    }
    add_action( 'init', 'wpb_custom_new_menu' );

      function register_my_menus() {
        register_nav_menus(
          array(
            'header-menu' => __( 'Header Menu' ),
            'extra-menu' => __( 'Extra Menu' )
          )
        );
      }
      add_action( 'init', 'register_my_menus' );

      function wood_theme_support() {

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );
    
        // Custom background color.
        add_theme_support(
            'custom-background',
            array(
                'default-color' => 'f5efe0',
            )
        );
    
        // Set content-width.
        global $content_width;
        if ( ! isset( $content_width ) ) {
            $content_width = 580;
        }
    
        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support( 'post-thumbnails' );
    
        // Set post thumbnail size.
        set_post_thumbnail_size( 1200, 9999 );
    
        // Add custom image size used in Cover Template.
        add_image_size( 'twentytwenty-fullscreen', 1980, 9999 );
    
        // Custom logo.
        $logo_width  = 120;
        $logo_height = 90;
    
        // If the retina setting is active, double the recommended width and height.
        if ( get_theme_mod( 'retina_logo', false ) ) {
            $logo_width  = floor( $logo_width * 2 );
            $logo_height = floor( $logo_height * 2 );
        }
    
        add_theme_support(
            'custom-logo',
            array(
                'height'      => $logo_height,
                'width'       => $logo_width,
                'flex-height' => true,
                'flex-width'  => true,
            )
        );
    
        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );
    
        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'script',
                'style',
                'navigation-widgets',
            )
        );
    
    }
    
    add_action( 'after_setup_theme', 'wood_theme_support' );

    function themename_widgets_init() {
        register_sidebar( array(
            'name'          => __( 'Primary Sidebar', 'woodworking' ),
            'id'            => 'sidebar-1',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
    }

    add_action( 'widgets_init', 'themename_widgets_init' );

    function custom_post_type() {
 
        // Set UI labels for Custom Post Type
            $labels = array(
                'name'                => _x( 'Portfolio', 'Post Type General Name', 'twentytwenty' ),
                'singular_name'       => _x( 'Portfolio', 'Post Type Singular Name', 'twentytwenty' ),
                'rewrite' => array('slug' => 'portfolio'),
                'menu_name'           => __( 'Portfolio', 'twentytwenty' ),
                'parent_item_colon'   => __( 'Parent Portfolio', 'twentytwenty' ),
                'all_items'           => __( 'All Portfolio', 'twentytwenty' ),
                'view_item'           => __( 'View Portfolio', 'twentytwenty' ),
                'add_new_item'        => __( 'Add New Portfolio', 'twentytwenty' ),
                'add_new'             => __( 'Add New', 'twentytwenty' ),
                'edit_item'           => __( 'Edit Portfolio', 'twentytwenty' ),
                'update_item'         => __( 'Update Portfolio', 'twentytwenty' ),
                'search_items'        => __( 'Search Portfolio', 'twentytwenty' ),
                'not_found'           => __( 'Not Found', 'twentytwenty' ),
                'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwenty' ),
            );
             
        // Set other options for Custom Post Type
             
            $args = array(
                'label'               => __( 'Portfolio', 'twentytwenty' ),
                'description'         => __( 'Portfolio news and reviews', 'twentytwenty' ),
                'labels'              => $labels,
                // Features this CPT supports in Post Editor
                'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
                // You can associate this CPT with a taxonomy or custom taxonomy. 
                'taxonomies'          => array( 'genres' ),
                /* A hierarchical CPT is like Pages and can have
                * Parent and child items. A non-hierarchical CPT
                * is like Posts.
                */ 
                'hierarchical'        => false,
                'public'              => true,
                'show_ui'             => true,
                'show_in_menu'        => true,
                'show_in_nav_menus'   => true,
                'show_in_admin_bar'   => true,
                'menu_position'       => 5,
                'can_export'          => true,
                'has_archive'         => true,
                'exclude_from_search' => false,
                'publicly_queryable'  => true,
                'capability_type'     => 'post',
                'show_in_rest' => true,
         
            );
             
            // Registering your Custom Post Type
            register_post_type( 'Portfolio', $args );
         
        }
         
        /* Hook into the 'init' action so that the function
        * Containing our post type registration is not 
        * unnecessarily executed. 
        */
         
        add_action( 'init', 'custom_post_type', 0 );



                /*
        * Plugin Name: Course Taxonomy
        * Description: A short example showing how to add a taxonomy called Course.
        * Version: 1.0
        * Author: developer.wordpress.org
        * Author URI: https://codex.wordpress.org/User:Aternus
        */
        //custom taxonomy (28-12-2020)
        function wporg_register_taxonomy_course() {
            $labels = array(
                'name'              => _x( 'Categories', 'taxonomy general name' ),
                'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
                'search_items'      => __( 'Search Category' ),
                'all_items'         => __( 'All Category' ),
                'parent_item'       => __( 'Parent Category' ),
                'parent_item_colon' => __( 'Parent Category:' ),
                'edit_item'         => __( 'Edit Category' ),
                'update_item'       => __( 'Update Category' ),
                'add_new_item'      => __( 'Add New Category' ),
                'new_item_name'     => __( 'New Category Name' ),
                'menu_name'         => __( 'Category' ),
            );
            $args   = array(
                'hierarchical'      => true, // make it hierarchical (like categories)
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => [ 'slug' => 'Category' ],
            );
            register_taxonomy( 'Category', array('portfolio') , $args );

            $labels = array(
                'name'              => _x( 'Tags', 'taxonomy general name' ),
                'singular_name'     => _x( 'Tag', 'taxonomy singular name' ),
                'search_items'      => __( 'Search Tag' ),
                'all_items'         => __( 'All Tag' ),
                'parent_item'       => __( 'Parent Tag' ),
                'parent_item_colon' => __( 'Parent Tag:' ),
                'edit_item'         => __( 'Edit Tag' ),
                'update_item'       => __( 'Update Tag' ),
                'add_new_item'      => __( 'Add New Tag' ),
                'new_item_name'     => __( 'New Tag Name' ),
                'menu_name'         => __( 'Tag' ),
            );
            $args   = array(
                'hierarchical'      => false, // make it hierarchical (like categories)
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => [ 'slug' => 'Tag' ],
            );
            register_taxonomy( 'Tag', array('portfolio') , $args );

        }
        add_action( 'init', 'wporg_register_taxonomy_course' );


        // Custom Widget (28-12-2020)

        class wpb_widget extends WP_Widget {
            function __construct() {
                parent::__construct(
                
                // Base ID of your widget
                'wpb_widget', 
                
                // Widget name will appear in UI
                __('WPBeginner Widget', 'wpb_widget_domain'), 
                
                // Widget description
                array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain' ), ) 
                );
            }
            
            // Creating widget front-end
            
            public function widget( $args, $instance ) {
                $title = apply_filters( 'widget_title', $instance['title'] );
                
                // before and after widget arguments are defined by themes
                echo $args['before_widget'];
                if ( ! empty( $title ) )
                echo $args['before_title'] . $title . $args['after_title'];
                
                // This is where you run the code and display the output
                $loop = new WP_Query( array( 'post_type' => 'Portfolio', 'posts_per_page' => 5 ) );
                while ( $loop->have_posts() ) : $loop->the_post();
                    the_title('<p class="entry-title"><a href="'.get_permalink().'" title="'. the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></p>' );
                endwhile;
                wp_reset_query();

                echo $args['after_widget'];
            }
                    
            // Widget Backend 
            public function form( $instance ) {
                if ( isset( $instance[ 'title' ] ) ) {
                    $title = $instance[ 'title' ];
                }
                else {
                    $title = __( 'New title', 'wpb_widget_domain' );
                }
                // Widget admin form
                ?>
                <p>
                    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
                    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
                </p>
            <?php 
            }
                
            // Updating widget replacing old instances with new
            public function update( $new_instance, $old_instance ) {
                $instance = array();
                $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
                return $instance;
            }
             
        // Class wpb_widget ends here
        } 
                
        // Register and load the widget
        function wpb_load_widget() {
            register_widget( 'wpb_widget' );
        }
        add_action( 'widgets_init', 'wpb_load_widget' );

?>