<?php

/*
 * Inwave_Location_map for Visual Composer
 */
if (!class_exists('Inwave_Location_map')) {

    class Inwave_Location_map {

        private $location_map;
        private $location;
        private $layout;
        private $first_item;
        private $scripts;

        function __construct() {
            $this->initParams();
            // action init
            add_action('vc_before_init', array($this, 'location_map_init'));
            // action shortcode
            add_shortcode('inwave_location_map', array($this, 'inwave_location_map_shortcode'));
            add_shortcode('inwave_location', array($this, 'inwave_location_shortcode'));
        }

        function initParams() {
            global $iw_shortcodes;
            $this->location_map = array(
                "name" => __("Location_map", 'inwavethemes'),
                "base" => "inwave_location_map",
                "content_element" => true,
                'category' => 'Custom',
                "description" => __("Show your locations on a map.", "inwavethemes"),
                "as_parent" => array('only' => 'inwave_location'),
                "show_settings_on_create" => true,
                "js_view" => 'VcColumnView',
                'icon' => 'iw-default',
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "class" => "iw-location-map-style",
                        "heading" => "Style",
                        "param_name" => "layout",
                        "value" => array(
                            "Tab - Style 1" => "layout1",
                            "Tab - Style 2" => "layout2",
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
            $this->location = array(
                "name" => __("Location", 'inwavethemes'),
                "base" => "inwave_location",
                "class" => "inwave_location",
                'icon' => 'iw-default',
                'category' => 'Custom',
                "description" => __("Your location with coordinate & description", "inwavethemes"),
                "as_child" => array('only' => 'inwave_location_map'),
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
                        'type' => 'iwicon',
                        "heading" => __("Tab Icon", "inwavethemes"),
                        "param_name" => "icon"
                    ),
                    array(
                        "type" => "textarea_html",
                        "heading" => "Content",
                        "param_name" => "content",
                        "value" => "Lorem ipsum dolor sit amet, consectetur adi sollicitudin"
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
            $iw_shortcodes['inwave_location_map'] = $this->location_map;
            $iw_shortcodes['inwave_location'] = $this->location;
            $iw_shortcodes['inwave_location_map_script'] = $this->scripts;
            $iw_shortcodes['inwave_location_script'] = $this->scripts;
        }

        /** define params */
        function location_map_init() {
            if (function_exists('vc_map')) {
                // Add infor list
                vc_map($this->location_map);
                // Add infor list
                vc_map($this->location);
            }
        }

        // Shortcode handler function for list
        function inwave_location_map_shortcode($atts, $content = null) {
            $output = $class = '';
            $id = 'iwt-' . rand(10000, 99999);
            extract(shortcode_atts(array(
                "class" => "",
                'layout' => 'layout1'
                            ), $atts));
            $this->layout = $layout;
            $this->first_item = true;
            $output .= '<div id="' . $id . '" class="iw-location_map ' . $class . ' ' . $layout . '">';
            $matches = array();
            $count = preg_match_all('/\[inwave_location\s+title="([^\"]+)"(.*)\]/Usi', $content, $matches);
            if ($layout == 'layout1' || $layout == 'layout2' || $layout == 'layout3' || $layout == 'layout31') {
                $type = 'tab';
                $output.= '<div class="iw-tab-items">';
                if ($count) {
                    foreach ($matches[1] as $key => $value) {
                        $output.= '<div class="iw-tab-item ' . ($key == 0 ? 'active' : '') . '">';
                        preg_match('/\icon=\"([^\"]+)\"/Usi', $matches[2][$key], $match);
                        if (count($match)) {
                            $output.= '<span class="iw-tab-icon"><i class="' . $match[1] . '"></i></span>';
                        }
                        $output.= '<div class="iw-tab-title"><span>' . $value . '</span></div>';
                        $output.= '</div>';
                    }
                }
                $output .= '</div>';
                $output .= '<div class="iw-tab-content">';
                $output .= do_shortcode($content);
                $output .= '</div>';
            } else {
                $type = 'accordion';
                $output .= do_shortcode($content);
            }
            $output .= '<div style="clear:both;"></div>';
            $output .= '</div>';
            $output .= '<script type="text/javascript">';
            $output .= '(function($){';
            $output .= '$(document).ready(function(){';
            $output .= '$("#' . $id . '").iwLocation_map("' . $type . '");';
            $output .= '});';
            $output .= '})(jQuery);';
            $output .= '</script>';
            return $output;
        }

        // Shortcode handler function for item
        function inwave_location_shortcode($atts, $content = null) {
            $output = $icon = $title = $sub_title = $description = $class = '';
            $content = do_shortcode($content);
            $content = preg_replace('/^\<\/p\>(.*)\<p\>$/Usi','$1',$content);

            extract(shortcode_atts(array(
                'icon' => '',
                'title' => '',
                'sub_title' => '',
                'class' => ''
                            ), $atts));

            if ($this->layout == 'layout1' || $this->layout == 'layout2' || $this->layout == 'layout3' || $this->layout == 'layout31') {
                $output .= '<div class="iw-tab-item-content iw-hidden ' . $class . '">';
                $output .= $content;
                $output .= '</div>';
            } else {
                $output .= '<div class="iw-accordion-item ' . $class . '">';
                $output .= '<div class="iw-accordion-header ' . ($this->first_item ? 'active' : '') . '">';
                if ($icon) {
//                    $output.= '<span class="iw-accordion-icon"><i class="' . $icon . '"></i></span>';
                }
                $output.= '<div class="iw-accordion-title"><span>' . $title . '</span></div>';
                $output.= '<span class="iw-accordion-header-icon">';
                $output.= '</span>';
                $output .= '</div>';
                $output .= '<div class="iw-accordion-content" ' . ($this->first_item ? '' : 'style="display: none;"') . '>';
                $output .= $content;
                $output .= '</div>';
                $output .= '</div>';
                if ($this->first_item) {
                    $this->first_item = false;
                }
            }
            return $output;
        }

    }

}

new Inwave_Location_map;
if (class_exists('WPBakeryShortCodesContainer')) {

    class WPBakeryShortCode_Inwave_Location_map extends WPBakeryShortCodesContainer {
        
    }

}
