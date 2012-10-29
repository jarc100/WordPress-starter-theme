<?php get_header(); ?>
	<div id="content">
		<div id="main" role="main">
			<article id="post-home" class="clearfix">
				<article class="post_content responsive-grid">
					<? get_template_part('loop'); ?>
				</article> <!-- end article section -->
			</article> <!-- end article -->
		</div> <!-- #main -->
	</div> <!-- #content -->
<?php get_footer(); ?>