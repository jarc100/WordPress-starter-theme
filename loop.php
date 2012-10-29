<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<article id="post-<? the_ID(); ?>" <? post_class(); ?>>
		<header>
			<h1><? the_edit_title(); ?></h1>
		</header>
		<section class="post_content">
			<? the_content(); ?>
		</section>
	</article>
<?php endwhile; endif; ?>
