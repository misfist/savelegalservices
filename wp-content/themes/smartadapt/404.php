<?php
/**
 * Template for displaying 404 pages (Not Found).
 */

get_header(); ?>

<div id="content" class="twelve columns" role="main">

    <article id="post-0" class="post error404 no-results not-found">
        <header class="entry-header">
            <h1 class="entry-title"><?php _e('This is somewhat embarrassing, isn&rsquo;t it?', 'smartadapt'); ?></h1>
        </header>

        <div class="entry-content">
            <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'smartadapt'); ?></p>
            <?php get_search_form(); ?>
        </div>
        <!-- .entry-content -->
    </article>


</div><!-- #content -->
</div><!-- #main -->

</div><!-- #page -->


<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
