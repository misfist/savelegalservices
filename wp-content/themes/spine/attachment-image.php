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

			<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php do_atomic( 'before_entry' ); // spine_before_entry ?>

            <article  role="article" id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

							<?php do_atomic( 'open_entry' ); // spine_open_entry ?>

                <header class="entry-header">
									<?php echo apply_atomic_shortcode( 'entry_title', the_title( '<h1 class="entry-title">', '</h1>', false ) ); ?>
									<?php echo apply_atomic_shortcode( 'byline', '<div class="byline">' . sprintf( __( 'Sizes: %s', 'spine' ), spine_get_image_size_links() ) . '</div>' ); ?>
                </header><!-- .entry-header -->

                <div class="entry-content">

									<?php if ( has_excerpt() ) {
									$src = wp_get_attachment_image_src( get_the_ID(), 'full' );
									echo do_shortcode( sprintf( '[caption align="aligncenter" width="%1$s"]%3$s %2$s[/caption]', esc_attr( $src[1] ), get_the_excerpt(), wp_get_attachment_image( get_the_ID(), 'full', false ) ) );
								} else {
									echo wp_get_attachment_image( get_the_ID(), 'full', false, array( 'class' => 'aligncenter' ) );
								} ?>

									<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'spine' ) ); ?>
									<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'spine' ), 'after' => '</p>' ) ); ?>

                </div><!-- .entry-content -->

							<?php do_atomic( 'close_entry' ); // spine_close_entry ?>

            </article><!-- .hentry -->

				<?php do_atomic( 'after_entry' ); // spine_after_entry ?>

            <div class="attachment-meta">

							<?php spine_image_info(); ?>

							<?php $gallery = do_shortcode( sprintf( '[gallery id="%1$s" exclude="%2$s" columns="5" numberposts="10" orderby="rand"]', $post->post_parent, get_the_ID() ) ); ?>

							<?php if ( !empty( $gallery ) ) { ?>
                <div class="image-gallery">
                    <h3><?php _e( 'Gallery', 'spine' ); ?></h3>
									<?php echo $gallery; ?>
                </div>
							<?php } ?>

            </div><!-- .attachment-meta -->

				<?php do_atomic( 'after_singular' ); // spine_after_singular ?>

				<?php comments_template( '/comments.php', true ); // Loads the comments.php template. ?>

				<?php endwhile; ?>

			<?php endif; ?>

    </div><!-- .hfeed -->

	<?php do_atomic( 'close_content' ); // spine_close_content ?>

</div><!-- #content -->

<?php do_atomic( 'after_content' ); // spine_after_content ?>

<?php get_footer(); // Loads the footer.php template.