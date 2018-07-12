<?php
/**
 * bloma functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package bloma
 */

if ( ! function_exists( 'bloma_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function bloma_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on bloma, use a find and replace
		 * to change 'bloma' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'bloma', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'bloma' ),
		) );
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-2' => esc_html__( 'FooterLocation', 'bloma' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'bloma_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'bloma_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bloma_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'bloma_content_width', 640 );
}
add_action( 'after_setup_theme', 'bloma_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bloma_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'bloma' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'bloma' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'bloma_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function bloma_scripts() {
	wp_enqueue_style( 'bloma-style', get_stylesheet_uri(), array(), microtime()  );

	wp_enqueue_style( 'fontello-icon-font', get_template_directory_uri() . '/assets/fonts/fontello-32c882a8/css/fontello.css', array(), microtime()  );
	
	wp_enqueue_style( 'google-fonts','https://fonts.googleapis.com/css?family=Montserrat:400,700|Noto+Sans:400,700&amp;subset=latin-ext',  array(), microtime());

	wp_enqueue_script( 'bloma-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'bloma-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bloma_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// add custom fields for global general variables


//Custom Theme Settings

function add_gcf_interface() {
	add_options_page('Social Media Bar', 'Social Media Bar', '8', 'functions', 'editglobalcustomfields');
}

function editglobalcustomfields() {
	?>
	<div class='wrap'>
		<h2>Social Media Bar</h2>
		<p>Each link must be provided in following format www.xxxxxx.xx/xxxx.</p>
		<p>If you dont want to display any of those social media icon simply put 0 in the input field and push 'Update Options' button.</p>
	<form method="post" action="options.php" style="margin-top:2rem;">
		<?php wp_nonce_field('update-options') ?>

	<p><strong>Link to Website Facebook:</strong><br />
	<input type="text" name="myFacebook" size="45" value="<?php echo get_option('myFacebook'); ?>" /></p>
	
	<p><strong>Link to Website Instagram:</strong><br />
	<input type="text" name="myInstagram" size="45" value="<?php echo get_option('myInstagram'); ?>" /></p>
	
	<p><strong>Link to Website Twitter:</strong><br />
	<input type="text" name="myTwitter" size="45" value="<?php echo get_option('myTwitter'); ?>" /></p>
	
	<p><strong>Link to Website Behance:</strong><br />
	<input type="text" name="myBehance" size="45" value="<?php echo get_option('myBehance'); ?>" /></p>
	
	<p><strong>Link to Website Pinterest:</strong><br />
	<input type="text" name="myPinterest" size="45" value="<?php echo get_option('myPinterest'); ?>" /></p>
	
	<p><strong>Link to Website GooglePlus:</strong><br />
	<input type="text" name="myGooglePlus" size="45" value="<?php echo get_option('myGooglePlus'); ?>" /></p>
	
	<p><strong>Link to Website Youtube:</strong><br />
	<input type="text" name="myYoutube" size="45" value="<?php echo get_option('myYoutube'); ?>" /></p>
	
	

	<p><input type="submit" name="Submit" value="Update Options" /></p>

	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="myFacebook,myInstagram,myTwitter,myBehance,myPinterest,myGooglePlus,myYoutube" />
	
</form>
</div>

<?php
}

add_action('admin_menu', 'add_gcf_interface');

