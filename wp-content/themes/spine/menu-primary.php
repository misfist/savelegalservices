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

if ( has_nav_menu( 'primary' ) ) : ?>

<?php do_atomic( 'before_menu_primary' ); // spine_before_menu_primary ?>

			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container' => false,
				'menu_class' => 'nav-bar',
				'menu_id' => 'primary-nav',
				'fallback_cb' => '',
				'walker' => new NavBar_Walker('left'),
				'depth' => 2
			) );
			?>

<?php do_atomic( 'after_menu_primary' ); // spine_after_menu_primary ?>

<?php endif;