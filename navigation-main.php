<header id="site-header">
	<div id="inner-header">
		
		<?php if(is_home()) : ?> 
			<a id="logo" class="" href="/" title="Back to the home page"><h1><?php bloginfo('name'); ?></h1></a>
		<?php else: ?>
			<a id="logo" class="" href="/" title="Back to the home page"><p><?php bloginfo('name'); ?></p></a>
		<?php endif; ?>
		
		<a id="view-cart" href="JavaScript:void(0);">View Cart</a>
		
		<nav id="social-profiles">
			<ul>
				<? $twitter_link = get_field('twitter_profile_link', 'options'); if ($twitter_link): ?>
					<li><a class="twitter" title="8dio Twitter profile (Opens in a new window)" href="<?= $twitter_link; ?>" rel="me" target="_blank">Twitter</a></li>
				<? endif; ?>
				
				<? $facebook_link = get_field('facebook_profile_link', 'options'); if ($facebook_link): ?>
					<li><a class="facebook" title="8dio Facebook page (Opens in a new window)" href="<?= $facebook_link; ?>" rel="me" target="_blank">Facebook</a></li>
				<? endif; ?>
				
				<? $soundcloud_link = get_field('soundcloud_profile_link', 'options'); if ($soundcloud_link): ?>
					<li><a class="soundcloud" title="8dio SoundCloud profile (Opens in a new window)" href="<?= $soundcloud_link; ?>" rel="me" target="_blank">SoundCloud</a></li>
				<? endif; ?>
				
				<? $youtube_link = get_field('youtube_profile_link', 'options'); if ($youtube_link): ?>
					<li><a class="youtube" title="8dio YouTube channel (Opens in a new window)" href="<?= $youtube_link; ?>" rel="me" target="_blank">YouTube</a></li>
				<? endif; ?>
			</ul>
		</nav>

		<nav id="navigation">
			<?php 
				wp_nav_menu(
					array(
						'menu' => 'main_nav', 
						'container_class' => 'menu', 
						'container' => false
					)
				); 
			?>
		</nav>


	</div> <!-- end #inner-header -->
</header> <!-- end header -->