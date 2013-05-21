<?php


/**
 * Smartadapt Widgets Classes
 *
 * Theme's widgets extends the default WordPress
 * widgets by giving users highly-customizable widget settings.
 *
 * @package    WordPress
 * @subpackage SmartAdapt
 * @since      SmartAdapt 1.0
 */


/**
 * Custom Search widget class
 *
 * @since 1.0
 */

class WP_Widget_Search_smartadapt extends WP_Widget
{

    function __construct()
    {
        $widget_ops = array('classname' => 'widget_search', 'description' => __("A search form for your site", 'smartadapt'));
        parent::__construct('search', __('Search', 'smartadapt'), $widget_ops);
    }

    function widget($args, $instance)
    {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

        echo $before_widget;
        if ($title)
            echo $before_title . $title . $after_title;

// Use current theme search form if it exists
        get_search_form();

        echo $after_widget;
    }

    function form($instance)
    {
        $instance = wp_parse_args((array)$instance, array('title' => ''));
        $title = $instance['title'];
        ?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'smartadapt'); ?> <input class="widefat"
                                                                                              id="<?php echo $this->get_field_id('title'); ?>"
                                                                                              name="<?php echo $this->get_field_name('title'); ?>"
                                                                                              type="text"
                                                                                              value="<?php echo esc_attr($title); ?>"/></label>
    </p>
    <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $new_instance = wp_parse_args((array)$new_instance, array('title' => ''));
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

}

/**
 * Recent_Posts widget class
 *
 * @since 1.0
 *
 */
class WP_Widget_Recent_Posts_smartadapt extends WP_Widget
{

    function __construct()
    {
        $widget_ops = array('classname' => 'widget_recent_entries_smartadapt', 'description' => __("The most recent posts on your site (extended contorls)", 'smartadapt'));
        parent::__construct('recent-posts-smartadapt', __('Extended Recent Posts', 'smartadapt'), $widget_ops);
        $this->alt_option_name = 'widget_recent_entries_smartadapt';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));
    }

    function widget($args, $instance)
    {

        $cache = wp_cache_get('widget_recent_posts', 'widget');

        if (!is_array($cache))
            $cache = array();

        if (!isset($args['widget_id']))
            $args['widget_id'] = $this->id;

        if (isset($cache[$args['widget_id']])) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts', 'smartadapt') : $instance['title'], $instance, $this->id_base);
        if (empty($instance['number']) || !$number = absint($instance['number']))
            $number = 10;
        $show_date = isset($instance['show_date']) ? $instance['show_date'] : false;
        $show_post_thumbnail = isset($instance['show_post_thumbnail']) ? $instance['show_post_thumbnail'] : false;
        $show_post_author = isset($instance['show_post_author']) ? $instance['show_post_author'] : false;

        $r = new WP_Query(apply_filters('widget_posts_args', array('posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true)));
        if ($r->have_posts()) :
            ?>
        <?php echo $before_widget; ?>
        <?php if ($title) echo $before_title . $title . $after_title; ?>
        <ul class="no-bullet">
            <?php while ($r->have_posts()) : $r->the_post(); ?>
            <li>
                <a href="<?php the_permalink() ?>"
                   title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>">
                    <?php
                    if (has_post_thumbnail() && $show_post_thumbnail) {
                        ?>
                        <span class="widget-image-outer">
                        <?php the_post_thumbnail('small-image'); ?>
                        </span>
                        <?php
                    }
                    ?>
                    <span class="widget-post-title"><?php if (get_the_title()) the_title(); else the_ID(); ?></span>
                    <span class="widget-post-excerpt"><?php echo smartadapt_excerpt_max_charlength(100); ?></span>
                </a>

                <div class="bottom-container">

                    <?php if ($show_date) : ?>
                    <span class="meta-date"><?php echo get_the_date(); ?></span>
                    <?php endif; ?>


                    <?php if ($show_post_author) : ?>
                    <span class="meta-publisher"><?php echo get_the_author(); ?></span>
                    <?php endif; ?>

                </div>
            </li>
            <?php endwhile; ?>
        </ul>
        <?php echo $after_widget; ?>
        <?php
            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_recent_posts', $cache, 'widget');
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int)$new_instance['number'];
        $instance['show_date'] = (bool)$new_instance['show_date'];
        $instance['show_post_thumbnail'] = (bool)$new_instance['show_post_thumbnail'];
        $instance['show_post_author'] = (bool)$new_instance['show_post_author'];

        $this->flush_widget_cache();

        $alloptions = wp_cache_get('alloptions', 'options');
        if (isset($alloptions['widget_recent_entries']))
            delete_option('widget_recent_entries');

        return $instance;
    }

    function flush_widget_cache()
    {
        wp_cache_delete('widget_recent_posts', 'widget');
    }

    function form($instance)
    {


        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $number = isset($instance['number']) ? absint($instance['number']) : 5;
        $show_date = isset($instance['show_date']) ? (bool)$instance['show_date'] : false;
        $show_post_thumbnail = isset($instance['show_post_thumbnail']) ? (bool)$instance['show_post_thumbnail'] : true;
        $show_post_author = isset($instance['show_post_author']) ? (bool)$instance['show_post_author'] : true;
        ?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'smartadapt'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
               name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/></p>

    <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:', 'smartadapt'); ?></label>
        <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>"
               type="text" value="<?php echo $number; ?>" size="3"/></p>

    <p><input class="checkbox" type="checkbox" <?php checked($show_date); ?>
              id="<?php echo $this->get_field_id('show_date'); ?>"
              name="<?php echo $this->get_field_name('show_date'); ?>"/>
        <label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e('Display post date?', 'smartadapt'); ?></label></p>

    <p><input class="checkbox" type="checkbox" <?php checked($show_post_thumbnail); ?>
              id="<?php echo $this->get_field_id('show_post_thumbnail'); ?>"
              name="<?php echo $this->get_field_name('show_post_thumbnail', 'smartadapt'); ?>"/>
        <label
            for="<?php echo $this->get_field_id('show_post_thumbnail'); ?>"><?php _e('Display post thumbnail?', 'smartadapt'); ?></label>
    </p>

    <p><input class="checkbox" type="checkbox" <?php checked($show_post_author); ?>
              id="<?php echo $this->get_field_id('show_post_author'); ?>"
              name="<?php echo $this->get_field_name('show_post_author'); ?>"/>
        <label for="<?php echo $this->get_field_id('show_post_author'); ?>"><?php _e('Display post author?', 'smartadapt'); ?></label>
    </p>
    <?php
    }
}

add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_Recent_Posts_smartadapt");'));

/**
 * One author info widget
 *
 * @since 1.0
 *
 */

class WP_Widget_One_Author_Widget_smartadapt extends WP_Widget
{

    function __construct()
    {
        $widget_ops = array('classname' => 'one_author_smartadapt', 'description' => __("Short  info & avatar", 'smartadapt'));
        parent::__construct('one-author-smartadapt', __('One Author Info', 'smartadapt'), $widget_ops);
        $this->alt_option_name = 'one-author-smartadapt';

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));
    }

    function widget($args, $instance)
    {


        $title = apply_filters('widget_title', $instance['title']);

        extract($args);

        $author = get_userdata($instance['user_id']);


        $name = $author->user_nicename;

        $avatar = get_avatar($instance['user_id'], $instance['size']);
        $description = get_the_author_meta('description', $instance['user_id']);
        $author_link = get_author_posts_url($instance['user_id']);


        ?>

    <?php echo $before_widget; ?>
    <?php if ($title) echo $before_title . $title . $after_title; ?>
    <span class="widget-image-outer"><?php echo $avatar ?></span>
    <h4><a href="<?php echo $author_link ?>"><?php echo $name ?></a></h4>
    <p class="description-widget"><?php echo $description ?></p>
    <?php echo $after_widget; ?>
    <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['size'] = strip_tags($new_instance['size']);
        $instance['user_id'] = strip_tags($new_instance['user_id']);

        return $instance;
    }

    function form($instance)
    {
        if (array_key_exists('title', $instance)) {
            $title = esc_attr($instance['title']);
        } else {
            $title = '';
        }

        if (array_key_exists('user_id', $instance)) {
            $user_id = esc_attr($instance['user_id']);
        } else {
            $user_id = 1;
        }

        if (array_key_exists('size', $instance)) {
            $size = esc_attr($instance['size']);
        } else {
            $size = 64;
        }

        ?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'smartadapt'); ?> <input class="widefat"
                                                                                              id="<?php echo $this->get_field_id('title'); ?>"
                                                                                              name="<?php echo $this->get_field_name('title'); ?>"
                                                                                              type="text"
                                                                                              value="<?php echo $title; ?>"/></label>
    </p>
    <p><label for="<?php echo $this->get_field_id('user_id'); ?>"><?php _e('Authot Name:', 'smartadapt'); ?>
        <select id="<?php echo $this->get_field_id('user_id'); ?>"
                name="<?php echo $this->get_field_name('user_id'); ?>" value="<?php echo $user_id; ?>">
            <?php

            $args = array(
                'order' => 'ASC'
            );

            $users = get_users($args);;

            foreach ($users as $row)
                echo "<option value='$row->ID' " . ($row->ID == $user_id ? "selected='selected'" : '') . ">$row->user_nicename</option>";
            ?>
        </select></label></p>
    <p><label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Avatar Size:', 'smartadapt'); ?>
        <select id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>"
                value="<?php echo $size; ?>">
            <?php
            for ($i = 16; $i <= 256; $i += 16)
                echo "<option value='$i' " . ($size == $i ? "selected='selected'" : '') . ">$i</option>";
            ?>
        </select></label></p>
    <?php
    }

    function flush_widget_cache()
    {
        wp_cache_delete('one_author_smartadapt', 'widget');
    }
}

add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_One_Author_Widget_smartadapt");'));

