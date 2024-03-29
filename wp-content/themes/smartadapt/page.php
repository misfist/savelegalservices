<?php
/**
 * The template for displaying all pages.
 *
 */

get_header(); ?>

<div id="content" class="twelve columns" role="main">


    <?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('content', 'page'); ?>
    <?php comments_template('', true); ?>
    <?php endwhile; // end of the loop. ?>


</div><!-- #content -->

</div><!-- #main -->

</div><!-- #page -->

<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>