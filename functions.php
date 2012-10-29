<?php
	/*-----------------------------------------------------------------------------------*/
	/*	Include extra files
	/*-----------------------------------------------------------------------------------*/
	include_once('library/query-overwrites.php');
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
	/*	MULTIPLE OPTIONS PAGES (VIA ADVANCED CUSTOM FIELDS PLUGIN)
	/*-----------------------------------------------------------------------------------*/
	if(function_exists("register_options_page"))
	{
		register_options_page('General');
		register_options_page('Style and design');
		register_options_page('Social Media');
	}

	/*-----------------------------------------------------------------------------------*/
	/*	CUSTOM IMAGE SIZE CROPPING VIA THE BACKEND
	/*	More: http://wordpress.org/support/topic/hack-crop-custom-thumbnail-sizes?replies=17
	/*-----------------------------------------------------------------------------------*/
	$my_image_sizes = array(
		# array( 'name'=>'folio-thumb', 'width'=>167, 'height'=>223, 'crop'=>true ),
		# array( 'name'=>'folio-full', 'width'=>510, 'height'=>9999, 'crop'=>false ),
		# array( 'name'=>'team', 'width'=>192, 'height'=>158, 'crop'=>true )
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
	/*	ADD '.has-submenu' CSS CLASS TO MENU ITEMS WITH SUB-MENUES 
	/*-----------------------------------------------------------------------------------*/
	add_filter( 'nav_menu_css_class', 'check_for_submenu', 10, 2);
	function check_for_submenu($classes, $item) {
		global $wpdb;
		$has_children = $wpdb->get_var("SELECT COUNT(meta_id) FROM wp_postmeta WHERE meta_key='_menu_item_menu_item_parent' AND meta_value='".$item->ID."'");
		if ($has_children > 0) array_push($classes,'has-submenu'); // add the class dropdown to the current list
		return $classes;
	}

	/*-----------------------------------------------------------------------------------*/
	/*	MODIFY EXCERPTS
	/*-----------------------------------------------------------------------------------*/
	function custom_excerpt_length($length) {
		return 42;
	}
	add_filter( 'excerpt_length', 'custom_excerpt_length', 999);

	function new_excerpt_more( $more ) {
		return '&hellip;';
	}
	add_filter('excerpt_more', 'new_excerpt_more');

	/*-----------------------------------------------------------------------------------*/
	/*	Enqueue JavaScript
	/*-----------------------------------------------------------------------------------*/
	if(!is_admin()) add_action('template_redirect', 'enque_custom_scripts');
	else add_action('admin_enqueue_scripts', 'enque_admin_scripts');
	
	function enque_custom_scripts() {
		$cachebust = '1.8';
		
		//	Header scripts
    	wp_enqueue_script('modernizr', get_bloginfo('template_url') . '/library/js/libs/modernizr-2.6.1.min.js');
    	
    	// Deregister jQuery, load it from Google's CDN and place it in the footer
    	wp_deregister_script('jquery');
		wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js', false, '1.8.2', true);
		wp_enqueue_script('jquery');
		
    	// Footer scripts
    	wp_enqueue_script('underscore', get_bloginfo('template_url') . '/library/js/libs/underscore-min.js', array('jquery'), $cachebust, true);
    	wp_enqueue_script('backbone', get_bloginfo('template_url') . '/library/js/libs/backbone-min.js', array('underscore'), $cachebust, true);
    	wp_enqueue_script('tweenmax', get_bloginfo('template_url') . '/library/js/libs/gs/TweenMax.min.js', array(''), $cachebust, true);
		wp_enqueue_script('plugins', get_bloginfo('template_url') . '/library/js/Plugins-ck.js', array('jquery'), $cachebust, true);			
		
		if (is_home() OR is_page_template('template-products.php')) {
			
		}


		wp_enqueue_script('main', get_bloginfo('template_url') . '/library/js/Main.js', array('jquery'), $cachebust, true);
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