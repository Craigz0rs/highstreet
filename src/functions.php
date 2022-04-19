<?php

defined( 'ABSPATH' ) || die( 'Direct file access is prohibited.' );

if ( ! isset( $content_width ) ) $content_width = 782;

class EpiqkTheme {

  public static function after_switch_theme() {
    update_option( 'image_default_link_type', 'none' );
  }
  
  public static function after_setup_theme() {
    
    register_nav_menus( [
      'primary' => esc_html__( 'Header navigation', 'epiqk' ),
    ] );
    register_nav_menus( [
      'footer' => esc_html__( 'Footer navigation', 'epiqk' ),
    ] );
  
    add_theme_support( 'title-tag' );
    add_theme_support( 'html5', [
      'search-form', 
      'comment-form',	
      'comment-list',	
      'gallery', 
      'caption',
    ] );
    add_theme_support( 'disable-custom-gradients' );
    add_theme_support( 'editor-gradient-presets', [] );

    $brand_colors = [
      'black' => [
        'label' => 'Black',
        'hex' => '#1E1E24',
      ],
      'primary' => [
        'label' => 'Orange (Primary)',
        'hex' => '#B75C1D',
      ],
      'secondary' => [
        'label' => 'Midnight (Secondary)',
        'hex' => '#303C42',
      ],
      'cream' => [
        'label' => 'Cream',
        'hex' => '#F4EBDD',
      ],
      'xl-grey' => [
        'label' => 'Grey (Extra Light)',
        'hex' => '#F7F2EF',
      ],
      'white' => [
        'label' => 'White',
        'hex' => '#FFF',
      ],
      
    ];

    add_theme_support( 'editor-color-palette', array_map( function( $slug, $color ) {

      return [
        'name' => __( $color['label'], 'epiqk' ),
        'slug'  => $slug,
        'color'	=> $color['hex'],
      ];

    }, array_keys( $brand_colors ), array_values( $brand_colors ) ) );
    
    add_theme_support( 'disable-custom-colors' );
    add_theme_support( 'disable-custom-font-sizes' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'editor-font-sizes', [[]] );
  
    add_theme_support( 'editor-font-sizes', [
        [
            'name' => __( 'Normal', 'epiqk' ),
            'shortName' => __( 'N', 'epiqk' ),
            'size' => 18,
            'slug' => 'normal'
        ],
        [
            'name' => __( 'Leading Paragraph', 'epiqk' ),
            'shortName' => __( 'L', 'epiqk' ),
            'size' => 25,
            'slug' => 'lead'
        ],
    ] );
  
    add_image_size( 'headshot', 900, 1000, true );

    // Add theme support for selective refresh for widgets.
    add_theme_support( 'customize-selective-refresh-widgets' );
  
    remove_theme_support( 'automatic-feed-links' );
    remove_theme_support( 'custom-background' );
    remove_theme_support( 'custom-header' );
    remove_theme_support( 'post-formats' );
  
  }
  
  public static function init() {

      register_post_type('properties', array(
        'supports' => array(
          'title', // post title
          'editor', // post content
          'thumbnail', // featured images
          // 'excerpt', // post excerpt
          'custom-fields', // custom fields
          'revisions', // post revisions
          'post-formats', // post formats
          'taxonomies',
        ),
        'labels' => array(
          'name' => _x('properties', 'plural'),
          'singular_name' => _x('property', 'singular'),
          'menu_name' => _x('Properties', 'admin menu'),
          'name_admin_bar' => _x('properties', 'admin bar'),
          'add_new' => _x('Add New', 'add new'),
          'add_new_item' => __('Add New property'),
          'new_item' => __('New property'),
          'edit_item' => __('Edit property'),
          'view_item' => __('View property'),
          'all_items' => __('All properties'),
          'search_items' => __('Search properties'),
          'not_found' => __('No property found.'),
        ),
        'public' => true,
        'query_var' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'show_in_rest' => true,
        'taxonomies' => array('locations, beds, baths, propid'),
        'show_in_nav_menus' => false,
        'menu_icon' => 'dashicons-admin-multisite',
        'menu_position' => 6,
        'rewrite' => array('slug' => 'properties', 'with_front' => false),
      ));

    remove_theme_support( 'post-thumbnails' );
    add_theme_support( 
      'post-thumbnails', [ 
        'post',
        'page',
        'properties',
      ]
    );

    register_taxonomy( 'locations', array( 'properties' ), array(
      'labels'                     => array(
        'name'                       => _x( 'Locations', 'epiqk' ),
        'singular_name'              => _x( 'Locations', 'Taxonomy Singular Name', 'epiqk' ),
        'menu_name'                  => __( 'Locations', 'epiqk' ),
        'all_items'                  => __( 'All Items', 'epiqk' ),
        'parent_item'                => __( 'Parent Item', 'epiqk' ),
        'parent_item_colon'          => __( 'Parent Item:', 'epiqk' ),
        'new_item_name'              => __( 'New Item Name', 'epiqk' ),
        'add_new_item'               => __( 'Add New Item', 'epiqk' ),
        'edit_item'                  => __( 'Edit Item', 'epiqk' ),
        'update_item'                => __( 'Update Item', 'epiqk' ),
        'view_item'                  => __( 'View Item', 'epiqk' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'epiqk' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'epiqk' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'epiqk' ),
        'popular_items'              => __( 'Popular Items', 'epiqk' ),
        'search_items'               => __( 'Search Items', 'epiqk' ),
        'not_found'                  => __( 'Not Found', 'epiqk' ),
        'no_terms'                   => __( 'No items', 'epiqk' ),
        'items_list'                 => __( 'Items list', 'epiqk' ),
        'items_list_navigation'      => __( 'Items list navigation', 'epiqk' ),
      ),
      'hierarchical'               => true,
      'public'                     => true,
      'show_ui'                    => true,
      'show_in_rest'               => true,
      'show_admin_column'          => true,
      'show_in_nav_menus'          => false,
      'show_tagcloud'              => false,
    ) );

    register_taxonomy( 'beds', array( 'properties' ), array(
      'labels'                     => array(
        'name'                       => _x( 'Beds', 'epiqk' ),
        'singular_name'              => _x( 'Beds', 'Taxonomy Singular Name', 'epiqk' ),
        'menu_name'                  => __( 'Beds', 'epiqk' ),
        'all_items'                  => __( 'All Items', 'epiqk' ),
        'parent_item'                => __( 'Parent Item', 'epiqk' ),
        'parent_item_colon'          => __( 'Parent Item:', 'epiqk' ),
        'new_item_name'              => __( 'New Item Name', 'epiqk' ),
        'add_new_item'               => __( 'Add New Item', 'epiqk' ),
        'edit_item'                  => __( 'Edit Item', 'epiqk' ),
        'update_item'                => __( 'Update Item', 'epiqk' ),
        'view_item'                  => __( 'View Item', 'epiqk' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'epiqk' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'epiqk' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'epiqk' ),
        'popular_items'              => __( 'Popular Items', 'epiqk' ),
        'search_items'               => __( 'Search Items', 'epiqk' ),
        'not_found'                  => __( 'Not Found', 'epiqk' ),
        'no_terms'                   => __( 'No items', 'epiqk' ),
        'items_list'                 => __( 'Items list', 'epiqk' ),
        'items_list_navigation'      => __( 'Items list navigation', 'epiqk' ),
      ),
      'hierarchical'               => true,
      'public'                     => true,
      'show_ui'                    => true,
      'show_admin_column'          => true,
      'show_in_rest'               => true,
      'show_in_nav_menus'          => false,
      'show_tagcloud'              => false,
    ) );

    register_taxonomy( 'baths', array( 'properties' ), array(
      'labels'                     => array(
        'name'                       => _x( 'Baths', 'epiqk' ),
        'singular_name'              => _x( 'Baths', 'Taxonomy Singular Name', 'epiqk' ),
        'menu_name'                  => __( 'Baths', 'epiqk' ),
        'all_items'                  => __( 'All Items', 'epiqk' ),
        'parent_item'                => __( 'Parent Item', 'epiqk' ),
        'parent_item_colon'          => __( 'Parent Item:', 'epiqk' ),
        'new_item_name'              => __( 'New Item Name', 'epiqk' ),
        'add_new_item'               => __( 'Add New Item', 'epiqk' ),
        'edit_item'                  => __( 'Edit Item', 'epiqk' ),
        'update_item'                => __( 'Update Item', 'epiqk' ),
        'view_item'                  => __( 'View Item', 'epiqk' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'epiqk' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'epiqk' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'epiqk' ),
        'popular_items'              => __( 'Popular Items', 'epiqk' ),
        'search_items'               => __( 'Search Items', 'epiqk' ),
        'not_found'                  => __( 'Not Found', 'epiqk' ),
        'no_terms'                   => __( 'No items', 'epiqk' ),
        'items_list'                 => __( 'Items list', 'epiqk' ),
        'items_list_navigation'      => __( 'Items list navigation', 'epiqk' ),
      ),
      'hierarchical'               => true,
      'public'                     => true,
      'show_ui'                    => true,
      'show_admin_column'          => true,
      'show_in_rest'               => true,
      'show_in_nav_menus'          => false,
      'show_tagcloud'              => false,
    ) );

    // register_taxonomy( 'propertyid', array( 'properties' ), array(
    //   'labels'                     => array(
    //     'name'                       => _x( 'Property ID', 'epiqk' ),
    //     'singular_name'              => _x( 'Property ID', 'Taxonomy Singular Name', 'epiqk' ),
    //     'menu_name'                  => __( 'Property ID', 'epiqk' ),
    //     'all_items'                  => __( 'All Items', 'epiqk' ),
    //     'parent_item'                => __( 'Parent Item', 'epiqk' ),
    //     'parent_item_colon'          => __( 'Parent Item:', 'epiqk' ),
    //     'new_item_name'              => __( 'New Item Name', 'epiqk' ),
    //     'add_new_item'               => __( 'Add New Item', 'epiqk' ),
    //     'edit_item'                  => __( 'Edit Item', 'epiqk' ),
    //     'update_item'                => __( 'Update Item', 'epiqk' ),
    //     'view_item'                  => __( 'View Item', 'epiqk' ),
    //     'separate_items_with_commas' => __( 'Separate items with commas', 'epiqk' ),
    //     'add_or_remove_items'        => __( 'Add or remove items', 'epiqk' ),
    //     'choose_from_most_used'      => __( 'Choose from the most used', 'epiqk' ),
    //     'popular_items'              => __( 'Popular Items', 'epiqk' ),
    //     'search_items'               => __( 'Search Items', 'epiqk' ),
    //     'not_found'                  => __( 'Not Found', 'epiqk' ),
    //     'no_terms'                   => __( 'No items', 'epiqk' ),
    //     'items_list'                 => __( 'Items list', 'epiqk' ),
    //     'items_list_navigation'      => __( 'Items list navigation', 'epiqk' ),
    //   ),
    //   'hierarchical'               => true,
    //   'public'                     => true,
    //   'show_ui'                    => true,
    //   'show_admin_column'          => true,
    //   'show_in_rest'               => true,
    //   'show_in_nav_menus'          => false,
    //   'show_tagcloud'              => false,
    // ) );

    register_taxonomy( 'propid', array( 'properties' ), array(
      'labels'                     => array(
        'name'                       => _x( 'Property ID', 'epiqk' ),
        'singular_name'              => _x( 'Property ID', 'Taxonomy Singular Name', 'epiqk' ),
        'menu_name'                  => __( 'Property ID', 'epiqk' ),
        'all_items'                  => __( 'All Items', 'epiqk' ),
        'parent_item'                => __( 'Parent Item', 'epiqk' ),
        'parent_item_colon'          => __( 'Parent Item:', 'epiqk' ),
        'new_item_name'              => __( 'New Item Name', 'epiqk' ),
        'add_new_item'               => __( 'Add New Item', 'epiqk' ),
        'edit_item'                  => __( 'Edit Item', 'epiqk' ),
        'update_item'                => __( 'Update Item', 'epiqk' ),
        'view_item'                  => __( 'View Item', 'epiqk' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'epiqk' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'epiqk' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'epiqk' ),
        'popular_items'              => __( 'Popular Items', 'epiqk' ),
        'search_items'               => __( 'Search Items', 'epiqk' ),
        'not_found'                  => __( 'Not Found', 'epiqk' ),
        'no_terms'                   => __( 'No items', 'epiqk' ),
        'items_list'                 => __( 'Items list', 'epiqk' ),
        'items_list_navigation'      => __( 'Items list navigation', 'epiqk' ),
      ),
      'hierarchical'               => true,
      'public'                     => true,
      'show_ui'                    => true,
      'show_admin_column'          => true,
      'show_in_rest'               => true,
      'show_in_nav_menus'          => false,
      'show_tagcloud'              => false,
    ) );

    
    add_theme_support( 'menus' );
    add_theme_support( 'widgets' );
    add_post_type_support( 'post', 'excerpt' );
    add_post_type_support( 'page', 'excerpt' );
    add_post_type_support( 'property', 'excerpt' );
  
    // Remove wp emoji support.
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    
    add_editor_style( 'assets/css/app-editor.css' );
  }

  public static function admin_bar_init() {
    remove_action( 'wp_head', '_admin_bar_bump_cb' );
  }
  
  public static function gutenberg_styles() {
    
    wp_enqueue_style( 'epiqk-fonts', 'https://use.typekit.net/ppa5oaf.css', [], null );
    wp_enqueue_style( 'epiqk-base-style', get_theme_file_uri( 'assets/css/app-editor.css' ), [], Epiqk::theme_version() );
  
    wp_enqueue_script( 'epiqk-block-styles', get_theme_file_uri( 'assets/js/app-admin.js' ), array( 'wp-blocks', 'wp-dom' ), Epiqk::theme_version(), true );
    wp_enqueue_script( 'epiqk-editor-js', get_theme_file_uri( 'assets/js/app-editor.js' ), array( 'jquery', 'wp-blocks', 'wp-dom' ), Epiqk::theme_version(), true );
    
  }
  
  public static function wp_enqueue_scripts() {
    
    wp_enqueue_script( 'epiqk-libs', get_template_directory_uri() . '/assets/js/app-libs.js', [ 'jquery' ], Epiqk::theme_version(), true );
    wp_enqueue_script( 'epiqk', get_template_directory_uri() . '/assets/js/app.js', [ 'jquery', 'epiqk-libs' ], Epiqk::theme_version(), true );
    
    wp_enqueue_style( 'epiqk-fonts', 'https://use.typekit.net/ppa5oaf.css', [], null );
    wp_enqueue_style( 'epiqk', get_template_directory_uri() . '/assets/css/app.css', ['epiqk-fonts'], Epiqk::theme_version() );
    
  }
  
  public static function wp_dequeue_scripts() {
    
    if ( !is_user_logged_in() ) {
      wp_deregister_script( 'wp-embed' );
    }
    
  }

  public static function pre_get_posts( $query ) {
  
    return $query;
  
  }
  
  public static function the_excerpt( $text ) {
    
    if( is_search() && !is_admin() ) {
          
      $keywords = preg_split( '/\s+/', get_query_var( 's' ) );
      $keywords = array_filter( $keywords, 'strip_tags' );
      $keywords = array_filter( $keywords, 'trim' );
      
      if ( !empty( $keywords ) ) {
        $text = preg_replace('/(' . implode('|', $keywords) .')/iu', '<strong>${1}</strong>', strip_tags( $text ) );
      }
    }
    
    return $text;
    
  }
  
  public static function upload_mimes( $mimes ) {
      $mimes['svg'] = 'image/svg+xml';
      return $mimes;
  }
  
  // Yoast SEO
  public static function wpseo_separator_options( $separators ) { 
    return $separators; 
  }
  
  // ACF
  public static function acf_init() {
      
    
    if( function_exists('acf_register_block_type') ) {


      acf_register_block_type( [
        'name' => 'ep-search-bar',
        'title' => __( 'Search Bar' ),
        'description' => __( '' ),
        'render_template' => '/blocks-acf/ep-search-bar/template.php',
        'enqueue_style' => get_template_directory_uri() . '/assets/css/app-blocks-acf.css',
        'enqueue_script' => get_template_directory_uri() . '/assets/js/app-blocks-acf.js',
        'category' => 'epiqk-blocks',
        'icon' => '',
        'supports' => [
          'align' => false,
          'anchor' => true,
        ],
      ] );

      acf_register_block_type( [
        'name' => 'ep-location',
        'title' => __( 'Location' ),
        'description' => __( '' ),
        'render_template' => '/blocks-acf/ep-location/template.php',
        'enqueue_style' => get_template_directory_uri() . '/assets/css/app-blocks-acf.css',
        'enqueue_script' => get_template_directory_uri() . '/assets/js/app-blocks-acf.js',
        'category' => 'epiqk-blocks',
        'icon' => '',
        'supports' => [
          'align' => false,
          'anchor' => true,
        ],
      ] );

      acf_register_block_type( [
        'name' => 'ep-accordion',
        'title' => __( 'Accordion' ),
        'description' => __( '' ),
        'render_template' => '/blocks-acf/ep-accordion/template.php',
        'enqueue_style' => get_template_directory_uri() . '/assets/css/app-blocks-acf.css',
        'enqueue_script' => get_template_directory_uri() . '/assets/js/app-blocks-acf.js',
        'category' => 'epiqk-blocks',
        'icon' => '',
        'supports' => [
          'align' => false,
          'anchor' => true,
        ],
      ] );


    }
    
  }

  public static function render_block( $block_content, $block ) {

    if ( !is_admin() ) {

      if ( 'core/cover' === $block['blockName'] ) {
        $block_content = str_replace(' playsinline', '', $block_content);
        $block_content = str_replace(' autoplay', ' autoplay playsinline', $block_content);
      }

    }
  
    return $block_content;
  }

  public static function custom_block_categories( $categories ) {
    return array_merge(
      array(
        array(
          'slug' => 'epiqk-blocks',
          'title' => __( 'Epiqk', 'epiqk-blocks' ),
        ),
      ),
      $categories
    );
  }

  public static function enable_more_buttons($buttons) {
    $buttons[] = 'subscript';
    $buttons[] = 'superscript';
    return $buttons;
  }

  public static function property_query( $query ) {
    if ( $query->is_post_type_archive('properties') && $query->is_main_query() && !is_admin() ) {

      $tax_query = [];
        
        if(!empty( $_GET['city'] ) ) {
          $tax_query[] = [
            'taxonomy' => 'locations',
            'field' => 'id',
            'terms' => (int)$_GET['city']
          ];
        }
  
        if(!empty( $_GET['baths'] ) ) {
          $tax_query[] = [
            'taxonomy' => 'baths',
            'field' => 'slug',
            'terms' => (int)$_GET['baths']
          ];
        }

        if(!empty( $_GET['beds'] ) ) {
          $tax_query[] = [
            'taxonomy' => 'beds',
            'field' => 'slug',
            'terms' => (int)$_GET['beds']
          ];
        }

        if(!empty( $_GET['propid'] ) ) {
          $propids = get_terms( array(
            'post_type' => 'properties',
            'orderby'   => 'name',
            'order'     => 'ASC',
            'taxonomy'  => 'propid',
            'hide_empty'=> false
          ) );

          $match = false;
          $propid = (string)$_GET['propid'];

          foreach($propids as $cat) :
            if($propid == $cat->slug) {
              $match = true;
            }
          endforeach; 

          if( $match ) {
            $tax_query[] = [
              'taxonomy' => 'propid',
              'field' => 'slug',
              'terms' => $propid
            ];

          } else {

            $tax_query[] = [
              'taxonomy' => 'beds',
              'field' => 'slug',
              'terms' => array('0','1','2','3','4')
            ];

          }
        }
        
        if ( !empty( $tax_query ) ) {
          $tax_query = array_merge( [ 'relation' => 'AND' ], $tax_query );
          $query->set( 'tax_query', $tax_query );
        }      
        
        // Epiqk::debug($query);
      return $query;
    }
  }

}

add_action( 'pre_get_posts', array('EpiqkTheme', 'property_query' ) );
add_action( 'login_enqueue_scripts', function() {
    
  wp_dequeue_style( 'dashicons' );
  wp_dequeue_style( 'buttons' );
  wp_dequeue_style( 'forms' );
  wp_dequeue_style( 'l10n' );
  wp_dequeue_style( 'login' );
  wp_dequeue_style( 'genericons' );
  wp_dequeue_style( 'jetpack-sso-login' );

  wp_enqueue_style( 'epiqk-login', get_stylesheet_directory_uri() . '/style-login.css' );
  wp_enqueue_style( 'epiqk-login-2021', get_stylesheet_directory_uri() . '/assets/css/app-login.css' );

}, 20 );

add_action( 'after_switch_theme', array( 'EpiqkTheme', 'after_switch_theme' ) );
add_action( 'after_setup_theme', array( 'EpiqkTheme', 'after_setup_theme' ) );
add_action( 'init', array( 'EpiqkTheme', 'init' ) );

add_action( 'enqueue_block_editor_assets', array( 'EpiqkTheme', 'gutenberg_styles' ) );

add_action( 'wp_enqueue_scripts', array( 'EpiqkTheme', 'wp_enqueue_scripts' ) );
add_action( 'admin_bar_init', array( 'EpiqkTheme', 'admin_bar_init' ) );

add_action( 'acf/init', array( 'EpiqkTheme', 'acf_init' ) );

// add_action( 'rest_api_init', function () {
//   register_rest_route( 'epiqk/v1', '/signup', [
//     'methods' => 'POST',
//     'callback' => function( $data ) {
//       $email = (string)$_POST['email'];
//       $token = (string)$_POST['token'];
//       $action = (string)$_POST['action'];
//       $secret_key = 'SECRET_KEY';

//       if( !empty($email) && filter_var( $email, FILTER_VALIDATE_EMAIL ) && !empty($token) ) {

//         $ch = curl_init();
//         curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
//         curl_setopt($ch, CURLOPT_POST, 1);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => $secret_key, 'response' => $token)));
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         $response = curl_exec($ch);
//         curl_close($ch);
//         $arrResponse = json_decode($response, true);
        
//         if($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.7) {
          
//           $mc_api = curl_init(); 
//           $mc_apikey = 'MC API KEY HERE';
//           $mc_listid = 'LIST ID HERE';
//           curl_setopt( $mc_api, CURLOPT_URL, 'https://'. substr( $mc_apikey, strpos( $mc_apikey, '-' ) + 1 ) .'.api.mailchimp.com/3.0/lists/'. $mc_listid .'/members/'. md5( strtolower( $email ) ) );
//           curl_setopt( $mc_api, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', 'Authorization: Basic '. base64_encode( 'user:'. $mc_apikey ) ) );
//           curl_setopt( $mc_api, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0' );
//           curl_setopt( $mc_api, CURLOPT_RETURNTRANSFER, true );
//           curl_setopt( $mc_api, CURLOPT_TIMEOUT, 10 );
//           curl_setopt( $mc_api, CURLOPT_SSL_VERIFYPEER, false );
//           curl_setopt( $mc_api, CURLOPT_CUSTOMREQUEST, 'PUT' );
//           curl_setopt( $mc_api, CURLOPT_POST, true );
//           curl_setopt( $mc_api, CURLOPT_POSTFIELDS, json_encode( [
//             'email_address' => $email,
//             'status' => 'subscribed',
//           ] ) );
//           $response = json_decode( curl_exec( $mc_api ) );
//           curl_close( $mc_api );
//           if ( !is_object( $response ) || empty( $response->id ) ) return new WP_Error( 400, 'Invalid Mailchimp response.' );
//           else return new WP_REST_Response( [ 'status' => 'success' ], 200 );
    
//         } else {
//           return new WP_Error( 400, 'Google recaptcha thinks this submission is spam! A score over 0.7 is required.', $arrResponse['score'] );
//         }

//       } else {
//         return new WP_Error( 400, 'Email is invalid or recaptcha token is missing' );
//       }
//     },
//   ] );
// } );

add_filter( 'block_categories', array( 'EpiqkTheme', 'custom_block_categories' ) );
add_filter( 'pre_get_posts', array( 'EpiqkTheme', 'pre_get_posts' ) );
add_filter( 'render_block', array( 'EpiqkTheme', 'render_block' ), 10, 2);
add_filter( 'the_excerpt', array( 'EpiqkTheme', 'the_excerpt' ) );
add_filter( 'upload_mimes', array( 'EpiqkTheme', 'upload_mimes' ) );
add_filter( 'mce_buttons', array( 'EpiqkTheme', 'enable_more_buttons' ) );

add_filter( 'rest_pre_echo_response', function( $result, $server, $request ) {
  if ( '/wp/v2/posts' === $request->get_route() ) {
    $result = array_map( function ( $post ) {
      return [ 'card' => '<li class="blog__listing content"><article class="blog__teaser"><a href="' . get_permalink( $post['id'] ) . '"><div class="blog__teaser__image-wrap">' . get_the_post_thumbnail( $post['id'], 'large' ) . '</div><div class="blog__teaser__content-wrap"><h2><sup>' . get_the_date('M d, Y', $post['id']) . '</sup>' . esc_html( get_the_title( $post['id'] ) ) . '</h2><span>Read more</span></div></a></article></li>'];
    }, $result );
  }
  return $result;
}, 10, 3 );

// Show all Properties on Properties Archive Page
add_action( 'pre_get_posts', 'tl_property_tax_page' );
function tl_property_tax_page( $query ) {
    if ( !is_admin() && $query->is_main_query() && is_category() ) {
            $query->set( 'posts_per_page', '-1' );
    }
}

// Allow SVG
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
  global $wp_version;
  if ( $wp_version !== '4.7.1' ) {
     return $data;
  }
  $filetype = wp_check_filetype( $filename, $mimes );
  return [
      'ext'             => $filetype['ext'],
      'type'            => $filetype['type'],
      'proper_filename' => $data['proper_filename']
  ];
}, 10, 4 );

function cc_mime_types( $mimes ){
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

function fix_svg() {
  echo '';
}
add_action( 'admin_head', 'fix_svg' );


//ADD ME TO config.php FOR SVG ENABLE//
//define( 'ALLOW_UNFILTERED_UPLOADS', true );