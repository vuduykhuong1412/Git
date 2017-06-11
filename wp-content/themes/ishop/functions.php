<?php

/**
 * ishop functions and definitions
 *
 * @package ishop
 */

if ( ! function_exists( 'ishop_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ishop_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on ishop, use a find and replace
	 * to change 'ishop' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'ishop', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
        set_post_thumbnail_size( 300, 300, true );
		 add_image_size( 'postthumbnail', 270, 180, true );
        add_image_size( 'ishop_themewidget', 65, 65, true );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'topmenu' => esc_html__( 'Top Menu', 'ishop' ),
		'primary' => esc_html__( 'Primary Menu', 'ishop' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );
        /*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css') );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'ishop_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // ishop_setup
add_action( 'after_setup_theme', 'ishop_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ishop_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ishop_content_width', 700 );
        if ( ! isset( $content_width ) ) $content_width = 700;
}
add_action( 'after_setup_theme', 'ishop_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function ishop_scripts() {
	wp_enqueue_style( 'ishop-style', get_stylesheet_uri() );
	wp_enqueue_style( 'ishop-foundation-css', get_stylesheet_directory_uri() . '/foundation/css/foundation.min.css' );
	wp_enqueue_style( 'ishop-customcss', get_stylesheet_directory_uri() . '/css/custom.css' );
/* Add Foundation CSS */
	wp_enqueue_style( 'ishop-font-awesome', get_stylesheet_directory_uri() . '/font-awesome/css/font-awesome.min.css' );
   // wp_enqueue_style('ishop-reset', get_template_directory_uri()."/foundation/css/normalize.css",array(),'5.1.1','screen');
	wp_enqueue_script('jquery'); //Default jQuery file shipped with WordPress
	wp_enqueue_script('ishop-smoothscroll', get_template_directory_uri().'/js/smoothscroll.js', array(), '1.0', false );
	/* Add Foundation JS */
    wp_enqueue_script( 'ishop-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script('ishop-backscript', get_template_directory_uri().'/js/scroll.js', array('jquery'), '1.0', false );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	if ( is_rtl() ) {
			wp_enqueue_style( 'ishop-rtl-css', get_template_directory_uri() . '/css/rtl.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'ishop_scripts' );

function ishop_register_scripts() {
    wp_register_script('foundation-js', get_template_directory_uri()."/foundation/js/foundation.min.js", array('jquery'),'5.1.1',true); 

  wp_enqueue_script(array('jquery-min','foundation-js'));
}

add_action('wp_enqueue_scripts','ishop_register_scripts');

function ishop_footerscript() {
    wp_enqueue_script(
        'foundation_js_footer',
        get_template_directory_uri() . '/js/footersc.js',
        array('jquery'),
        '1.0',
        true
    );

}

add_action('wp_enqueue_scripts', 'ishop_footerscript',10);
/**
 * Enqueue script for custom customize control.
 */
function ishop_custom_customize_enqueue() {
	wp_enqueue_style( 'customizer-cs', get_stylesheet_directory_uri() . '/css/customizer-css.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'ishop_custom_customize_enqueue' );


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';
/**
 * Include theme widgets.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
/**
 * custom-function file.
 */
require get_template_directory() . '/inc/custom-function.php';

include_once('inc/installs.php');
include_once('inc/core/core.php');

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'ishop_register_required_plugins' );

function ishop_register_required_plugins() {

   $plugins = array(

	
		
		// This is an example of how to include a plugin from the WordPress Plugin Repository.
		array(
			'name'      => 'Regenerate Thumbnails',
			'slug'      => 'regenerate-thumbnails',
			'required'  => false,
		),
		array(
			'name'      => 'WooCommerce - excelling eCommerce',
			'slug'      => 'woocommerce',
			'required'  => false,
		),
		array(
			'name'      => 'Menu Icons',
			'slug'      => 'menu-icons',
			'required'  => false,
		),


	);


	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.


);	tgmpa( $plugins, $config );

}
	require get_template_directory() . '/inc/metaboxpage.php';
	require get_template_directory() . '/inc/metaboxsingle.php';