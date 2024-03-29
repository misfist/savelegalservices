<?php get_header(); ?>
			
			<div id="content">
			
				<div id="main" class="eight columns clearfix" role="main">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
						
						<header>
							
							<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
													
						</header> <!-- end article header -->
					
						<section class="post_content clearfix">
							<div class="post-thumbnail">
							<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'wpf-featured' ); ?></a>
							</div>

							<?php the_excerpt('Read more &raquo;'); ?>
					
						</section> <!-- end article section -->
						
						<footer>
			
							<h6 class="meta"><time datetime="<?php echo the_time('Y-m-j'); ?>" pubdate><?php the_time('F jS, Y'); ?></time> <?php _e("by ", "bonestheme"); ?><?php the_author_posts_link(); ?> | <?php the_category(' | '); ?>.</h6>
							<h6 class="tags"><?php the_tags('<span class="tags-title">Tags:</span> ', ' ', ''); ?></h6>

							<div style="clear:both;">
							</div>
							
						</footer> <!-- end article footer -->
					
					</article> <!-- end article -->
					
					<?php comments_template(); ?>
					
					<?php endwhile; ?>	
					
					<?php if (function_exists('page_navi')) { // if expirimental feature is active ?>
						
						<?php page_navi(); // use the page navi function ?>
						
					<?php } else { // if it is disabled, display regular wp prev & next links ?>
						<nav class="wp-prev-next">
							<ul class="clearfix">
								<li class="prev-link"><?php next_posts_link(_e('&laquo; Older Entries', "bonestheme")) ?></li>
								<li class="next-link"><?php previous_posts_link(_e('Newer Entries &raquo;', "bonestheme")) ?></li>
							</ul>
						</nav>
					<?php } ?>		
					
					<?php else : ?>
					
					<article id="post-not-found">
					    <header>
					    	<h1>Not Found</h1>
					    </header>
					    <section class="post_content">
					    	<p>Sorry, but the requested resource was not found on this site.</p>
					    </section>
					    <footer>
					    </footer>
					</article>
					
					<?php endif; ?>
			
				</div> <!-- end #main -->
    
				<?php get_sidebar(); // sidebar 1 ?>
    
			</div> <!-- end #content -->

<?php get_footer(); ?>