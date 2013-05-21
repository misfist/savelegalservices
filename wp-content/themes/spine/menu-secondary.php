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
require_once 'includes/topbar-walker.php';
if ( has_nav_menu( 'secondary' ) ) : ?>


<?php $title = '<ul><li class="name"><h1><a href="' . home_url('/') . '">' . get_bloginfo( 'name' ) . '</a></h1></li><li class="toggle-topbar"><a href="#"></a></li></ul>'; ?>
<?php wp_nav_menu( array(
		'container' => 'nav',
		'theme_location' => 'secondary',
		'container_class' => 'top-bar',
		'menu_class' => '',
		'menu_id' => 'menu-primary-items',
		'items_wrap' => $title . '<section><ul class="right"><li class="divider"></li>%3$s</ul></section>',
		'walker' => new Foundation_Walker(),
		'fallback_cb' => '' ) );
	?>


<?php endif;