<?php

/*
 * Inwave_Info_List for Visual Composer
 */
if (!class_exists('Inwave_Info_List')) {

    class Inwave_Info_List {

        private $style = '';
        private $params1;
        private $params2;

        function __construct() {
            $this->initParams();
            // action init
            add_action('vc_before_init', array($this, 'info_list_init'));

            // action shortcode
            add_shortcode('inwave_info_list', array($this, 'inwave_info_list_shortcode'));
            add_shortcode('inwave_info_item', array($this, 'inwave_info_item_shortcode'));
        }

        function initParams() {
            global $iw_shortcodes;
            $this->params1 = array(
                "name" => __("Info List", 'inwavethemes'),
                "base" => "inwave_info_list",
                "content_element" => true,
                'category' => 'Custom',
                'icon' => 'iw-default',
                "description" => __("Add a set of list info and give some custom style.", "inwavethemes"),
                "as_parent" => array('only' => 'inwave_info_item'),
                "show_settings_on_create" => true,
                "js_view" => 'VcColumnView',
                "params" => array(
                    array(
                        "type" => "textfield",
                        "class" => "",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "value" => "",
                        "description" => __("Write your own CSS and mention the class name here.", "inwavethemes"),
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
                            "Style 3" => "style3"
                        )
                    )
                )
            );
            $this->params2 = array(
                "name" => __("Info Item", 'inwavethemes'),
                "base" => "inwave_info_item",
                "class" => "inwave_info_item",
                'icon' => 'iw-default',
                'category' => 'Custom',
                "description" => __("Add a information block and give some custom style.", "inwavethemes"),
                "show_settings_on_create" => true,
                "params" => array(

                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "This is title",
                        "param_name" => "title"
                    ),
                    array(
                        "type" => "textarea_html",
                        "heading" => "Description",
                        "param_name" => "content",
                        "value" => ""
                    ),
                    array(
                        "type" => "iwicon",
                        "class" => "",
                        "heading" => __("Select Icon", "inwavethemes"),
                        "param_name" => "icon",
                        "value" => "",
                        "admin_label" => true,
                        "description" => __("Click and select icon of your choice. You can get complete list of available icons here: <a target='_blank' href='http://fortawesome.github.io/Font-Awesome/icons/'>Font-Awesome</a>", "inwavethemes"),
                    ),
					array(
                        'type' => 'attach_image',
                        "heading" => __("Icon Image", "inwavethemes"),
                        "param_name" => "img",
						"description" => __("Use for style 4", "inwavethemes"),
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Icon Size", "inwavethemes"),
                        "param_name" => "icon_size",
                        "description" => __("Example: 70", "inwavethemes"),
                        "value" => "70"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Link", "inwavethemes"),
                        "param_name" => "link",
                        "value" => ""
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
                            "Style 3" => "style3",
                            "Style 4" => "style4",
							"Style 5" => "style5",
							"Style 6" => "style6",
							"Style 7" => "style7",
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "class" => "",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "value" => "",
                        "description" => __("Write your own CSS and mention the class name here.", "inwavethemes"),
                    ),
                )
            );
            $iw_shortcodes['inwave_info_list'] = $this->params1;
            $iw_shortcodes['inwave_info_item'] = $this->params2;
        }

        /** define params */
        function info_list_init() {
            if (function_exists('vc_map')) {
                // Add Info list
                vc_map($this->params1);
                // Add Info list
                vc_map($this->params2);
            }
        }

        // Shortcode handler function for list
        function inwave_info_list_shortcode($atts, $content = null) {
            $class = $style = '';
            extract(shortcode_atts(array(
                "class" => "",
                "style" => "style1"
                            ), $atts));
            $this->style = $style;

            $class .= ' '. $style;

            $output = '<div class="info-list ' . $class . '">';
            $output .= do_shortcode($content);
            $output .= '</div>';
            return $output;
        }

        // Shortcode handler function for item
        function inwave_info_item_shortcode($atts, $content = null) {

            $output = $style = $icon = $icon_size = $title = $class = $img_tag = '';
            $description = preg_replace('/^\<\/p\>(.*)\<p\>$/Usi','$1',$content);
            extract(shortcode_atts(array(
                'icon' => '',
                'icon_size' => '70',
                'title' => '',
                'img' => '',
                'style' => 'style1',
                'link' => '',
                'class' => ''
                            ), $atts));
            $class .= ' '. $style;
			
			if ($img) {
                $img = wp_get_attachment_image_src($img, 'large');
                $img = $img[0];
                $size = '';
                if ($icon_size) {
                    $size = 'style="width:' . $icon_size . 'px!important;"';
                }
                $img_tag .= '<img ' . $size . ' src="' . $img . '" alt="' . $title . '">';
            }
            switch ($style) {
                case 'style1':
                    $output .= '<div class="info-item ' . $class . '">';
                    if ($icon) {
                        if($link) {
                            $output .= '<div class="icon"><a href="' . $link . '"><i style="font-size:' . $icon_size . 'px" class="theme-color ' . $icon . '"></i></a></div>';
                        }else{
                            $output .= '<div class="icon"><i style="font-size:'.$icon_size.'px" class="theme-color ' . $icon . '"></i></div>';
                        }
                    }
                    $output .= '<div class="info-item-content">';
                    if ($title) {
                        if($link) {
                            $output .= '<h4 class="info-item-title"><a href="' . $link . '">' . $title . '</a></h4>';
                        }else{
                            $output .= '<h4 class="info-item-title">' . $title . '</h4>';
                        }
                    }
                    $output .= '<div class="info-item-desc">' . $description . '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    break;
                case 'style2':
                    $output .= '<div class="info-item ' . $class . '">';
                    if ($icon) {
                        if($link){
                            $output .= '<div class="icon"><a href="' . $link . '"><i class="theme-color ' .  $icon . '"></i></a></div>';
                        }else{
                            $output .= '<div class="icon"><i class="theme-color ' .  $icon . '"></i></div>';
                        }
                    }
                    $output .= '<div class="info-item-content">';
                    if ($title) {
                        if($link){
                            $output .= '<h4 class="theme-color info-item-title"><a href="' . $link . '">' . $title . '</a></h4>';
                        }
                        else{
                            $output .= '<h4 class="theme-color info-item-title">' . $title . '</h4>';
                        }
                    }
                    $output .= '<div class="info-item-desc">' . $description . '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                break;
				
					case 'style4':
                    $output .= '<div class="info-item ' . $class . '">';
                    if ($img_tag) {
                        if($link) {
                            $output .= '<div class="icon_img"><a href="' . $link . '">'.$img_tag.'</a><h4 class="info-item-title">' . $title . '</h4></div>';
                        }else{
                            $output .= '<div class="icon_img">'.$img_tag.'<h4 class="info-item-title">' . $title . '</h4></div>';
                        }
                    }
                    $output .= '<div class="info-item-content">';
                    $output .= '<div class="info-item-desc">' . $description . '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    break;
				
				case 'style5':
                    $output .= '<div class="info-item ' . $class . '">';
                    if ($icon) {
                        if($link){
                            $output .= '<div class="icon theme-color"><a href="' . $link . '"><i style="font-size:' . $icon_size . 'px" class="' .  $icon . '"></i></a></div>';
                        }else{
                            $output .= '<div class="icon theme-color"><i style="font-size:' . $icon_size . 'px" class="' .  $icon . '"></i></div>';
                        }
                    }
                    $output .= '<div class="info-item-content">';
                    if ($title) {
                        if($link){
                            $output .= '<h4 class="info-item-title"><a href="' . $link . '">' . $title . '</a></h4>';
                        }
                        else{
                            $output .= '<h4 class="info-item-title">' . $title . '</h4>';
                        }
                    }
                    $output .= '<div class="info-item-desc">' . $description . '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                break;
				
				case 'style6':
					$output .= '<div class="info-item'.$class.'">';
					if ($icon) {
						$output .= '<div class="info-item-icon theme-color" style="font-size:'.$icon_size.'px"><i  class="' . $icon . '"></i></div>';
					}
					$output .= '<div class="info-item-body">';
					if ($title) {
						if($link) {
							$output .= '<h3 class="info-item-title"><a href="'.$link.'">'.$title.'</a></h3>';
						} else {
							$output .= '<h3 class="info-item-title">'.$title.'</h3>';
						}
					}
					$output .= '<div class="info-item-desc">' . $description . '</div>';
					$output .= '</div>';
					$output .= '<div style="clear:both;"></div></div>';
				break;
				case 'style7':
					$output .= '<div class="info-item'.$class.'">';
					if ($icon) {
						$output .= '<div class="info-item-icon theme-bg" style="font-size:'.$icon_size.'px"><i  class="' . $icon . '"></i></div>';
					}
					$output .= '<div class="info-item-body">';
					if ($title) {
						if($link) {
							$output .= '<h3 class="info-item-title theme-color"><a href="'.$link.'">'.$title.'</a></h3>';
						} else {
							$output .= '<h3 class="info-item-title theme-color">'.$title.'</h3>';
						}
					}
					$output .= '<div class="info-item-desc">' . $description . '</div>';
					$output .= '</div>';
					$output .= '<div style="clear:both;"></div></div>';
				break;
				
                default:
                    $output .= '<div class="info-item style2 ' . $class . '">';
                    if ($icon) {
                        if($link) {
                            $output .= '<div class="icon"><a href="' . $link . '"><i style="font-size:' . $icon_size . 'px" class="' . $icon . '"></i></a></div>';
                        }else{
                            $output .= '<div class="icon"><i style="font-size:'.$icon_size.'px" class="' . $icon . '"></i></div>';
                        }
                    }
                    $output .= '<div class="info-item-content">';
                    if ($title) {
                        if($link) {
                            $output .= '<h4 class="info-item-title"><a href="' . $link . '">' . $title . '</a></h4>';
                        }else{
                            $output .= '<h4 class="info-item-title">' . $title . '</h4>';
                        }
                    }
                    $output .= '<div class="info-item-desc">' . $description . '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                break;
            }
            return $output;
        }
    }
}

new Inwave_Info_List;
if (class_exists('WPBakeryShortCodesContainer')) {

    class WPBakeryShortCode_Inwave_Info_List extends WPBakeryShortCodesContainer {
        
    }

}
