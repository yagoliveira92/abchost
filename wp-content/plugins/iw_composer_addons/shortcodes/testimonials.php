<?php

/*
 * @package Inwave Inhost
 * @version 1.0.0
 * @created May 5, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of testimonials
 *
 * @developer duongca
 */
if (!class_exists('Inwave_Testimonials')) {

    class Inwave_Testimonials {

        private $testimonials;
        private $testimonial_item;
        private $has_parent;
        private $scripts;

        function __construct() {
            $this->initParams();
            // action init
            add_action('vc_before_init', array($this, 'testimonials_init'));
            add_action('wp_enqueue_scripts', array($this, 'inwave_testimonials_scripts'));
            // action shortcode
            add_shortcode('inwave_testimonials', array($this, 'inwave_testimonials_shortcode'));
            add_shortcode('inwave_testimonial_item', array($this, 'inwave_testimonial_item_shortcode'));
        }

        function inwave_testimonials_scripts() {
            getShortcodeScript($this->scripts);
        }

        function initParams() {
            global $iw_shortcodes;
            $this->scripts = array(
                'scripts' => array('iw-testimonials' => plugins_url('iw_composer_addons/assets/js/iw-testimonials.js')),
                'styles' => array('iw-testimonials' => plugins_url('iw_composer_addons/assets/css/iw-testimonials.css'))
            );
            $this->testimonials = array(
                "name" => __("Testimonial Slider", 'inwavethemes'),
                "base" => "inwave_testimonials",
                "content_element" => true,
                'category' => 'Custom',
                'icon' => 'iw-default',
                "description" => __("Add a set of testimonial and give some custom style.", "inwavethemes"),
                "as_parent" => array('only' => 'inwave_testimonial_item'),
                "show_settings_on_create" => true,
                "js_view" => 'VcColumnView',
                "params" => array(

                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "class" => "iw-testimonials-style",
                        "heading" => "Style",
                        "param_name" => "layout",
                        "value" => array(
                            "Style 1" => "layout1",
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
            $this->testimonial_item = array(
                "name" => __("Testimonial Item", 'inwavethemes'),
                "base" => "inwave_testimonial_item",
                "class" => "inwave_testimonial_item",
                'icon' => 'iw-default',
                'category' => 'Custom',
                "description" => __("Add a list of testimonials with some content and give some custom style.", "inwavethemes"),
                "show_settings_on_create" => true,
                "params" => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "class" => "iw-testimonial-title iw-hidden",
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "",
                        "param_name" => "title"
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Name", "inwavethemes"),
                        "value" => "This is Name",
                        "param_name" => "name"
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "class" => "iw-testimonial-date",
                        "heading" => __("Date", "inwavethemes"),
                        "value" => "",
                        "param_name" => "date"
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "class" => "iw-testimonial-position iw-hidden",
                        "heading" => __("Position", "inwavethemes"),
                        "value" => "",
                        "param_name" => "position"
                    ),
                    array(
                        "type" => "attach_image",
                        "class" => "iw-testimonial-image",
                        "heading" => __("Client Image", "inwavethemes"),
                        "param_name" => "image",
                        "value" => "",
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "iw-testimonials-rate",
                        "heading" => "Rate",
                        "param_name" => "rate",
                        "value" => array(
                            "Select rate" => "0",
                            "1" => "1",
                            "2" => "2",
                            "3" => "3",
                            "4" => "4",
                            "5" => "5"
                        )
                    ),
                    array(
                        "type" => "textarea",
                        "heading" => "Testimonial Text",
                        "param_name" => "testimonial_text",
                        "value" => "Lorem ipsum dolor sit amet, consectetur adi sollicitudin"
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "class" => "iw-testimonials-style",
                        "heading" => "Style",
                        "param_name" => "layout",
                        "value" => array(
                            "Style 1" => "layout1",
                            "Style 2" => "layout2",
                            "Style 3" => "layout3",
                            "Style 4" => "layout4",
                            "Style 5  - White text" => "layout5",
                            "Style 6" => "layout6",
                            "Style 7" => "layout7",
                            "Style 8" => "layout8",
                            "Style 9" => "layout9",
                            "Style 10" => "layout10"
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "class" => "",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "value" => "",
                        "description" => __("Write your own CSS and mention the class name here.", "inwavethemes"),
                    )
                )
            );
            $iw_shortcodes['inwave_testimonials'] = $this->testimonials;
            $iw_shortcodes['inwave_testimonial_item'] = $this->testimonial_item;
            $iw_shortcodes['inwave_testimonial_item_script'] = $this->scripts;
        }

        /** define params */
        function testimonials_init() {
            if (function_exists('vc_map')) {
                // Add infor list
                vc_map($this->testimonials);
                // Add infor list
                vc_map($this->testimonial_item);
            }
        }

        // Shortcode handler function for list
        function inwave_testimonials_shortcode($atts, $content = null) {
            $output = $class = '';
            //$id = 'iwt-' . rand(10000, 99999);
            extract(shortcode_atts(array(
                "class" => ""
                            ), $atts));
//            $this->has_parent = true;
            $output .= '<div class="iw-testimonals ' . $class . '">';
            $matches = array();

            //$count = preg_match_all('/\[inwave_testimonial_item(?:\s+layout="([^\"]*)"){0,1}(?:\s+title="([^\"]*)"){0,1}(?:\s+name="([^\"]*)"){0,1}(?:\s+date="([^\"]*)"){0,1}(?:\s+position="([^\"]*)"){0,1}(?:\s+image="([^\"]*)"){0,1}(?:\s+rate="([^\"]*)"){0,1}(?:\s+testimonial_text="([^\"]*)"){0,1}(?:\s+class="([^\"]*)"){0,1}\]/i', $content, $matches);
            $count = preg_match_all( '/inwave_testimonial_item([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );


            if ($count) {
                $output.= '<div class="testi-owl-maincontent">';
                $items = array();

                foreach ($matches[1] as $value) {
                    $items[] = shortcode_parse_atts( $value[0] );
                }
                foreach ($items as $key => $item) {
                    $text = html_entity_decode($item['testimonial_text']);
                    $output.= '<div class="iw-testimonial-item ' . ($key == 0 ? 'active' : '') . '">';
                    $output.= '<div class="testi-content">' . $text . '</div>';
                    $output.= '</div>';
                }
                $output.= '</div>';
                $output.= '<div class="testi-owl-clientinfo">';
                foreach ($items as $key => $item) {
                    $name = html_entity_decode($item['name']);
                    $position = html_entity_decode($item['position']);
                    $image = $item['image'];
                    if ($image) {
                        $img = wp_get_attachment_image_src($image);
                        $image = '<img class="grayscale" src="' . $img[0] . '" alt=""/>';
                    }
                    $output.= '<div data-item-active="' . $key . '" class="iw-testimonial-client-item ' . ($key == 0 ? 'active' : '') . '">';
                    $output.= '<div class="testi-image">' . $image . '</div>';
                    $output.= '<div class="testi-client-info">';
                    $output.= '<div class="testi-client-name">' . $name . '</div>';
                    $output.= '<div class="testi-client-position">' . $position . '</div>';
                    $output.= '</div>';
                    $output.= '</div>';
                }
                $output.= '</div>';
            }
            $output .= '</div>';
            $output .= '<div style="clear:both;"></div>';
            $output .= '<script type="text/javascript">';
            $output .= '(function ($) {';
            $output .= '$(document).ready(function () {';
            $output .= '$(".iw-testimonals").iwCarousel();';
            $output .= '});';
            $output .= '})(jQuery);';
            $output .= '</script>';

            return $output;
        }

        // Shortcode handler function for item
        function inwave_testimonial_item_shortcode($atts, $content = null) {
            $output = $layout = $title = $name = $date = $position = $image =  $rate = $testimonial_text = $class = '';
            extract(shortcode_atts(array(
                'layout' => '',
                'title' => '',
                'name' => '',
                'date' => '',
                'position' => '',
                'image' => '',
                'rate' => '',
                'testimonial_text' => '',
                'class' => ''
                            ), $atts));

            if ($this->has_parent) {
                $output .= '<div class="iw-tab-item-content iw-hidden ' . $class . '">';
                $output .= $content;
                $output .= '</div>';
            } else {
                if ($image) {
                    $img = wp_get_attachment_image_src($image);
                    $image = '<img src="' . $img[0] . '" alt=""/>';
                }
                $ht_rate = '';
                if ($rate) {
                    for ($i = 0; $i < 5; $i++) {
                        $ht_rate.='<span' . ($i < $rate ? ' class="active"' : '') . '><i class="fa fa-star"></i></span>';
                    }
                }
                $output .= '<div class="iw-testimonial-item ' . $class . ' ' . $layout . '">';
                switch ($layout) {
                    case 'layout1':
                        $output .= '<div class="testi-col-left">';
                        $output .= '<div class="content">';
                        $output .= '<div class="testi-image">' . $image . '</div>';
                        $output .= '<div class="testi-rate">' . $ht_rate . '</div>';
                        $output .= '</div>';
                        $output .= '</div>';
                        $output .= '<div class="testi-col-right">';
                        $output .= '<div class="testi-name">' . html_entity_decode($name) . '</div>';
                        $output .= '<div class="testi-date">' . $date . '</div>';
                        $output .= '<div class="testi-text">' . html_entity_decode($testimonial_text) . '</div>';
                        $output .= '</div>';
                        break;
                    case 'layout2':
                    case 'layout3':
                        $output .= '<div class="testi-text-content'.($layout =='layout3'?' theme-bg':'').'">';
                        $output .= '<div class="testi-title '.($layout =='layout2'?' theme-color':'').'">' . html_entity_decode($title) . '</div>';
                        $output .= '<div class="testi-content">' . html_entity_decode($testimonial_text) . '</div>';
                        $output .= '<div class="testi-rate">' . $ht_rate . '</div>';
                        $output .= '</div>';
                        $output .= '<div class="testi-client">';
                        $output .= '<div class="testi-image">' . $image . '</div>';
                        $output .= '<div class="testi-client-info">';
                        $output .= '<div class="testi-client-name theme-color">' . html_entity_decode($name) . '</div>';
                        $output .= '<div class="testi-client-position">' . html_entity_decode($position) . '</div>';
                        $output .= '</div>';
                        $output .= '</div>';
                        break;
                    case 'layout4':
                        $output .= '<div class="testi-text-content">';
                        $output .= '<div class="testi-content">' . html_entity_decode($testimonial_text) . '</div>';
                        $output .= '</div>';
                        $output .= '<div class="testi-client">';
                        $output .= '<div class="testi-image">' . $image . '</div>';
                        $output .= '<div class="testi-client-info">';
                        $output .= '<div class="testi-client-name theme-color">' . html_entity_decode($name) . '</div>';
                        $output .= '<div class="testi-client-position">' . html_entity_decode($position) . '</div>';
                        $output .= '</div>';
                        $output .= '</div>';
                        break;
                    case 'layout5':
                        $output .= '<div class="testi-content-wrap">';
                        $output .= '<div class="testi-image-icon"><i class="fa fa-comments"></i></div>';
                        $output .= '<div class="testi-content">' . html_entity_decode($testimonial_text) . '</div>';
                        $output .= '<div class="testi-client">';
                        $output .= '<div class="testi-image">' . $image . '</div>';
                        $output .= '<div class="testi-client-info">';
                        $output .= '<div class="testi-client-name">' . html_entity_decode($name) . '</div>';
                        $output .= '<div class="testi-client-position">' . html_entity_decode($position) . '</div>';
                        $output .= '</div>';
                        $output .= '</div>';
                        $output .= '</div>';
                        break;
                    case 'layout6':
                    case 'layout7':
                    case 'layout8':
                        $output .= '<div class="testi-text-content'.($layout =='layout7'?' theme-bg':'').'">';
                        $output .= '<div class="testi-title theme-color">' . html_entity_decode($title) . '</div>';
                        $output .= '<div class="testi-content">' . html_entity_decode($testimonial_text) . '</div>';
                        $output .= '<div class="testi-client-info">';
                        $output .= '<div class="testi-client-name theme-color">' . html_entity_decode($name) . '</div>';
                        $output .= '<div class="testi-client-position">' . html_entity_decode($position) . '</div>';
                        $output .= '</div>';
                        $output .= '</div>';
                        $output .= '<div class="testi-client">';
                        $output .= '<div class="testi-image">' . $image . '</div>';
                        $output .= '</div>';
                        break;
                    case 'layout9':
                        $output .= '<div class="testi-text-content">';
                        $output .= '<div class="testi-text-content-icon theme-bg"><span><i class="fa fa-quote-left fa-2x"></i></span></div>';
                        $output .= '<div class="testi-title theme-color">' . html_entity_decode($title) . '</div>';
                        $output .= '<div class="testi-content">' . html_entity_decode($testimonial_text) . '</div>';
                        $output .= '<div class="testi-client-info">';
                        $output .= '<div class="testi-client-name theme-color">' . html_entity_decode($name) . '</div>';
                        $output .= '<div class="testi-client-position">' . html_entity_decode($position) . '</div>';
                        $output .= '</div>';
                        $output .= '</div>';
                        break;
                    case 'layout10':
                        $output .= '<div class="testi-text-content">';
                        $output .= '<div class="testi-content">' . html_entity_decode($testimonial_text) . '</div>';
                        $output .= '</div>';
                        $output .= '<div class="testi-client">';
                        $output .= '<div class="testi-image">' . $image . '</div>';
                        $output .= '<div class="testi-client-info">';
                        $output .= '<div class="testi-client-name theme-color">' . html_entity_decode($name) . '</div>';
                        $output .= '<div class="testi-client-position">' . html_entity_decode($position) . '</div>';
                        $output .= '</div>';
                        $output .= '</div>';
                        break;
                    default:
                        break;
                }

                $output .= '<div style="clear: both;"></div>';
                $output .= '</div>';
            }
            return $output;
        }

    }

}

new Inwave_Testimonials;
if (class_exists('WPBakeryShortCodesContainer')) {

    class WPBakeryShortCode_Inwave_Testimonials extends WPBakeryShortCodesContainer {
        
    }

}
