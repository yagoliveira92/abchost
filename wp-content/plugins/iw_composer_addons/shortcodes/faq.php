<?php

/*
 * Inwave_Heading for Visual Composer
 */
if (!class_exists('Inwave_Faq')) {

    class Inwave_Faq {

        private $params;

        function __construct() {
            $this->initParams();
            add_action('vc_before_init', array($this, 'heading_init'));
            add_shortcode('inwave_faq', array($this, 'inwave_faq_shortcode'));
        }

        function initParams() {
            global $iw_shortcodes;
            $this->params = array(
                'name' => 'FAQ',
                'description' => __('Frequently asked question', 'inwavethemes'),
                'base' => 'inwave_faq',
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Question", "inwavethemes"),
                        "value" => "This is question",
                        "param_name" => "question"
                    ),
                    array(
                        'type' => 'textarea',
                        "heading" => __("Answer", "inwavethemes"),
                        "value" => "This is Answer",
                        "param_name" => "answer"
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
                            "Style 1 - Normal heading" => "style1",
                            "Style 2 - Our pricing" => "style2",
                            "Style 3 - Pricing plan" => "style3"
                        )
                    ),
                )
            );
            $iw_shortcodes['inwave_faq'] = $this->params;
        }

        function heading_init() {
            if (function_exists('vc_map')) {
                // Add banner addon
                vc_map($this->params);
            }
        }

        // Shortcode handler function for list Icon
        function inwave_faq_shortcode($atts, $content = null) {
            $output = $answer = $question = $class = '';
            extract(shortcode_atts(array(
                'answer' => '',
                'question' => '',
                'class' => ''
                            ), $atts));

            $output .= '<div class="ask-question-content ' . $class . '">';
            $output .= '<div class="question"><div class="question-content">';
            $output .= '<p>' . $question . '</p>';
            $output .= '</div></div>';
            $output .= '<div class="answer"><div class="answer-content">';
            $output .= '<p>' . $answer . '</p>';
            $output .= '</div></div>';
            $output .= '</div>';
            return $output;
        }

    }

}

new Inwave_Faq;
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_Inwave_Faq extends WPBakeryShortCode {
        
    }

}