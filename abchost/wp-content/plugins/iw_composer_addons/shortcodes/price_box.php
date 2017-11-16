<?php
/*
 * Inwave_Price_Box for Visual Composer
 */
if (!class_exists('Inwave_Price_Box')) {

    class Inwave_Price_Box {

        private $params;

        function __construct() {
            $this->initParams();
            add_action('vc_before_init', array($this, 'price_box_init'));
            add_shortcode('inwave_price_box', array($this, 'inwave_price_box_shortcode'));
            add_shortcode('inwave_rate', array($this, 'inwave_rate_shortcode'));
        }

        function initParams() {
            global $iw_shortcodes;
            $this->params = array(
                'name' => 'Price Box',
                'description' => __('Add a price box & some information', 'inwavethemes'),
                'base' => 'inwave_price_box',
                'wrapper_class' => 'clearfix',
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Package name/Title", "inwavethemes"),
                        "value" => "Lorem ipsum dolor sit amet",
                        "description" => __("You can add |TEXT_EXAMPLE| to specify strong words, {TEXT_EXAMPLE} to specify colorful words", "inwavethemes"),
                        "param_name" => "title"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Price", "inwavethemes"),
                        "param_name" => "price"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Price Description", "inwavethemes"),
                        "param_name" => "price_desc"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Purchase button text", "inwavethemes"),
                        "param_name" => "purchase_text"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Purchase link", "inwavethemes"),
                        "param_name" => "purchase_link"
                    ),
					array(
                        "type" => "dropdown",
                        "heading" => "Target",
                        "param_name" => "target",
                        "value" => array(
                            "Default" => "",
							"New window/tab" => "_blank"
                        )
                    ),
                    array(
                        "type" => "textarea_html",
                        "heading" => "Features",
                        "param_name" => "content",
                        "value" => ""
                    ),
                    array(
                        'type' => 'attach_image',
                        "heading" => __("Select image", "inwavethemes"),
                        "param_name" => "img"
                    ),
                    array(
                        'type' => 'iwicon',
                        "heading" => __("Or select icon", "inwavethemes"),
                        "param_name" => "icon"
                    ),
                    array(
                        'type' => 'textfield',
                        "heading" => __("Icon size", "inwavethemes"),
                        "param_name" => "icon_size",
                        "value" => '36px'
                    ),
                    array(
                        'type' => 'dropdown',
                        "heading" => __("Featured", "inwavethemes"),
                        "param_name" => "featured",
                        "value" => array(
                            "No" => '0',
                            "Yes" => '1'
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Free trial day", "inwavethemes"),
                        "param_name" => "trial_day",
                        "description" => __('Free trial day of plan - For Price box style 5 only.', "inwavethemes"),
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
                        )
                    ),
                )
            );
            $iw_shortcodes['inwave_price_box'] = $this->params;
        }

        function price_box_init() {
            if (function_exists('vc_map')) {
                // Add banner addon
                vc_map($this->params);
            }
        }

        function inwave_rate_shortcode($atts, $content = null) {
            $output = $value = '';
            extract(shortcode_atts(array(
                'value' => '5'
                            ), $atts));
            $output .= '<span class="iw-rate">';
            if ($value) {
                for ($i = 0; $i < 5; $i++) {
                    $output .= '<span' . ($i < $value ? ' class="active theme-color"' : '') . '><i class="fa fa-star"></i></span>';
                }
            }
            $output .= '</span>';
            return $output;
        }

        // Shortcode handler function for list Icon
        function inwave_price_box_shortcode($atts, $content = null) {
            $content = preg_replace('/^\<\/p\>(.*)\<p\>$/Usi', '$1', $content);
            $output = $img = $title = $sub_title = $class = $style = $icon_size = $purchase_text = $purchase_link = $price = $price_desc = $icon = $featured = $trial_day = '';
            extract(shortcode_atts(array(
                'img' => '',
                'icon' => '',
                'icon_size' => '36px',
                'title' => '',
                'class' => '',
                'purchase_link' => '',
                'purchase_text' => '',
                'target' => '',
                'price' => '',
                'style' => 'style1',
                'featured' => '',
                'price_desc' => '',
                'trial_day' => '',
                            ), $atts));

            $title = preg_replace('/\|(.*)\|/isU', '<strong>$1</strong>', $title);
            $title = preg_replace('/\{(.*)\}/isU', '<span class="theme-color">$1</span>', $title);
			
			if($target){
				$target = 'target="'.$target.'"';
			}

            if ($img) {
                $img = wp_get_attachment_image_src($img, 'large');
                $img = $img[0];
                $icon = '<img style="width:' . $icon_size . '"src="' . $img . '" alt="">';
            } else {
                $icon = '<i style="font-size:' . $icon_size . '" class="theme-color ' . $icon . '"></i>';
            }
            $class .= ' ' . $style;
            if ($featured) {
                $class .= ' featured featured-image';
            }
            if (!$price) {
                $class .= ' no-price';
            }
            ob_start();
			$price = htmlspecialchars_decode($price);
            switch ($style) {
                case 'style1':
                    ?>
                    <div class="pricebox <?php echo $class ?>">
                        <div class="pricebox-header">
                            <div class="pricebox-header-content theme-bg">
                                <div class="pricebox-icon">
                                    <?php
                                    echo $icon;
                                    ?>
                                </div>
                                <h3 class="pricebox-title"><?php echo $title ?></h3>

                                <div class="pricebox-edge"></div>
                            </div>
                            <div class="pricebox-shadow theme-bg"></div>
                        </div>
                        <div class="pricebox-body">
                            <div class="pricebox-body-content">
                                <?php
                                if ($price) {
                                    ?>
                                    <div class="pricebox-price">
                                        <?php echo $price ?>
                                    </div>

                                    <?php
                                }
                                ?>
                                <?php if ($price_desc) { ?>
                                    <div class="pricebox-price-desc"><span
                                            class="theme-bg"><?php echo $price_desc ?></span></div>
                                    <?php } ?>
                                <div
                                    class="pricebox-description"><?php echo do_shortcode($content) ?></div>

                                <?php
                                if ($purchase_text) {
                                    ?>
                                    <div class="pricebox-purchased-link"><a class="ibutton ibutton1 ibutton-small ibutton-effect1" <?php echo $target ?>
                                                                            href="<?php echo $purchase_link ?>"><span><?php echo $purchase_text ?></span></a>
                                    </div>
                                    <?php
                                }
                                ?>

                            </div>
                            <div class="pricebox-shadow"></div>
                        </div>
                    </div>
                    <?php
                    break;
                case 'style2':
                    ?>
                    <div class="pricebox <?php echo $class ?>">
                        <div class="pricebox-header">
                            <div class="pricebox-header-content">
                                <div class="pricebox-icon-wrapper">
                                    <div class="pricebox-icon">
                                        <?php
                                        echo $icon;
                                        ?>
                                    </div>
                                </div>
                                <h3 class="pricebox-title theme-color"><?php echo $title ?></h3>
                                <?php
                                if ($price) {
                                    $price = str_replace('</','PREVENT_REPLACE',$price);
									$price = explode('/', $price,2);
                                    ?>
                                    <div class="pricebox-price">
                                        <?php
                                        echo str_replace('PREVENT_REPLACE','</',$price[0]);
                                        if (isset($price[1])) {
                                            echo ' / <span>' . str_replace('PREVENT_REPLACE','</',$price[1]) . '</span>';
                                        }
                                        ?>
                                    </div>

                                    <?php
                                }
                                ?>
                                <?php if ($price_desc) { ?>
                                    <div class="pricebox-price-desc"><span
                                            class="theme-bg"><?php echo $price_desc ?></span></div>
                                    <?php } ?>

                            </div>
                        </div>
                        <div class="pricebox-body">
                            <div class="pricebox-body-content">

                                <div class="pricebox-description"><?php echo do_shortcode($content) ?></div>
                                <?php
                                if ($purchase_text) {
                                    ?>
                                    <div class="pricebox-purchased-link">
                                        <a href="<?php echo $purchase_link ?>" <?php echo $target ?> class="ibutton ibutton1 ibutton-small ibutton-effect1"><span class="ibutton-inner"><?php echo $purchase_text ?></span></a>
                                    </div>
                                    <?php
                                }
                                ?>

                            </div>

                        </div>
                    </div>
                    <?php break; ?>
                <?php case 'style5': ?>
                    <div class="pricebox <?php echo $class ?>">
                        <div class="pricebox-col1">
                            <h3 class="pricebox-title theme-color"><?php echo $title ?></h3>
                            <?php if ($price_desc) { ?>
                                <div class="pricebox-price-desc"><?php echo $price_desc ?></div>
                            <?php } ?>

                        </div>
                        <div class="pricebox-col2">
                            <div class="pricebox-description"><?php echo do_shortcode($content) ?></div>
                        </div>
                        <div class="pricebox-col3 theme-bg">
                            <?php
                            if ($price) {
                                //	$pos = strpos($price, '$', 0)
								$price = str_replace('</','PREVENT_REPLACE',$price);
                                if (function_exists('mb_substr')) {
                                    $str = mb_substr($price, 0, 1);
                                    $price = explode('/', mb_substr($price, 1));
                                } else {
                                    $str = substr($price, 0, 1);
                                    $price = explode('/', substr($price, 1));
                                }
                                ?>
                                <div class="pricebox-price">
                                    <?php
                                    echo '<sup>' . $str . '</sup>' . str_replace('PREVENT_REPLACE','</',$price[0]);
                                    if (isset($price[1])) {
                                        echo ' / <span>' . str_replace('PREVENT_REPLACE','</',$price[1]) . '</span>';
                                    }
                                    ?>
                                </div>
                            <?php } ?>

                            <?php if ($trial_day) { ?><div class="pricebox_trial"><?php echo $trial_day; ?></div><?php } ?>

                            <?php if ($purchase_text) { ?>
                                <div class="pricebox-purchased-link">
                                    <a href="<?php echo $purchase_link ?>" <?php echo $target ?> class="ibutton ibutton2 ibutton-effect2"><span class="ibutton-inner"><?php echo $purchase_text ?></span></a>
                                </div>
                            <?php } ?>
                        </div>
                        <div style="clear:both;"></div>
                    </div>
                    <?php break; ?>
                <?php case 'style6': ?>
                    <div class="pricebox style6">
                        <div class="pricebox-body">
                            <h3 class="pricebox-title"><?php echo $title ?></h3>
                            <?php if ($purchase_text) { ?>
                                <div class="pricebox-purchased-link">
                                    <a href="<?php echo $purchase_link ?>" <?php echo $target ?> class=""><span class="ibutton-inner"><?php echo $purchase_text ?></span></a>
                                </div>
                            <?php } ?>
                            <div style="clear:both;"></div>
                        </div>



                    </div>
                    <?php break; ?>
                <?php
                default:
                    if ($style != 'style3') {
                        $class .= ' style3';
                    }
                    ?>
                    <div class="pricebox animate-2 <?php echo $class ?>">
                        <div class="pricebox-header">
                            <div class="pricebox-header-content">
                                <h3 class="pricebox-title"><?php echo $title ?></h3>
                                <?php
                                if ($price) {
									$price = str_replace('</','PREVENT_REPLACE',$price);
                                    $price = explode('/', $price,2);
                                    ?>
                                    <div class="pricebox-price">
                                        <?php
                                        echo trim(str_replace('PREVENT_REPLACE','</',$price[0]));
                                        if (isset($price[1])) {
                                            echo '/<span>' . trim(str_replace('PREVENT_REPLACE','</',$price[1])) . '</span>';
                                        }
                                        ?>
                                    </div>

                                    <?php
                                }
                                ?>
                                <?php if ($price_desc) { ?>
                                    <div class="pricebox-price-desc"><span
                                            class="theme-bg"><?php echo $price_desc ?></span></div>
                                    <?php } ?>

                            </div>
                        </div>
                        <div class="pricebox-body">
                            <div class="pricebox-body-content">

                                <div
                                    class="pricebox-description"><?php echo do_shortcode($content) ?></div>
                                    <?php
                                    if ($purchase_text) {
                                        ?>
                                    <div class="pricebox-purchased-link">
                                        <a href="<?php echo $purchase_link ?>" <?php echo $target ?> class="ibutton ibutton3 ibutton-small ibutton-effect1"><span class="ibutton-inner"><?php echo $purchase_text ?></span></a>

                                    </div>
                                    <?php
                                }
                                ?>

                            </div>

                        </div>
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

new Inwave_Price_Box;
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_Inwave_Price_Box extends WPBakeryShortCode {
        
    }

}