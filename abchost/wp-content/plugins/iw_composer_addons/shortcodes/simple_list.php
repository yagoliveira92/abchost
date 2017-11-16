<?php

/*
 * Inwave_Simple_List for Visual Composer
 */
if (!class_exists('Inwave_Simple_List')) {

    class Inwave_Simple_List {

        private $params;

        function __construct() {
            $this->initParams();
            add_action('vc_before_init', array($this, 'simple_list_init'));
            add_shortcode('inwave_simple_list', array($this, 'inwave_simple_list_shortcode'));
        }

        function initParams() {
            global $iw_shortcodes;
            $this->params = array(
                'name' => 'Simple List',
                'description' => __('Add a items list with some simple style', 'inwavethemes'),
                'base' => 'inwave_simple_list',
                'category' => 'Custom',
                'icon' => 'iw-default',
                'params' => array(
                    array(
                        'type' => 'textarea',
                        "holder" => "div",
                        "heading" => __("Content", "inwavethemes"),
                        "value" => '<ul>
    <li>Lorem ipsum dolor sit amet</li>
    <li>Lorem ipsum dolor sit amet</li>
    <li>Lorem ipsum dolor sit amet</li>
    <li>Lorem ipsum dolor sit amet</li>
    <li>Lorem ipsum dolor sit amet</li>
</ul>',
                        "description" => "Format: <br>Inactive Item: ".htmlspecialchars('<li>Lorem ipsum dolor sit amet</li>')."<br>Active Item: ".htmlspecialchars('<li class="active">Lorem ipsum dolor sit amet</li>')."",
                        "param_name" => "content"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",

                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Check Mark" => "check-mark",
                            "Angle Right" => "angle-right",
                            "Stars" => "stars",
                            "Numbers" => "numbers"
                        )
                    ),
                )
            );
            $iw_shortcodes['inwave_simple_list'] = $this->params;
        }
        function simple_list_init() {
            if (function_exists('vc_map')) {
                // Add banner addon
                vc_map($this->params);
            }
        }
        // Shortcode handler function for list Icon
        function inwave_simple_list_shortcode($atts, $content = null) {
            $output = $class = $style = '';
            $content = preg_replace('/^\<\/p\>(.*)\<p\>$/Usi','$1',$content);
            extract(shortcode_atts(array(
                'style' => 'check-mark',
                'class' => ''
                            ), $atts));
            $class .= ' '.$style;
            $output .= '<div class="simple-list ' . $class . '">';


                $i = 0;
                do {
                    $i++;
                    if($style == 'numbers') {
                        $replacer = '<#$1> <span class="list-style">'. ($i<10?'0':'') . $i . '</span><span class="list-content">';
                    }else if($style == 'stars') {
                        $replacer = '<#$1> <span class="list-style"><i class="fa fa-star"></i></span><span class="list-content">';
                    }
                    else if($style == 'angle-right') {
                        $replacer = '<#$1> <span class="list-style"><i class="fa fa-chevron-right"></i></span><span class="list-content">';
                    }else{
                        $replacer = '<#$1> <span class="list-style"><i class="fa fa-check"></i></span><span class="list-content">';
                    }
                    $content = preg_replace('/\<li(.*)\>/Uis',$replacer, $content, 1, $count);
            } while ($count);
            $content = str_replace('<#','<li',$content);
            $content = str_replace('</li>','</span></li>',$content);
            $output .= $content;
            $output .= '</div>';
            return $output;
        }
    }

}

new Inwave_Simple_List;
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_Inwave_Simple_List extends WPBakeryShortCode {
        
    }

}