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

get_header(); // Loads the header.php template. ?>
<?php $content_grid_classes = pdw_spine_fetch_content_grid_classes(); ?>
<?php do_atomic( 'before_content' ); // spine_before_content ?>

<div class="<?php echo $content_grid_classes; ?>" role="main">

	<?php do_atomic( 'open_content' ); // spine_open_content ?>

    <div class="hfeed">

        <article id="post-0" class="<?php hybrid_entry_class(); ?>" role="article">

            <header class="entry-header">
                <h1 class="error-404-title entry-title"><?php _e( 'Whoah! You broke something!', 'spine' ); ?></h1>
            </header><!-- .entry-header -->

            <div class="entry-content">

                <p>
									<?php printf( __( "Just kidding! You tried going to %s, which doesn't exist, so that means I probably broke something.", 'spine' ), '<code>' . home_url( esc_url( $_SERVER['REQUEST_URI'] ) ) . '</code>' ); ?>
                </p>
                <p>
									<?php _e( "The following is a list of the latest posts from the blog. Maybe it will help you find what you're looking for.", 'spine' ); ?>
                </p>

                <ul>
									<?php wp_get_archives( array( 'limit' => 20, 'type' => 'postbypost' ) ); ?>
                </ul>

            </div><!-- .entry-content -->

        </article><!-- .hentry -->

    </div><!-- .hfeed -->

	<?php do_atomic( 'close_content' ); // spine_close_content ?>

</div><!-- #content -->

<?php do_atomic( 'after_content' ); // spine_after_content ?>

<?php get_footer(); // Loads the footer.php template. ?>