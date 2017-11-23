<?php

/*
 * Inwave_Profile List for Visual Composer
 */
if (!class_exists('Inwave_Profile_Slider')) {

    class Inwave_Profile_Slider {

        private $params;
        private $params1;
        private $count;

        function __construct() {
            $this->initParams();
            add_action('vc_before_init', array($this, 'profile_init'));
            add_shortcode('inwave_profile_slider', array($this, 'inwave_profile_slider_shortcode'));
            add_shortcode('inwave_profile', array($this, 'inwave_profile_item_shortcode'));
        }

        function initParams() {
            global $iw_shortcodes;
            $this->count = 0;

            $this->params = array(
                "name" => __("Inwave Profile Slider", 'inwavethemes'),
                "base" => "inwave_profile_slider",
                "content_element" => true,
                'category' => 'Custom',
                "description" => __("Add a set of list item.", "inwavethemes"),
                "as_parent" => array('only' => 'inwave_profile_item'),
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

            $this->params1 = array(
                'name' => 'Profile Item',
                'description' => __('Show a personal profile', 'inwavethemes'),
                'base' => 'inwave_profile',
                'category' => 'Custom',
                'icon' => 'iw-default',
                "show_settings_on_create" => true,
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Name", "inwavethemes"),
                        "value" => "",
                        "param_name" => "name"
                    ),
                    array(
                        'type' => 'textfield',
                        "heading" => __("Position", "inwavethemes"),
                        "value" => "",
                        "param_name" => "position"
                    ),
                    array(
                        "type" => "textarea_html",
                        "heading" => __("Description", "inwavethemes"),
                        "param_name" => "content",
                        "value" => ""
                    ),
                    array(
                        "type" => "textarea",
                        "heading" => __("Social links", "inwavethemes"),
                        "description" => __("Separated by newline", "inwavethemes"),
                        "param_name" => "social_links",
                        "value" => ""
                    ),
                    array(
                        'type' => 'attach_image',
                        "heading" => __("Profile Image", "inwavethemes"),
                        "param_name" => "img"
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
                            "Style 1" => "style1",
                            "Style 2" => "style2",
                            "Style 3" => "style3",
                            "Style 4" => "style4"
                        )
                    )
                )
            );
            $iw_shortcodes['inwave_profile_slider'] = $this->params;
            $iw_shortcodes['inwave_profile'] = $this->params1;
        }

        function profile_init() {
            if (function_exists('vc_map')) {
                // Add banner addon
                vc_map($this->params);
                vc_map($this->params1);
            }
        }

        function inwave_profile_slider_shortcode($atts, $content = null) {
            extract(shortcode_atts(array(
                "class" => ""
                            ), $atts));

            $output = '<div class="iw-profile-slider-block ' . $class . '">';
            $output .= '<div id="profile_slider" class="dg-container fit-video">';
            $output .= '<div class="dg-wrapper">';
            $output .= do_shortcode($content);
            $output .= '</div>';
            $output .= '<div class="controls">';
            $output .= '<span class="next"><i class="fa fa-chevron-right fa-2x"></i></span>';
            $output .= '<span class="prev"><i class="fa fa-chevron-left fa-2x"></i></span>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '<div class="profile-info-view"></div>';
            $output .= '</div>';
            $output .= '<script type="text/javascript">';
            $output .= 'jQuery(document).ready(function () {';
            $output .= 'jQuery("#profile_slider").gallery();';
            $output .= '});';
            $output .= '</script>';
            return $output;
        }

        // Shortcode handler function for profile box
        function inwave_profile_item_shortcode($atts, $content = null) {
            $output = $img = $name = $position = $class = $description = $social_links = '';
            extract(shortcode_atts(array(
                'img' => '',
                'name' => '',
                'position' => '',
                'class' => '',
                'social_links' => '',
                'style' => 'style1'
                            ), $atts));
            $img_tag = '';
            if ($img) {
                $img = wp_get_attachment_image_src($img, 'large');
                $img = $img[0];
                $size = '';
                $img_tag .= '<img ' . $size . ' src="' . $img . '" alt="' . $name . '">';
            }
            $social_links = str_replace('<br />', "\n", $social_links);
            $social_links = explode("\n", $social_links);
            $description = do_shortcode($content);
            switch ($style) {
                case 'style1':
                    $output .= '<div class="row"><div class="profile-box style1 ' . $class . '">';
                    $output .= '<div class="col-md-6 col-sm-6 col-xs-12"><div class="profile-image">' . $img_tag . '</div></div>';
                    $output .= '<div class="col-md-6 col-sm-6 col-xs-12">';
                    $output .= '<div class="profile-info"><div class="position theme-color">' . $position . '</div><h3 class="name">' . $name . '</h3><div class="description">' . $description . '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div></div>';
                    break;
                case 'style2':
                    $output .= '<div class="profile-box style2 ' . $class . '">';
                    $output .= '<div class="profile-image"><div class="social-links">';
                    foreach ($social_links as $link) {
                        $domain = explode(".com", $link);

                        if ($link && isset($domain[0])) {

                            $domain = str_replace(array('https://', 'http://'), '', $domain[0]);
                            if ($domain == 'plus.google') {
                                $domain = 'google-plus';
                            }

                            $output .= '<a href="' . $link . '"><i class="fa fa-' . $domain . '"></i></a>';
                        }
                    }
                    $output.= '</div>';

                    $output .= '' . $img_tag . '</div>';
                    $output .= '<div class="profile-info"><h3 class="name">' . $name . '</h3><div class="position">' . $position . '</div><div class="description">' . $description . '</div></div>';
                    $output .= '</div>';
                    break;
                case 'style3':
                    $output .= '<div class="profile-box style3 ' . $class . '">';
                    $output .= '<div class="profile-image">' . $img_tag . '';
                    $output .= '<div class="social-links">';
                    foreach ($social_links as $link) {
                        $domain = explode(".com", $link);

                        if ($link && isset($domain[0])) {

                            $domain = str_replace(array('https://', 'http://'), '', $domain[0]);
                            if ($domain == 'plus.google') {
                                $domain = 'google-plus';
                            }

                            $output .= '<a href="' . $link . '"><i class="fa fa-' . $domain . '"></i></a>';
                        }
                    }
                    $output .= '</div></div>';
                    $output .= '<div class="profile-info"><h3 class="name theme-color">' . $name . '</h3><div class="position">' . $position . '</div><div class="description">' . $description . '</div></div><div style="clear:both;"></div>';


                    $output .= '</div>';
                    break;
                case 'style4':
                    $output .= '<div class="profile-box item item' . $this->count++ . ' ' . $class . '">';
                    $output .= '<div class="profile-image">' . $img_tag . '</div>';
                    $output .= '<div class="profile-info-wrap">';
                    $output .= '<div class="profile-info"><h3 class="name">' . $name . '</h3><div class="position">' . $position . '</div><div class="description">' . $description . '</div></div>';
                    $output .= '<div class="social-links">';
                    foreach ($social_links as $link) {
                        $domain = explode(".com", $link);

                        if ($link && isset($domain[0])) {

                            $domain = str_replace(array('https://', 'http://'), '', $domain[0]);
                            if ($domain == 'plus.google') {
                                $domain = 'google-plus';
                            }

                            $output .= '<a href="' . $link . '"><i class="fa fa-' . $domain . '"></i></a>';
                        }
                    }
                    $output.= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    break;
            }

            return $output;
        }

    }

}

new Inwave_Profile_Slider;
if (class_exists('WPBakeryShortCodesContainer')) {

    class WPBakeryShortCode_Inwave_Profile_Slider extends WPBakeryShortCodesContainer {
        
    }

}