<?php

/*
 * Inwave_Tabs for Visual Composer
 */
if (!class_exists('Inwave_Tabs')) {

    class Inwave_Tabs {

        private $tabs;
        private $tab_item;
        private $layout;
        private $first_item;
        private $scripts;
        private $full_width;

        function __construct() {
            $this->initParams();
            // action init
            add_action('vc_before_init', array($this, 'tabs_init'));
            // action shortcode
            add_shortcode('inwave_tabs', array($this, 'inwave_tabs_shortcode'));
            add_shortcode('inwave_tab_item', array($this, 'inwave_tab_item_shortcode'));
        }

        function initParams() {
            global $iw_shortcodes;
            $this->tabs = array(
                "name" => __("Tabs", 'inwavethemes'),
                "base" => "inwave_tabs",
                "content_element" => true,
                'category' => 'Custom',
                "description" => __("Add a set of tabs and give some custom style.", "inwavethemes"),
                "as_parent" => array('only' => 'inwave_tab_item'),
                "show_settings_on_create" => true,
                "js_view" => 'VcColumnView',
                'icon' => 'iw-default',
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "class" => "iw-tabs-style",
                        "heading" => "Style",
                        "param_name" => "layout",
                        "value" => array(
                            "Tab - Style 1" => "layout1",
                            "Tab - Style 2" => "layout2",
                            "Tab - Style 3" => "layout3",
                            "Tab - Style 4" => "layout31",
                            "Tab - Style 5" => "layout32",
                            "Tab - Style 6" => "layout33",
                            "Tab - Style 7" => "layout34",
                            "Accordions - Style 1" => "layout4",
                            "Accordions - Style 2" => "layout5",
                            "Accordions - Style 3" => "layout6",
                            "Accordions - Style 4" => "layout7",
                            "Accordions - Style 5" => "layout8",
                            "Accordions - Style 6" => "layout9",
                            "Accordions - Question & Answers" => "layout10",
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Effect",
                        "param_name" => "effect",
                        "value" => array(
                            "Fade Slide" => "fade-slide",
                            "Horizontal Slide" => "horizontal-slide",
                            "Vertical Slide" => "vertical-slide"
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
            $this->tab_item = array(
                "name" => __("Tab Container", 'inwavethemes'),
                "base" => "inwave_tab_item",
                "content_element" => true,
                'icon' => 'iw-default',
                'category' => 'Custom',
                "description" => __("Add a set of tabs and give some custom style.", "inwavethemes"),
                "show_settings_on_create" => true,
                "as_child" => array('only' => 'inwave_tabs'),
                "as_parent" => array('except' => 'inwave_tabs,inwave_tab_item'),
                "js_view" => 'VcColumnView',
                "params" => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "This is title",
                        "param_name" => "title"
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Sub Title", "inwavethemes"),
                        "value" => "This is sub title",
                        "param_name" => "sub_title"
                    ),
                    array(
                        'type' => 'iwicon',
                        "heading" => __("Tab Icon", "inwavethemes"),
                        "param_name" => "icon"
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
            $iw_shortcodes['inwave_tabs'] = $this->tabs;
            $iw_shortcodes['inwave_tab_item'] = $this->tab_item;
            $iw_shortcodes['inwave_tabs_script'] = $this->scripts;
            $iw_shortcodes['inwave_tab_item_script'] = $this->scripts;
        }

        /** define params */
        function tabs_init() {
            if (function_exists('vc_map')) {
                // Add infor list
                vc_map($this->tabs);
                // Add infor list
                vc_map($this->tab_item);
            }
        }

        // Shortcode handler function for list
        function inwave_tabs_shortcode($atts, $content = null) {
            $output = $class = '';
            $id = 'iwt-' . rand(10000, 99999);
            extract(shortcode_atts(array(
                "class" => "",
                "effect" => "fade-slide",
                'layout' => 'layout1'
                            ), $atts));
            $this->layout = $layout;
            $this->first_item = true;
            $class .= ' '.$effect;
            $output .= '<div id="' . $id . '" class="iw-tabs ' . $class . ' ' . $layout . '">';
            $matches = array();
            $count = preg_match_all('/\[inwave_tab_item\s+title="([^\"]+)"(.*)\]/Usi', $content, $matches);
            if ($layout == 'layout1' || $layout == 'layout2' || $layout == 'layout3' || $layout == 'layout31' || $layout == 'layout32' || $layout == 'layout33' || $layout == 'layout34'
            ) {
                $type = 'tab';
                $this->full_width = false;
                if ($layout == 'layout32' || $layout == 'layout33' || $layout == 'layout34') {
                    $this->full_width = true;
                }
                if ($layout == 'layout34') {
                    $output .= '<div class="iw-tab-content">';
                    $output .= '<div class="iw-tab-content-inner">';
                    $output .= do_shortcode($content);
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '<div style="clear:both;"></div>';
                }
                $output.= '<div class="iw-tab-items">';
                if ($count) {
                    if ($this->full_width) {
                        $output .='<div class="container">';
                    }
                    foreach ($matches[1] as $key => $value) {
                        $output.= '<div class="iw-tab-item ' . ($key == 0 ? 'active' : '') . '" ' . ($this->full_width ? 'style="width: ' . (100 / $count) . '%;"' : '') . '>';
                        $output.= '<div class="iw-tab-item-inner">';
                        preg_match('/\icon=\"([^\"]+)\"/Usi', $matches[2][$key], $match);
                        if (count($match)) {
                            $output.= '<span class="iw-tab-icon"><i class="' . $match[1] . '"></i></span>';
                        }
                        $output.= '<div class="iw-tab-title"><span>' . $value . '</span></div>';
                        preg_match('/\s+sub_title=\"([^\"]+)\"/Usi', $matches[2][$key], $sub_title);
                        if (count($sub_title)) {
                            $output.= '<div class="iw-tab-subtitle">' . $sub_title[1] . '</div>';
                        }
                        $output.= '</div>';
                        $output.= '</div>';
                    }
                    if ($this->full_width) {
                        $output .='</div>';
                    }
                }
                $output .= '</div>';
                if ($layout != 'layout34') {
                    $output .= '<div class="iw-tab-content">';
                    $output .= '<div class="iw-tab-content-inner">';
                    $output .= do_shortcode($content);
                    $output .= '</div>';
                    $output .= '</div>';
                }
            } else {
                $type = 'accordion';
                $output .= do_shortcode($content);
            }
            $output .= '<div style="clear:both;"></div>';
            $output .= '</div>';
            $output .= '<script type="text/javascript">';
            $output .= '(function($){';
            $output .= '$(document).ready(function(){';
            $output .= '$("#' . $id . '").iwTabs("' . $type . '");';
            $output .= '});';
            $output .= '})(jQuery);';
            $output .= '</script>';
            return $output;
        }

        // Shortcode handler function for item
        function inwave_tab_item_shortcode($atts, $content = null) {
            $output = $icon = $title = $sub_title = $description = $class = '';
            $content = do_shortcode($content);
            $content = preg_replace('/^\<\/p\>(.*)\<p\>$/Usi', '$1', $content);

            extract(shortcode_atts(array(
                'icon' => '',
                'title' => '',
                'sub_title' => '',
                'class' => ''
                            ), $atts));

            if ($this->layout == 'layout1' || $this->layout == 'layout2' || $this->layout == 'layout3' || $this->layout == 'layout31' || $this->layout == 'layout32' || $this->layout == 'layout33' || $this->layout == 'layout34'
            ) {
                $output .= '<div class="iw-tab-item-content ' . ($this->first_item ? 'active' : 'next') . ' ' . $class . '">';
                if ($this->full_width && $this->layout != 'layout33') {
                    $output .= '<div class="container">';
                }
                $output .= $content;
                if ($this->full_width && $this->layout != 'layout33') {
                    $output .= '</div>';
                }
                $output .= '</div>';
                if ($this->first_item) {
                    $this->first_item = false;
                }
            } else {
                $output .= '<div class="iw-accordion-item ' . $class . '">';
                $output .= '<div class="iw-accordion-header ' . ($this->first_item ? 'active' : '') . '">';
                if ($icon && $this->layout == 'layout33') {
                    $output.= '<span class="iw-accordion-icon"><i class="' . $icon . '"></i></span>';
                }
                $output.= '<div class="iw-accordion-title"><span>' . $title . '</span></div>';
                $output.= '<span class="iw-accordion-header-icon">';
                switch ($this->layout) {
                    case 'layout4':
                    case 'layout7':
                        if ($this->first_item) {
                            $output .= '<i class="fa fa-plus no-expand" style="display:none;"></i>';
                            $output .= '<i class="fa fa-minus expand"></i>';
                        } else {
                            $output .= '<i class="fa fa-plus no-expand"></i>';
                            $output .= '<i class="fa fa-minus expand" style="display:none;"></i>';
                        }
                        break;
                    case 'layout5':
                        if ($this->first_item) {
                            $output .= '<i class="fa fa-check no-expand" style="display:none;"></i>';
                            $output .= '<i class="fa fa-check expand"></i>';
                        } else {
                            $output .= '<i class="fa fa-check no-expand"></i>';
                            $output .= '<i class="fa fa-check expand" style="display:none;"></i>';
                        }
                        break;
                    case 'layout6':
                        if ($this->first_item) {
                            $output .= '<i class="fa fa-check-circle-o no-expand" style="display:none;"></i>';
                            $output .= '<i class="fa fa-check-circle-o expand"></i>';
                        } else {
                            $output .= '<i class="fa fa-check-circle-o no-expand"></i>';
                            $output .= '<i class="fa fa-check-circle-o expand" style="display:none;"></i>';
                        }
                        break;
                    case 'layout8':
                    case 'layout9':
                        if ($this->first_item) {
                            $output .= '<i class="fa fa-plus-circle no-expand" style="display:none;"></i>';
                            $output .= '<i class="fa fa-minus-circle expand"></i>';
                        } else {
                            $output .= '<i class="fa fa-plus-circle no-expand"></i>';
                            $output .= '<i class="fa fa-minus-circle expand" style="display:none;"></i>';
                        }
                        break;
                    case 'layout10':
                        if ($icon) {
                            $output.= '<span class="iw-faq-icon"><i class="' . $icon . '"></i></span>';
                        } else {
                            $output .= '<span class="iw-faq-text">Q</span>';
                        }
                        break;

                    default:
                        break;
                }
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

new Inwave_Tabs;
if (class_exists('WPBakeryShortCodesContainer')) {

    class WPBakeryShortCode_Inwave_Tabs extends WPBakeryShortCodesContainer {
        
    }

}
if (class_exists('WPBakeryShortCodesContainer')) {

    class WPBakeryShortCode_Inwave_Tab_Item extends WPBakeryShortCodesContainer {
        
    }

}