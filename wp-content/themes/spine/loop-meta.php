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

 if ( is_home() && !is_front_page() ) : ?>

<div class="loop-meta">

    <h1 class="loop-title"><?php echo get_post_field( 'post_title', get_queried_object_id() ); ?></h1>

    <div class="loop-description">
			<?php echo apply_filters( 'the_excerpt', get_post_field( 'post_excerpt', get_queried_object_id() ) ); ?>
    </div><!-- .loop-description -->

</div><!-- .loop-meta -->

<?php elseif ( is_category() ) : ?>

<div class="loop-meta">

    <h1 class="loop-title"><?php single_cat_title(); ?></h1>

    <div class="loop-description">
			<?php echo category_description(); ?>
    </div><!-- .loop-description -->

</div><!-- .loop-meta -->

<?php elseif ( is_tag() ) : ?>

<div class="loop-meta">

    <h1 class="loop-title"><?php single_tag_title(); ?></h1>

    <div class="loop-description">
			<?php echo tag_description(); ?>
    </div><!-- .loop-description -->

</div><!-- .loop-meta -->

<?php elseif ( is_tax() ) : ?>

<div class="loop-meta">

    <h1 class="loop-title"><?php single_term_title(); ?></h1>

    <div class="loop-description">
			<?php echo term_description( '', get_query_var( 'taxonomy' ) ); ?>
    </div><!-- .loop-description -->

</div><!-- .loop-meta -->

<?php elseif ( is_author() ) : ?>

<?php $user_id = get_query_var( 'author' ); ?>

<div id="hcard-<?php echo esc_attr( get_the_author_meta( 'user_nicename', $user_id ) ); ?>" class="loop-meta vcard">

    <h1 class="loop-title fn n"><?php the_author_meta( 'display_name', $user_id ); ?></h1>

    <div class="loop-description">
			<?php echo wpautop( get_the_author_meta( 'description', $user_id ) ); ?>
    </div><!-- .loop-description -->

</div><!-- .loop-meta -->

<?php elseif ( is_search() ) : ?>

<div class="loop-meta">

    <h1 class="loop-title"><?php echo esc_attr( get_search_query() ); ?></h1>

    <div class="loop-description">
        <p>
					<?php printf( __( 'You are browsing the search results for "%s"', 'spine' ), esc_attr( get_search_query() ) ); ?>
        </p>
    </div><!-- .loop-description -->

</div><!-- .loop-meta -->

<?php elseif ( is_date() ) : ?>

<div class="loop-meta">
    <h1 class="loop-title"><?php _e( 'Archives by date', 'spine' ); ?></h1>

    <div class="loop-description">
        <p>
					<?php _e( 'You are browsing the site archives by date.', 'spine' ); ?>
        </p>
    </div><!-- .loop-description -->

</div><!-- .loop-meta -->

<?php elseif ( is_post_type_archive() ) : ?>

<?php $post_type = get_post_type_object( get_query_var( 'post_type' ) ); ?>

<div class="loop-meta">

    <h1 class="loop-title"><?php post_type_archive_title(); ?></h1>

    <div class="loop-description">
			<?php if ( !empty( $post_type->description ) ) echo wpautop( $post_type->description ); ?>
    </div><!-- .loop-description -->

</div><!-- .loop-meta -->

<?php elseif ( is_archive() ) : ?>

<div class="loop-meta">

    <h1 class="loop-title"><?php _e( 'Archives', 'spine' ); ?></h1>

    <div class="loop-description">
        <p>
					<?php _e( 'You are browsing the site archives.', 'spine' ); ?>
        </p>
    </div><!-- .loop-description -->

</div><!-- .loop-meta -->

<?php endif;