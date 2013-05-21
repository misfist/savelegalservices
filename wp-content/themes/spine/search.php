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

			<?php get_template_part( 'loop-meta' ); // Loads the loop-meta.php template. ?>

			<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php do_atomic( 'before_entry' ); // spine_before_entry ?>

            <article role="article" id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

							<?php do_atomic( 'open_entry' ); // spine_open_entry ?>

                <header class="entry-header">
									<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title]' ); ?>
                </header><!-- .entry-header -->

                <div class="entry-summary">
									<?php the_excerpt(); ?>
                </div><!-- .entry-summary -->

                <footer class="entry-footer">
									<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . sprintf( __( '[entry-published] &mdash; <code>%s</code>', 'spine' ), get_permalink() ) . '</div>' ); ?>
                </footer><!-- .entry-footer -->

							<?php do_atomic( 'close_entry' ); // spine_close_entry ?>

            </article><!-- .hentry -->

				<?php do_atomic( 'after_entry' ); // spine_after_entry ?>

				<?php endwhile; ?>

			<?php else : ?>

			<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

			<?php endif; ?>

    </div><!-- .hfeed -->

	<?php do_atomic( 'close_content' ); // spine_close_content ?>

	<?php get_template_part( 'loop-nav' ); // Loads the loop-nav.php template. ?>

</div><!-- #content -->

<?php do_atomic( 'after_content' ); // spine_after_content ?>

<?php get_footer(); // Loads the footer.php template.