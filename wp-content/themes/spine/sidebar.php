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
?>
<!-- Sidebar -->
<?php if ( is_active_sidebar( 'primary' ) ) : ?>

<?php do_atomic( 'before_sidebar_primary' ); // spine_before_sidebar_primary ?>
<?php $sidebar_grid_classes = pdw_spine_fetch_sidebar_grid_classes(); ?>
<aside role="complementary" class="<?php echo $sidebar_grid_classes; ?>">

	<?php do_atomic( 'open_sidebar_primary' ); // spine_open_sidebar_primary ?>

	<?php dynamic_sidebar( 'primary' ); ?>

	<?php do_atomic( 'close_sidebar_primary' ); // spine_close_sidebar_primary ?>

</aside>
<?php do_atomic( 'after_sidebar_primary' ); // spine_after_sidebar_primary ?>

<?php endif; ?>
<!-- End Sidebar -->