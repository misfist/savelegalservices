<?php
/**
 * Project Name - Short Description
 *
 * Long Description
 * Can span several lines
 *
 * @package    demos.dev
 * @subpackage subfolder
 * @version    1.2.1
 * @author     paul <pauldewouters@gmail.com>
 * @copyright  Copyright (c) 2012, Paul de Wouters
 * @link       http://pauldewouters.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/** Load the core theme framework. */
require_once( trailingslashit( get_template_directory() ) . 'library/hybrid.php' );
new Hybrid();

/** Theme setup */
function pdw_spine_theme_setup() {

	/** Custom thumbnail size */
	add_image_size('featured', 637, 132, true);

	/** Theme constants */
	define ( 'PDW_SPINE_JS_URL', trailingslashit( get_template_directory_uri() . '/js' ) );

	define ( 'PDW_SPINE_INC_DIR', trailingslashit( get_template_directory() . '/includes' ) );

	define ( 'PDW_SPINE_DIR', dirname( __FILE__ ) );

	define( 'PDW_SPINE_VERSION', '1.3.3' );

	/** Template tags */
	include_once PDW_SPINE_INC_DIR . 'template-tags.php';

	/** Use Foundation nav bar markup for menus */
	include_once PDW_SPINE_INC_DIR . 'navbar-walker.php';

	/** Use Foundation makrup for galleries */
	include_once PDW_SPINE_INC_DIR . 'gallery-shortcode.php';


	/** Load main stylesheet */
	add_action( 'wp_enqueue_scripts', 'pdw_spine_load_styles' );

	/** Load the javascripts */
	add_action( 'wp_enqueue_scripts', 'pdw_spine_load_scripts' );

	/** Hybrid Core features */
	/** Get action/filter hook prefix. */
	$prefix = hybrid_get_prefix();

	/** Add theme support for core framework features. */
	add_theme_support( 'hybrid-core-menus', array( 'primary', 'secondary', 'subsidiary' ) );
	add_theme_support( 'hybrid-core-sidebars', array( 'primary', 'subsidiary' ) );
	add_theme_support( 'hybrid-core-widgets' );
	add_theme_support( 'hybrid-core-shortcodes' );

	/** Add theme settings */
	add_theme_support( 'hybrid-core-theme-settings', array( 'about', 'footer' ) );

	/** Include theme customizer options */
	include_once 'includes/spine-customizer.php';
	add_action( 'customize_register', 'pdw_spine_customize_register' );

	add_theme_support( 'hybrid-core-template-hierarchy' );

	/** Add theme support for framework extensions. */
	//add_theme_support( 'post-stylesheets' );
	add_theme_support( 'dev-stylesheet' );
	//add_theme_support( 'loop-pagination' );
	add_theme_support( 'get-the-image' );
	add_theme_support( 'breadcrumb-trail' );
	add_theme_support( 'cleaner-gallery' );

	/** Add theme support for WordPress features. */
	add_theme_support( 'automatic-feed-links' );
	//add_theme_support( 'post-formats', array( 'image', 'gallery' ) );

	add_theme_support( 'theme-layouts', array( '2c-l', '2c-r', '1c' ) );

	/* Add support for WordPress custom background. */
	add_theme_support(
		'custom-background',
		array(
			'default-image'    => trailingslashit( get_template_directory_uri() ) . 'backgrounds/satinweave.png',
			'wp-head-callback' => 'pdw_spine_custom_background_callback'
		)
	);

	/** Add support for WordPress custom header image. */
	add_theme_support(
		'custom-header',
		array(
			'wp-head-callback'    => '__return_false',
			'admin-head-callback' => '__return_false',
			'header-text'         => false,
			'default-image'       => 'remove-header',
			'width'               => 970,
			'height'              => 250
		)
	);

	add_theme_support( 'featured-header' );

	/** Set content width. */
	hybrid_set_content_width( 637 );

	//add_filter( 'wp_nav_menu_objects',  'pdw_spine_add_parent_class'  );
	add_filter( 'wp_nav_menu_objects', 'pdw_spine_add_active_class' );

	add_filter( 'loop_pagination_args', 'pdw_spine_foundation_pagination' );

	/* Register Spine widgets. */
	add_action( 'widgets_init', 'pdw_spine_register_widgets' );

	/**  custom editor styles */
	if ( is_admin() ) {
		include( 'tinymce-kit/tinymce-kit.php' );
	} // end if

	//add_filter('post_thumbnail_html', 'pdw_spine_add_thumbnail_class',10, 3 );
	add_filter( 'get_the_image', 'pdw_spine_add_featured_img_class', 10, 1 );

	/** Register widget areas */
	add_action('widgets_init', 'pdw_spine_register_sidebars', 11);

	add_filter("{$prefix}_sidebar_defaults", 'spine_sidebar_defaults', 10, 2);

	add_editor_style();

	/** Jetpack feature */
	add_theme_support( 'infinite-scroll', array(
		'container'  => 'hfeed',
		'footer'     => 'page',
	) );

	/* Disable primary sidebar widgets when layout is one column. */
	add_filter( 'sidebars_widgets', 'pdw_spine_disable_sidebars' );
	add_action( 'template_redirect', 'pdw_spine_one_column' );

	// Add customizer styles to frontend
	add_action( 'wp_head', 'pdw_spine_wp_head' );
}

add_action( 'after_setup_theme', 'pdw_spine_theme_setup' );

/**
 * Registers Spine extra widget areas
 */
function pdw_spine_register_sidebars(){
		/** Register front-page widget areas */
	register_sidebar(
		array(
			'id' => 'banded-first-band',
			'name' => __( 'Front Page First Band','spine' ),
			'description' => __( 'This is the full width area at the top of the Front Page template.','spine'  ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);
	register_sidebar(
		array(
			'id' => 'banded-second-band-1',
			'name' => __( 'Front Page Second Band 1','spine' ),
			'description' => __( 'This is the narrow area in the middle of the Front Page template.','spine'  ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);
	register_sidebar(
		array(
			'id' => 'banded-second-band-2',
			'name' => __( 'Front Page Second Band 2','spine' ),
			'description' => __( 'This is the wider area in the middle of the Front Page template.','spine'  ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);
	register_sidebar(
		array(
			'id' => 'banded-third-band-1',
			'name' => __( 'Front Page Third Band 1','spine' ),
			'description' => __( 'This is the wider area at the bottom of the Front Page template.','spine'  ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);
	register_sidebar(
		array(
			'id' => 'banded-third-band-2',
			'name' => __( 'Front Page Third Band 2','spine' ),
			'description' => __( 'This is the narrow area at the bottom of the Front Page template.','spine'  ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);
}

function spine_sidebar_defaults($defaults, $sidebar){

	if('subsidiary' == $sidebar){
		/* Set up some default sidebar arguments. */
		$spine = array(
			'before_widget' => '<article role="article" id="%1$s" class="six columns widget %2$s widget-%2$s"><div class="widget-wrap widget-inside">',
			'after_widget'  => '</div></article>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>'
		);
	} else{
		/* Set up some default sidebar arguments. */
		$spine = array(
			'before_widget' => '<article role="article" id="%1$s" class="panel widget %2$s widget-%2$s"><div class="widget-wrap widget-inside">',
			'after_widget'  => '</div></article>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>'
		);
	}


	array_merge($defaults,$spine);
	return $spine;
}

/**
 * Load the necessary CSS files
 */
function pdw_spine_load_styles() {

	/* translators: If there are characters in your language that are not supported
	   by Open Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'spine' ) ) {
		$subsets = 'latin,latin-ext';

		/* translators: To add an additional Open Sans character subset specific to your language, translate
		   this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language. */
		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'spine' );

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => 'Open+Sans|Gentium+Basic',
			'subset' => $subsets,
		);
		wp_enqueue_style( 'spine-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
	}

		/** This loads the main theme style.css */
		wp_enqueue_style( 'main', get_stylesheet_uri() );

}

/**
 * Load the necessary javascript files
 */
function pdw_spine_load_scripts() {

	wp_enqueue_script( 'foundation-buttons', PDW_SPINE_JS_URL . 'jquery.foundation.buttons.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	wp_enqueue_script( 'foundation-forms', PDW_SPINE_JS_URL . 'jquery.foundation.forms.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	wp_enqueue_script( 'foundation-mq-toggle', PDW_SPINE_JS_URL . 'jquery.foundation.mediaQueryToggle.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	wp_enqueue_script( 'foundation-navigation', PDW_SPINE_JS_URL . 'jquery.foundation.navigation.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	wp_enqueue_script( 'foundation-topbar', PDW_SPINE_JS_URL . 'jquery.foundation.topbar.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	wp_enqueue_script( 'foundation-tabs', PDW_SPINE_JS_URL . 'jquery.foundation.tabs.js', array( 'jquery' ), PDW_SPINE_VERSION, true );
	//wp_enqueue_script( 'foundation-clearing', PDW_SPINE_JS_URL . 'jquery.foundation.clearing.js', array( 'jquery' ), PDW_SPINE_VERSION, true );

	/** This is the main javascript file */
	wp_enqueue_script( 'foundation-app', PDW_SPINE_JS_URL . 'app.js', array( 'jquery' ), PDW_SPINE_VERSION, true );

}

/**
 * This is a fix for when a user sets a custom background color with no custom background image.  What
 * happens is the theme's background image hides the user-selected background color.  If a user selects a
 * background image, we'll just use the WordPress custom background callback.
 *
 * @since 0.1.0
 * @link  http://core.trac.wordpress.org/ticket/16919
 */
function pdw_spine_custom_background_callback() {

	/* Get the background image. */
	$image = get_background_image();

	/* If there's an image, just call the normal WordPress callback. We won't do anything here. */
	if ( ! empty( $image ) ) {
		_custom_background_cb();
		return;
	}

	/* Get the background color. */
	$color = get_background_color();

	/* If no background color, return. */
	if ( empty( $color ) )
		return;

	/* Use 'background' instead of 'background-color'. */
	$style = "background: #{$color};";

	?>
<style type="text/css">body.custom-background { <?php echo trim( $style ); ?> }</style>
<?php

}

function pdw_spine_hasSub( $menu_item_id, $items ) {
	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent == $menu_item_id ) {
			return true;
		}
	}
	return false;
}

/*function pdw_spine_add_parent_class( $items ) {
	foreach ( $items as $item ) {
		if ( pdw_spine_hasSub( $item->ID, $items ) ) {
			$item->classes[] = 'has-flyout'; // all elements of field "classes" of a menu item get join together and render to class attribute of <li> element in HTML
		}
	}
	return $items;
}*/

function pdw_spine_add_active_class( $items ) {
	foreach ( $items as $item ) {
		$current_element_markers = array( 'current-menu-item', 'current-menu-parent', 'current-menu-ancestor' );
		$current_class           = array_intersect( $current_element_markers, $item->classes );
		if ( ! empty( $current_class ) ) {
			$item->classes[] = 'active'; // all elements of field "classes" of a menu item get join together and render to class attribute of <li> element in HTML
		}
	}
	return $items;
}

/** Customize loop pagination extension */
function pdw_spine_foundation_pagination( $args ) {
	$args['before'] = '<div class="loop-pagination">';

	$args['type'] = 'list';

	return $args;
}

function pdw_spine_register_widgets() {
	/** Customize Nav Menu Widget */
	include_once  'includes/widget-nav-menu.php';

	/* Register the nav menu widget. */
	register_widget( 'Spine_Widget_Nav_Menu' );
}

function pdw_spine_add_featured_img_class( $img_html ) {
	/** Only do this is there's an image */
	if ( ! empty( $img_html ) )
		$img_html = '<a class="th" href="' . get_permalink( get_the_ID() ) . '" title="' . esc_attr( get_post_field( 'post_title', get_the_ID() ) ) . '">' . $img_html . '</a>';

	return $img_html;
}

function pdw_spine_fetch_bg_images() {
	$directory = PDW_SPINE_DIR . '/backgrounds/';
	//get all image files with a .jpg extension.
	$images = glob( $directory . "*.jpg" );

	return $images;
}


function pdw_spine_fetch_content_grid_classes() {

	/** Set the grid column span */
	$span_cols = apply_filters( 'spine_content_span_cols', 'eight columns' );

		/** Layout logic  */
		if(is_singular())
			$layout = get_post_layout( get_the_ID() );
		if ( empty($layout) || 'default' == $layout ) {
			$layout = get_theme_mod( 'theme_layout' );
		}
		switch ( $layout ) {
			case 'default' :
				$content_classes = $span_cols;
				break;
			case '1c' :
				$content_classes = "twelve columns";
				break;
			case '2c-l':
				$content_classes = $span_cols;
				break;
			case '2c-r':
				$content_classes = $span_cols . " push-four";
				break;
			default:
				$content_classes = $span_cols;
				break;
		} // end switch

	return $content_classes;
}

function pdw_spine_fetch_sidebar_grid_classes() {

	$span_cols = apply_filters( 'spine_sidebar_span_cols', 'four columns' );

		/** Layout logic  */
		if(is_singular())
			$layout = get_post_layout( get_the_ID() );
		if ( empty($layout) || 'default' == $layout ) {
			$layout = get_theme_mod( 'theme_layout' );
		}
		switch ( $layout ) {
			case 'default' :
				$sidebar_classes = $span_cols;
				break;
			case '1c' :
				/* Won't be displayed anyway */
				$sidebar_classes = "twelve columns";
				break;
			case '2c-l':
				$sidebar_classes = $span_cols;
				break;
			case '2c-r':
				$sidebar_classes = $span_cols . " pull-eight";
				break;
			default:
				$sidebar_classes = $span_cols;
				break;
		} //end switch

	return $sidebar_classes;
}

/**
 * Function for deciding which pages should have a one-column layout.
 *
 * @since 1.2.0
 */
function pdw_spine_one_column() {

	if ( ! ( is_active_sidebar( 'primary' ) )  || ( is_attachment() && 'layout-default' == theme_layouts_get_layout() ) )
		add_filter( 'get_theme_layout', 'pdw_spine_theme_layout_one_column' );

}

/**
 * Filters 'get_theme_layout' by returning 'layout-1c'.
 *
 * @since 1.2.0
 * @param string $layout The layout of the current page.
 * @return string
 */
function pdw_spine_theme_layout_one_column( $layout ) {
	return 'layout-1c';
}

/**
 * Disables sidebars if viewing a one-column page.
 *
 * @since 1.2.0
 * @param array $sidebars_widgets A multidimensional array of sidebars and widgets.
 * @return array $sidebars_widgets
 */
function pdw_spine_disable_sidebars( $sidebars_widgets ) {
	global $wp_query, $wp_customize;

	if ( current_theme_supports( 'theme-layouts' ) && !is_admin() ) {
		if ( ! isset( $wp_customize ) ) {
			if ( 'layout-1c' == theme_layouts_get_layout() ) {
				$sidebars_widgets['primary'] = false;
				//$sidebars_widgets['secondary'] = false;
			}
		}
	}

	return $sidebars_widgets;
}

/**
 * Insert customizer styles to document head
 */
function pdw_spine_wp_head() {
	$body_color = hybrid_get_setting( 'body_color' );
	$headline_color = hybrid_get_setting( 'headline_color' );
	$link_color = hybrid_get_setting( 'link_color' );
	$link_hover_color = hybrid_get_setting( 'link_hover_color' );

	echo "<style> body { color: $body_color; } h1, h2, h3, h4, h5, h6 { color: $headline_color } a { color: $link_color; } a:hover { color: $link_hover_color; } </style>";
}


/**
 * Returns a set of image attachment links based on size.
 *
 * @since 0.1.0
 * @return string Links to various image sizes for the image attachment.
 */
function spine_get_image_size_links() {

	/* If not viewing an image attachment page, return. */
	if ( !wp_attachment_is_image( get_the_ID() ) )
		return;

	/* Set up an empty array for the links. */
	$links = array();

	/* Get the intermediate image sizes and add the full size to the array. */
	$sizes = get_intermediate_image_sizes();
	$sizes[] = 'full';

	/* Loop through each of the image sizes. */
	foreach ( $sizes as $size ) {

		/* Get the image source, width, height, and whether it's intermediate. */
		$image = wp_get_attachment_image_src( get_the_ID(), $size );

		/* Add the link to the array if there's an image and if $is_intermediate (4th array value) is true or full size. */
		if ( !empty( $image ) && ( true === $image[3] || 'full' == $size ) )
			$links[] = "<a class='image-size-link' href='" . esc_url( $image[0] ) . "'>{$image[1]} &times; {$image[2]}</a>";
	}

	/* Join the links in a string and return. */
	return join( ' <span class="sep">/</span> ', $links );
}

/**
 * Displays an attachment image's metadata and exif data while viewing a singular attachment page.
 *
 * Note: This function will most likely be restructured completely in the future.  The eventual plan is to
 * separate each of the elements into an attachment API that can be used across multiple themes.  Keep
 * this in mind if you plan on using the current filter hooks in this function.
 *
 * @since 0.1.0
 */
function spine_image_info() {

	/* Set up some default variables and get the image metadata. */
	$meta = wp_get_attachment_metadata( get_the_ID() );
	$items = array();
	$list = '';

	/* Add the width/height to the $items array. */
	$items['dimensions'] = sprintf( __( '<span class="prep">Dimensions:</span> %s', 'spine' ), '<span class="image-data"><a href="' . esc_url( wp_get_attachment_url() ) . '">' . sprintf( __( '%1$s &#215; %2$s pixels', 'spine' ), $meta['width'], $meta['height'] ) . '</a></span>' );

	/* If a timestamp exists, add it to the $items array. */
	if ( !empty( $meta['image_meta']['created_timestamp'] ) )
		$items['created_timestamp'] = sprintf( __( '<span class="prep">Date:</span> %s', 'spine' ), '<span class="image-data">' . date( get_option( 'date_format' ), $meta['image_meta']['created_timestamp'] ) . '</span>' );

	/* If a camera exists, add it to the $items array. */
	if ( !empty( $meta['image_meta']['camera'] ) )
		$items['camera'] = sprintf( __( '<span class="prep">Camera:</span> %s', 'spine' ), '<span class="image-data">' . $meta['image_meta']['camera'] . '</span>' );

	/* If an aperture exists, add it to the $items array. */
	if ( !empty( $meta['image_meta']['aperture'] ) )
		$items['aperture'] = sprintf( __( '<span class="prep">Aperture:</span> %s', 'spine' ), '<span class="image-data">' . sprintf( __( 'f/%s', 'spine' ), $meta['image_meta']['aperture'] ) . '</span>' );

	/* If a focal length is set, add it to the $items array. */
	if ( !empty( $meta['image_meta']['focal_length'] ) )
		$items['focal_length'] = sprintf( __( '<span class="prep">Focal Length:</span> %s', 'spine' ), '<span class="image-data">' . sprintf( __( '%s mm', 'spine' ), $meta['image_meta']['focal_length'] ) . '</span>' );

	/* If an ISO is set, add it to the $items array. */
	if ( !empty( $meta['image_meta']['iso'] ) )
		$items['iso'] = sprintf( __( '<span class="prep">ISO:</span> %s', 'spine' ), '<span class="image-data">' . $meta['image_meta']['iso'] . '</span>' );

	/* If a shutter speed is given, format the float into a fraction and add it to the $items array. */
	if ( !empty( $meta['image_meta']['shutter_speed'] ) ) {

		if ( ( 1 / $meta['image_meta']['shutter_speed'] ) > 1 ) {
			$shutter_speed = '1/';

			if ( number_format( ( 1 / $meta['image_meta']['shutter_speed'] ), 1 ) ==  number_format( ( 1 / $meta['image_meta']['shutter_speed'] ), 0 ) )
				$shutter_speed .= number_format( ( 1 / $meta['image_meta']['shutter_speed'] ), 0, '.', '' );
			else
				$shutter_speed .= number_format( ( 1 / $meta['image_meta']['shutter_speed'] ), 1, '.', '' );
		} else {
			$shutter_speed = $meta['image_meta']['shutter_speed'];
		}

		$items['shutter_speed'] = sprintf( __( '<span class="prep">Shutter Speed:</span> %s', 'spine' ), '<span class="image-data">' . sprintf( __( '%s sec', 'spine' ), $shutter_speed ) . '</span>' );
	}

	/* Allow devs to overwrite the array of items. */
	$items = apply_atomic( 'image_info_items', $items );

	/* Loop through the items, wrapping each in an <li> element. */
	foreach ( $items as $item )
		$list .= "<li>{$item}</li>";

	/* Format the HTML output of the function. */
	$output = '<div class="image-info"><h3>' . __( 'Image Info', 'spine' ) . '</h3><ul>' . $list . '</ul></div>';

	/* Display the image info and allow devs to overwrite the final output. */
	echo apply_atomic( 'image_info', $output );
}


add_filter('wp_get_attachment_image_attributes','pdw_spine_attachment_attrs',10,2);
function pdw_spine_attachment_attrs($attr, $attachment ){
	$attr['data-caption'] = $attachment->post_title;
	return $attr;
}