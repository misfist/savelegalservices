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
<?php get_header(); ?>
<?php $content_grid_classes = pdw_spine_fetch_content_grid_classes(); ?>
<?php do_atomic( 'before_content' ); // pdw_spine_before_content ?>

<!-- Main Blog Content -->
<div class="<?php echo $content_grid_classes; ?>" role="main">

			<?php do_atomic( 'open_content' ); // pdw_spine_open_content ?>

        <div class="hfeed">

					<?php get_template_part( 'loop-meta' ); // Loads the loop-meta.php template. ?>

					<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'content', ( post_type_supports( get_post_type(), 'post-formats' ) ? get_post_format() : get_post_type() ) ); ?>

						<?php if ( is_singular() ) { ?>

							<?php do_atomic( 'after_singular' ); // pdw_spine_after_singular ?>

							<?php comments_template( '/comments.php', true ); // Loads the comments.php template. ?>

							<?php } ?>

						<?php endwhile; ?>

					<?php else : ?>

					<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

					<?php endif; ?>

        </div><!-- .hfeed -->

			<?php do_atomic( 'close_content' ); // pdw_spine_close_content ?>

			<?php get_template_part( 'loop-nav' ); // Loads the loop-nav.php template. ?>

    </div><!-- #content -->

	<?php do_atomic( 'after_content' ); // pdw_spine_after_content ?>

<?php get_footer();

