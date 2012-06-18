<?php

/*-----------------------------------------------------------------------------------*/
/*	This filter adds custom meta boxes to various post types
/*-----------------------------------------------------------------------------------*/
function add_custom_meta_boxes() {
	/*
	 * 1: $id: Will be added to the box as an id to make it easy to reference in style sheets and other functions
	 * 2: $title: Will be displayed in the handle of the box
	 * 3: $callback: The function we’ll use to define the output inside the box
	 * 4: $page: used to select which post type the box will be used on
	 * 5: $context('side'/'normal'): Determine where the box will show up on the page. (Sidebar or main column)x
	 * 6: $priority: Defines how close to the editor our field show be and factors in other boxes added by core and plugins.
	 */
	
	// add_meta_box('link', 'Produkt link', 'create_product_link_box', 'product', 'side', 'high');
	
    // check for a template type
	/*$post_id = $_GET['post'];
	$template_file = get_post_meta($post_id, '_wp_page_template', true);

	if ($template_file == 'template-contact.php')
	{
		 add_meta_box('contact-meta', 'Contact meta', 'create_contact_meta_box', 'page', 'normal', 'high');
	}*/
}
add_action('add_meta_boxes', 'add_custom_meta_boxes');

/*-----------------------------------------------------------------------------------*/
/*	Here we create the 'models' for our boxes here so they're accessible in the functions below
/*-----------------------------------------------------------------------------------*/

// product post type
/*$product_meta_prefix = 'product_meta_';
$product_meta_box = array(
	'prefix' => $product_meta_prefix,
	'fields' => array(
		array(
			'label'	=> 'Link:',
			'desc'	=> 'Link til produktet/brandet',
			'placeholder' => 'http://some-product.com/',
			'id'	=> $product_meta_prefix . 'link',
			'type'	=> 'text'
		)
	)

);*/

/*-----------------------------------------------------------------------------------*/
/*	Here we create the individual meta boxes
/*-----------------------------------------------------------------------------------*/

// Product meta
/*function create_product_link_box() {
	global $product_meta_box, $post;
	render_box($product_meta_box, $post, 'side');	
}*/

/**
 * Adds the nonce verification and passes the fields onto our custom function
 * 
 * @param  array	$box		array holding meta box fields
 * @param  object	$post		post connected to this meta data
 * @param  string	$context	'side' or 'normal'
 */
function render_box($box, $post, $context) {
	echo '<input type="hidden" name="' . $box['prefix'] . 'nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	echo get_box_html($box['fields'], $post, $context);
}

/**
 * Loops through all boxes and saves any updated data.
 * 
 * @param  integer $post_id	ID of the post we want to save this data on.
 */
function save_custom_meta_boxes($post_id) {

    // Check if this method was triggered by an autosave
	if (defined('DOING_AUTOSAVE') AND DOING_AUTOSAVE) return $post_id;
		
	// Check user permissions
	if (!current_user_can('edit_post', $post_id)) return $post_id;
    
    //global $product_meta_box; 
    
    // Finally loop through all boxes, verify nonces and store/delete updated data.
    $all_boxes = array();
    foreach ($all_boxes as $box) {
    	$nonce = $box['prefix'] . 'nonce';
    	if (isset($_POST[$nonce])) {
    		if (!wp_verify_nonce($_POST[$nonce], basename(__FILE__))) return $post_id;
    	}
    	
    	foreach ($box['fields'] as $fields) {
    		$field_id = $fields['id'];
    		
			$old = get_post_meta($post_id, $field_id, true);
			(isset($_POST[$field_id]))? $new = $_POST[$field_id] : $new = '';
			
			if ($new != $old) update_post_meta($post_id, $field_id, $new);
			else if ($new == '' && $old) delete_post_meta($post_id, $field_id, $old);
    	}
    }
}
add_action('save_post', 'save_custom_meta_boxes');

?>