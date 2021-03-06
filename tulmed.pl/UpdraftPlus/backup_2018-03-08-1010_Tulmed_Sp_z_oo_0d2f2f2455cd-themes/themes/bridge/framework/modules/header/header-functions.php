<?php
if(!function_exists('qode_header_parameters')) {

	function qode_header_parameters() {

		$params = array();

		$params['enable_side_area'] = "yes";
		if (qode_options()->getOptionValue('enable_side_area') == "no"){ $params['enable_side_area'] = "no"; };

		$params['enable_popup_menu'] = "no";
		if(qode_options()->getOptionValue('enable_popup_menu') == "yes" && has_nav_menu('popup-navigation')) {
			$params['enable_popup_menu'] = "yes";
		}
		if (qode_options()->getOptionValue('popup_menu_animation_style') !== '') {
			$params['popup_menu_animation_style'] = 'qode_'.qode_options()->getOptionValue('popup_menu_animation_style');
		}

		$params['enable_fullscreen_search'] = "no";
		if(qode_options()->getOptionValue('enable_search') == "yes" && qode_options()->getOptionValue('search_type') == "fullscreen_search" ){
			$params['enable_fullscreen_search'] = "yes";
		}

		$params['fullscreen_search_animation'] = "fade";
		if(qode_options()->getOptionValue('search_type') == "fullscreen_search" && qode_options()->getOptionValue('search_animation') !== "" ){
			$params['fullscreen_search_animation'] = qode_options()->getOptionValue('search_animation');
		}

		$params['enable_vertical_menu'] = false;
		if(qode_options()->getOptionValue('vertical_area') =='yes'){
			$params['enable_vertical_menu'] = true;
		}

		$params['header_button_size'] = '';
		if(isset($qode_options_proya['header_buttons_size'])){
			$params['header_button_size'] = qode_options()->getOptionValue('header_buttons_size');
		}



		$params['paspartu_header_alignment'] = false;
		if(qode_options()->getOptionValue('paspartu_header_alignment') == 'yes' && qode_options()->getOptionValue('paspartu') == 'yes'){ $params['paspartu_header_alignment'] = true; }

		$params['header_in_grid'] = true;
		if(qode_options()->getOptionValue('header_in_grid') == "no" || $params['paspartu_header_alignment']){ $params['header_in_grid'] = false; }

		$params['menu_position'] = "right";
		if(qode_options()->getOptionValue('menu_position') !== ''){$params['menu_position'] = qode_options()->getOptionValue('menu_position'); }

		$params['centered_logo'] = false;
		if(qode_options()->getOptionValue('center_logo_image') == "yes") { $params['centered_logo'] = true; }

		$params['centered_logo_animate'] = false;
		if (qode_options()->getOptionValue('center_logo_image_animate') == "yes") { $params['centered_logo_animate'] = true; }

		if(qode_options()->getOptionValue('header_bottom_appearance') == "fixed_hiding"){
			$params['centered_logo'] = true;
			$params['centered_logo_animate'] = true;
		}

		$params['display_header_top'] = "yes";
		$params['display_header_top'] = qode_options()->getOptionValue('header_top_area');
		if (!empty($_SESSION['qode_proya_header_top'])){
			$params['display_header_top'] = $_SESSION['qode_proya_header_top'];
		}

		$params['header_top_area_scroll'] = "no";
		$params['header_top_area_scroll'] = qode_options()->getOptionValue('header_top_area_scroll');
		if (!empty($_SESSION['qode_header_top'])) {
			if ($_SESSION['qode_header_top'] == "no")
				$params['header_top_area_scroll'] = "no";
			if ($_SESSION['qode_header_top'] == "yes")
				$params['header_top_area_scroll'] = "yes";
		}

		global $wp_query;
		$id = $wp_query->get_queried_object_id();
		$params['is_woocommerce'] = false;
		if(function_exists("is_woocommerce")) {
			$params['is_woocommerce'] = is_woocommerce();
			if($params['is_woocommerce']){
				$id = get_option('woocommerce_shop_page_id');
			}
		}
		$params['id'] = $id; //used in other template parts

		$params['header_style'] = "";
		if(get_post_meta($id, "qode_header-style", true) != ""){
			$params['header_style'] = get_post_meta($id, "qode_header-style", true);
		}else{
			$params['header_style'] = qode_options()->getOptionValue('header_style');
		}

		$params['header_color_transparency_per_page'] = "";
		if(qode_options()->getOptionValue('header_background_transparency_initial') != "") {
			$params['header_color_transparency_per_page'] = qode_options()->getOptionValue('header_background_transparency_initial');
		}
		if(get_post_meta($id, "qode_header_color_transparency_per_page", true) != ""){
			$params['header_color_transparency_per_page'] = get_post_meta($id, "qode_header_color_transparency_per_page", true);
		}

		$params['header_color_per_page'] = "style='";
		if(get_post_meta($id, "qode_header_color_per_page", true) != ""){
			if($params['header_color_transparency_per_page'] != ""){
				$params['header_background_color'] = qode_hex2rgb(get_post_meta($id, "qode_header_color_per_page", true));
				$params['header_color_per_page'] .= " background-color:rgba(" . $params['header_background_color'][0] . ", " . $params['header_background_color'][1] . ", " . $params['header_background_color'][2] . ", " . $params['header_color_transparency_per_page'] . ");";
			}else{
				$params['header_color_per_page'] .= " background-color:" . get_post_meta($id, "qode_header_color_per_page", true) . ";";
			}
		} else if($params['header_color_transparency_per_page'] != "" && get_post_meta($id, "qode_header_color_per_page", true) == ""){
			$params['header_background_color'] = qode_options()->getOptionValue('header_background_color') ? qode_hex2rgb(qode_options()->getOptionValue('header_background_color')) : qode_hex2rgb("#ffffff");
			$params['header_color_per_page'] .= " background-color:rgba(" . $params['header_background_color'][0] . ", " . $params['header_background_color'][1] . ", " . $params['header_background_color'][2] . ", " . $params['header_color_transparency_per_page'] . ");";
		}

		$params['header_top_color_per_page'] = "style='";
		if(get_post_meta($id, "qode_header_color_per_page", true) != ""){
			if($params['header_color_transparency_per_page'] != ""){
				$params['header_background_color'] = qode_hex2rgb(get_post_meta($id, "qode_header_color_per_page", true));
				$params['header_top_color_per_page'] .= "background-color:rgba(" . $params['header_background_color'][0] . ", " . $params['header_background_color'][1] . ", " . $params['header_background_color'][2] . ", " . $params['header_color_transparency_per_page'] . ");";
			}else{
				$params['header_top_color_per_page'] .= "background-color:" . get_post_meta($id, "qode_header_color_per_page", true) . ";";
			}
		} else if($params['header_color_transparency_per_page'] != "" && get_post_meta($id, "qode_header_color_per_page", true) == ""){
			$params['header_background_color'] = qode_options()->getOptionValue('header_top_background_color') ? qode_hex2rgb(qode_options()->getOptionValue('header_top_background_color')) : qode_hex2rgb("#ffffff");
			$params['header_top_color_per_page'] .= "background-color:rgba(" . $params['header_background_color'][0] . ", " . $params['header_background_color'][1] . ", " . $params['header_background_color'][2] . ", " . $params['header_color_transparency_per_page'] . ");";
		}

		$params['header_color_per_page'] .= "'";
		$params['header_top_color_per_page'] .= "'";

		$params['header_separator'] = qode_hex2rgb("#eaeaea");
		if(qode_options()->getOptionValue('header_separator_color') != ""){
			$params['header_separator'] = qode_hex2rgb(qode_options()->getOptionValue('header_separator_color'));
		}

		//generate header classes based on qode options
		$params['header_classes'] = '';
		if(is_active_sidebar('woocommerce_dropdown')) {
			$params['header_classes'] .= 'has_woocommerce_dropdown ';
		}

		if($params['display_header_top'] == "yes") {
			$params['header_classes'] .= ' has_top';
		}

		if($params['header_top_area_scroll'] == "yes") {
			$params['header_classes'] .= ' scroll_top';
		}

		if($params['centered_logo']) {
			$params['header_classes'] .= ' centered_logo';
		}

		if($params['centered_logo_animate']){
			$params['header_classes'] .= ' centered_logo_animate';
		}

		if(is_active_sidebar('header_fixed_right')) {
			$params['header_classes'] .= ' has_header_fixed_right';
		}

		if(qode_options()->getOptionValue('header_top_area_scroll') == 'no') {
			$params['header_classes'] .= ' scroll_header_top_area';
		}

		if(get_post_meta($id, "qode_header-style", true) != ""){
			$params['header_classes'] .= ' '.get_post_meta($id, "qode_header-style", true);
		} else{
			$params['header_classes'] .= ' '.qode_options()->getOptionValue('header_style');
		}

		$params['header_classes'] .= ' '.qode_options()->getOptionValue('header_bottom_appearance');
		$params['header_bottom_appearance'] = qode_options()->getOptionValue('header_bottom_appearance');


		$params['per_page_header_transparency'] = get_post_meta($id, 'qode_header_color_transparency_per_page', true);
		$params['header_transparency'] = '';

		if($params['per_page_header_transparency'] !== '') {
			$params['header_transparency'] = $params['per_page_header_transparency'];
		} else {
			$params['header_transparency'] = qode_options()->getOptionValue('header_background_transparency_initial');
		}


		$transparent_values_array 	= array('0.00', '0');
		$sticky_headers_array       = array('stick','stick menu_bottom','stick_with_left_right_menu','stick compound');
		$fixed_headers_array        = array('fixed','fixed fixed_minimal','fixed_hiding','fixed_top_header');

		//is header transparent not set on current page?
		if(get_post_meta($id, "qode_header_color_transparency_per_page", true) === "" || get_post_meta($id, "qode_header_color_transparency_per_page", true) === false) {
			//take global value set in Qode Options
			$transparent_header = qode_options()->getOptionValue('header_background_transparency_initial');
		} else {
			//take value set for current page
			$transparent_header = get_post_meta($id, "qode_header_color_transparency_per_page", true);
		}

		//is header completely transparent?
		$is_header_transparent 	= in_array($transparent_header, $transparent_values_array);
		if($is_header_transparent) {
			$params['header_classes'] .= ' transparent';
		}

		//is header transparent on scrolled window?
		if(qode_options()->getOptionValue('header_bottom_appearance') !== 'regular' &&
			((!in_array(qode_options()->getOptionValue('header_background_transparency_sticky'), $transparent_values_array) && in_array(qode_options()->getOptionValue('header_bottom_appearance'), $sticky_headers_array)) ||
				(!in_array(qode_options()->getOptionValue('header_background_transparency_scroll'), $transparent_values_array) && in_array(qode_options()->getOptionValue('header_bottom_appearance'), $fixed_headers_array)))) {
			$params['header_classes'] .= ' scrolled_not_transparent';
		}

		if(qode_options()->getOptionValue('header_bottom_border_color') != '') {
			$params['header_classes'] .= ' with_border';
		}

		//check if first level hover background color is set
		if(qode_options()->getOptionValue('menu_hover_background_color') !== '') {
			$params['header_classes'] .= ' with_hover_bg_color';
		}

		if(qode_options()->getOptionValue('paspartu_header_alignment') == 'yes' && qode_options()->getOptionValue('paspartu') == 'yes'){
			$params['header_classes'] .= ' paspartu_header_alignment';
		}

		if(qode_options()->getOptionValue('paspartu_header_inside') == 'yes' && qode_options()->getOptionValue('paspartu') == 'yes'){
			$params['header_classes'] .= ' paspartu_header_inside';
		}

		$params['vertical_area_background_image'] = "";
		if(qode_options()->getOptionValue('vertical_area_background_image') != "") {
			$params['vertical_area_background_image'] = qode_options()->getOptionValue('vertical_area_background_image');
		}
		if(get_post_meta($id, "qode_page_vertical_area_background_image", true) != ""){
			$params['vertical_area_background_image'] = get_post_meta($id, "qode_page_vertical_area_background_image", true);
		}

		if(get_post_meta($id, "qode_header-style-on-scroll", true) != ""){
			if(get_post_meta($id, "qode_header-style-on-scroll", true) == "yes") {
				$params['header_classes'] .= ' header_style_on_scroll';
			}
		} else if(qode_options()->getOptionValue('enable_header_style_on_scroll') == 'yes'){
			$params['header_classes'] .= ' header_style_on_scroll';
		}

		if($params['menu_position'] == 'left' && in_array($params['header_bottom_appearance'], array('regular','fixed','stick'))){
			$params['header_classes'] .= ' menu_position_left';
		}

		if(qode_is_ajax_header_animation_enabled()){
			$params['header_classes'] .= ' ajax_header_animation';
		}

		$params['logo_height'] = 0;
		if(qode_options()->getOptionValue('logo_image')){
			$logo_url_obj = parse_url(qode_options()->getOptionValue('logo_image'));
			if (file_exists($_SERVER['DOCUMENT_ROOT'].$logo_url_obj['path'])) {
				list($params['logo_width'], $params['logo_height'], $params['logo_type'], $params['logo_attr']) = getimagesize($_SERVER['DOCUMENT_ROOT'].$logo_url_obj['path']);
			}
		}

		$params['enable_search_left_sidearea_right'] = false;
		if(qode_options()->getOptionValue('header_bottom_appearance') =='fixed_hiding'){
			if(qode_options()->getOptionValue('search_left_sidearea_right') =='yes'){
				$params['enable_search_left_sidearea_right'] = true;
			}
		}else{
			if(qode_options()->getOptionValue('search_left_sidearea_right_regular') =='yes'){
				$params['enable_search_left_sidearea_right'] = true;
			}
		}

		$params['overlapping_content'] = false;
		if(qode_options()->getOptionValue('overlapping_content') == 'yes'){
			$params['overlapping_content'] = true;
		}

		return $params;

	}

}

if(!function_exists('qode_get_logo')) {

	function qode_get_logo($params){
		$logo_image = false;
		$logo_image_light = false;
		$logo_image_dark = false;
		$logo_image_sticky = false;
		$logo_image_popup = false;
		$logo_image_fixed_hidden = false;
		$logo_image_mobile = false;
		$wrapper_class = 'logo_wrapper';
		$image_class = 'q_logo';
		$logo_style = '';

		extract($params);

		$logo_params = array();

		$logo_params['show_logo_image'] = $logo_image;
		$logo_params['show_logo_image_light'] = $logo_image_light;
		$logo_params['show_logo_image_dark'] = $logo_image_dark;
		$logo_params['show_logo_image_sticky'] = $logo_image_sticky;
		$logo_params['show_logo_image_popup'] = $logo_image_popup;
		$logo_params['show_logo_image_fixed_hidden'] = $logo_image_fixed_hidden;
		$logo_params['show_logo_image_mobile'] = $logo_image_mobile;

		$logo_params['logo_image'] = qode_options()->getOptionValue('logo_image') != "" ? qode_options()->getOptionValue('logo_image') : get_template_directory_uri().'/img/logo.png';
		$logo_params['logo_image_light'] = qode_options()->getOptionValue('logo_image_light') != "" ? qode_options()->getOptionValue('logo_image_light') : get_template_directory_uri().'/img/logo.png';
		$logo_params['logo_image_dark'] = qode_options()->getOptionValue('logo_image_dark') != "" ? qode_options()->getOptionValue('logo_image_dark') : get_template_directory_uri().'/img/logo_black.png';
		$logo_params['logo_image_sticky'] = qode_options()->getOptionValue('logo_image_sticky') != "" ? qode_options()->getOptionValue('logo_image_sticky') : get_template_directory_uri().'/img/logo_black.png';
		$logo_params['logo_image_popup'] = qode_options()->getOptionValue('logo_image_popup') != "" ? qode_options()->getOptionValue('logo_image_popup') : get_template_directory_uri().'/img/logo_white.png';
		$logo_params['logo_image_fixed_hidden'] = qode_options()->getOptionValue('logo_image_fixed_hidden') != "" ? qode_options()->getOptionValue('logo_image_fixed_hidden') : get_template_directory_uri().'/img/logo.png';
		$logo_params['logo_image_mobile'] = qode_options()->getOptionValue('logo_image_mobile') != "" ? qode_options()->getOptionValue('logo_image_mobile') : $logo_params['logo_image'];

		$logo_params['wrapper_class'] = $wrapper_class;
		$logo_params['image_class'] = $image_class;

		$logo_params['logo_style'] = $logo_style !== '' ? 'style="'.$logo_style.'"' : '';

		return qode_get_module_template_part('templates/parts/logo', 'header', '', $logo_params);
	}
}

if(!function_exists('qode_get_content_class')) {
	function qode_get_content_class(){
		$content_class = "";
		$id = qode_get_page_id();

		$per_page_header_transparency = get_post_meta($id, 'qode_header_color_transparency_per_page', true);
		$header_transparency = $per_page_header_transparency !== '' ? $per_page_header_transparency: qode_options()->getOptionValue('header_background_transparency_initial');

		if((get_post_meta($id, "qode_revolution-slider", true) == "" &&
			qode_is_title_hidden() &&
			!is_category() &&
			!is_tag() &&
			!is_author() &&
			($header_transparency === '' || $header_transparency == 1)) ||
			qode_is_content_below_header()){
				if(in_array(qode_options()->getOptionValue('header_bottom_appearance'), array('fixed', 'fixed fixed_minimal'))){
					$content_class = "content_top_margin";
				}elseif(qode_is_content_below_header() && qode_options()->getOptionValue('header_bottom_appearance') == "fixed_hiding"){
					$content_class = "content_top_margin";
				}else {
					$content_class = "content_top_margin_none";
				}
		}

		if(get_post_meta($id, "qode_revolution-slider", true) != ""){
			$content_class .= " has_slider";
		}

		if(in_array(qode_options()->getOptionValue('header_bottom_appearance'), array('stick', 'stick menu_bottom', 'stick_with_left_right_menu'))){
			if(get_post_meta(qode_get_page_id(), "qode_page_hide_initial_sticky", true) !== ''){
				if(get_post_meta(qode_get_page_id(), "qode_page_hide_initial_sticky", true) == 'yes'){
					$content_class = " ";
				}
			}else if(qode_options()->getOptionValue('hide_initial_sticky') == 'yes') {
				$content_class = " ";
			}
		}

		return $content_class;
	}
}

if(!function_exists('qode_get_paspartu_class')) {
	function qode_get_paspartu_class(){
		$paspartu_additional_classes = "";
		if(qode_options()->getOptionValue('paspartu_on_top') == 'no'){
			$paspartu_additional_classes .= " disable_top_paspartu";
		}
		if(qode_options()->getOptionValue('paspartu_on_bottom') == 'no'){
			$paspartu_additional_classes .= " disable_bottom_paspartu";
		}
		if(qode_options()->getOptionValue('paspartu_on_bottom_slider') == 'yes'){
			$paspartu_additional_classes .= " paspartu_on_bottom_slider";
		}
		if((qode_options()->getOptionValue('paspartu_on_bottom') == 'yes' && qode_options()->getOptionValue('paspartu_on_bottom_fixed') == 'yes') ||
			(qode_options()->getOptionValue('vertical_area') == "yes" && qode_options()->getOptionValue('vertical_menu_inside_paspartu') == 'yes')){
			$paspartu_additional_classes .= " paspartu_on_bottom_fixed";
		}

		return $paspartu_additional_classes;
	}
}