<?php get_header(); ?>
			
			<div id="content" class="clearfix">
				<div id="main" role="main">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
						<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
							<header><h1><?php the_title(); ?></h1></header>
						
							<section class="post_content">
								<?php the_content(); ?>
							</section> <!-- end article section -->
							
							<footer class="clear fix">
							</footer>
						</article> <!-- end article -->
					
					<?php endwhile; endif; ?>
					
				</div> <!-- #main -->
			</div> <!-- #content -->
			
<?php get_footer(); ?>