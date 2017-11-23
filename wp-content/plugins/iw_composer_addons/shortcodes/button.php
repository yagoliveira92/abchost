<?php
/*
 * Inwave_Button for Visual Composer
 */
if (!class_exists('Inwave_Button')) {

    class Inwave_Button {

        private $params;
        function __construct() {
            $this->initParams();
            add_action('vc_before_init', array($this, 'button_init'));
            add_shortcode('inwave_button', array($this, 'inwave_button_shortcode'));
        }
        function button_init() {
            if (function_exists('vc_map')) {
                // Add banner addon
                vc_map($this->params);
            }
        }
        function initParams() {
            global $iw_shortcodes;
            $this->params = array(
                'name' => 'Button',
                'description' => __('Insert a button with some styles', 'inwavethemes'),
                'base' => 'inwave_button',
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        "type" => "textfield",
                        "heading" => __("Button Text", "inwavethemes"),
                        "param_name" => "button_text",
                        "holder" => "div",
                        "value"=>"Click here"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Button Link", "inwavethemes"),
                        "param_name" => "button_link",
                        "value"=>"#"
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => "Button style",
                        "param_name" => "style",
                        "value" => array(
                            "Button 1" => "button1",
                            "Button 2" => "button2",
                            "Button 3" => "button3",
                            "Button 4" => "button4",
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => "Button size",
                        "param_name" => "button_size",
                        "value" => array(
                            "Normal" => "button-normal",
                            "Small" => "button-small",
                            "Large" => "button-large",
                        )
                    ),
                    array(
                        "type" => "iwicon",
                        "class" => "",
                        "heading" => "Button Icon",
                        "param_name" => "button_icon"
                    ),
                    array(
                        "type" => "colorpicker",
                        "class" => "",
                        "heading" => "Button Color",
                        "param_name" => "button_color",
                        "description" => "Select color for the button. Example '#232323'"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    )
                )
            );
            $iw_shortcodes['inwave_button'] = $this->params;
        }
        function inwave_button_shortcode($atts, $content = null){
            $output = $class = $button_link = $button_text = $button_color = $button_icon = $button_size = $style = '';
            extract(shortcode_atts(array(
                'class' => '',
                'button_link' => '',
                'button_text' => '',
                'button_color' => '',
                'button_color' => '',
                'button_icon' => '',
                'button_size' => '',
                'style' => 'button1'
            ), $atts));

            return self::inwave_button_shortcode_html($button_link,$button_text,$button_color,$button_icon,$button_size,$style,$class);

        }
        public static function inwave_button_shortcode_html($button_link,$button_text,$button_color,$button_icon,$button_size,$style,$class =''){
            $class .= ' i' . $style;
            if($button_size !='button-normal'){
                $class .= ' i' . $button_size;
            }
            $bg = $border = $color = '';
            if($button_color){
                $bg = 'background-color:'.$button_color.';';
                $border = 'border-color:'.$button_color.';';
                $color = 'color:'.$button_color.';';
            }
            $effect = 'ibutton-effect1';
            if($style =='button2' || $style =='button4'){
                $effect = 'ibutton-effect2';
            }
            if($button_icon){
                $button_icon = '<i class="'.$button_icon.'"></i>';
                $effect = 'ibutton-effect3';
            }
            $class .= ' '.$effect;
            switch($style){
                case 'button1':
                    $output =  '<a style="'.$bg.'"  class="ibutton '.$class.'" href="'.$button_link.'">'.$button_icon.'<span class="ibutton-inner">'.$button_text.'</span></a>';
                    break;
                case 'button3':
                    $output =  '<a style="'.$bg.'"  class="ibutton '.$class.'" href="'.$button_link.'">'.$button_icon.'<span class="ibutton-inner">'.$button_text.'</span></a>';
                    break;
                case 'button2':
                    $output =  '<a style="'.$color.$border.'"  class="ibutton '.$class.'" href="'.$button_link.'">'.$button_icon.'<span class="ibutton-inner">'.$button_text.'</span></a>';
                    break;
                case 'button4':
                    $output =  '<a style="'.$color.$border.'"  class="ibutton '.$class.'" href="'.$button_link.'">'.$button_icon.'<span class="ibutton-inner">'.$button_text.'</span></a>';
                    break;
            }
            return $output;

        }

    }
}
new Inwave_Button;
