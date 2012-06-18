<?php
		// Remove irrelevant widgets
		add_action('wp_dashboard_setup', 'remove_dashboard_widgets');
		function remove_dashboard_widgets(){
		  global$wp_meta_boxes;
		  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
		  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		  // unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
		  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
		}
		
		//	Remove redundant widgets We don't have any widgetized areas anyway.
		add_action('widgets_init', 'remove_some_wp_widgets', 1);
		function remove_some_wp_widgets(){
		  unregister_widget('WP_Widget_Calendar');
		  unregister_widget('WP_Widget_Search');
		  unregister_widget('WP_Widget_Recent_Comments');
		}
		
		
		//	Remove sidebar items
		add_action('admin_menu', 'remove_menu_items');
		function remove_menu_items() {
			global $menu;
			
			$restricted = array(__('Links'), __('Comments'), __('Media'));
			end ($menu);
			while (prev($menu)){
			$value = explode(' ',$menu[key($menu)][0]);
			
			if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){
				unset($menu[key($menu)]);}
			}
		}
		
		//	Remove meta boxes from the edit page/post section
		add_action('admin_init','customize_meta_boxes');
		function customize_meta_boxes() {
		  /* Removes meta boxes from Posts */
		  // remove_meta_box('postcustom','post','normal');
		  remove_meta_box('trackbacksdiv','post','normal');
		  remove_meta_box('commentstatusdiv','post','normal');
		  remove_meta_box('commentsdiv','post','normal');
		  remove_meta_box('tagsdiv-post_tag','post','normal');
		  //remove_meta_box('postexcerpt','post','normal');
		  
		  /* Removes meta boxes from pages */
		  //remove_meta_box('postcustom','page','normal');
		  remove_meta_box('trackbacksdiv','page','normal');
		  remove_meta_box('commentstatusdiv','page','normal');
		  remove_meta_box('commentsdiv','page','normal'); 
		}
	
		//	Remove comments from posts overview page
		add_filter('manage_posts_columns', 'custom_post_columns');
		function custom_post_columns($defaults) {
		  unset($defaults['comments']);
		  return $defaults;
		}
		
		//	Remove comments from pages overview page
		add_filter('manage_pages_columns', 'custom_pages_columns');
		function custom_pages_columns($defaults) {
		  unset($defaults['comments']);
		  return $defaults;
		}
		
		/*
		 * Adding some custom author bling-bling
		 * - Woot, woot!
		 */
		 
		//	Footer message
		add_filter('admin_footer_text', 'modify_footer_admin');
		function modify_footer_admin () {
			echo 'Made with love by <a href="http://ahrengot.com" target="_blank">Jens Ahrengot Boddum</a>';
		}
		
		//	Openminded logo for the log-in screen
		add_action('login_head', 'custom_login_logo');
		function custom_login_logo() {
		  echo '<style type="text/css">
		    		h1 a { background-image:url('.get_bloginfo('template_directory').'/library/img/icons/login-logo.png) !important; }
		    	</style>';
		}
	
	
?>