<?php

// =========================================================================
// Remove wordpress adminbar
// =========================================================================
add_filter('show_admin_bar', '__return_false');

// =========================================================================
// Enqueue scripts
// =========================================================================
if ( ! function_exists('vina_enqueue_scripts') ) {
    
    // Enqueue scripts
    function vina_enqueue_scripts() {
        wp_enqueue_script('ped_main', get_template_directory_uri() . '/js/vendor.js', array('jquery'), false, true);
        wp_enqueue_script('plugins', get_template_directory_uri() . '/js/main.js', array(), null , true);
    }
    add_action('wp_enqueue_scripts', 'vina_enqueue_scripts');
    
}



// =========================================================================
// Enqueue styles
// =========================================================================
if ( ! function_exists('vina_enqueue_styles') ) {
    
    // Enqueue styles
    function vina_enqueue_styles() {
        wp_enqueue_style('vina_styles', get_template_directory_uri() . '/css/style.css', array(), '3.0.3', 'all');
    }
    add_action('wp_enqueue_scripts', 'vina_enqueue_styles');
    
}

/*
  ****************** Register Custom Post Types ******************
*/




// =========================================================================
// Custom duplicate post type
// https://rudrastyh.com/wordpress/duplicate-post.html
// =========================================================================
/*
 * Function creates post duplicate as a draft and redirects then to the edit post screen
 */
function rd_duplicate_post_as_draft(){
  global $wpdb;
  if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
    wp_die('No post to duplicate has been supplied!');
  }
 
  /*
   * get the original post id
   */
  $post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
  /*
   * and all the original post data then
   */
  $post = get_post( $post_id );
 
  /*
   * if you don't want current user to be the new post author,
   * then change next couple of lines to this: $new_post_author = $post->post_author;
   */
  $current_user = wp_get_current_user();
  $new_post_author = $current_user->ID;
 
  /*
   * if post data exists, create the post duplicate
   */
  if (isset( $post ) && $post != null) {
 
    /*
     * new post data array
     */
    $args = array(
      'comment_status' => $post->comment_status,
      'ping_status'    => $post->ping_status,
      'post_author'    => $new_post_author,
      'post_content'   => $post->post_content,
      'post_excerpt'   => $post->post_excerpt,
      'post_name'      => $post->post_name,
      'post_parent'    => $post->post_parent,
      'post_password'  => $post->post_password,
      'post_status'    => 'draft',
      'post_title'     => $post->post_title,
      'post_type'      => $post->post_type,
      'to_ping'        => $post->to_ping,
      'menu_order'     => $post->menu_order
    );
 
    /*
     * insert the post by wp_insert_post() function
     */
    $new_post_id = wp_insert_post( $args );
 
    /*
     * get all current post terms ad set them to the new post draft
     */
    $taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
    foreach ($taxonomies as $taxonomy) {
      $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
      wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
    }
 
    /*
     * duplicate all post meta just in two SQL queries
     */
    $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
    if (count($post_meta_infos)!=0) {
      $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
      foreach ($post_meta_infos as $meta_info) {
        $meta_key = $meta_info->meta_key;
        $meta_value = addslashes($meta_info->meta_value);
        $sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
      }
      $sql_query.= implode(" UNION ALL ", $sql_query_sel);
      $wpdb->query($sql_query);
    }
 
 
    /*
     * finally, redirect to the edit post screen for the new draft
     */
    wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
    exit;
  } else {
    wp_die('Post creation failed, could not find original post: ' . $post_id);
  }
}
add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );
 
/*
 * Add the duplicate link to action list for post_row_actions
 */
function rd_duplicate_post_link( $actions, $post ) {
  if (current_user_can('edit_posts')) {
    $actions['duplicate'] = '<a href="admin.php?action=rd_duplicate_post_as_draft&amp;post=' . $post->ID . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
  }
  return $actions;
}
 
add_filter( 'post_row_actions', 'rd_duplicate_post_link', 10, 2 );

/*
  ****************** ACF ******************
*/

    add_action( 'init', 'acf_init' );
    function acf_init() {
      // Import ACF
      //define( 'ACF_LITE' , false );

      // Rename options page and register subpages
      if( function_exists('acf_add_options_page') ) {
          $page = array(

            'page_title' => 'Instellingen',
            'menu_title' => '',
            'menu_slug' => '',
            'position' => '99.1',
            'parent_slug' => '',
            'icon_url' => false,
            'redirect' => true,
            'post_id' => 'options',
            'autoload' => false,

          );
          acf_add_options_page($page);

      }

      if( function_exists('acf_set_options_page_capability') ) {
          acf_set_options_page_capability('read');
      }
    }




/*
  ****************** Navigation ******************
*/

    // Register nav menu's
    add_action( 'after_setup_theme', 'navigation_registration' );
    function navigation_registration() {
      register_nav_menu( 'primary', __( 'Top menu', 'primary' ) );
      register_nav_menu( 'footer', __( 'Footer menu', 'footer' ) );
    }


/*
  ****************** Remove support ******************
*/

    if ( ! function_exists('solarmade_cleaner_wordpress') ) {      function solarmade_cleaner_wordpress() {
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'feed_links_extra', 3);
        remove_action('wp_head', 'index_rel_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'start_post_rel_link', 10, 0);
        remove_action('wp_head', 'parent_post_rel_link', 10, 0);
        remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
        remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

        // Added by hand
        add_filter( 'emoji_svg_url', '__return_false' );
        remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
      }
      add_action( 'init', 'solarmade_cleaner_wordpress' );
    }

/*
  ****************** Extra's ******************
*/   

    // Add theme support
    function custom_stuff() {
      // post thumbnail
      add_theme_support( 'post-thumbnails' );

      // html5 searchform
      add_theme_support( 'html5', array( 'search-form' ) );
    }
    add_action( 'after_setup_theme', 'custom_stuff' );


    // Add SVG support for media uploader
    function cc_mime_types($mimes) {
      $mimes['svg'] = 'image/svg+xml';
      return $mimes;
    }
    add_filter('upload_mimes', 'cc_mime_types');


    // Change Excerpt length
    function custom_excerpt_length( $length ) {
      return 55;
    }
    add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


    // Change Excerpt ending
    function new_excerpt_more( $more ) {
      return ' <small><a href="'. get_permalink($post->ID) . '">' . 'Read More ' . '</a></small>';
    }
    add_filter('excerpt_more', 'new_excerpt_more');

?>
