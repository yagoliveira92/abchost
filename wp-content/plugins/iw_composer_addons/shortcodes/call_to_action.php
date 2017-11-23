<?php
/*
 * Inwave_CTA for Visual Composer
 */
if (!class_exists('Inwave_CTA')) {

    class Inwave_CTA {

        private $params;

        function __construct() {
            $this->initParams();
            add_action('vc_before_init', array($this, 'cta_init'));
            add_shortcode('inwave_cta', array($this, 'inwave_cta_shortcode'));
        }

        function initParams(){
            global $iw_shortcodes;
            $this->params = array(
                'name' => 'Call To Action',
                'description' => __('Catch visitors attention with Call To Action block', 'inwavethemes'),
                'base' => 'inwave_cta',
                'category' => 'Custom',
                'icon' => 'iw-default',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "",
                        "description" => __("You can add |TEXT_EXAMPLE| to specify strong words, {TEXT_EXAMPLE} to specify colorful words", "inwavethemes"),
                        "param_name" => "title"
                    ),
                    array(
                        "type" => "textarea_html",
                        "holder" => "div",
                        "heading" => "Description",
                        "param_name" => "content",
                        "value" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "heading" => __("Button Text", "inwavethemes"),
                        "param_name" => "button_text",
                        "value"=>"Click here"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Button Link", "inwavethemes"),
                        "param_name" => "button_link",
                        "value"=>"#"
                    ),
                    array(
                        "type" => "iwicon",
                        "class" => "",
                        "heading" => "Button Icon",
                        "param_name" => "button_icon"
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "class" => "",
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1 - Normal 1" => "style1",
                            "Style 2 - Normal 2" => "style2",
                            "Style 3 - Center text 1" => "style3",
                            "Style 4 - Center text 2" => "style4"
                        )
                    ),

                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "class" => "",
                        "heading" => "Button style",
                        "param_name" => "button_style",
                        "value" => array(
                            "Button 1" => "button1",
                            "Button 2" => "button2",
                            "Button 3" => "button3",
                            "Button 4" => "button4",
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
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
                        "type" => "colorpicker",
                        "group" => "Style",
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
            $iw_shortcodes['inwave_cta'] = $this->params;
        }

        function cta_init() {
            if (function_exists('vc_map')) {
                // Add banner addon
                vc_map($this->params);
            }
        }

        // Shortcode handler function for cta
        function inwave_cta_shortcode($atts, $content = null) {
            $output = $img = $img_size = $title = $sub_title = $class = $description = $button_text = $button_link = $button_color = $button_icon = $button_size = $overlay = $style = $button_style = '';
            extract(shortcode_atts(array(
                'title' => '',
                'class' => '',
                'button_link' => '',
                'button_text' => '',
                'button_color' => '',
                'button_icon' => '',
                'button_size' => '',
                'button_text' => '',
                'button_style' => '',
                'style' => 'style1'
                            ), $atts));


			
			$class .= ' ' . $style;
			$content = preg_replace('/^\<\/p\>(.*)\<p\>$/Usi','$1',$content);
			ob_start();
            if($button_text) {
                $button = Inwave_Button::inwave_button_shortcode_html($button_link, $button_text, $button_color, $button_icon, $button_size, $button_style);
            }
            $title= preg_replace('/\|(.*)\|/isU','<strong>$1</strong>',$title);
            $title= preg_replace('/\{(.*)\}/isU','<strong class="theme-color">$1</strong>',$title);
            switch ($style) {
                case 'style1':
				?>
                    <div class="cta-banner <?php echo $class?>">
                        <?php if($title){?>
                            <h3 class="cta-title"><?php echo $title ?></h3>
                        <?php }?>
                        <div class="cta-desc">
                            <?php
                            if ($button_text) {
                                echo '<div class="cta-btn">'.$button.'</div>';
                            }
                            ?>
                            <?php echo $content ?>


                        </div>
                    </div>
				<?php	
                    break;
                case 'style2':
                    ?>
                    <div class="cta-banner theme-bg <?php echo $class?>">
                        <?php if($title){?>
                            <h3 class="cta-title"><?php echo $title ?></h3>
                        <?php }?>
                        <div class="cta-desc">
                            <?php
                            if ($button_text) {
                                echo '<div class="cta-btn">'.$button.'</div>';
                            }
                            ?>
                            <?php echo $content ?>


                        </div>
                    </div>
                    <?php
                    break;
                case 'style3':
                    ?>
                    <div class="cta-banner <?php echo $class?>">
                        <?php if($title){?>
                        <h3 class="cta-title"><?php echo $title ?></h3>
                        <?php }?>
                        <?php
                        if ($button_text) {
                            echo $button;
                        }
                        ?>
                        <div class="cta-desc">
                            <?php echo $content ?>

                        </div>
                    </div>
                    <?php
                    break;
                case 'style4':
                    ?>
                    <div class="cta-banner <?php echo $class?>">
                        <?php if($title){?>
                            <h3 class="cta-title"><?php echo $title ?></h3>
                        <?php }?>
                        <div class="cta-desc">
                            <?php echo $content ?>
                        </div>
                        <?php
                        if ($button_text) {
                            echo '<div class="cta-btn">'.$button.'</div>';
                        }
                        ?>
                    </div>
                    <?php
                    break;
			}
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }

    }

}

new Inwave_CTA;
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_Inwave_CTA extends WPBakeryShortCode {
        
    }

}