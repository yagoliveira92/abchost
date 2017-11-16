<?php

/*
 * @package Inwave Athlete
 * @version 1.0.0
 * @created Mar 30, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of athlete_map
 *
 * @Developer duongca
 */
if (!class_exists('Athlete_Map')) {

    class Athlete_Map {

        private $params;
        private $scripts;

        function __construct() {
            $this->initParams();

            add_action('vc_before_init', array($this, 'heading_init'));

            add_action('wp_enqueue_scripts', array($this, 'athlete_map_scripts'));
            add_shortcode('athlete_map', array($this, 'athlete_map_shortcode'));
        }

        function initParams() {
            global $iw_shortcodes;
            $this->params = array(
                'name' => 'Map',
                'description' => __('Display a Google Map', 'inwavethemes'),
                'base' => 'athlete_map',
                 'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "Map",
                        "param_name" => "title",
                        "description" => __('Title of map block.', "inwavethemes")
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "heading" => __("Latitude", "inwavethemes"),
                        "param_name" => "latitude",
                        "value" => "40.6700",
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "heading" => __("Longitude", "inwavethemes"),
                        "param_name" => "longitude",
                        "value" => "-73.9400",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Zoom", "inwavethemes"),
                        "param_name" => "zoom",
                        "value" => "11",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Map width", "inwavethemes"),
                        "param_name" => "width",
                        "value" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Map height", "inwavethemes"),
                        "param_name" => "height",
                        "value" => "400px",
                        "description"=> __("Example: 400px", "inwavethemes"),
                    ),
                    array(
                        "type" => "textfield",
                        "group" => "marker",
                        "heading" => __("Title", "inwavethemes"),
                        "param_name" => "marker_title",
                    ),
                    array(
                        "type" => "attach_image",
                        "group" => "marker",
                        "heading" => __("Image", "inwavethemes"),
                        "param_name" => "marker_image",
                    ),
                    array(
                        "type" => "textarea",
                        "group" => "marker",
                        "heading" => __("Info", "inwavethemes"),
                        "param_name" => "info",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    )
                )
            );
            $iw_shortcodes['athlete_map'] = $this->params;
            $iw_shortcodes['athlete_map_script'] = $this->scripts;
        }

        function heading_init() {

            // Add banner addon
            if (function_exists('vc_map')) {
                vc_map($this->params);
            }
        }

        function athlete_map_scripts() {

            $theme_info = wp_get_theme();
            wp_register_script('google-maps', 'https://maps.googleapis.com/maps/api/js', array('jquery'), $theme_info->get('Version'));
            wp_register_script('athlete-map-script', plugins_url() . '/iw_composer_addons/assets/js/athlete_map.js', array('jquery'), $theme_info->get('Version'));
        }

        // Shortcode handler function for list Icon
        function athlete_map_shortcode($atts, $content = null) {
            extract(shortcode_atts(array(
                'title' => '',
                'latitude' => '40.6700',
                'longitude' => '-73.9400',
                'marker_title' => 'inwavethemes',
                'marker_image' => '',
                'width' => '',
                'height' => '400px',
                'zoom' => '11',
                'info' => '',
                'class' => ''
                            ), $atts));
            $img = wp_get_attachment_image_src($marker_image, 'large');
            $img = $img[0];
            if($height){
                $height = 'style="height:'.$height.'"';
            }
            $html = '<div class="contact-map ' . $class . '">';
            $html .= '<div class="map-contain" data-title="' . $marker_title . '" data-image="' . $img . '" data-lat="' . $latitude . '" data-long="' . $longitude . '" data-zoom="' . $zoom . '" data-info="' . $info . '"><div class="map-view map-frame" '.$height.'></div></div>';
            $html .='</div>';
            wp_enqueue_script('google-maps');
            wp_enqueue_script('athlete-map-script');
            return $html;
        }

    }

}

$athlete_Map = new Athlete_Map();
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_Athlete_Map extends WPBakeryShortCode {
        
    }

}