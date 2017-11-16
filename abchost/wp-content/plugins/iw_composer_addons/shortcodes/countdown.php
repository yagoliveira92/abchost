<?php

/*
 * Inwave_Heading for Visual Composer
 */
if (!class_exists('Inwave_Countdown')) {

    class Inwave_Countdown {

        private $params;
        private $scripts;

        function __construct() {
            $this->initParams();
            add_action('vc_before_init', array($this, 'heading_init'));
            add_shortcode('inwave_countdown', array($this, 'inwave_countdown_shortcode'));
            add_action('wp_enqueue_scripts', array($this, 'add_scripts'));
//            add_action('admin_enqueue_scripts', array($this, 'add_scripts'));
        }

        function add_scripts() {
            getShortcodeScript($this->scripts);
        }

        function initParams() {
            global $iw_shortcodes;
            $this->scripts = array('scripts'=>array('cdtime'=>plugins_url('iw_composer_addons/assets/js/cdtime.js')));
            $this->params = array(
                'name' => 'Countdown timer',
                'description' => __('Schedule a countdown until a time in the future', 'inwavethemes'),
                'base' => 'inwave_countdown',
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Time to end:", "inwavethemes"),
                        'description' => __('Example: February 24, 2017 00:00:00', 'inwavethemes'),
                        "value" => "February 24, 2016",
                        "param_name" => "end_date"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    )
                )
            );
            $iw_shortcodes['inwave_countdown'] = $this->params;
        }

        function heading_init() {
            // Add banner addon
            if (function_exists('vc_map')) {
                vc_map($this->params);
            }
        }

        // Shortcode handler function for list Icon
        function inwave_countdown_shortcode($atts, $content = null) {
            $output = $end_date = $class = '';
            extract(shortcode_atts(array(
                'end_date' => '',
                'class' => ''
                            ), $atts));

            $output .= '<span class="defaultCountdown ' . $class . '" data-enddate="' . esc_attr($end_date) . '">';
            $output .= '</span >';
            return $output;
        }

    }

}

new Inwave_Countdown;
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_Inwave_Countdown extends WPBakeryShortCode {
        
    }

}    