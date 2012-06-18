<?php get_header(); ?>
			
			<div id="content" class="clearfix">
				<div id="main" role="main">
					<article id="post-archive">
						<header>
							<?php 
								$archive_for = '';
								$archive_name = '';
							
								if (is_category()) {
									$archive_for = single_cat_title('', false);
									$cat = get_category(get_query_var('cat'),false);
									$archive_name = $archive_for;
								} else if (is_tag()) {
									$archive_for = 	single_tag_title('', false);
									$archive_name = "Articles tagged '{$archive_for}'"; 
								} else if (is_day()) {
									$archive_for = get_the_time('l, F j, Y');
									$archive_name = "Articles from {$archive_for}";
								} else if (is_month()) {
									$archive_for = get_the_time('F Y');
									$archive_name = "Articles from {$archive_for}";
								} else if (is_year()) {
									$archive_for = get_the_time('Y');
									$archive_name = "Articles from {$archive_for}";
								}
							?>
						
							<h1><?= $archive_name; ?></h1>
						</header>
						
						<section class="post_content">
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
						</section> <!-- end .post_content -->
					</article> <!-- end #blog -->
				</div> <!-- #main -->
			</div> <!-- #content -->
			
<?php get_footer(); ?>