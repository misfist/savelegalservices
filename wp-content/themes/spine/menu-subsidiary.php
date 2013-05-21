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
if ( has_nav_menu( 'subsidiary' ) ) : ?>

<?php do_atomic( 'before_menu_subsidiary' ); // spine_before_menu_subsidiary ?>

<nav id="menu-subsidiary" class="menu-container">

    <div class="wrap">

			<?php do_atomic( 'open_menu_subsidiary' ); // spine_open_menu_subsidiary ?>

			<?php wp_nav_menu( array( 'theme_location' => 'subsidiary', 'container_class' => 'menu', 'menu_class' => 'inline-list', 'menu_id' => 'menu-subsidiary-items', 'depth' => 1, 'fallback_cb' => '' ) ); ?>

			<?php do_atomic( 'close_menu_subsidiary' ); // spine_close_menu_subsidiary ?>

    </div>

</nav><!-- #menu-subsidiary .menu-container -->

<?php do_atomic( 'after_menu_subsidiary' ); // spine_after_menu_subsidiary ?>

<?php endif;