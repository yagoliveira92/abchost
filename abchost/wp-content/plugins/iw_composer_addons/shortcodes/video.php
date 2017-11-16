<?php

/*
 * Inwave_Video for Visual Composer
 */
if (!class_exists('Inwave_Video')) {

    class Inwave_Video {

        private $params;

        function __construct() {
            $this->initParams();
            add_action('vc_before_init', array($this, 'heading_init'));
            add_shortcode('inwave_video', array($this, 'inwave_video_shortcode'));
        }

        function initParams() {
            global $iw_shortcodes;
            $this->params = array(
                'name' => 'HTML5 Video',
                'description' => __('HTML5 Video', 'inwavethemes'),
                'base' => 'inwave_video',
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Video URL", "inwavethemes"),
                        "value" => "",
                        "param_name" => "url"
                    ),
                    array(
                        'type' => 'attach_image',
                        "heading" => __("Poster image", "inwavethemes"),
                        "param_name" => "poster"
                    ),
                    array(
                        'type' => 'textarea_html',
                        "holder" => "div",
                        "heading" => __("Content", "inwavethemes"),
                        "param_name" => "content"
                    ),
                    array(
                        'type' => 'colorpicker',
                        "heading" => __("Background overlay", "inwavethemes"),
                        "description" => __("Enter value: 'transparent' if you want to disable overlay", "inwavethemes"),
                        "param_name" => "overlay"
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Parallax video effect", "inwavethemes"),
                        "value" => array('No'=>'','Yes'=>1),
                        "description" => __("Required 'Parallax height' value", "inwavethemes"),
                        "param_name" => "parallax"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Parallax height", "inwavethemes"),
                        "value" => '450px',
                        "param_name" => "parallax_height",
                        "description" => __("Example: '450px'", "inwavethemes"),
                    ),
                    array(
                        "type" => "textfield",
                        "class" => "",
                        "heading" => "Parallax background speed",
                        "description" => "Enter speed factor from 0 to 1",
                        "param_name" => "parallax_speed",
                        "value" => "0.5"
                    ),
                    array(
                        'type' => 'textfield',
                        "heading" => __("Background overlay opacity", "inwavethemes"),
                        "description" => __("Enter value 0 -> 1, example '0.9'", "inwavethemes"),
                        "value"=>'0.9',
                        "param_name" => "opacity"
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show controls", "inwavethemes"),
                        "value" => array('No'=>'','Yes'=>1),
                        "param_name" => "controls"
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Auto play", "inwavethemes"),
                        "value" => array('No'=>'','Yes'=>1),
                        "param_name" => "autoplay"
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Auto replay", "inwavethemes"),
                        "value" => array('No'=>'','Yes'=>1),
                        "param_name" => "autoreplay"
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Hide content overlay when playing", "inwavethemes"),
                        "value" => array('No'=>'','Yes'=>1),
                        "param_name" => "hide_content"
                    ),

                    array(
                        'type' => 'iwicon',
                        "heading" => __("Play Icon", "inwavethemes"),
                        "description" => __("Only show when 'controls' = false and 'autoplay' = false", "inwavethemes"),
                        "param_name" => "icon"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    )
                )
            );
            $iw_shortcodes['inwave_video'] = $this->params;
        }

        function heading_init() {
            if (function_exists('vc_map')) {
                // Add banner addon
                vc_map($this->params);
            }
        }

        // Shortcode handler function for list Icon
        function inwave_video_shortcode($atts, $content = null) {
            $output = $answer = $question = $class = '';
            extract(shortcode_atts(array(
                'url' => '',
                'poster' => '',
                'overlay' => '',
                'opacity' => '',
                'opacity' => '0.9',
                'controls' => '',
                'autoplay' => '',
                'parallax' => '',
                'parallax_height' => '450px',
                'speed' => '0.5',
                'autoreplay' => '',
                'hide_content' => '',
                'icon' => '',
                'icon_size' => '60px',
                'class' => '',
                            ), $atts));
            $content = do_shortcode($content);
            if($content){
                $class .= ' have-content';
            }
            if($hide_content){
                $class .= ' hide-content';
            }
            $output .= '<div class="iw-video ' . $class . '">';
            $output .= '<div class="iw-video-player">';
            if (!$controls && !$autoplay) {
                if(!$icon) {
                    $icon = 'fa fa-play-circle';
                }
                $output .= '<div class="play-button"><i style="font-size:' . $icon_size . '" class="' . $icon . '"></i></div>';
            }
            if($url){
                if($parallax){
                    wp_enqueue_script( 'jquery-parallax');
                    $output .= '<div class="iw-parallax-video" data-iw-paraspeed="'.$speed.'" data-iw-paraheight="'.$parallax_height.'">';
                }
                $output .= '<video src="'.$url.'" '.($autoplay?'autoplay':'').' '.($controls?'controls':'').' '.($autoreplay?'loop':'').'></video> ';
                if($poster){
                    $poster = wp_get_attachment_image_src($poster, 'large');
                    $poster = $poster[0];
                    if(!$parallax) {
                        $output .= '<div class="iw-video-poster" style="background:url(\'' . $poster . '\') 50% 50% / cover no-repeat"></div>';
                    }else{
                        $output .= '<img class="iw-video-poster" src="'.$poster.'" alt="" />';
                    }
                }

                if($parallax) {
                    $output .= '</div>';
                }
            }

            if($overlay!='transparent') {
                $output .= '<div class="theme-bg iw-video-overlay" style="' . ($overlay ? 'background-color:' . $overlay . ';' : '') . 'opacity:' . $opacity . '"></div>';
            }
            $output .= '</div>';
            if($content){
                $output .= '<div class="iw-video-content">'.$content.'</div>';
            }
            $output .= '</div>';
            return $output;
        }

    }

}

new Inwave_Video;
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_Inwave_Video extends WPBakeryShortCode {
        
    }

}