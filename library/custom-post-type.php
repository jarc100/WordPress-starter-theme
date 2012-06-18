<?php

// To use stadnard wordpress taxonomies like 'category' and 'post_tag' we need to wait for init
add_action('init', 'add_custom_post_types');
add_action('init', 'add_custom_taxonomies');

function add_custom_post_types() {
	/*register_post_type(
		'TEST_POST_TYPE', 
		 array(	
				'label' => 'TEST_LABEL',
				'description' => 'TEST_DESCRIPTION',
				'public' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				'show_in_nav_menus' => false,
				'publicly_queryable' => true,
				'has_archive' => true,
				'menu_icon' => get_bloginfo('template_directory') . '/library/img/icons/TEST_ICON.png',
				'supports' => array('title', 'custom-fields'),
				'labels' => array('name' => 'NAME', 'singular_name' => 'SINGULAR_NAME')
		)
	);*/
}

function add_custom_taxonomies() {
	/*register_taxonomy(
		'TEST_TAXONOMY', 
		array(
			'CUSTOM_POST_TYPE_ONE', 
			'CUSTOM_POST_TYPE_TWO'
		), 
		array(
			'hierarchical' => true,
			'public' => true,
			'show_in_nav_menus' => false,
			'labels' => array (
				'name' => __('NAME'),
				'add_new_item' => __('ADD_NEW_ITEM'),
				'update_item' => __('EDIT_ITEM')
			)
		)
	);*/
}
?>
