<?php
/**
 * Project Name - Spine Theme
 *
 * Sidebar template
 *
 * @package    spine
 * @version    0.1
 * @author     paul <pauldewouters@gmail.com>
 * @copyright  Copyright (c) 2013, Paul de Wouters
 * @link       http://pauldewouters.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
?>
<!-- Sidebar -->
<?php if ( is_active_sidebar( 'subsidiary' ) ) : ?>

	<?php do_atomic( 'before_sidebar_subsidiary' ); // spine_before_sidebar_subsidiary ?>

	<aside class="row">

			<div class="twelve columns">
				<div class="panel twelve columns">
					<?php do_atomic( 'open_sidebar_subsidiary' ); // spine_open_sidebar_subsidiary ?>

					<?php dynamic_sidebar( 'subsidiary' ); ?>

					<?php do_atomic( 'close_sidebar_subsidiary' ); // spine_close_sidebar_subsidiary ?>
				</div>

		</div>
	</aside>
	<?php do_atomic( 'after_sidebar_subsidiary' ); // spine_after_sidebar_subsidiary ?>

<?php endif; ?>
<!-- End Sidebar -->