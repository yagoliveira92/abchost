<?php
/*
 * @package Inwave Event
 * @version 1.0.0
 * @created Jun 8, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */


/**
 * Description of iw_slider
 *
 * @developer duongca
 */
if (!class_exists('Inwave_Slider')) {

    class Inwave_Slider {

        private $params;
        private $params2;
        private $count;

        function __construct() {
            $this->initParams();
            add_action('vc_before_init', array($this, 'heading_init'));
            add_shortcode('inwave_slider', array($this, 'inwave_slider_shortcode'));
            add_shortcode('inwave_slider_item', array($this, 'inwave_slider_item_shortcode'));
        }

        function initParams() {
            global $iw_shortcodes;
            $this->count = 0;

            $this->params = array(
                "name" => __("Inwave Slider", 'inwavethemes'),
                "base" => "inwave_slider",
                "content_element" => true,
                'category' => 'Custom',
                "description" => __("Add a set of list item.", "inwavethemes"),
                "as_parent" => array('only' => 'inwave_slider_item'),
                "show_settings_on_create" => true,
                "js_view" => 'VcColumnView',
                'icon' => 'iw-default',
                "params" => array(
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

            $this->params2 = array(
                "name" => __("Inwave Slider Item", 'inwavethemes'),
                "base" => "inwave_slider_item",
                "class" => "inwave_slider_item",
                "icon" => "inwave_slider_item",
                'icon' => 'iw-default',
                'category' => 'Custom',
                "as_child" => array('only' => 'inwave_slider'),
                "description" => __("Add a information block and give some custom style.", "inwavethemes"),
                "show_settings_on_create" => true,
                "params" => array(
                    array(
                        'type' => 'textarea_html',
                        "heading" => __("Slide content", "inwavethemes"),
                        "param_name" => "content"
                    )
                )
            );
            $iw_shortcodes['inwave_slider'] = $this->params;
            $iw_shortcodes['inwave_slider_item'] = $this->params2;
        }

        function heading_init() {
            if (function_exists('vc_map')) {
                vc_map($this->params);
                vc_map($this->params2);
            }
        }

        // Shortcode handler function for list Icon
        function inwave_slider_shortcode($atts, $content = null) {
            extract(shortcode_atts(array(
                "class" => ""
                            ), $atts));

            $output = '<div class="iw-slider-block ' . $class . '">';
            $output .= '<div class="dg-container fit-video">';
            $output .= '<div class="dg-wrapper">';
            $output .= do_shortcode($content);
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '<script type="text/javascript">';
            $output .= 'jQuery(document).ready(function () {';
            $output .= 'jQuery(".dg-container").gallery();';
            $output .= '});';
            $output .= '</script>';
            return $output;
        }

        function inwave_slider_item_shortcode($atts, $content = null) {
            ob_start();
            ?>
            <div class="item item<?php echo $this->count++;?>">
                <div class="browser-frame"></div>
                <?php
                echo do_shortcode($content);
                ?>
            </div>
            <?php
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }

    }

}

new Inwave_Slider();
if (class_exists('WPBakeryShortCodesContainer')) {

    class WPBakeryShortCode_Inwave_Slider extends WPBakeryShortCodesContainer {
        
    }

}
