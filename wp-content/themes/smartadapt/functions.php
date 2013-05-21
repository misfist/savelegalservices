<?php
/**
 *
 * SmartAdapt functions and definitions.
 *
 * The functions file is used to initialize everything in the theme.
 * It sets up the supported features, default actions  and filters.
 *
 * @package    WordPress
 * @subpackage SmartAdapt
 * @since      SmartAdapt 1.0
 */

// include customize class
require(get_template_directory() . '/inc/classes/theme-options-class.php');

/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */

if (!isset($content_width))
    $content_width = 625;

/**
 * Sets up theme defaults and registers the various WordPress features
 */

function smartadapt_setup()
{

    // Load external function - helpers

    require(get_template_directory() . '/inc/template-tags.php');

    // Load external widget classes

    require(get_template_directory() . '/inc/classes/custom-widgets.php');


    /*
             * Load textdomain.
             */
    load_theme_textdomain('smartadapt', get_template_directory() . '/languages');

    // This theme styles the visual editor with editor-style.css to match the theme style.
    add_editor_style();

    // Adds RSS feed links to <head> for posts and comments.
    add_theme_support('automatic-feed-links');

    // This theme supports a variety of post formats.
    add_theme_support('post-formats', array('aside', 'image', 'link', 'quote', 'status'));

    // add custom header suport
    $args = array(
        'width' => 964,
        'height' => 110,
        'uploads' => true,
        'header-text' => false
    );
    add_theme_support('custom-header', $args);

    // This theme two wp_nav_menu() in one location.
    register_nav_menu('top_pages', __('Top Menu', 'smartadapt'));
    register_nav_menu('footer_pages', __('Bottom Menu', 'smartadapt'));
    register_nav_menu('categories', __('Categories Menu', 'smartadapt'));
    /*
                 * This theme supports custom background color and image, and here
                 * we also set up the default background color.
                 */
    add_theme_support('custom-background', array(
                                                'default-color' => 'D8D8D8',
                                           ));

    /**
     * POSTS THUMBNAILS
     */
    // This theme uses a custom image size for featured images, displayed on "standard" posts.
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(624, 9999); // Unlimited height, soft crop
    add_image_size('small-image', 90, 90, true); //front page
    add_image_size('single-post', 500, 200, true); //front page
    add_image_size('single-post-small', 266, 200, true); //front page


}

add_action('after_setup_theme', 'smartadapt_setup');

/**
 * Enqueues scripts and styles for front-end.
 *
 */
function smartadapt_scripts_styles()
{
    global $wp_styles;

    /*
                 * Adds JavaScript to pages with the comment form to support
                 * sites with threaded comments (when in use).
                 */
    if (is_singular() && comments_open() && get_option('thread_comments'))
        wp_enqueue_script('comment-reply');

    wp_deregister_script('jquery');
    wp_register_script('jquery', get_template_directory_uri() . '/js/jquery.min.js');
    wp_enqueue_script('jquery');
    wp_enqueue_script('modernizr-foundation', get_template_directory_uri() . '/js/foundation/modernizr.foundation.js', array('jquery'), '1.0', false);
    wp_enqueue_script('smartadapt-navigation', get_template_directory_uri() . '/js/foundation/jquery.foundation.navigation.js', array('jquery'), '1.0', false);
    wp_enqueue_script('foundation-buttons', get_template_directory_uri() . '/js/foundation/jquery.foundation.buttons.js', array('jquery'), '1.0', false);
    wp_enqueue_script('foundation-topbar', get_template_directory_uri() . '/js/foundation/jquery.foundation.topbar.js', array('jquery'), '1.0', false);
    wp_enqueue_script('foundation-tooltips', get_template_directory_uri() . '/js/foundation/jquery.foundation.tooltips.js', array('jquery'), '1.0', false);
    wp_enqueue_script('smartadapt-main', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0', false);


    /*
          * Adds foundation app.js
          */
    wp_enqueue_script('app-foundation', get_template_directory_uri() . '/js/foundation/app.js', array(), '1.0', true);

    /*register pinterest script*/
    wp_register_script('pinterest', '//assets.pinterest.com/js/pinit.js');

    /*
              *  Add Google Web Fonts
              */

    wp_enqueue_style('smartadapt-font-body', 'http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700&amp;subset=latin,latin-ext');
    wp_enqueue_style('smartadapt-font-header', 'http://fonts.googleapis.com/css?family=Merriweather+Sans:400,700&amp;subset=latin,latin-ext');


    /*
          * Loads foundation stylesheet.
          */
    wp_enqueue_style('smartadapt-foundation', get_template_directory_uri() . '/css/foundation.min.css');

    /*
             * Loads font stylesheet.
             */

    wp_enqueue_style('smartadapt-font-icon', get_template_directory_uri() . '/font/css/font-awesome.min.css');


    /*
          * Loads structure stylesheet.
          */
    wp_enqueue_style('smartadapt-structure', get_template_directory_uri() . '/style.css', array('smartadapt-foundation'));

}

add_action('wp_enqueue_scripts', 'smartadapt_scripts_styles');

/**
 * Return title tag content
 *
 * @param string $title Default title text for current view.
 * @param string $sep   Optional separator.
 *
 * @return string Filtered title.
 */
function smartadapt_wp_title($title, $sep)
{
    global $paged, $page;

    if (is_feed())
        return $title;

    // Add the site name.
    $title .= get_bloginfo('name');

    // Add the site description for the home/front page.
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && (is_home() || is_front_page()))
        $title = "$title $sep $site_description";

    // Add a page number if necessary.
    if ($paged >= 2 || $page >= 2)
        $title = "$title $sep " . sprintf(__('Page %s', 'smartadapt'), max($paged, $page));

    return $title;
}

add_filter('wp_title', 'smartadapt_wp_title', 10, 2);

/**
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since SmartAdapt 1.0
 *
 */
function smartadapt_page_menu_args($args)
{
    if (!isset($args['show_home']))
        $args['show_home'] = true;
    return $args;
}

add_filter('wp_page_menu_args', 'smartadapt_page_menu_args');

/**
 * Registers widgets area
 *
 * @since SmartAdapt 1.0
 */
function smartadapt_widgets_init()
{
    register_sidebar(array(
                          'name' => __('Main Sidebar', 'smartadapt'),
                          'id' => 'sidebar-1',
                          'description' => __('Appears on posts and pages except the optional Front Page template, which has its own widgets', 'smartadapt'),
                          'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                          'after_widget' => '</aside>',
                          'before_title' => '<h3 class="widget-title">',
                          'after_title' => '</h3>',
                     ));

    register_sidebar(array(
                          'name' => __('Footer Front Page Widget Area', 'smartadapt'),
                          'id' => 'sidebar-2',
                          'description' => __('Appears on Frontpage', 'smartadapt'),
                          'before_widget' => '<li id="%1$s" class="widget %2$s">',
                          'after_widget' => '</li>',
                          'before_title' => '<h3 class="widget-title">',
                          'after_title' => '</h3>',
                     ));

    register_sidebar(array(
                          'name' => __('Footer Single Page Widget Area', 'smartadapt'),
                          'id' => 'sidebar-3',
                          'description' => __('Appears on Single page', 'smartadapt'),
                          'before_widget' => '<li id="%1$s" class="widget %2$s">',
                          'after_widget' => '</li>',
                          'before_title' => '<h3 class="widget-title">',
                          'after_title' => '</h3>',
                     ));
}

add_action('widgets_init', 'smartadapt_widgets_init');


add_action('admin_menu', 'smartadapt_add_customize_to_admin_menu');

/**
 * Add sub menu page to the Appearance menu
 *
 * @since SmartAdapt 1.0
 */


function smartadapt_add_customize_to_admin_menu()
{
    add_theme_page(__('Customize', 'smartadapt'), 'Customize', 'edit_theme_options', 'customize.php');
}

/*
 *  Add dynamic select menus  for mobile device navigation * *
 *
 * @since SmartAdapt 1.0
 * @link: http://kopepasah.com/tutorials/creating-dynamic-select-menus-in-wordpress-for-mobile-device-navigation/
 *
 * @param array $args
 *
*/

function smartadapt_wp_nav_menu_select($args = array())
{

    $menu = array();

    $defaults = array(
        'theme_location' => '',
        'menu_class' => 'mobile-menu',
    );

    $args = wp_parse_args($args, $defaults);
    $menu_locations = get_nav_menu_locations();
    if (isset($menu_locations[$args['theme_location']])) {
        $menu = wp_get_nav_menu_object($menu_locations[$args['theme_location']]);
    }

    if (count($menu) > 0 && isset($menu->term_id)) {


        $menu_items = wp_get_nav_menu_items($menu->term_id);

        $children = array();
        $parents = array();

        foreach ($menu_items as $id => $data) {
            if (empty($data->menu_item_parent)) {
                $top_level[$data->ID] = $data;
            }
            else {
                $children[$data->menu_item_parent][$data->ID] = $data;
            }
        }

        foreach ($top_level as $id => $data) {
            foreach ($children as $parent => $items) {
                if ($id == $parent) {
                    $menu_item[$id] = array(
                        'parent' => true,
                        'item' => $data,
                        'children' => $items,
                    );
                    $parents[] = $parent;
                }
            }
        }

        foreach ($top_level as $id => $data) {
            if (!in_array($id, $parents)) {
                $menu_item[$id] = array(
                    'parent' => false,
                    'item' => $data,
                );
            }
        }

        uksort($menu_item, 'smartadapt_wp_nav_menu_select_sort');

        ?>
    <select id="menu-<?php echo $args['theme_location'] ?>" class="<?php echo $args['menu_class'] ?>">
        <option value=""><?php _e('- Select -', 'smartadapt'); ?></option>
        <?php foreach ($menu_item as $id => $data) : ?>
        <?php if ($data['parent'] == true) : ?>
            <optgroup label="<?php echo $data['item']->title ?>">
                <option value="<?php echo $data['item']->url ?>"><?php echo $data['item']->title ?></option>
                <?php foreach ($data['children'] as $id => $child) : ?>
                <option value="<?php echo $child->url ?>"><?php echo $child->title ?></option>
                <?php endforeach; ?>
            </optgroup>
            <?php else : ?>
            <option value="<?php echo $data['item']->url ?>"><?php echo $data['item']->title ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
    <?php


    }
    else {
        ?>
    <select class="menu-not-found">
        <option value=""><?php _e('Menu Not Found', 'smartadapt'); ?></option>
    </select>
        <?php

    }
}

/*
 * Sort helper function
 */
function smartadapt_wp_nav_menu_select_sort($a, $b)
{
    return $a = $b;
}

/**
 * Add mobile menu script
 *
 * @since SmartAdapt 1.0
 *
 */

function smartadapt_wp_nav_menu_select_scripts()
{
    wp_enqueue_script('select-menu', get_stylesheet_directory_uri() . '/js/mobile-menu.js', array('jquery'), '', true);
}

add_action('wp_enqueue_scripts', 'smartadapt_wp_nav_menu_select_scripts');


/**
 * Custom form password
 *
 * @since SmartAdapt 1.0
 *
 * @return string
 */

function smartadapt_password_form()
{
    global $post;
    $label = 'pwbox-' . (empty($post->ID) ? rand() : $post->ID);
    $o = '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" method="post" class="password-form"><div class="row"><div class="columns sixteen"><i class="icon-lock icon-left"></i>' . __("To view this protected post, enter the password below:", 'smartadapt') . '</div><label for="' . $label . '" class="columns four mobile-four">' . __("Password:", 'smartadapt') . ' </label><div class="columns eight mobile-four"><input name="post_password" id="' . $label . '" type="password" size="20" /></div><div class="columns four mobile-four"><input type="submit" name="Submit" value="' . esc_attr__("Submit", 'smartadapt') . '" /></div>
    </div></form>
    ';
    return $o;
}

add_filter('the_password_form', 'smartadapt_password_form');


/**
 * W3C validation - fix the rel=”category tag”
 *
 * @since SmartAdapt 1.0
 */

add_filter('the_category', 'smartadapt_replace_cat_tag');

function smartadapt_replace_cat_tag($text)
{
    $text = str_replace('rel="category tag"', "", $text);
    return $text;
}

/**
 * add IE 7 & IE 8 CSS3 Box-sizing support
 *
 * @since SmartAdapt 1.0
 *
 */

function smartadapt_ie_support()
{

    ?><!--[if IE 7]>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/font/css/font-awesome-ie7.min.css">
<![endif]-->
<!--[if IE 7]>
<style>
    * {
    * behavior : url (<?php echo get_template_directory_uri(); ?>/ js / boxsize-fix . htc );
    }
</style>
<![endif]-->
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php

}

add_action('wp_head', 'smartadapt_ie_support');

/**
 * add external social & user's scripts
 *
 * @since SmartAdapt 1.0
 *
 */
function smartadapt_additional_footer_scripts()
{
    if (smartadapt_option('social_button_facebook')
    ) :
        //Load FB
        smartadapt_display_facebook_script();
    endif;

    //Load pinterest
    if (smartadapt_option('social_button_pinterest')) :
        wp_enqueue_script('pinterest');
      endif;


        //display custom footer code (Theme Customization)
        echo smartadapt_option('custom_code_footer');
}

add_action('wp_footer', 'smartadapt_additional_footer_scripts');


