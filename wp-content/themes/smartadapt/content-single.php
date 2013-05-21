<?php
/**
 * The default template for displaying single content.
 *
 */
?>
<div class="post-box">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php if (is_sticky() && is_home() && !is_paged()) : ?>
        <div class="featured-post">
            <?php _e('Featured post', 'smartadapt'); ?>
        </div>
        <?php endif; ?>
        <header class="entry-header">

            <?php if (is_single()) : ?>
            <h2 class="entry-title"><?php the_title(); ?></h2>
            <?php else : ?>
            <h2 class="entry-title">
                <a href="<?php the_permalink(); ?>"
                   title="<?php echo esc_attr(sprintf(__('Permalink to %s', 'smartadapt'), the_title_attribute('echo=0'))); ?>"
                   rel="bookmark"><?php the_title(); ?></a>
            </h2>
            <?php endif; // is_single() ?>
            <p class="meta-line"><?php echo smartadapt_get_date() ?></p>
        </header>
        <!-- .entry-header -->
        <div class="row">
            <?php
            if (has_post_thumbnail()) {
                ?>
                <div class="columns fourteen"><?php the_post_thumbnail('single-post'); ?></div>
                <div class="columns two social-column">
                    <?php smartadapt_get_social_buttons(); ?>
                </div>
                <?php
            } else {
                ?>
                <div class="columns twelve">
                    <?php smartadapt_get_social_buttons(); ?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="top-meta">
            <?php smartadapt_category_line(); ?>
        </div>
        <div class="row">
             <?php if(has_tag()): ?>
					<div class="left columns sixteen tags-article"><i
                class="icon-tags icon-left"></i> <?php the_tags(__('Tags: ', 'smartadapt'), ', '); ?></div>
						<?php endif ?>
        </div>

        <div class="entry-content">
            <?php the_content(); ?>
            <?php smartadapt_custom_wp_link_pages(); ?>
        </div>
        <!-- .entry-content -->

        <footer class="entry-meta">
            <?php edit_post_link(__('Edit', 'smartadapt'), '<span class="edit-link">', '</span>'); ?>
            <?php if (is_singular() && get_the_author_meta('description') && is_multi_author()) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries. ?>
            <div class="author-info">
                <div class="author-avatar">
                    <?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('smartadapt_author_bio_avatar_size', 68)); ?>
                </div>
                <!-- .author-avatar -->
                <div class="author-description">
                    <h2><?php printf(__('About %s', 'smartadapt'), get_the_author()); ?></h2>

                    <p><?php the_author_meta('description'); ?></p>

                    <div class="author-link">
                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" rel="author">
                            <?php printf(__('View all posts by %s <span class="meta-nav">&rarr;</span>', 'smartadapt'), get_the_author()); ?>
                        </a>
                    </div>
                    <!-- .author-link	-->
                </div>
                <!-- .author-description -->
            </div><!-- .author-info -->
            <?php endif; ?>
        </footer>
        <!-- .entry-meta -->
    </article>
    <!-- #post -->
</div><!-- .post-box -->
