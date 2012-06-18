<?php

	/*-----------------------------------------------------------------------------------*/
	/*	SHORTEN LONG TEXTS
	/*-----------------------------------------------------------------------------------*/
	function clamp_txt($txt, $limit, $tail) {
		if (mb_strlen($txt) > $limit) {
			$txt = mb_substr($txt, 0, $limit) . $tail;
		} else {
			$txt = $txt;
		}
		
		return $txt;
	}

	/**
	 * Returns all posts matching post type
	 * 
	 * @param  string $post_type 	post type to look for
	 * @param  array $post_array	posts to filter
	 * 
	 * @return array             	matches
	 */
	function filter_posts_by_type($post_type, $post_array) {
		$result = array();
		foreach ($post_array as $post) {
			if ($post->post_type === $post_type) {
				array_push($result, $post);
			}
		}
		return $result;
	}

	/*-----------------------------------------------------------------------------------*/
	/*	HUMAN READABLE TIME. I.E. '7 hours ago', '2 days ago', etc.
	/*-----------------------------------------------------------------------------------*/
	function time_ago($timestamp) {
		try {
			$t1 = new DateTime('now');
			$t2 = new DateTime('@'.$timestamp);
			
			foreach ($t2->diff($t1) as $period => $value)
			{
				if ($value > 0 && strlen($period) == 1)
				{
					switch ($period)
					{
						case 'y': $name = 'year'; break;
						case 'm': $name = 'month'; break;
						case 'd': $name = 'day'; break;
						case 'h': $name = 'hour'; break;
						case 'i': $name = 'minute'; break;
						case 's': $name = 'second'; break;
					}
					return $value.' '.$name.($value>1?'s':'').' ago';
				}
			}
			return '0 seconds ago';
		}
		catch (Exception $e) { die ($e->getMessage()); }
	}

	/*-----------------------------------------------------------------------------------*/
	/*	DETECT VARIOUS USER AGENTS
	/*-----------------------------------------------------------------------------------*/
	function is_iphone() {
		$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
		return (strpos($user_agent, 'iPhone') !== FALSE);
	}

	function is_android() {
		$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
		return (strpos($user_agent, 'Android') !== FALSE);
	}

	function is_mobile() {
		return is_iphone() || is_android();
	}

	/*-----------------------------------------------------------------------------------*/
	/*	RENDER CUSTOM META BOXES
	/*-----------------------------------------------------------------------------------*/
	
	/**
	 * Renders the html markup for a custom meta box based on $fields array
	 * 
	 * @param  array  $fields  array of field values
	 * @param  object $post    post connected to this meta data
	 * @param  string $context 'side' or 'normal'.
	 * 
	 * @return string
	 */
	function get_box_html(array $fields, $post, $context) {
		$html = '';
		
		$html .= '<table class="form-table">';
		foreach ($fields as $field) {
			// get value of this field if it exists for this post
			$meta = get_post_meta($post->ID, $field['id'], true);
			if ($context == 'side') $html .= '<tr><th style="width: 30%;"><label for="'.$field['id'].'">'.$field['label'].'</label></th><td>';
			else $html .= '<tr><th><label for="'.$field['id'].'">'.$field['label'].'</label></th><td>';
				switch($field['type']) {
						case 'text':
							$html .= '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'"';
							if ($context == 'normal') $html .= ' size=30 ';
							if (isset($field["placeholder"])) $html .= " placeholder='".$field['placeholder']."' ";
							$html .= '/>';
							$html .= '<br /><span class="description">'.$field['desc'].'</span>';
						break;
						case 'number':
							$html .= '<input type="number" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'"';
							if ($context == 'normal') $html .= ' size=30 ';
							if (isset($fields["placeholder"])) $html .= " placeholder='".$fields['placeholder']."' ";
							$html .= '/>';
							$html .= '<br /><span class="description">'.$field['desc'].'</span>';
						break;
						case 'textarea':
							$html .= '<textarea name="'.$field['id'].'" id="'.$field['id'].'" rows="4"';
							if ($context == 'normal') $html .= ' cols="60" ';
							if (isset($field["placeholder"])) $html .= " placeholder='".$field['placeholder']."' ";
							$html .= '>'.$meta.'</textarea>';
							$html .= '<br /><span class="description">'.$field['desc'].'</span>';
						break;
						case 'checkbox':
							$html .= '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ';
							if($meta) $html .= ' checked="checked"';
							$html .= '/>';
							$html .= '<label for="'.$field['id'].'">'.$field['desc'].'</label>';
						break;
						case 'select':
							$html .= '<select name="'.$field['id'].'" id="'.$field['id'].'">';
							foreach ($field['options'] as $option) {
								$html .= '<option';
								if ($meta == $option['value']) $html .= ' selected="selected"';
								$html .= ' value="'.$option['value'].'">'.$option['label'].'</option>';
							}
							$html .= '</select><br /><span class="description">'.$field['desc'].'</span>';
						break;
						case 'radio':
							foreach ( $field['options'] as $option ) {
								$html .= '<input type="radio" name="'.$field['id'].'" id="'.$option['value'].'"';
								$html .= ' value="'.$option['value'].'" ';
								if ($meta == $option['value']) $html .= ' checked="checked"';
								$html .= ' />';
								$html .= '<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
							}
							$html .= '<span class="description">'.$field['desc'].'</span>';
						break;
						case 'image':
							$image = get_template_directory_uri().'/library/img/admin/image-placeholder.png';
							echo '<span class="custom_default_image" style="display:none">' . $image . '</span>';
							if ($meta) { $image = wp_get_attachment_image_src($meta, 'full');	$image = $image[0]; }
							echo	'<input name="' . $field['id'] . '" type="hidden" class="custom_upload_image" value="' . $meta . '" />
										<img src="' . $image . '" class="custom_preview_image" width="100%" /><br />
										<input class="custom_upload_image_button button" type="button" value="Vælg billede" />
										<small> <a href="#" class="custom_clear_image_button">Fjern billede</a></small>
										<br clear="all" /><span class="description">' . $field['desc'] . '';
						break;
					}
			$html .= '</td></tr>';
		}
		$html .= '</table>';
		
		return $html;
	}
?>