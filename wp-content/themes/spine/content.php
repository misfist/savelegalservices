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
<article role="article" id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">
    <div class="row">
			<?php do_atomic( 'open_entry' ); // spine_open_entry ?>

			<?php if ( is_singular() && is_main_query() ) { ?>

        <header class="entry-header twelve columns">
					<?php echo apply_atomic_shortcode( 'entry_title', the_title( '<h1 class="entry-title">', '</h1>', false ) ); ?>
					<?php echo apply_atomic_shortcode( 'byline', '<div class="byline"><p>' . __( 'Published by [entry-author] on [entry-published] [entry-comments-link before=" | "] [entry-edit-link before=" | "]', 'spine' ) . '</p></div>' ); ?>
        </header><!-- .entry-header -->
        <div class="entry-content twelve columns">
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'spine' ), 'after' => '</p>' ) ); ?>
        </div><!-- .entry-content -->

        <footer class="entry-footer twelve columns">
					<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . __( '[entry-terms taxonomy="category" before="Posted in "] [entry-terms before="Tagged "]', 'spine' ) . '</div>' ); ?>
        </footer><!-- .entry-footer -->

			<?php } else { ?>

				<?php $image = get_the_image( array( 'echo' => false ) ); ?>
			<?php if ( !empty($image) ) { ?>
				<div class="twelve columns">
						<?php }else{ ?>
					<div class="twelve columns">
				<?php } ?>
			<?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'link_to_post' => false, 'meta_key' => 'Featured', 'size' => 'featured' ) ); ?>
			<?php if (  !empty($image) ) : ?></div><!-- two columns --><?php endif; ?>
			<?php if (  !empty($image) ) : ?><div class="twelve columns"><?php endif; ?>
        <header class="entry-header">
					<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title]' ); ?>
					<?php echo apply_atomic_shortcode( 'byline', '<div class="byline"><p>' . __( 'Published by [entry-author] on [entry-published] [entry-comments-link before=" | "] [entry-edit-link before=" | "]', 'spine' ) . '</p></div>' ); ?>
        </header><!-- .entry-header -->

        <div class="entry-summary">
					<?php the_excerpt(); ?>
					<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'spine' ), 'after' => '</p>' ) ); ?>
        </div><!-- .entry-summary -->

        <footer class="entry-footer">
					<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . __( '[entry-terms taxonomy="category" before="Posted in "] [entry-terms before="Tagged "]', 'spine' ) . '</div>' ); ?>
        </footer><!-- .entry-footer -->
			<?php if (  !empty($image) ) : ?></div><!-- ten columns --><?php endif; ?>
			<?php } ?>

			<?php do_atomic( 'close_entry' ); // spine_close_entry ?>
    </div>
</article><!-- .hentry -->

<?php do_atomic( 'after_entry' ); // spine_after_entry ?>

<hr />