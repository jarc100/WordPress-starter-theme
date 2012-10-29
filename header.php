<?php get_template_part('head'); ?>
	<body onload="setTimeout(function() { if(Modernizr.touch && window.pageYOffset <= 1) window.scrollTo(0, 1) }, 100);" <?php body_class(); ?>>
		<div id="container">
			<?php get_template_part('navigation', 'main'); ?>
