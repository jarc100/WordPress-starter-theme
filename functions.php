<?php
	/*-----------------------------------------------------------------------------------*/
	/*	Include extra files
	/*-----------------------------------------------------------------------------------*/
	include_once('library/custom-functions.php');
	include_once('library/custom-post-type.php');
	include_once('library/custom-meta-boxes.php');
	include_once('library/shortcodes.php');
	include_once('library/backend.php');
	include_once('library/htaccess.php');
	
	/*-----------------------------------------------------------------------------------*/
	/*	Add RSS links to <head> section
	/*-----------------------------------------------------------------------------------*/
	add_theme_support('automatic-feed-links');
		
	/*-----------------------------------------------------------------------------------*/
	/*	Add WP 3.0 Functions
	/*-----------------------------------------------------------------------------------*/
	add_theme_support('menus');
	add_theme_support('post-thumbnails');
	add_theme_support( 'post-formats', array( 'video', 'image', 'gallery' ) ); /* http://wp.tutsplus.com/tutorials/proof-using-post-formats/ */ 
	
	/*-----------------------------------------------------------------------------------*/
	/*	CUSTOM IMAGE SIZE CROPPING VIA THE BACKEND
	/*	More: http://wordpress.org/support/topic/hack-crop-custom-thumbnail-sizes?replies=17
	/*-----------------------------------------------------------------------------------*/
	$my_image_sizes = array(
		array( 'name'=>'folio-thumb', 'width'=>167, 'height'=>223, 'crop'=>true ),
		array( 'name'=>'folio-full', 'width'=>510, 'height'=>9999, 'crop'=>false ),
		array( 'name'=>'team', 'width'=>192, 'height'=>158, 'crop'=>true ),
	);
	
	// For each new image size, run add_image_size() and update_option() to add the necessary info. 
	// update_option() is good because it only updates the database if the value has changed. It also adds the option if it doesn't exist
	foreach ( $my_image_sizes as $my_image_size ){
		add_image_size( $my_image_size['name'], $my_image_size['width'], $my_image_size['height'], $my_image_size['crop'] ); 
		update_option( $my_image_size['name']."_size_w", $my_image_size['width'] );
		update_option( $my_image_size['name']."_size_h", $my_image_size['height'] );
		update_option( $my_image_size['name']."_crop", $my_image_size['crop'] );
	}
	
	// Hook into the 'intermediate_image_sizes' filter used by image-edit.php. 
	// This adds the custom sizes into the array of sizes it uses when editing/saving images. 
	add_filter( 'intermediate_image_sizes', 'my_add_image_sizes' );
	function my_add_image_sizes( $sizes ){
		global $my_image_sizes;
		foreach ( $my_image_sizes as $my_image_size ){
			$sizes[] = $my_image_size['name'];
		}
		return $sizes;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/*	Creating the Nav Menus
	/*-----------------------------------------------------------------------------------*/
	add_action( 'init', 'custom_menus' );
	function custom_menus() { 
		if (function_exists( 'register_nav_menu' )) register_nav_menu('main_nav', 'Top Menu');	
	}

	/*-----------------------------------------------------------------------------------*/
	/*	CHANGE NUMBER OF POSTS ON ARCHIVE PAGES
	/*-----------------------------------------------------------------------------------*/
	function limit_posts_per_archive_page() {
	if ( is_post_type_archive() )
		set_query_var('posts_per_archive_page', 999);
	}
	add_filter('pre_get_posts', 'limit_posts_per_archive_page');

	/*-----------------------------------------------------------------------------------*/
	/*	Enqueue JavaScript
	/*-----------------------------------------------------------------------------------*/
	if(!is_admin()) add_action('template_redirect', 'enque_custom_scripts');
	else add_action('admin_enqueue_scripts', 'enque_admin_scripts');
	
	function enque_custom_scripts() {
		//	Header scripts
    	wp_enqueue_script('modernizr', get_bloginfo('template_url') . '/library/js/modernizr-2.5.3.custom-min.js');
    	
    	// Deregister jQuery, load it from Google's CDN and place it in the footer
    	wp_deregister_script('jquery');
		wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js', false, '1.7.2', true);
		wp_enqueue_script('jquery');
		
    	// Footer scripts
    	wp_enqueue_script('underscore', get_bloginfo('template_url') . '/library/js/libs/underscore-min.js', array('jquery'), '1.0', true);
    	wp_enqueue_script('backbone', get_bloginfo('template_url') . '/library/js/libs/backbone-min.js', array('underscore'), '1.0', true);
    	wp_enqueue_script('tweenmax', get_bloginfo('template_url') . '/library/js/libs/gs/TweenMax.min.js', array(''), '1.0', true);
    	wp_enqueue_script('scroll-to', get_bloginfo('template_url') . '/library/js/libs/jquery.scrollTo-1.4.2-min.js', array('jquery'), '1.0', true);
    	wp_enqueue_script('validate', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.8.1/jquery.validate.min.js', array('jquery'), '1.0', true);
		wp_enqueue_script('placeholder', get_bloginfo('template_url') . '/library/js/libs/jquery.placeholder.js', array('jquery'), '1.0', true);
		wp_enqueue_script('logfix', get_bloginfo('template_url') . '/library/js/logfx.js', array('jquery'), '1.0', true);			
		wp_enqueue_script('ahrengot', get_bloginfo('template_url') . '/library/js/script.js', array('jquery'), '1.0', true);
	}

	function enque_admin_scripts() {
		
	}

	/*-----------------------------------------------------------------------------------*/
	/*	OUTPUT BROWSER ON <BODY> CLASS
	/*-----------------------------------------------------------------------------------*/
	// Display the Browser People Are Using
	function ahrengot_browser_class($classes) {
		global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
			if($is_lynx) $classes[] = 'browser-lynx';
			elseif($is_gecko) $classes[] = 'browser-gecko';
			elseif($is_opera) $classes[] = 'browser-opera';
			elseif($is_NS4) $classes[] = 'browser-ns4';
			elseif($is_safari) $classes[] = 'browser-safari';
			elseif($is_chrome) $classes[] = 'browser-chrome';
			elseif($is_IE) $classes[] = 'browser-ie';
			else $classes[] = '';
			if($is_iphone) $classes[] = 'browser-iphone';
		return $classes;
	}
	// Add the Browser Class to the Body Class
	add_filter('body_class','ahrengot_browser_class');
?>