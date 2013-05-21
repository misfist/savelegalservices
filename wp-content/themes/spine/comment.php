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
global $post, $comment;
?>

<li id="comment-<?php comment_ID(); ?>" class="<?php hybrid_comment_class(); ?>">

	<?php do_atomic( 'before_comment' ); // spine_before_comment ?>

    <div class="comment-wrap row">

			<?php do_atomic( 'open_comment' ); // spine_open_comment ?>

        <div class="two columns mobile-one"><?php echo hybrid_avatar(); ?></div>

        <div class="ten columns">
					<?php echo apply_atomic_shortcode( 'comment_meta', '<div class="comment-meta"><p>[comment-author] [comment-published] [comment-permalink before="| "] [comment-edit-link before="| "] [comment-reply-link before="| "]</p></div>' ); ?>

            <div class="comment-content comment-text">
							<?php if ( '0' == $comment->comment_approved ) : ?>
							<?php echo apply_atomic_shortcode( 'comment_moderation', '<p class="alert moderation">' . __( 'Your comment is awaiting moderation.', 'spine' ) . '</p>' ); ?>
							<?php endif; ?>

							<?php comment_text( $comment->comment_ID ); ?>
            </div>
            <!-- .comment-content .comment-text -->

					<?php //echo do_shortcode( '[comment-reply-link]' ); ?>

					<?php do_atomic( 'close_comment' ); // spine_close_comment ?>
        </div>
        <!-- .ten columns -->
    </div>
    <!-- .comment-wrap -->
    <hr>
	<?php do_atomic( 'after_comment' ); // spine_after_comment ?>

<?php /* No closing </li> is needed.  WordPress will know where to add it. */