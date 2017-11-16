<?php
/*
 * Inwave_Adv_Banner for Visual Composer
 */
if (!class_exists('Inwave_Adv_Banner')) {

    class Inwave_Adv_Banner {

        private $params;

        function __construct() {
            $this->initParams();
            add_action('vc_before_init', array($this, 'adv_banner_init'));
            add_shortcode('inwave_adv_banner', array($this, 'inwave_adv_banner_shortcode'));
        }

        function initParams() {
            global $iw_shortcodes;
            $this->params = array(
                'name' => 'Adv Banner',
                'description' => __('Add a banner & some advertising information', 'inwavethemes'),
                'base' => 'inwave_adv_banner',
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        "heading" => __("Banner Image", "inwavethemes"),
                        "param_name" => "img"
                    ),
					array(
                        'type' => 'attach_image',
                        "heading" => __("Background Image", "inwavethemes"),
                        "param_name" => "bg"
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "This is title",
                        "param_name" => "title"
                    ),
                    array(
                        'type' => 'textfield',
                        "heading" => __("Sub Title", "inwavethemes"),
                        "value" => "",
                        "param_name" => "sub_title"
                    ),
					array(
                        'type' => 'textfield',
                        "heading" => __("Price", "inwavethemes"),
                        "value" => "",
                        "param_name" => "price"
                    ),
                    array(
                        "type" => "textarea_html",
                        "heading" => "Description",
                        "param_name" => "content",
                        "value" => "<ul>\n<li>Lorem ipsum dolor sit amet</li>\n\n<li>Lorem ipsum dolor sit amet</li>\n\n<li>Lorem ipsum dolor sit amet</li>\n</ul>"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Available Date", "inwavethemes"),
                        "param_name" => "date"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Button Text", "inwavethemes"),
                        "param_name" => "button_text"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Button Link", "inwavethemes"),
                        "param_name" => "link"
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
                            "Style 4" => "style4",
                            "Style 5" => "style5",
                            "Style 6" => "style6",
                            "Style 7" => "style7",
                            "Style 8" => "style8",
                        )
                    ),
					array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "class" => "",
                        "heading" => "Overlay",
                        "param_name" => "overlay",
                        "value" => array(
                            "Yes" => "1",
                            "No" => "0"
                        )
                    ),
					array(
                        "type" => "textfield",
						"group" => "Style",
                        "heading" => __("Banner Size", "inwavethemes"),
                        "param_name" => "img_size",
                        "description" => __("Enter image size. Example in pixels: 200x100 (Width x Height)", "inwavethemes")
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    )
                )
            );
            $iw_shortcodes['inwave_adv_banner'] = $this->params;
        }

        function adv_banner_init() {
            if (function_exists('vc_map')) {
                // Add banner addon
                vc_map($this->params);
            }
        }

        // Shortcode handler function for list Icon
        function inwave_adv_banner_shortcode($atts, $content = null) {
            $output = $img = $img_size = $title = $sub_title = $class = $link = $description = $button_text = $overlay = $style = '';
            extract(shortcode_atts(array(
                'img' => '',
                'bg' => '',
                'img_size' => '',
                'title' => '',
                'sub_title' => '',
                'class' => '',
                'date' => '',
                'link' => '',
                'button_text' => '',
                'overlay' => 1,
                'price' => '',
                'style' => 'style1'
                            ), $atts));
            $content = preg_replace('/^\<\/p\>(.*)\<p\>$/Usi','$1',$content);

            $img_tag = '';
            $bg_tag = '';
            if ($img) {
                $img = wp_get_attachment_image_src($img, 'large');
                $img = $img[0];
                $size = '';
                if ($img_size) {
                    $img_size = explode('x', $img_size);
                    $size = 'style="width:' . $img_size[0] . 'px!important;height:' . $img_size[1] . 'px!important"';
                }
                $img_tag .= '<img ' . $size . ' src="' . $img . '" alt="' . $title . '">';
            }
			if ($bg) {
                $bg = wp_get_attachment_image_src($bg, 'large');
                $bg = $bg[0];
				$bg_tag .= '<img class="iw-av-bg" src="' . $bg . '" alt="bg"><div class="iw-av-bg-overlay"></div>';
            }

			$class .= ' ' . $style;
			ob_start();
            if(substr_count($price,'/')){
                $price = str_replace('/','<hr><span>',$price).'</span>';
            }
            switch ($style) {
                case 'style1':
				?>
                    <div class="iw-av-banner theme-bg <?php echo $class?>">
						<div class="iw-av-image col-md-6 col-sm-6 col-xs-12">
							<?php echo $img_tag;?>
							<?php 
							if($overlay){
								echo '<div class="theme-bg iw-av-overlay"></div>';
							}
							?>				
						</div>
						<div class="iw-av-content col-md-6 col-sm-6 col-xs-12">
							<div class="iw-av-price theme-bg">
								<?php echo $price ?>
								<div class="iw-av-tail-left theme-border-color"></div>
                                <div class="iw-av-tail-right theme-border-color"></div>
							</div>
							<div class="iw-av-subtitle"><?php echo $sub_title ?></div>
							<div class="iw-av-title theme-color"><?php echo $title ?></div>
							<div class="clear"></div>
							<div class="iw-av-desc"><?php echo $content ?></div>
                            <?php
                            if ($date) {
                                echo '<div class="iw-av-date"><span class="ibutton ibutton2 ibutton-small ibutton-effect2"><span>' . $date . '</span></span></div>';
                            }
                            ?>
							<?php 
								if ($button_text) {
									echo '<a class="ibutton ibutton2 ibutton-small ibutton-effect2" href="' . $link . '"><span>' . $button_text . '</span></a>';
								}
							?>
						</div>
						<?php echo $bg_tag;?>
                    </div>
					
				<?php	
                    break;
                case 'style2':
                    if(!$content && !$button_text){
                        $class .= ' iw-av-banner-img';
                    }
                    ?>
                    <div class="iw-av-banner theme-bg <?php echo $class?>">
                        <div class="iw-av-subtitle"><?php echo $sub_title ?></div>
                        <div class="iw-av-title"><?php echo $title ?></div>
                    <div class="iw-av-body">
                        <div class="iw-av-image">
                            <?php  if($link){
                                echo '<a href="'.$link.'">';
                            }?>
                            <?php echo $img_tag;?>
                            <span class="iw-av-price">
                                <span class="theme-color-force"><?php echo $price ?></span>
                            </span>
                            <?php  if($link){
                                echo '</a>';
                            }?>
                        </div>
                        <?php if($content || $button_text): ?>
                        <div class="iw-av-content">
                            <div class="iw-av-desc"><?php echo $content ?>
                                <?php
                                if ($date) {
                                    echo '<div class="iw-av-date"><span class="ibutton ibutton2 ibutton-small ibutton-effect2"><span>' . $date . '</span></span></div>';
                                }
                                ?>
                                <?php
                                if ($button_text) {
                                    echo '<a class="ibutton ibutton4 ibutton-small ibutton-effect2" href="' . $link . '"><span>' . $button_text . '</span></a>';
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        endif;
                        ?>
                    </div>
                        <?php
                        if($overlay){
                            echo '<div class="theme-bg iw-av-overlay"></div>';
                        }else{
                            echo $bg_tag;
                        }
                        ?>

                    </div>

                    <?php
                    break;
                case 'style3':
                    ?>
                    <div class="iw-av-banner theme-bg <?php echo $class?>">
                        <div class="iw-av-image">
                            <?php echo $img_tag;?>
                            <div class="iw-av-price theme-color">
                                <span><?php echo $price ?></span>
                            </div>
                        </div>
                        <div class="iw-av-content">
                            <div class="iw-av-subtitle"><?php echo $sub_title ?></div>
                            <div class="iw-av-title"><?php echo $title ?></div>
                            <div class="iw-av-desc"><?php echo $content ?>

                            </div>
                            <?php
                            if ($date) {
                                echo '<div class="iw-av-date"><span class="ibutton ibutton2 ibutton-effect2"><span>' . $date . '</span></span></div>';
                            }
                            ?>
                            <?php
                            if ($button_text) {
                                echo '<a class="ibutton ibutton2 ibutton-small ibutton-effect2" href="' . $link . '"><span>' . $button_text . '</span></a>';
                            }
                            ?>
                        </div>
                        <?php
                        if($overlay){
                            echo '<div class="theme-bg iw-av-overlay"></div>';
                        }else{
                            echo $bg_tag;
                        }
                        ?>

                    </div>
                    <?php
                    break;
                case 'style4':
                    ?>
                    <div class="iw-av-banner <?php echo $class?>">
                        <div class="iw-av-image">
                            <?php
                            if($overlay){
                                echo '<div class="theme-bg iw-av-overlay1"></div>';
                                echo '<div class="theme-bg iw-av-overlay2"></div>';
                            }
                            ?>
                            <div class="iw-av-image-wrap">
                                <?php echo $img_tag;?>
                                <div class="iw-av-price theme-color">
                                    <span><?php echo $price ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="iw-av-content">

                            <div class="iw-av-subtitle theme-color"><?php echo $sub_title ?></div>
                            <div class="iw-av-title theme-color"><?php echo $title ?></div>
                            <div class="clear"></div>
                            <div class="iw-av-desc theme-color"><?php echo $date ?></div>

                            <?php
                            if ($button_text) {
                                echo '<a class="ibutton ibutton2 ibutton-effect2" href="' . $link . '"><span>' . $button_text . '</span></a>';
                            }
                            ?>
                        </div>
                        <div class="iw-av-content2">

                            <div class="iw-av-subtitle"><?php echo $sub_title ?></div>
                            <div class="iw-av-title"><?php echo $title ?></div>
                            <div class="clear"></div>
                            <div class="iw-av-desc"><?php echo $content ?></div>
                            <?php
                            if ($button_text) {
                                echo '<span class="theme-bg"><a class="ibutton ibutton2 ibutton-effect2" href="' . $link . '"><span>' . $button_text . '</span></a></span>';
                            }
                            ?>
                        </div>
                        <?php echo $bg_tag;?>
                    </div>

                    <?php
                    break;
                case 'style5':
                    ?>
                    <div class="iw-av-banner style4 <?php echo $class?>">
                        <div class="iw-av-image">
                            <?php
                            if($overlay){
                                echo '<div class="theme-bg iw-av-overlay1"></div>';
                                echo '<div class="theme-bg iw-av-overlay2"></div>';
                            }
                            ?>
                            <div class="iw-av-image-wrap">
                                <?php echo $img_tag;?>
                                <div class="iw-av-price theme-color">
                                    <span><?php echo $price ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="iw-av-content2">
                            <div class="iw-av-subtitle theme-color"><?php echo $sub_title ?></div>
                            <div class="iw-av-title theme-color"><?php echo $title ?></div>
                            <div class="clear"></div>
                            <div class="iw-av-desc theme-color"><?php echo $content ?></div>
                            <?php
                            if ($button_text) {
                                echo '<a class="ibutton ibutton2 ibutton-effect2" href="' . $link . '"><span>' . $button_text . '</span></a>';
                            }
                            ?>
                        </div>
                        <div class="iw-av-content">
                            <div class="iw-av-subtitle"><?php echo $sub_title ?></div>
                            <div class="iw-av-title"><?php echo $title ?></div>
                            <div class="clear"></div>
                            <div class="iw-av-desc"><?php echo $date ?></div>
                            <?php
                            if ($button_text) {
                                echo '<span class="theme-bg"><a class="ibutton ibutton2 ibutton-effect2" href="' . $link . '"><span>' . $button_text . '</span></a></span>';
                            }
                            ?>
                        </div>
                        <?php echo $bg_tag;?>
                    </div>
                    <?php
                    break;
                case 'style6':
                    ?>
                    <div class="iw-av-banner theme-bg animate-1 <?php echo $class?>">
                        <div class="iw-av-title-wrap animate-1">
                            <div class="iw-av-subtitle"><?php echo $sub_title ?></div>
                            <div class="iw-av-title"><?php echo $title ?></div>
                        </div>
                        <div class="iw-av-image animate-1">
                            <?php echo $img_tag;?>
                            <div class="iw-av-price theme-color">
                                <span><?php echo $price ?></span>
                            </div>
                        </div>
                        <div class="iw-av-desc animate-1">
                            <?php echo $content ?>
                            <div class="iw-av-button">
                                <?php
                                if ($button_text) {
                                    echo '<a class="ibutton ibutton2 ibutton-effect2" href="' . $link . '"><span>' . $button_text . '</span></a>';
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        if ($date) {
                            echo '<div class="iw-av-date animate-1"><span class="ibutton ibutton2 ibutton-effect2">' . $date . '</span></div>';
                        }
                        ?>
                        <?php echo $bg_tag;?>
                        <?php
                        if($overlay){
                            echo '<div class="theme-bg iw-av-overlay1 animate-1"></div>';
                            echo '<div class="theme-bg iw-av-overlay2 animate-1"></div>';
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

new Inwave_Adv_Banner;
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_Inwave_Adv_Banner extends WPBakeryShortCode {
        
    }

}