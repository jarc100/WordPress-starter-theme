<?php get_template_part('head'); ?>
	<body onload="setTimeout(function() { if(Modernizr.touch && window.pageYOffset <= 1) window.scrollTo(0, 1) }, 100);" <?php body_class(); ?>>
		<div id="container">
			
			<header id="site-header">
				<div id="inner-header">
					
					<?php if(is_home()) : ?> 
						<a id="logo" class="" href="/" title="Tilbage til forsiden"><h1><?php bloginfo('name'); ?></h1></a>
					<?php else: ?>
						<a id="logo" class="" href="/" title="Tilbage til forsiden"><p><?php bloginfo('name'); ?></p></a>
					<?php endif; ?>
					
					<nav id="navigation" class="clearfix">
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
