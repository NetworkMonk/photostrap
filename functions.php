<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {

	// Get the theme data
	$the_theme = wp_get_theme();
    wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_script( 'jquery');
	wp_enqueue_script( 'popper-scripts', get_stylesheet_directory_uri() . '/js/popper.min.js', array(), false);
    wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
	wp_enqueue_script( 'fade-on-scroll', get_stylesheet_directory_uri() . '/js/fade-on-scroll.js', array(), false);
	wp_enqueue_script( 'easy-gallery', get_stylesheet_directory_uri() . '/js/easy-gallery.min.js', array(), false);
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

function add_child_theme_textdomain() {
    load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );

add_action('wp_update_nav_menu', 'blank_menu_items');
function blank_menu_items($nav_menu_selected_id) {
    $navmenudata = json_decode(stripslashes($_POST['nav-menu-data']),true);
    $k=0;
    if ($navmenudata) {
        foreach($navmenudata as $data){
            if(
            isset($data['name']) && 
            isset($data['value']) &&
            strpos($data['name'], 'menu-item-title') !==false
            ){
                if(trim($data['value']) == ''){
                    $data['value'] = '&nbsp;';
                    $navmenudata[$k] = $data;
                }
            }
            $k++;
        }
    }
    if(isset($_POST['menu-item-title'])){
        $k=0;
        foreach($_POST['menu-item-title'] as $key => $value){
            if(trim($value) == ''){
                $value = '&nbsp;';
                $_POST['menu-item-title'][$key] = $value;
            }
            $k++;
        }
    }
}

add_filter('wp_nav_menu_objects', 'blank_menu_display', 10, 2);
function blank_menu_display( $items, $args ){
    foreach( $items as &$item ) {
        $item->title = str_replace('&nbsp;','',$item->title);
    }
    return $items;
}

add_post_type_support( 'page', 'excerpt' );


// Setup post type for carousel
add_action( 'init', 'custom_bootstrap_slider' );
/**
 * Register a Custom post type for.
 */
function custom_bootstrap_slider() {
	$labels = array(
		'name'               => _x( 'Slider', 'post type general name'),
		'singular_name'      => _x( 'Slide', 'post type singular name'),
		'menu_name'          => _x( 'Slider', 'admin menu'),
		'name_admin_bar'     => _x( 'Slide', 'add new on admin bar'),
		'add_new'            => _x( 'Add New', 'Slide'),
		'add_new_item'       => __( 'Name'),
		'new_item'           => __( 'New Slide'),
		'edit_item'          => __( 'Edit Slide'),
		'view_item'          => __( 'View Slide'),
		'all_items'          => __( 'All Slide'),
		'featured_image'     => __( 'Featured Image', 'text_domain' ),
		'search_items'       => __( 'Search Slide'),
		'parent_item_colon'  => __( 'Parent Slide:'),
		'not_found'          => __( 'No Slide found.'),
		'not_found_in_trash' => __( 'No Slide found in Trash.'),
	);

	$args = array(
		'labels'             => $labels,
		'menu_icon'	         => 'dashicons-star-half',
    	'description'        => __( 'Description.'),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array('title','editor','thumbnail')
	);

	register_post_type( 'slider', $args );
}


add_action( 'init', 'custom_project_page' );
/**
 * Register a Custom post type for.
 */
function custom_project_page() {
	$labels = array(
		'name'               => _x( 'Projects', 'post type general name'),
		'singular_name'      => _x( 'Project', 'post type singular name'),
		'menu_name'          => _x( 'Projects', 'admin menu'),
		'name_admin_bar'     => _x( 'Project', 'add new on admin bar'),
		'add_new'            => _x( 'Add New', 'Project'),
		'add_new_item'       => __( 'Name'),
		'new_item'           => __( 'New Project'),
		'edit_item'          => __( 'Edit Project'),
		'view_item'          => __( 'View Project'),
		'all_items'          => __( 'All Projects'),
		'featured_image'     => __( 'Featured Image', 'text_domain' ),
		'search_items'       => __( 'Search Project'),
		'parent_item_colon'  => __( 'Parent Project:'),
		'not_found'          => __( 'No Project found.'),
		'not_found_in_trash' => __( 'No Project found in Trash.'),
	);

	$args = array(
		'labels'             => $labels,
		'menu_icon'	         => 'dashicons-schedule',
    	'description'        => __( 'Description.'),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => null,
        'supports'           => array('title','editor','thumbnail','excerpt'),
        'show_in_rest'       => true
	);

    register_post_type( 'project', $args );
    
    //'title','thumbnail','editor','page-attributes','excerpt'
}


function pw_show_gallery_image_urls( $content ) {

	global $post;

	// Only do this on singular items
	if( ! is_singular() )
		return $content;

	// Make sure the post has a gallery in it
	if( ! has_shortcode( $post->post_content, 'gallery' ) )
		return $content;

	// Retrieve the first gallery in the post
	$gallery = get_post_gallery_images( $post );

   $image_list = '<ul>';

   // Loop through each image in each gallery
   foreach( $gallery as $image_url ) {

	   $image_list .= '<li>' . '<img src="' . $image_url . '">' . '</li>';

   }

   $image_list .= '</ul>';

   // Append our image list to the content of our post
   $content .= $image_list;

	return $content;

}
add_filter( 'the_content', 'pw_show_gallery_image_urls' );