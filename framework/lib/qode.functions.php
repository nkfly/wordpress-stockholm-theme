<?php

function qodef_option_has_value($name) {
	global $qode_options;
	global $qodeFramework;
	if (array_key_exists($name, $qodeFramework->qodeOptions->options)) {
		if(isset($qode_options[$name])){
			return true;
		} else {
			return false;
		}
	} else {
		global $post;
		$value = get_post_meta( $post->ID, $name, true );
		if (isset($value) && $value !== "")
			return true;
		else
			return false;
	}
}

function qodef_option_get_value($name) {
	global $qode_options;
	global $qodeFramework;
	if (array_key_exists($name, $qodeFramework->qodeOptions->options)) {
		if(isset($qode_options[$name])){
			return $qode_options[$name];
		} else {
			return $qodeFramework->qodeOptions->getOption($name);
		}
	} else {
		global $post;
		$value = get_post_meta( $post->ID, $name, true );
		if (isset($value) && $value !== "")
			return $value;
		else
			return $qodeFramework->qodeMetaBoxes->getOption($name);
	}
}

function qodef_generate_filename( $file, $w, $h ){
	$info         = pathinfo( $file );
	$dir = "";
	if(!empty($info['dirname'])){
		$dir          = $info['dirname'];	
	}
	$ext = "";
	$name = "";
	if(!empty($info['extension'])){
		$ext          = $info['extension'];
		$name         = wp_basename( $file, ".$ext" );
	}
	
	$suffix       = "{$w}x{$h}";

	if (qodef_url_exists("{$dir}/{$name}-{$suffix}.{$ext}"))
		return "{$dir}/{$name}-{$suffix}.{$ext}";
	else
		return $file;
}

function qodef_url_exists($url){
    $url = str_replace("http://", "", $url);
    if (strstr($url, "/")) {
        $url = explode("/", $url, 2);
        $url[1] = "/".$url[1];
    } else {
        $url = array($url, "/");
    }

    $fh = fsockopen($url[0], 80);
    if ($fh) {
        fputs($fh,"GET ".$url[1]." HTTP/1.1\nHost:".$url[0]."\n\n");
        if (fread($fh, 22) == "HTTP/1.1 404 Not Found") { return FALSE; }
        else { return TRUE;    }

    } else { return FALSE;}
}

function qodef_get_attachment_thumb_url($attachment_url) {
	$attachment_id = qode_get_attachment_id_from_url($attachment_url);

	if(!empty($attachment_id)) {
		return wp_get_attachment_thumb_url($attachment_id);
	} else {
		return $attachment_url;
	}
}

if(!function_exists('qode_resize_image')) {
	/**
	 * Functin that generates custom thumbnail for given attachment
	 * @param null $attach_id id of attachment
	 * @param null $attach_url URL of attachment
	 * @param int $width desired height of custom thumbnail
	 * @param int $height desired width of custom thumbnail
	 * @param bool $crop whether to crop image or not
	 * @return array returns array containing img_url, width and height
	 *
	 * @see qode_get_attachment_id_from_url()
	 * @see get_attached_file()
	 * @see wp_get_attachment_url()
	 * @see wp_get_image_editor()
	 */
	function qode_resize_image($attach_id = null, $attach_url = null, $width = null, $height = null, $crop = true) {
		$return_array = array();

		//is attachment id empty?
		if(empty($attach_id) && $attach_url !== '') {
			//get attachment id from url
			$attach_id = qode_get_attachment_id_from_url($attach_url);
		}

		if(!empty($attach_id) && (isset($width) && isset($height))) {

			//get file path of the attachment
			$img_path = get_attached_file($attach_id);

			//get attachment url
			$img_url  = wp_get_attachment_url($attach_id);

			//break down img path to array so we can use it's components in building thumbnail path
			$img_path_array = pathinfo($img_path);
//            var_dump($attach_id); exit;
			//build thumbnail path
			$new_img_path = $img_path_array['dirname'].'/'.$img_path_array['filename'].'-'.$width.'x'.$height.'.'.$img_path_array['extension'];

			//build thumbnail url
			$new_img_url = str_replace($img_path_array['filename'], $img_path_array['filename'].'-'.$width.'x'.$height, $img_url);

			//check if thumbnail exists by it's path
			if(!file_exists($new_img_path)) {
				//get image manipulation object
				$image_object = wp_get_image_editor($img_path);

				if(!is_wp_error($image_object)) {
					//resize image and save it new to path
					$image_object->resize($width, $height, $crop);
					$image_object->save($new_img_path);

					//get sizes of newly created thumbnail.
					///we don't use $width and $height because those might differ from end result based on $crop parameter
					$image_sizes = $image_object->get_size();

					$width = $image_sizes['width'];
					$height = $image_sizes['height'];
				}
			}

			//generate data to be returned
			$return_array = array(
				'img_url' => $new_img_url,
				'img_width' => $width,
				'img_height' => $height
			);
		}

		//attachment wasn't found, probably because it comes from external source
		elseif($attach_url !== '' && (isset($width) && isset($height))) {
			//generate data to be returned
			$return_array = array(
				'img_url' => $attach_url,
				'img_width' => $width,
				'img_height' => $height
			);
		}

		return $return_array;
	}
}

if(!function_exists('qode_generate_thumbnail')) {
	/**
	 * Generates thumbnail img tag. It calls qode_resize_image function which resizes img on the fly
	 * @param null $attach_id attachment id
	 * @param null $attach_url attachment URL
	 * @param  int$width width of thumbnail
	 * @param int $height height of thumbnail
	 * @param bool $crop whether to crop thumbnail or not
	 * @return string generated img tag
	 *
	 * @see qode_resize_image()
	 * @see qode_get_attachment_id_from_url()
	 */
	function qode_generate_thumbnail($attach_id = null, $attach_url = null, $width = null, $height = null, $crop = true) {
		//is attachment id empty?
		if(empty($attach_id)) {
			//get attachment id from attachment url
			$attach_id = qode_get_attachment_id_from_url($attach_url);
		}

		if(!empty($attach_id) || !empty($attach_url)) {
			$img_info = qode_resize_image($attach_id, $attach_url, $width, $height, $crop);
			$img_alt = !empty($attach_id) ? get_post_meta($attach_id, '_wp_attachment_image_alt', true) : '';

			if(is_array($img_info) && count($img_info)) {
				return '<img src="'.$img_info['img_url'].'" alt="'.$img_alt.'" width="'.$img_info['img_width'].'" height="'.$img_info['img_height'].'" />';
			}
		}

		return '';
	}
}

if(!function_exists('qode_inline_style')) {
	/**
	 * Function that echoes generated style attribute
	 * @param $value string | array attribute value
	 *
	 * @see qode_get_inline_style()
	 */
	function qode_inline_style($value) {
		echo qode_get_inline_style($value);
	}
}

if(!function_exists('qode_get_inline_style')) {
	/**
	 * Function that generates style attribute and returns generated string
	 * @param $value string | array value of style attribute
	 * @return string generated style attribute
	 *
	 * @see qode_get_inline_style()
	 */
	function qode_get_inline_style($value) {
		return qode_get_inline_attr($value, 'style', ';');
	}
}

if(!function_exists('qode_class_attribute')) {
	/**
	 * Function that echoes class attribute
	 * @param $value string value of class attribute
	 *
	 * @see qode_get_class_attribute()
	 */
	function qode_class_attribute($value) {
		echo qode_get_class_attribute($value);
	}
}

if(!function_exists('qode_get_class_attribute')) {
	/**
	 * Function that returns generated class attribute
	 * @param $value string value of class attribute
	 * @return string generated class attribute
	 *
	 * @see qode_get_inline_attr()
	 */
	function qode_get_class_attribute($value) {
		return qode_get_inline_attr($value, 'class');
	}
}

if(!function_exists('qode_get_inline_attr')) {
	/**
	 * Function that generates html attribute
	 * @param $value string | array value of html attribute
	 * @param $attr string name of html attribute to generate
	 * @param $glue string glue with which to implode $attr. Used only when $attr is array
	 * @return string generated html attribute
	 */
	function qode_get_inline_attr($value, $attr, $glue = ' ') {
		if(!empty($value)) {

			if(is_array($value) && count($value)) {
				$properties = implode($glue, $value);
			} elseif($value !== '') {
				$properties = $value;
			}

			return $attr.'="'.esc_attr($properties).'"';
		}

		return '';
	}
}

if(!function_exists('qode_inline_attr')) {
	/**
	 * Function that generates html attribute
	 *
	 * @param $value string | array value of html attribute
	 * @param $attr string name of html attribute to generate
	 * @param $glue string glue with which to implode $attr. Used only when $attr is array
	 *
	 * @return string generated html attribute
	 */
	function qode_inline_attr($value, $attr, $glue = '') {
		echo qode_get_inline_attr($value, $attr, $glue);
	}
}

if(!function_exists('qode_get_inline_attrs')) {
	/**
	 * Generate multiple inline attributes
	 *
	 * @param $attrs
	 *
	 * @return string
	 */
	function qode_get_inline_attrs($attrs) {
		$output = '';

		if(is_array($attrs) && count($attrs)) {
			foreach($attrs as $attr => $value) {
				$output .= ' '.qode_get_inline_attr($value, $attr);
			}
		}

		$output = ltrim($output);

		return $output;
	}
}

if(!function_exists('qode_filter_px')) {
	/**
	 * Removes px in provided value if value ends with px
	 * @param $value
	 * @return string
	 */
	function qode_filter_px($value) {
		if($value !== '' && qode_string_ends_with($value, 'px')) {
			$value = substr($value, 0, strpos($value, 'px'));
		}

		return $value;
	}
}

if(!function_exists('qode_string_starts_with')) {
	/**
	 * Checks if $haystack starts with $needle and returns proper bool value
	 * @param $haystack string to check
	 * @param $needle string with which $haystack needs to start
	 * @return bool
	 */
	function qode_string_starts_with($haystack, $needle) {
		if($haystack !== '' && $needle !== '') {
			return (substr($haystack, 0, strlen($needle)) == $needle);
		}

		return true;
	}
}

if(!function_exists('qode_string_ends_with')) {
	/**
	 * Checks if $haystack ends with $needle and returns proper bool value
	 * @param $haystack string to check
	 * @param $needle string with which $haystack needs to end
	 * @return bool
	 */
	function qode_string_ends_with($haystack, $needle) {
		if($haystack !== '' && $needle !== '') {
			return (substr($haystack, -strlen($needle), strlen($needle)) == $needle);
		}

		return true;
	}
}

if(!function_exists('qode_icon_collections')) {
	/**
	 * Returns instance of QodeIconCollections class
	 *
	 * @return QodeIconCollections
	 */
	function qode_icon_collections() {
		return QodeIconCollections::getInstance();
	}
}

if(!function_exists('qode_kses_img')) {
	/**
	 * Function that does escaping of img html.
	 * It uses wp_kses function with predefined attributes array.
	 * Should be used for escaping img tags in html.
	 * Defines qode_filter_kses_img_atts filter that can be used for changing allowed html attributes
	 *
	 * @see wp_kses()
	 *
	 * @param $content string string to escape
	 * @return string escaped output
	 */
	function qode_kses_img($content) {
		$img_atts = apply_filters('qode_filter_kses_img_atts', array(
			'src' => true,
			'alt' => true,
			'height' => true,
			'width' => true,
			'class' => true,
			'id' => true,
			'title' => true
		));

		return wp_kses($content, array(
			'img' => $img_atts
		));
	}
}

if(!function_exists('qode_get_template_part')) {
	/**
	 * Loads template part with parameters. If file with slug parameter added exists it will load that file, else it will load file without slug added.
	 * Child theme friendly function
	 *
	 * @param string $template name of the template to load without extension
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 */
	function qode_get_template_part($template, $slug = '', $params = array()) {
		if(is_array($params) && count($params)) {
			extract($params);
		}

		$templates = array();

		if($template !== '') {
			if($slug !== '') {
				$templates[] = "{$template}-{$slug}.php";
			}

			$templates[] = $template.'.php';
		}

		$located = qode_find_template_path($templates);

		if($located) {
			include($located);
		}
	}
}
if(!function_exists('qode_get_module_template_part')) {
	/**
	 * Loads module template part.
	 *
	 * @param string $template name of the template to load
	 * @param string $module name of the module folder
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 *
	 * @see qode_get_template_part()
	 */
	function qode_get_module_template_part($template, $module, $slug = '', $params = array()) {
		$template_path = 'framework/modules/'.$module;

		qode_get_template_part($template_path.'/'.$template, $slug, $params);
	}
}
if(!function_exists('qode_get_shortcode_template_part')) {
	/**
	 * Loads module template part.
	 *
	 * @param string $template name of the template to load
	 * @param string $shortcode name of the shortcode folder
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 *
	 * @return html
	 * @see qode_get_template_part()
	 */
	function qode_get_shortcode_template_part($template, $shortcode, $slug = '', $params = array()) {

		//HTML Content from template
		$html          = '';
		$template_path = 'includes/shortcodes/shortcode-elements/'.$shortcode;

		$temp = $template_path.'/'.$template;

		if(is_array($params) && count($params)) {
			extract($params);
		}

		$templates = array();

		if($temp !== '') {
			if($slug !== '') {
				$templates[] = "{$temp}-{$slug}.php";
			}

			$templates[] = $temp.'.php';
		}
		$located = qode_find_template_path($templates);
		if($located) {
			ob_start();
			include($located);
			$html = ob_get_clean();
		}

		return $html;
	}
}

if(!function_exists('qode_find_template_path')) {
	/**
	 * Find template path and return it
	 *
	 * @param $template_names
	 *
	 * @return string
	 */
	function qode_find_template_path($template_names) {
		$located = '';
		foreach((array) $template_names as $template_name) {
			if(!$template_name) {
				continue;
			}
			if(file_exists(get_stylesheet_directory().'/'.$template_name)) {
				$located = get_stylesheet_directory().'/'.$template_name;
				break;
			} elseif(file_exists(get_template_directory().'/'.$template_name)) {
				$located = get_template_directory().'/'.$template_name;
				break;
			}
		}

		return $located;
	}
}

if(!function_exists('qode_dynamic_css')) {
	/**
	 * Generates css based on selector and rules that are provided
	 *
	 * @param array|string $selector selector for which to generate styles
	 * @param array $rules associative array of rules.
	 *
	 * Example of usage: if you want to generate this css:
	 *      header { width: 100%; }
	 * function call should look like this: qodef_fn_themename_dynamic_css('header', array('width' => '100%'));
	 *
	 * @return string
	 */
	function qode_dynamic_css($selector, $rules) {
		$output = '';
		//check if selector and rules are valid data
		if(!empty($selector) && (is_array($rules) && count($rules))) {

			if(is_array($selector) && count($selector)) {
				$output .= implode(', ', $selector);
			} else {
				$output .= $selector;
			}

			$output .= ' { ';
			foreach($rules as $prop => $value) {
				if($prop !== '') {
					$output .= $prop.': '.esc_attr($value).';';
				}
			}

			$output .= '}'."\n\n";
		}

		return $output;
	}
}

if ( ! function_exists( 'qode_active_widget' ) ) {
	/**
	 * Whether widget is displayed on the front-end.
	 */
	function qode_active_widget( $callback = false, $widget_id = false, $id_base = false, $skip_inactive = true ) {
		global $wp_registered_widgets;

		$sidebars_widgets = wp_get_sidebars_widgets();
		$sidebars_array   = array();

		if ( is_array( $sidebars_widgets ) ) {
			foreach ( $sidebars_widgets as $sidebar => $widgets ) {
				if ( $skip_inactive && ( 'wp_inactive_widgets' === $sidebar || 'orphaned_widgets' === substr( $sidebar, 0, 16 ) ) ) {
					continue;
				}
				if ( is_array( $widgets ) ) {
					foreach ( $widgets as $widget ) {
						if ( ( $callback && isset( $wp_registered_widgets[ $widget ]['callback'] ) && $wp_registered_widgets[ $widget ]['callback'] == $callback ) || ( $id_base && _get_widget_id_base( $widget ) == $id_base ) ) {
							if ( ! $widget_id || $widget_id == $wp_registered_widgets[ $widget ]['id'] ) {
								$sidebars_array[] = $sidebar;
							}
						}
					}
				}
			}

			return $sidebars_array;
		}

		return false;
	}
}

if(!function_exists('qode_execute_shortcode')) {
	/**
	 * @param $shortcode_tag - shortcode base
	 * @param $atts - shortcode attributes
	 * @param null $content - shortcode content
	 *
	 * @return mixed|string
	 */
	function qode_execute_shortcode($shortcode_tag, $atts, $content = null) {
		global $shortcode_tags;

		if(!isset($shortcode_tags[$shortcode_tag])) {
			return 'Shortcode doesn\'t exist';
		}

		if(is_array($shortcode_tags[$shortcode_tag])) {
			$shortcode_array = $shortcode_tags[$shortcode_tag];

			return call_user_func(array(
				$shortcode_array[0],
				$shortcode_array[1]
			), $atts, $content, $shortcode_tag);
		}

		return call_user_func($shortcode_tags[$shortcode_tag], $atts, $content, $shortcode_tag);
	}
}

if(!function_exists('qode_get_meta_field_intersect')) {
	/**
	 * @param $name
	 * @param $post_id
	 *
	 * @return bool|mixed|void
	 */
	function qode_get_meta_field_intersect($name, $post_id = '') {
		$post_id = !empty($post_id) ? $post_id : get_the_ID();

		$value = qode_options()->getOptionValue($name);

		if($post_id !== -1) {
			$meta_field = get_post_meta($post_id, $name.'_meta', true);
			if($meta_field !== '' && $meta_field !== false) {
				$value = $meta_field;
			}
		}

		$value = apply_filters('qode_meta_field_intersect_'.$name, $value);

		return $value;
	}
}
if(!function_exists('qode_replace_newline')) {
	function qode_replace_newline( $text ) {
		/**
		 * @param $text
		 *
		 * @return string
		 */
		$text = (string) $text;
		$text = str_replace( array( "\r", "\n" ), '', $text );
		return trim( $text );
	}
}