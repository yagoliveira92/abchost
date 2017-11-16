<?php

/*
 * Inwave_Heading for Visual Composer
 */
if (!class_exists('Inwave_Heading')) {

    class Inwave_Heading {

        private $params;

        function __construct() {
            $this->initParams();
            add_action('vc_before_init', array($this, 'heading_init'));
            add_shortcode('inwave_heading', array($this, 'inwave_heading_shortcode'));
        }

        function initParams() {
            global $iw_shortcodes;
            $this->params = array(
                'name' => 'Heading',
                'description' => __('Add a heading & some information', 'inwavethemes'),
                'base' => 'inwave_heading',
                'category' => 'Custom',
                'icon' => 'iw-default',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "span",
                        "heading" => __("Title", "inwavethemes"),
                        "description" => __("You can add |TEXT_EXAMPLE| to specify strong words, {TEXT_EXAMPLE} to specify colorful words", "inwavethemes"),
                        "value" => "",
                        "param_name" => "title"
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Sub Title", "inwavethemes"),
                        "value" => "",
                        "param_name" => "sub_title"
                    ),
                    array(
                        'type' => 'textarea',
                        "heading" => __("Content Below", "inwavethemes"),
                        "value" => "",
                        "param_name" => "content"
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => __("Heading type", "inwavethemes"),
                        "param_name" => "heading_type",
                        "value" => array(
                            "default" => "",
                            "h1" => "h1",
                            "h2" => "h2",
                            "h3" => "h3",
                            "h4" => "h4",
                            "h5" => "h5",
                            "h6" => "h6",
                        ),
                        "description" => __("Select heading type.", "inwavethemes")
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "class" => "",
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1 - Normal" => "style1",
                            "Style 2 - Dark bg" => "style2",
                            "Style 3 - Small" => "style3",
                            "Style 4 - Underline" => "style4",
							"Style 5 - Underline Left" => "style5"

                        )
                    ),
                    array(
                        'type' => 'textfield',
                        "group" => "Style",
                        "heading" => __("Font Size", "inwavethemes"),
                        "value" => "",
                        "description" => __('Custom font-size for heading title. Example 16px', "inwavethemes"),
                        "param_name" => "font_size"
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "class" => "",
                        "heading" => "Text align",
                        "param_name" => "align",
                        "value" => array(
                            "Default" => "",
                            "Left" => "left",
                            "Right" => "right",
                            "Center" => "center"
                        )
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __( 'CSS box', 'js_composer' ),
                        'param_name' => 'css',
                        // 'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
                        'group' => __( 'Design Options', 'js_composer' )
                    )
                )
            );
            $iw_shortcodes['inwave_heading'] = $this->params;
        }

        function heading_init() {
            if (function_exists('vc_map')) {
                // Add banner addon
                vc_map($this->params);
            }
        }

        // Shortcode handler function for list Icon
        function inwave_heading_shortcode($atts, $content = null) {
            $output = $title = $sub_title = $heading_type = $align = $class = $style = $font_size = '';
            $content = preg_replace('/^\<\/p\>(.*)\<p\>$/Usi','$1',$content);
            extract(shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'heading_type' => 'h3',
                'style' => 'style1',
                'font_size' => '',
                'align' => '',
                'css' => '',
                'class' => ''
                            ), $atts));
            $class .= ' '.$style.' '. vc_shortcode_custom_css_class( $css);

            if($align){
                $class.= ' '.$align.'-text';
            }
            $extracss = '';
            if($font_size){
                $extracss = 'style="font-size:'.$font_size.'"';
            }
            $title= preg_replace('/\|(.*)\|/isU','<strong>$1</strong>',$title);
            $title= preg_replace('/\{(.*)\}/isU','<span class="theme-color">$1</span>',$title);

            $sub_title= preg_replace('/\|(.*)\|/isU','<strong>$1</strong>',$sub_title);
            $sub_title= preg_replace('/\{(.*)\}/isU','<span class="theme-color">$1</span>',$sub_title);
            if(!$heading_type){
                $heading_type = 'h3';
            }
            switch ($style) {
                // Normal style
                case 'style1':
                case 'style2':
                case 'style3':
                case 'style4':
                    $output .= '<div class="iw-heading ' . $class . '">';
                    if ($sub_title) {
                        $output .= '<div class="iwh-sub-title">' . $sub_title . '</div>';
                    }
                    $output .= '<' . $heading_type . ' class="iwh-title" '.$extracss.'>' . $title . '</' . $heading_type . '>';
                    if ($content) {
                        $output .= '<p class="iwh-content">' . $content . '</p>';
                    }
                    $output .= '</div>';
                break;
				case 'style5':
                    $output .= '<div class="iw-heading ' . $class . '">';
                    if ($sub_title) {
                        $output .= '<div class="iwh-sub-title">' . $sub_title . '</div>';
                    }
                    $output .= '<' . $heading_type . ' class="iwh-title" '.$extracss.'>' . $title . '</' . $heading_type . '>';
                    if ($content) {
                        $output .= '<p class="iwh-content">' . $content . '</p>';
                    }
                    $output .= '</div>';
                break;
            }
            return $output;
        }
    }
}

new Inwave_Heading;
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_Inwave_Heading extends WPBakeryShortCode {
        
    }

}