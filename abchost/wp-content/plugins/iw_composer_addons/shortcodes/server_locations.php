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
 * Description of server_locations
 *
 * @developer duongca
 */
if (!class_exists('Inwave_Server_Locations')) {

    class Inwave_Server_Locations {

        private $params;

        function __construct() {
            $this->initParams();
            add_action('vc_before_init', array($this, 'heading_init'));
            add_shortcode('server_locations', array($this, 'server_locations_shortcode'));
        }

        function initParams() {
            global $iw_shortcodes;
            $this->params = array(
                'name' => 'Inwave Server Locations',
                'description' => __('Add a server locations block', 'inwavethemes'),
                'base' => 'server_locations',
                'category' => 'Custom',
                'icon' => 'iw-default',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "",
                        "param_name" => "title"
                    ),
                    array(
                        'type' => 'iw_server_location',
                        "heading" => __("Location info", "inwavethemes"),
                        "value" => "",
                        "param_name" => "server_locations"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    )
                )
            );
            $iw_shortcodes['server_locations'] = $this->params;
        }

        function heading_init() {
            if (function_exists('vc_map')) {
                // Add banner addon
                vc_map($this->params);
            }
        }

        // Shortcode handler function for list Icon
        function server_locations_shortcode($atts, $content = null) {
            extract(shortcode_atts(array(
                "title" => "",
                "server_locations" => "",
                "class" => ""
                            ), $atts));
            ob_start();
            echo '<div class="server-location-block ' . $class . '">';
            if ($title) {
                echo '<div class="block-title">' . $title . '</div>';
            }
            if ($server_locations):
                $server_location_info = json_decode(base64_decode($server_locations));
                ?>
                <div class="iw-server-location-wrap site-view">
                    <?php
                    if ($server_location_info[0]) {
                        $mapimg = wp_get_attachment_image_src($server_location_info[0], 'large');
                        $map_img_src = $mapimg[0];
                    } else {
                        $map_img_src = plugins_url('iw_composer_addons/assets/images/map.png');
                    }
                    ?>
                    <div class="image-map-preview col-sm-6">
                        <div class="image">
                            <img src="<?php echo $map_img_src; ?>" alt="map" />
                        </div>
                        <div class="map-pickers">
                            <?php
                            $marker_infos = array();
                            if (!empty($server_location_info[1]) && $server_location_info[1]) {
                                foreach ($server_location_info[1] as $marker) {
									if($marker[0]){
										$post = get_post($marker[0]);
									}else{
										$post = new stdClass();
										$post->ID = 0;
										$post->post_title = '';
										$post->post_content = '';
									}
                                    
                                    $marker_info = array();
                                    $marker_info['id'] = $post->ID;
                                    $marker_info['title'] = $post->post_title;
									$marker_info['cat'] = '';
                                    if (!empty($post->post_category)) {
                                        $marker_info['cat'] = get_cat_name($post->post_category[0]);
                                    }
                                    $marker_info['content'] = $post->post_content;
                                    $marker_info['active'] = 0;
                                    if ($marker[2]) {
                                        $marker_info['active'] = 1;
                                    }
                                    $marker_infos[] = $marker_info;
                                    $style = '';
                                    $pos = explode('x', $marker[1]);
                                    $style = 'left:' . $pos[0] * 100 . '%; top:' . $pos[1] * 100 . '%;';
                                    $flag = '';
                                    if($post->ID){
										$flag = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
										if($flag) $flag = '<img alt="flag" src="'.$flag[0].'" width="30"/>';
                                    }
                                    echo '<span data-post="' . $marker[0] . '" data-position="' . $marker[1] . '" class="map-picker ' . ($marker[2] ? 'active' : '') . '" style="' . $style . '"><span class="tip ' . ($marker[2] ? '' : 'iw-hidden').'">'.$flag.' '.$post->post_title.'</span></span>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="marker-info col-sm-6">

                        <?php
                        if (!empty($marker_infos)):
                            foreach ($marker_infos as $marker_info):
                                ?>
                                <div class="marker-info-<?php echo $marker_info['id']; ?> <?php echo $marker_info['active'] ? 'active' : 'iw-hidden'; ?>">
                                    <div class="sub-title theme-color iw-capital"><?php echo $marker_info['cat']; ?></div>
                                    <div class="title theme-color iw-capital"><?php echo $marker_info['title']; ?></div>
                                    <div class="description"><?php echo do_shortcode($marker_info['content']); ?></div>
                                </div>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
                <?php
            endif;
            echo '</div>';
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }

    }

}

new Inwave_Server_Locations();
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_Inwave_Server_Locations extends WPBakeryShortCode {
        
    }

}