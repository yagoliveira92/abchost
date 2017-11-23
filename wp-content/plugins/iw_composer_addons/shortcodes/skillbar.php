<?php

/*
 * Inwave_Heading for Visual Composer
 */
if (!class_exists('Inwave_Skillbar')) {

    class Inwave_Skillbar {

        private $params;

        function __construct() {
            $this->initParams();
            add_action('vc_before_init', array($this, 'skillbar_init'));
            add_shortcode('inwave_skillbar', array($this, 'inwave_skillbar_shortcode'));
        }

        function initParams() {
            global $iw_shortcodes;
            $this->params = array(
                'name' => 'Skillbar',
                'description' => __('Show skill of a person', 'inwavethemes'),
                'base' => 'inwave_skillbar',
                'category' => 'Custom',
                'icon' => 'iw-default',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Skillbar title", "inwavethemes"),
                        "value" => "Skillbar title",
                        "param_name" => "skillbar_title"
                    ),
					array(
                        "type" => "textfield",
                        "heading" => __("Class", "inwavethemes"),
						"value" => "",
                        "param_name" => "skillbar_class"
                    ),
                    array(
                        "type" => "iw_range_skillbar",
                        "heading" => __("Percent", "inwavethemes"),
						"value" => "",
                        "param_name" => "skillbar_percent"
                    ),
					 array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "class" => "",
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1" => "style1",
                            "Style 2" => "style2",
                        )
                    ),
                )
            );
            $iw_shortcodes['inwave_skillbar'] = $this->params;
        }

        function skillbar_init() {
            if (function_exists('vc_map')) {
                // Add banner addon
                vc_map($this->params);
            }
        }

        // Shortcode handler function for list Icon
        function inwave_skillbar_shortcode($atts, $content = null) {
            $output = $skillbar_title = $skillbar_percent = $skillbar_class = $style = '';
            extract(shortcode_atts(array(
                'skillbar_title' => 'Skillbar title',
				'skillbar_class' => '',
				'style' => '',
                'skillbar_percent' => '',
            ), $atts));
			
			switch ($style) {
				case 'style1':
					$output .= '<div class="skillbar_wap style1 '.$skillbar_class.'">';
					$output .= '<div class="skillbar_title">' . $skillbar_title . '</div>';
					$output .= '<div class="skillbar">';
					$output .= '<div class="skillbar_level theme-bg" style="width:' . $skillbar_percent . '%;"></div>';
					$output .= '<div class="skillbar_callout theme-bg" style="left:' . $skillbar_percent . '%;">' . $skillbar_percent . '%</div>';
					$output .= '</div></div>';
				break;
				case 'style2':
					$output .= '<div class="skillbar_wap style2 '.$skillbar_class.'">';
					$output .= '<div class="skillbar_title">' . $skillbar_title . '</div>';
					$output .= '<div class="skillbar">';
					$output .= '<div class="skillbar_level theme-bg" style="width:' . $skillbar_percent . '%;"></div>';
					$output .= '</div></div>';
				break;
				default:
					$output .= '<div class="skillbar_wap style1 '.$skillbar_class.'">';
					$output .= '<div class="skillbar_title">' . $skillbar_title . '</div>';
					$output .= '<div class="skillbar">';
					$output .= '<div class="skillbar_level theme-bg" style="width:' . $skillbar_percent . '%;"></div>';
					$output .= '<div class="skillbar_callout theme-bg" style="left:' . $skillbar_percent . '%;">' . $skillbar_percent . '%</div>';
					$output .= '</div></div>';
				break;
			}
			return $output;
        }

    }

}

new Inwave_Skillbar;
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_Inwave_Skillbar extends WPBakeryShortCode {
        
    }

}