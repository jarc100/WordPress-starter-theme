

<!-- 
    
    DESIGNED AND DEVELOPED BY:
    Jens Ahrengot Boddum, http://ahrengot.com/

    Built with HTML5, CSS3, Backbone.js and other cool shit.
    
    Have fun checking out the source! :)

-->

<!doctype html>
<!--[if IE 7 ]>    <html class="no-js ie7" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml" lang="<?php bloginfo('language'); ?>"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml" lang="<?php bloginfo('language'); ?>"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml" lang="<?php bloginfo('language'); ?>"> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!-- <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" /> -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="author" content="Jens Ahrnegot Boddum – http://ahrengot.com"/>
	
    <title><?php wp_title(''); ?></title>

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php bloginfo('template_url'); ?>/library/img/icons/114x114.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php bloginfo('template_url'); ?>/library/img/icons/114x114.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php bloginfo('template_url'); ?>/library/img/icons/72x72.png">
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php bloginfo('template_url'); ?>/library/img/icons/57x57.png">
	<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/library/img/icons/favicon.ico">
    
    <!-- Open Graph tags -->
    <meta property="fb:admins" content="100000936142315">
    <meta property="og:locale" content="<?php echo str_replace('-', '_', get_bloginfo('language')); ?>">
    
    <?php
    	if (class_exists('WPSEO_Frontend')) $wp_seo = new WPSEO_Frontend();;
    	
    	$og_title = get_bloginfo('name');
    	if (class_exists('WPSEO_Frontend')) $og_title = $wp_seo->title(false);
    	
    	$og_description = get_bloginfo('description');
    	if (class_exists('WPSEO_Frontend')) $og_description = $wp_seo->metadesc(false);
    	
    	$og_type = "article";
		if (is_front_page()) $og_type = "website";
		
		$og_url = get_permalink();
		if (is_front_page()) $og_url = get_bloginfo('url');
		    	
    	echo '<meta property="og:type" content="' . $og_type . '">' . "\n";	
    	echo '<meta property="og:url" content="' . $og_url . '">' . "\n"; 
    	echo '<meta property="og:site_name" content="' . get_bloginfo("name") . '">' . "\n";
    	echo '<meta property="og:title" content="' . $og_title . '">' . "\n";
    	echo '<meta property="og:description" content="' . $og_description . '">' . "\n";
    	
    	if (is_front_page()) {
    		echo '<meta property="og:image" content="' . get_bloginfo('template_url') . '/library/img/icons/facebook-main-thumbnail.png' . '">' . "\n";
    	} else if (has_post_thumbnail()){
	    	global $post;
	    	$img_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');
	    	echo '<meta property="og:image" content="' . $img_src[0] . '">' . "\n";
	    } else {
	    	echo '<meta property="og:image" content="' . get_bloginfo('template_url') . '/library/img/icons/kato.png">' . "\n";
	    }
    ?>
	
    <?php
    	//	Enque styles. Expand with conditionals here, so we only load what necessary based on the page type.
    	wp_enqueue_style('default', get_bloginfo('template_url') . '/library/css/combined.css', array(), '1.0');
    ?>
    
    <?php wp_head(); ?>
</head>