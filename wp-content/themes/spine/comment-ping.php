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

    <div class="comment-wrap">

			<?php do_atomic( 'open_comment' ); // spine_open_comment ?>

			<?php echo apply_atomic_shortcode( 'comment_meta', '<div class="comment-meta">[comment-author] [comment-published] [comment-permalink before="| "] [comment-edit-link before="| "] [comment-reply-link before="| "]</div>' ); ?>

			<?php do_atomic( 'close_comment' ); // spine_close_comment ?>

    </div><!-- .comment-wrap -->

	<?php do_atomic( 'after_comment' ); // spine_after_comment ?>

<?php /* No closing </li> is needed.  WordPress will know where to add it. */