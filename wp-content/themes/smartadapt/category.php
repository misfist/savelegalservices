<?php
/**
 * The template for displaying Category pages.
 */

get_header(); ?>

<div id="content" class="twelve columns" role="main">


    <?php if (have_posts()) : ?>
    <header class="archive-header">
        <h1 class="archive-title"><?php printf(__('Category Archives: %s', 'smartadapt'), '<span>' . single_cat_title('', false) . '</span>'); ?></h1>

        <?php if (category_description()) : // Show an optional category description ?>
        <div class="archive-meta"><?php echo category_description(); ?></div>
        <?php endif; ?>
    </header><!-- .archive-header -->

    <?php
    /* Start the Loop */
    while (have_posts()) : the_post();

        /* Include the post format-specific template for the content. If you want to
                   * this in a child theme then include a file called called content-___.php
                   * (where ___ is the post format) and that will be used instead.
                   */
        get_template_part('content', get_post_format());

    endwhile;

    smartadapt_content_nav('nav-below');
    ?>

    <?php else : ?>
    <?php get_template_part('content', 'none'); ?>
    <?php endif; ?>

</div><!-- #content -->
</div><!-- #main -->

</div><!-- #page -->

<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>