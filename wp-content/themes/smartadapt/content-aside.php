<?php
/**
 * The template for displaying posts in the Aside post format
 */
?>
<div class="post-box">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="aside">
            <h2 class="entry-title"><a href="<?php the_permalink(); ?>"
                                       title="<?php echo esc_attr(sprintf(__('Permalink to %s', 'smartadapt'), the_title_attribute('echo=0'))); ?>"
                                       rel="bookmark"><?php the_title(); ?></a></h2>

            <div class="entry-content">
                <?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'smartadapt')); ?>
            </div>
            <!-- .entry-content -->
        </div>
        <!-- .aside -->

        <footer class="entry-meta">
            <p class="meta-line"><?php echo smartadapt_get_date() ?></p>
            <?php if (comments_open()) : ?>
            <div class="comments-link">
                <?php comments_popup_link('<span class="leave-reply"><i class="icon-comment"></i>' . __('Leave a reply', 'smartadapt') . '</span>', __('1 Reply', 'smartadapt'), __('% Replies', 'smartadapt')); ?>
            </div><!-- .comments-link -->
            <?php endif; // comments_open() ?>
            <?php edit_post_link(__('Edit', 'smartadapt'), '<span class="edit-link">', '</span>'); ?>
        </footer>
        <!-- .entry-meta -->
    </article>
    <!-- #post -->
</div><!-- .post-box -->