<?php
/**
 * Project Name - Short Description
 *
 * Long Description
 * Can span several lines
 *
 * @package    demos.dev
 * @subpackage subfolder
 * @version    0.1
 * @author     paul <pauldewouters@gmail.com>
 * @copyright  Copyright (c) 2012, Paul de Wouters
 * @link       http://pauldewouters.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

require_once PDW_SPINE_DIR . '/library/classes/widget-nav-menu.php';
require_once 'navbar-walker.php';

class Spine_Widget_Nav_Menu extends Hybrid_Widget_Nav_Menu {


	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since 1.2.0
	 */
	function __construct() {

		/* Set up the widget options. */
		$widget_options = array(
			'classname'   => 'nav-menu',
			'description' => esc_html__( 'Foundation Flyout menus.', 'spine' )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width'  => 525,
			'height' => 350
		);

		/* Create the widget. */
		$this->WP_Widget(
			'spine-nav-menu',                      // $this->id_base
			__( 'Vertical Flyout Menu', 'spine' ), // $this->name
			$widget_options,                        // $this->widget_options
			$control_options                        // $this->control_options
		);
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since 0.8.0
	 */
	function widget( $sidebar, $instance ) {
		extract( $sidebar );

		/* Set the $args for wp_nav_menu() to the $instance array. */
		$args = $instance;

		/* Overwrite the $echo argument and set it to false. */
		$args['echo'] = false;

		/* Output the theme's widget wrapper. */
		echo $before_widget;

		/* If a title was input by the user, display it. */
		if ( !empty( $instance['title'] ) )
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

		/* Output the nav menu. */
		echo str_replace( array( "\r", "\n", "\t" ), '', wp_nav_menu( $args ) );

		/* Close the theme's widget wrapper. */
		echo $after_widget;
	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @since 0.8.0
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance = $new_instance;

		$instance['title']           = strip_tags( $new_instance['title'] );
		$instance['depth']           = strip_tags( $new_instance['depth'] );
		$instance['container_id']    = strip_tags( $new_instance['container_id'] );
		$instance['container_class'] = strip_tags( $new_instance['container_class'] );
		$instance['menu_id']         = strip_tags( $new_instance['menu_id'] );
		$instance['menu_class']      = 'nav-bar vertical';
		$instance['fallback_cb']     = strip_tags( $new_instance['fallback_cb'] );
		$instance['walker'] = new NavBar_Walker($new_instance['flyout_dir']);
		return $instance;
	}

	/**
	 * Displays the widget control options in the Widgets admin screen.
	 *
	 * @since 0.8.0
	 */
	function form( $instance ) {

		/* Set up the default form values. */
		$defaults = array(
			'title'           => esc_attr__( 'Navigation', 'spine' ),
			'menu'            => '',
			'container'       => 'div',
			'container_id'    => '',
			'container_class' => '',
			'menu_id'         => '',
			'menu_class'      => 'nav-bar vertical',
			'depth'           => 2,
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'fallback_cb'     => 'wp_page_menu',
			'flyout_dir'      => '',
			'walker' => new NavBar_Walker('right')
		);

		/* Merge the user-selected arguments with the defaults. */
		$instance = wp_parse_args( (array) $instance, $defaults );

		$container = apply_filters( 'wp_nav_menu_container_allowedtags', array( 'div', 'nav' ) );
		?>

	<div class="hybrid-widget-controls columns-2">
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'spine' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'menu' ); ?>"><code>menu</code></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'menu' ); ?>" name="<?php echo $this->get_field_name( 'menu' ); ?>">
				<?php foreach ( wp_get_nav_menus() as $menu ) { ?>
				<option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $instance['menu'], $menu->term_id ); ?>><?php echo esc_html( $menu->name ); ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'container' ); ?>"><code>container</code></label>
			<select class="smallfat" id="<?php echo $this->get_field_id( 'container' ); ?>" name="<?php echo $this->get_field_name( 'container' ); ?>">
				<?php foreach ( $container as $option ) { ?>
				<option value="<?php echo esc_attr( $option ); ?>" <?php selected( $instance['container'], $option ); ?>><?php echo esc_html( $option ); ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'container_id' ); ?>"><code>container_id</code></label>
			<input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'container_id' ); ?>" name="<?php echo $this->get_field_name( 'container_id' ); ?>" value="<?php echo esc_attr( $instance['container_id'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'container_class' ); ?>"><code>container_class</code></label>
			<input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'container_class' ); ?>" name="<?php echo $this->get_field_name( 'container_class' ); ?>" value="<?php echo esc_attr( $instance['container_class'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'menu_id' ); ?>"><code>menu_id</code></label>
			<input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'menu_id' ); ?>" name="<?php echo $this->get_field_name( 'menu_id' ); ?>" value="<?php echo esc_attr( $instance['menu_id'] ); ?>" />
		</p>
	</div>

	<div class="hybrid-widget-controls columns-2 column-last">
		<p>
			<label for="<?php echo $this->get_field_id( 'menu_class' ); ?>"><code>menu_class</code></label>
			<input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'menu_class' ); ?>" name="<?php echo $this->get_field_name( 'menu_class' ); ?>" value="<?php echo esc_attr( $instance['menu_class'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'depth' ); ?>"><code>depth</code></label>
			<input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'depth' ); ?>" name="<?php echo $this->get_field_name( 'depth' ); ?>" value="<?php echo esc_attr( $instance['depth'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'before' ); ?>"><code>before</code></label>
			<input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'before' ); ?>" name="<?php echo $this->get_field_name( 'before' ); ?>" value="<?php echo esc_attr( $instance['before'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'after' ); ?>"><code>after</code></label>
			<input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'after' ); ?>" name="<?php echo $this->get_field_name( 'after' ); ?>" value="<?php echo esc_attr( $instance['after'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_before' ); ?>"><code>link_before</code></label>
			<input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'link_before' ); ?>" name="<?php echo $this->get_field_name( 'link_before' ); ?>" value="<?php echo esc_attr( $instance['link_before'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_after' ); ?>"><code>link_after</code></label>
			<input type="text" class="smallfat code" id="<?php echo $this->get_field_id( 'link_after' ); ?>" name="<?php echo $this->get_field_name( 'link_after' ); ?>" value="<?php echo esc_attr( $instance['link_after'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'fallback_cb' ); ?>"><code>fallback_cb</code></label>
			<input type="text" class="widefat code" id="<?php echo $this->get_field_id( 'fallback_cb' ); ?>" name="<?php echo $this->get_field_name( 'fallback_cb' ); ?>" value="<?php echo esc_attr( $instance['fallback_cb'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'flyout_dir' ); ?>"><code>flyout direction</code></label>
			<select class="smallfat" id="<?php echo $this->get_field_id( 'flyout_dir' ); ?>" name="<?php echo $this->get_field_name( 'flyout_dir' ); ?>">

				<option value="left" <?php selected( $instance['flyout_dir'], 'left' ); ?>>left</option>
				<option value="right" <?php selected( $instance['flyout_dir'], 'right' ); ?>>right</option>

			</select>
		</p>
	</div>
	<div style="clear:both;">&nbsp;</div>
	<?php
	}
}

