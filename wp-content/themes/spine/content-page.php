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

do_atomic( 'before_entry' ); // spine_before_entry ?>

<article role="article" id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

	<?php do_atomic( 'open_entry' ); // spine_open_entry ?>

	<?php if ( is_singular() ) { ?>

    <header class="entry-header">
			<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title]' ); ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'spine' ), 'after' => '</p>' ) ); ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
			<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">[entry-edit-link]</div>' ); ?>
    </footer><!-- .entry-footer -->

	<?php } else { ?>

	<?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'link_to_post' => false, 'meta_key' => 'Featured', 'size' => 'featured' ) ); ?>

    <header class="entry-header">
			<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title]' ); ?>
    </header><!-- .entry-header -->

    <div class="entry-summary">
			<?php the_excerpt(); ?>
			<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'spine' ), 'after' => '</p>' ) ); ?>
    </div><!-- .entry-summary -->

	<?php } ?>

	<?php do_atomic( 'close_entry' ); // spine_close_entry ?>

</article><!-- .hentry -->

<?php do_atomic( 'after_entry' ); // spine_after_entry