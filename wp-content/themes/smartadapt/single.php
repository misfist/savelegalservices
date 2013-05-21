<?php
/**
 * The Template for displaying all single posts.
 */

get_header(); ?>

<div id="content" class="twelve columns" role="main">

    <?php while (have_posts()) : the_post(); ?>

    <?php
    if (get_post_format()) {
        get_template_part('content', get_post_format());
    } else {
        get_template_part('content', 'single');
    }
    ?>

    <?php smartadapt_single_nav(); ?>

    <?php comments_template('', true); ?>

    <?php endwhile; // end of the loop. ?>

</div><!-- #content -->
</div><!-- #main -->

</div><!-- #page -->

<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>