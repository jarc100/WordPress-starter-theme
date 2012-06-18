<?php

	function roots_add_h5bp_htaccess($rules) {
		global $wp_filesystem;
		
		if (!defined('FS_METHOD')) define('FS_METHOD', 'direct');
		if (is_null($wp_filesystem)) WP_Filesystem(array(), ABSPATH);
		
		$filename = __DIR__ . '/h5bp-htaccess';
		
		return $rules . $wp_filesystem->get_contents($filename);
	}
	
	add_filter('mod_rewrite_rules', 'roots_add_h5bp_htaccess');
  
?>