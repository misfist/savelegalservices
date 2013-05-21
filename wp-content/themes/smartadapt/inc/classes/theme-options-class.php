<?php
/**
 * Smartadapt Theme Customizer Class
 *
 * Contains methods for customizing the theme customization screen.
 *
 *
 * @package    WordPress
 * @subpackage SmartAdapt
 * @since      SmartAdapt 1.0
 */


require_once ( ABSPATH . WPINC . '/class-wp-customize-control.php' );

class smartadapt_Customize {

	/**
	 * Identifier, namespace
	 */
	public static $theme_key = 'smartadapt';

	/**
	 * The option value in the database will be based on get_stylesheet()
	 * so child themes don't share the parent theme's option value.
	 */
	public static $option_key = 'smartadapt_theme_options';

	/**
	 * Array of default theme options
	 */

	public static $default_theme_options = array(
		'link_color'                  => '#6491A1',
		'breadcrumb_separator'        => ' &raquo; ',
		'sidebar_color'               => '#385A72',
		'header_color'                => '#404040',
		'smartadapt_logo'             => '',
		'smartadapt_pagination_posts' => '1',
		'custom_code_header'          => '',
		'custom_code_footer'          => '',
		'social_button_facebook'      => '0',
		'social_button_gplus'         => '0',
		'social_button_twitter'       => '0',
		'social_button_pinterest'     => '0'

	);


	/**
	 * This will output the custom WordPress settings to the live theme's WP head.
	 *
	 */
	public static function header_output() {
		?>
	<!--Customizer CSS-->
	<style type="text/css">
			<?php self::generate_css( 'a', 'color', 'link_color' );  ?>
			<?php self::generate_css( '#sidebar .widget-title', 'background-color', 'sidebar_color' );  ?>
			<?php self::generate_css( 'h1, h2 a, h2, h3, h4, h5, h6', 'color', 'header_color' ); ?>
	</style>
	<!--/Customizer CSS-->
	<?php
	}


	/**
	 * This will generate a line of CSS for use in header output. If the setting
	 * ($mod_name) has no defined value, the CSS will not be output.
	 *
	 * @uses  get_theme_mod()
	 *
	 * @param string $selector CSS selector
	 * @param string $style    The name of the CSS *property* to modify
	 * @param string $mod_name The name of the 'theme_mod' option to fetch
	 * @param string $prefix   Optional. Anything that needs to be output before the CSS property
	 * @param string $postfix  Optional. Anything that needs to be output after the CSS property
	 * @param bool   $echo     Optional. Whether to print directly to the page (default: true).
	 *
	 * @return string Returns a single line of CSS with selectors and a property.
	 * @since SmartAdapt 1.0
	 */
	public static function generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true ) {
		$return = '';
		$mod    = get_option( self::$option_key );

		if ( ! empty( $mod[$mod_name] ) ) {
			$return = sprintf( '%s { %s:%s; }',
				$selector,
				$style,
					$prefix . $mod[$mod_name] . $postfix
			);
			if ( $echo ) {
				echo $return . "\n";
			}
		}
		return $return;
	}

	/**
	 * Implement theme options into Theme Customizer on Frontend
	 *
	 * @see   examples for different input fields https://gist.github.com/2968549
	 * @since 08/09/2012
	 *
	 * @param $wp_customize Theme Customizer object
	 *
	 * @return void
	 */
	public static function  register( $wp_customize ) {

		$defaults = self::$default_theme_options;

// defaults, import for live preview with js helper
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';


		//add section: logo
		$wp_customize->add_section( 'smartadapt_logo', array(
			'title'    => __( 'Logo', 'smartadapt' ),
			'priority' => 20,
		) );
		//add section: breadcrumb
		$wp_customize->add_section( 'smartadapt_breadcrumb', array(
			'title'    => __( 'Breadcrumb', 'smartadapt' ),
			'priority' => 50,
		) );

		//add section: pagination
		$wp_customize->add_section( 'smartadapt_pagination_posts', array(
			'title'    => __( 'Pagination', 'smartadapt' ),
			'priority' => 60,
		) );
		//add section: social buttons
		$wp_customize->add_section( 'smartadapt_social_buttons', array(
			'title'    => __( 'Social buttons', 'smartadapt' ),
			'priority' => 40,
		) );

		//add section: custom code

		$wp_customize->add_section( 'smartadapt_custom_code', array(
			'title'    => __( 'Custom Code', 'smartadapt' ),
			'priority' => 70,
		) );


		//add setting pagination

		$wp_customize->add_setting( self::$option_key . '[smartadapt_pagination_posts]', array(
			'default'    => '1',
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );


		$wp_customize->add_control( self::$option_key . '_pagination_posts', array(
			'label'      => __( 'Pagination', 'smartadapt' ),
			'section'    => 'smartadapt_pagination_posts',
			'settings'   => self::$option_key . '[smartadapt_pagination_posts]',
			'type'       => 'radio',
			'choices'    => array(
				'1' => __( 'Older posts/Newer posts' , 'smartadapt'),
				'2' => __( 'Paginate links', 'smartadapt' )
			)

		) );

		//add setting breadcrumb_separator

		$wp_customize->add_setting( self::$option_key . '[breadcrumb_separator]', array(
			'default'    => $defaults['breadcrumb_separator'],
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( self::$option_key . '_breadcrumb_separator', array(
			'label'      => __( 'Separator', 'smartadapt' ),
			'section'    => 'smartadapt_breadcrumb',
			'settings'   => self::$option_key . '[breadcrumb_separator]',
			'type'       => 'text',

		) );
		//add header color

		$wp_customize->add_setting( self::$option_key . '[header_color]', array(
			'default'           => $defaults['header_color'],
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, self::$option_key . '_header_color', array(
			'label'    => __( 'Headers Text Color', 'smartadapt' ),
			'section'  => 'colors',
			'settings' => self::$option_key . '[header_color]',
		) ) );

		//sidebar color
		$wp_customize->add_setting( self::$option_key . '[sidebar_color]', array(
			'default'           => $defaults['sidebar_color'],
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, self::$option_key . '_sidebar_color', array(
			'label'    => __( 'Sidebar Color', 'smartadapt' ),
			'section'  => 'colors',
			'settings' => self::$option_key . '[sidebar_color]',
		) ) );

		// Link Color (added to Color Scheme section in Theme Customizer)
		$wp_customize->add_setting( self::$option_key . '[link_color]', array(
			'default'           => $defaults['link_color'],
			'type'              => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, self::$option_key . '_link_color', array(
			'label'    => __( 'Link Color', 'smartadapt' ),
			'section'  => 'colors',
			'settings' => self::$option_key . '[link_color]',
		) ) );


		$wp_customize->add_setting( self::$option_key . '[smartadapt_logo]', array(
			'default'    => $defaults['smartadapt_logo'],
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );


		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, self::$option_key . '_logo', array(
			'label'    => __( 'Upload', 'smartadapt' ),
			'section'  => 'smartadapt_logo',
			'settings' => self::$option_key . '[smartadapt_logo]',
		) ) );

		//add social buttons settings

		//Facebook
		$wp_customize->add_setting( 'smartadapt_theme_options[social_button_facebook]', array(
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		) );

		$wp_customize->add_control( self::$option_key . '_social_button_facebook', array(
			'settings' => self::$option_key . '[social_button_facebook]',
			'label'    => __( 'Facebook Like', 'smartadapt' ),
			'section'  => 'smartadapt_social_buttons',
			'type'     => 'checkbox',
		) );
		//Twitter
		$wp_customize->add_setting( self::$option_key . '[social_button_twitter]', array(
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		) );

		$wp_customize->add_control( self::$option_key . '_social_button_twitter', array(
			'settings' => self::$option_key . '[social_button_twitter]',
			'label'    => __( 'Twitter Button ', 'smartadapt' ),
			'section'  => 'smartadapt_social_buttons',
			'type'     => 'checkbox',
		) );

		//Google +1
		$wp_customize->add_setting( self::$option_key . '[social_button_gplus]', array(
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		) );

		$wp_customize->add_control( self::$option_key . '_social_button_gplus', array(
			'settings' => self::$option_key . '[social_button_gplus]',
			'label'    => __( 'Google +1', 'smartadapt' ),
			'section'  => 'smartadapt_social_buttons',
			'type'     => 'checkbox',
		) );

		//Pinterest
		$wp_customize->add_setting( self::$option_key . '[social_button_pinterest]', array(
			'capability' => 'edit_theme_options',
			'type'       => 'option',
		) );

		$wp_customize->add_control( self::$option_key . '_social_button_pinterest', array(
			'settings' => self::$option_key . '[social_button_pinterest]',
			'label'    => __( 'Pinterest', 'smartadapt' ),
			'section'  => 'smartadapt_social_buttons',
			'type'     => 'checkbox',
		) );

		//add costom code setting

		$wp_customize->add_setting( self::$option_key . '[custom_code_header]', array(
			'default'    => '',
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_setting( self::$option_key . '[custom_code_footer]', array(
			'default'    => '',
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new smartadapt_Customize_Textarea_Control( $wp_customize, self::$option_key . '_custom_code_header', array(
			'label'      => __( 'Custom header code, e.g. Google Analytics', 'smartadapt' ),
			'section'    => 'smartadapt_custom_code',
			'capability' => 'edit_theme_options',
			'settings'   => self::$option_key . '[custom_code_header]'

		) ) );

		$wp_customize->add_control( new smartadapt_Customize_Textarea_Control( $wp_customize, self::$option_key . '_custom_code_footer', array(
			'label'      => __( 'Custom footer code', 'smartadapt' ),
			'section'    => 'smartadapt_custom_code',
			'capability' => 'edit_theme_options',
			'settings'   => self::$option_key . '[custom_code_footer]'

		) ) );


	}

	/**
	 * Live preview javascript
	 *
	 * @since  SmartAdapt 1.0
	 * @return void
	 */
	public function customize_preview_js() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.dev' : '';

		wp_register_script(
			self::$theme_key . '-customizer',
				get_template_directory_uri() . '/js/theme-customizer' . $suffix . '.js',
			array( 'customize-preview' ),
			FALSE,
			TRUE
		);

		wp_enqueue_script( self::$theme_key . '-customizer' );
	}

}


/**
 * Customize for textarea, extend the WP customizer
 *
 * @package WordPress
 * @subpackage SmartAdapt
 * @since SmartAdapt 1.0
 */

class smartadapt_Customize_Textarea_Control extends WP_Customize_Control {
	public $type = 'textarea';

	public function render_content() {
		?>
	<label>
		<?php echo esc_html( $this->label ); ?></label>
	<textarea rows="5"
						style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>

	<?php
	}
}

//Setup the Theme Customizer settings and controls
add_action( 'customize_register', array( 'smartadapt_Customize', 'register' ) );

//Output custom CSS to live site
add_action( 'wp_head', array( 'smartadapt_Customize', 'header_output' ) );

//Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init', array( 'smartadapt_Customize', 'customize_preview_js' ) );







