<?php
/**
 * Template for displaying Search Results pages.
 */

get_header(); ?>

<div id="content" class="twelve columns" role="main">

    <?php if (have_posts()) : ?>

    <header class="page-header">
        <h1 class="archive-title"><?php printf(__('Search Results for: %s', 'smartadapt'), '<span>' . get_search_query() . '</span>'); ?></h1>
    </header>



    <?php /* Start the Loop */ ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('content', get_post_format()); ?>
        <?php endwhile; ?>

    <?php smartadapt_content_nav('nav-below'); ?>

    <?php else : ?>

    <article id="post-0" class="post no-results not-found">
        <header class="entry-header">
            <h2 class="entry-title"><?php _e('Nothing Found', 'smartadapt'); ?></h2>
        </header>

        <div class="entry-content">
            <p><?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'smartadapt'); ?></p>
            <?php get_search_form(); ?>
        </div>
        <!-- .entry-content -->
    </article>

    <?php endif; ?>

</div><!-- #content -->
</div><!-- #main -->

</div><!-- #page -->


<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
