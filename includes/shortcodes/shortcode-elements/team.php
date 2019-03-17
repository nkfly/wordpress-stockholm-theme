<?php
/* Team shortcode */

if (!function_exists('q_team')) {
	function q_team($atts, $content = null) {
		$args = array(
			"team_type"									=> "",
			"team_image"								=> "",
			"team_image_hover_color"					=> "",
			"team_name"									=> "",
			"team_name_tag"							    => "h4",
			"team_name_color"							=> "",
			"team_name_font_size"						=> "",
			"team_name_font_weight"						=> "",
			"team_name_text_transform"                  => "",
			"team_position"								=> "",
			"team_position_color"						=> "",
			"team_position_font_size"					=> "",
			"team_position_font_weight"					=> "",
			"team_position_text_transform"              => "",
			"team_description"							=> "",
			"team_description_color"					=> "",
			"text_align"                                => "",
			"background_color"							=> "",
			"box_border"								=> "",
			"box_border_width"							=> "",
			"box_border_color"							=> "",

			"team_social_icon_pack"     				=> "",
			"team_social_icon_type"     				=> "circle_social",
			"team_social_icon_color"    				=> "",
			"team_social_icon_background_color"    		=> "",
			"team_social_icon_border_color"	    		=> "",
			"team_social_icon_hover_color"              => "",
			"team_social_background_hover_color"        => "",
			"team_social_border_hover_color"            => "",

			"team_social_fa_icon_1"						=> "",
			"team_social_fe_icon_1"						=> "",
			"team_social_icon_1_link"					=> "",
			"team_social_icon_1_target"					=> "",

			"team_social_fa_icon_2"						=> "",
			"team_social_fe_icon_2"						=> "",
			"team_social_icon_2_link"					=> "",
			"team_social_icon_2_target"					=> "",

			"team_social_fa_icon_3"						=> "",
			"team_social_fe_icon_3"						=> "",
			"team_social_icon_3_link"					=> "",
			"team_social_icon_3_target"					=> "",

			"team_social_fa_icon_4"						=> "",
			"team_social_fe_icon_4"						=> "",
			"team_social_icon_4_link"					=> "",
			"team_social_icon_4_target"					=> "",

			"team_social_fa_icon_5"     				=> "",
			"team_social_fe_icon_5"     				=> "",
			"team_social_icon_5_link"   				=> "",
			"team_social_icon_5_target" 				=> "",

			"show_skills"								=> "no",
			"skills_title_size"							=> "",
			"skill_title_1"								=> "",
			"skill_percentage_1"						=> "",
			"skill_title_2"								=> "",
			"skill_percentage_2"						=> "",
			"skill_title_3"								=> "",
			"skill_percentage_3"						=> "",
		);

		extract(shortcode_atts($args, $atts));

		$headings_array = array('h2', 'h3', 'h4', 'h5', 'h6');

		//get correct heading value. If provided heading isn't valid get the default one
		$team_name_tag = (in_array($team_name_tag, $headings_array)) ? $team_name_tag : $args['team_name_tag'];

		if(is_numeric($team_image)) {
			$team_image_src = wp_get_attachment_url( $team_image );
		} else {
			$team_image_src = $team_image;
		}

		$q_team_holder_classes = array();

		if($background_color != "" || ($box_border != "")) {
			$q_team_holder_classes[] = "with_padding";
		}

		if($team_type == "info_hover") {
			$q_team_holder_classes[] = "info_hover";
		}

		$q_team_style = "";
		if($background_color != ""){
			$q_team_style .= " style='";
			$q_team_style .= 'background-color:' . $background_color . ';';
			$q_team_style .= "'";
		}

		$q_team_image_hover_style = "";
		if($team_image_hover_color != ""){
			$q_team_image_hover_style .= " style='";
			$q_team_image_hover_style .= 'background-color:' . $team_image_hover_color . ';';
			$q_team_image_hover_style .= "'";
		}

		$qteam_box_style = "";
		if($box_border == "yes"){

			$qteam_box_style .= "style=";

			$qteam_box_style .= "border-style:solid;";
			if($box_border_color != "" ){
				$qteam_box_style .= "border-color:" . $box_border_color . ";";
			}
			if($box_border_width != "" ){
				$qteam_box_style .= "border-width:" . $box_border_width . "px;";
			}

			$qteam_box_style .= "'";

		}

		$q_team_name_style_array = array();
		$q_team_name_style 		 = '';

		if($team_name_color != '') {
			$q_team_name_style_array[] = 'color: '.$team_name_color;
		}

		if($team_name_font_size != '') {
			$q_team_name_style_array[] = 'font-size: '.$team_name_font_size.'px';
		}

		if($team_name_font_weight != '') {
			$q_team_name_style_array[] = 'font-weight: '.$team_name_font_weight;
		}

		if($team_name_text_transform != '') {
			$q_team_name_style_array[] = 'text-transform: '.$team_name_text_transform;
		}

		if(is_array($q_team_name_style_array) && count($q_team_name_style_array)) {
			$q_team_name_style = 'style ="'.implode(';', $q_team_name_style_array).'"';
		}

		$q_team_position_style_array = array();
		$q_team_position_style 		 = '';

		if($team_position_color != '') {
			$q_team_position_style_array[] = 'color: '.$team_position_color;
		}

		if($team_position_font_size != '') {
			$q_team_position_style_array[] = 'font-size: '.$team_position_font_size.'px';
		}

		if($team_position_font_weight != '') {
			$q_team_position_style_array[] = 'font-weight: '.$team_position_font_weight;
		}

		if($team_position_text_transform != '') {
			$q_team_position_style_array[] = 'text-transform: '.$team_position_text_transform;
		}

		if(is_array($q_team_position_style_array) && count($q_team_position_style_array)) {
			$q_team_position_style = 'style ="'.implode(';', $q_team_position_style_array).'"';
		}

		$q_team_description_style_array  = array();
		$q_team_description_style 		 = '';

		if($team_description_color != '') {
			$q_team_description_style_array[] = 'color: '.$team_description_color;
		}

		if(is_array($q_team_description_style_array) && count($q_team_description_style_array)) {
			$q_team_description_style = 'style ="'.implode(';', $q_team_description_style_array).'"';
		}

		$html =  "<div class='q_team ".implode(' ', $q_team_holder_classes)."'". $q_team_style .">";
		$html .=  "<div class='q_team_inner'>";
		if($team_image != "") {
			$html .=  "<div class='q_team_image'>";
			$html .= "<img src='$team_image_src' alt='team_image' />";
			$html .=  "<div class='q_team_social_holder' ".$q_team_image_hover_style.">";
			$html .=  "<div class='q_team_social'>";
			$html .=  "<div class='q_team_social_inner'>";


			if($team_type == 'info_hover'){
				// html for info hover type
				$html .=  "<div class='q_team_title_holder'>";
				$html .=  "<$team_name_tag class='q_team_name' ".$q_team_name_style.">";
				$html .= $team_name;
				$html .=  "</$team_name_tag>";
				if($team_position != "") {
					$html .= "<h6 class='q_team_position' ".$q_team_position_style.">" . $team_position . "</h6>";
				}
				$html .=  "</div>"; //close div.q_team_title_holder
			}

			//generate social icons html
			$team_social_icon_type_label = ''; //used in generating shortcode parameters based on icon pack
			$team_social_icon_param_label = ''; //used in generating shortcode parameters based on icon pack

			//is font awesome icon pack chosen?
			if($team_social_icon_pack == 'font_awesome') {
				$team_social_icon_type_label = 'team_social_fa_icon';
				$team_social_icon_param_label = 'fa_icon';
			} else {
				$team_social_icon_type_label = 'team_social_fe_icon';
				$team_social_icon_param_label = 'fe_icon';
			}

			if($team_type == 'info_hover'){ $html .=  "<div class='q_team_social_on_hover'>"; }

			//for each of available icons
			for($i = 1; $i <= 5; $i++) {
				$team_social_icon 		= ${$team_social_icon_type_label.'_'.$i};
				$team_social_link 		= ${'team_social_icon_'.$i.'_link'};
				$team_social_target		= ${'team_social_icon_'.$i.'_target'};

				if($team_social_icon != "") {
					$social_icons_param_array = array();

					$social_icons_param_array[] = $team_social_icon_param_label."='".$team_social_icon."'";

					if($team_social_link !== '') {
						$social_icons_param_array[] = "link='".$team_social_link."'";
					}

					if($team_social_target !== '') {
						$social_icons_param_array[] = "target='".$team_social_target."'";
					} else {
						$social_icons_param_array[] = "target='_self'";
					}

					if($team_social_icon_type !== '') {
						$social_icons_param_array[] = "type='".$team_social_icon_type."'";
					}

					if($team_social_icon_color !== '') {
						$social_icons_param_array[] = "icon_color='".$team_social_icon_color."'";
					}

					if($team_social_icon_background_color !== '') {
						$social_icons_param_array[] = "background_color='".$team_social_icon_background_color."'";
					}

					if($team_social_icon_border_color !== '') {
						$social_icons_param_array[] = "border_color='".$team_social_icon_border_color."'";
					}

					if($team_social_icon_hover_color !== ''){
						$social_icons_param_array[] = "icon_hover_color='".$team_social_icon_hover_color."'";
					}

					if($team_social_background_hover_color !== ''){
						$social_icons_param_array[] = "background_hover_color='".$team_social_background_hover_color."'";
					}

					if($team_social_border_hover_color !== ''){
						$social_icons_param_array[] = "border_hover_color='".$team_social_border_hover_color."'";
					}


					$html .=  do_shortcode('[social_icons icon_pack="'.$team_social_icon_pack.'" '.implode(' ', $social_icons_param_array).']');

				}

			}

			if($team_type == 'info_hover'){ $html .=  "</div>"; }

			$html .=  "</div></div></div>"; //close div.q_team_social_holder
			$html .=  "</div>"; //close div.q_team_image
		}
		if(($team_type == 'info_hover' && ($team_description != '' || $show_skills == 'yes')) || $team_type == '') {
			$html .=  "<div class='q_team_text ".$text_align."' ". $qteam_box_style .">";
			$html .=  "<div class='q_team_text_inner'>";


			if($team_type != 'info_hover') {
				$html .= "<div class='q_team_title_holder'>";
				if ($team_position != "") {
					$html .= "<h6 class='q_team_position' " . $q_team_position_style . ">" . $team_position . "</h6>";
				}
				$html .= "<$team_name_tag class='q_team_name' " . $q_team_name_style . ">";
				$html .= $team_name;
				$html .= "</$team_name_tag>";
				$html .= "</div>"; //close div.q_team_title_holder
			}

			if($team_description != "") {

				$html .= "<div class='q_team_description'>";
				$html .= "<p ".$q_team_description_style.">".$team_description."</p>";
				$html .= "</div>"; // close div.q_team_description
			}

			if($show_skills == 'yes') {
				$html .= '<div class="q_team_skills_holder">';

				for($i = 1; $i <=3; $i++) {
					$skill_title = ${"skill_title_".$i};
					$skill_percentage = ${"skill_percentage_".$i};

					if($skill_title != '' && $skill_percentage != '') {

						$skills_param_array = array(
							'title ="'.$skill_title.'"',
							'percent = '.$skill_percentage
						);

						if($skills_title_size != '') {
							$skills_param_array[] = 'title_custom_size = '.$skills_title_size;
						}

						$html .= do_shortcode('[progress_bar '.implode(' ', $skills_param_array).']');
					}
				}

				$html .= '</div>';
			}

			$html .=  "</div>"; //close div.q_team_text_inners
			$html .=  "</div>"; //close div.q_team_text
		}

		$html .=  "</div>"; //close div.q_team_inner
		$html .=  "</div>"; //close div.q_team

		return $html;
	}
	add_shortcode('q_team', 'q_team');
}
