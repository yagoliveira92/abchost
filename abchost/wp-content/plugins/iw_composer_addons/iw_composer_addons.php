<?php
/*
  Plugin Name: Visual Composer Addons
  Plugin URI: http://inwavethemes.com
  Description: Includes advanced addon elements for Visual Composer
  Version: 1.4.2
  Author: Inwavethemes
  Author URI: http://www.inwavethemes.com
  License: GNU General Public License v2 or later
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
/**
 * Flushes rewrite rules on plugin activation to ensure custom posts don't 404.
 *
 * @since 1.0.0
 * @link http://codex.wordpress.org/Function_Reference/flush_rewrite_rules
 */
defined('ABSPATH') or die();
global $iw_shortcodes;
$iw_shortcodes = array();
require 'inc/iw.init.php';
require 'functions.php';

// translate plugin
add_action('plugins_loaded', 'iw_composer_load_textdomain');
function iw_composer_load_textdomain() {
	load_plugin_textdomain( 'inwavethemes', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
} 


class InwaveVC_Support {

    // declare custom shortcodes
    private $shortCodes;

    function __construct() {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if (is_plugin_active('js_composer/js_composer.php')) {
            require_once(WP_PLUGIN_DIR . '/js_composer/include/classes/shortcodes/shortcodes.php');
        } else {
            return;
        }

        $this->shortCodes = get_list_iw_shortcode();
        add_action('init', array($this, 'addParamsForRow'));
        add_action('admin_init', array($this, 'generate_shortcode_params'));
        add_action('admin_enqueue_scripts', array($this, 'athlete_scripts_admin'));
        add_action('wp_enqueue_scripts', array($this, 'athlete_scripts'));
        // include shortcodes
        foreach ($this->shortCodes as $shortCode) {
            include_once(dirname(__FILE__) . '/shortcodes/' . $shortCode . '.php');
        }
        add_action('media_buttons', 'iw_shortcode_add_button', 15);
        add_action('wp_ajax_nopriv_loadShortCodeSettings', array($this, 'loadShortCodeSettings'));
        add_action('wp_ajax_loadShortCodeSettings', array($this, 'loadShortCodeSettings'));
        add_action('wp_ajax_nopriv_loadShortCodePreview', array($this, 'loadShortCodePreview'));
        add_action('wp_ajax_loadShortCodePreview', array($this, 'loadShortCodePreview'));
		add_action('wp_ajax_nopriv_searchIcons', array($this, 'searchIcons'));
        add_action('wp_ajax_searchIcons', array($this, 'searchIcons'));
    }

    function loadShortCodeSettings() {
        global $iw_shortcodes;
        $shortcode = $_POST['shortcode'];
        echo getFieldHtml($iw_shortcodes[$shortcode]);
        exit;
    }
	function searchIcons(){
		$key = $_POST['key'];
		$type = $_POST['type'];
		echo getSearchIconsHtml($type,$key);
        exit;
	}

    function generate_shortcode_params() {
        /* Generate param type "iwicon" */
        if (function_exists('vc_add_shortcode_param')) {
            vc_add_shortcode_param('iwicon', array($this, 'iwicon'));
        }
        /* Generate param type "courses_categories" */
        if (function_exists('vc_add_shortcode_param')) {
            vc_add_shortcode_param('courses_categories', array($this, 'iwcourses_categories'));
        }
        /* Generate param type "courses_categories" */
        if (function_exists('vc_add_shortcode_param')) {
            vc_add_shortcode_param('inwave_select', array($this, 'inwave_select'));
        }

        /* Generate param type "iw_server_location" */
        if (function_exists('vc_add_shortcode_param')) {
            vc_add_shortcode_param('iw_server_location', array($this, 'iw_server_location'));
        }

        /* Generate param type "iw_range_skillbar" */
        if (function_exists('vc_add_shortcode_param')) {
            vc_add_shortcode_param('iw_range_skillbar', array($this, 'iw_range_skillbar'));
        }
    }

    function loadShortCodePreview() {
        echo '<html><head>';
        wp_head();
        echo '<style>body{background:none!important}</style>';
        echo '</head><body>';
        $shortcode = stripslashes($_GET['shortcode']);
        echo do_shortcode($shortcode);
        wp_footer();
        echo '</body></html>';
        exit();
    }

    /* add parameter for rows */

    function addParamsForRow() {
        if (!defined('WPB_VC_VERSION')) {
            return;
        }

        // init new params
        $newParams = array(
            array(
                "type" => "dropdown",
                "group" => "Layout options",
                "class" => "",
                "heading" => "Width",
                "param_name" => "iw_layout",
                "value" => array(
                    "Boxed" => "boxed",
                    "Wide Background" => "wide-bg",
                    "Wide Content" => "wide-content"
                )
            ),
            array(
                "type" => "dropdown",
                "group" => "Layout options",
                "class" => "",
                "heading" => "Parallax background",
                "description" => 'Require background image in Design Options Tab',
                "param_name" => "iw_parallax",
                "value" => array(
                    "No" => "0",
                    "Yes" => "1"
                )
            ),
            array(
                "type" => "textfield",
                "group" => "Layout options",
                "class" => "",
                "heading" => "Parallax Overlay opacity",
                "param_name" => "iw_parallax_overlay",
                "value" => '0.9'
            ),
            array(
                "type" => "textfield",
                "group" => "Layout options",
                "class" => "",
                "heading" => "Parallax background speed",
                "description" => "Enter speed factor from 0 to 1",
                "param_name" => "iw_parallax_speed",
                "value" => "0.1"
            )
        );
        // add to row
        vc_add_params("vc_row", $newParams);
        vc_set_shortcodes_templates_dir(dirname(__FILE__) . '/vc_templates');


    }

    function iwicon($settings, $value) {
        $name = $settings['param_name'] ? $settings['param_name'] : '';
        $type = isset($settings['type']) ? $settings['type'] : '';
        $class = $settings['class'] ? $settings['class'] : '';
        $class .= ' wpb_vc_param_value ' . $name . " " . $type;
        return getIwIconField($name, $value, $class);
    }

    function athlete_scripts() {
        $theme_info = wp_get_theme();
        wp_deregister_style('font-awesome');
        wp_enqueue_style('font-awesome', plugins_url() . '/iw_composer_addons/assets/css/font-awesome/css/font-awesome.min.css', array(), $theme_info->get('Version'));
        wp_enqueue_style('font-whhg', plugins_url() . '/iw_composer_addons/assets/css/font-whhg/css/whhg.css', array(), $theme_info->get('Version'));
        wp_enqueue_style('iw-main', plugins_url() . '/iw_composer_addons/assets/css/iw-main.css', array(), $theme_info->get('Version'));
        wp_register_script('jquery-parallax', plugins_url() . '/iw_composer_addons/assets/js/jquery.parallax-1.1.3.js', array(), $theme_info->get('Version'), true);
        wp_enqueue_script('iw-server-location', plugins_url() . '/iw_composer_addons/assets/js/iw-server-location.js', array('jquery'), $theme_info->get('Version'), true);
        wp_enqueue_script('iw-main', plugins_url() . '/iw_composer_addons/assets/js/iw-main.js', array(), $theme_info->get('Version'), true);
        wp_enqueue_script('jquery-gallery', plugins_url() . '/iw_composer_addons/assets/js/jquery.gallery.js', array(), $theme_info->get('Version'), true);
    }

    function athlete_scripts_admin() {
        $theme_info = wp_get_theme();
        wp_deregister_style('font-awesome');
        wp_enqueue_style('font-awesome', plugins_url() . '/iw_composer_addons/assets/css/font-awesome/css/font-awesome.min.css', array(), $theme_info->get('Version'));
		wp_enqueue_style('font-whhg', plugins_url() . '/iw_composer_addons/assets/css/font-whhg/css/whhg.css', array(), $theme_info->get('Version'));
		wp_enqueue_style('glyphicons', plugins_url() . '/iw_composer_addons/assets/css/glyphicons.css', array(), $theme_info->get('Version'));
        wp_enqueue_style('iwicon', plugins_url() . '/iw_composer_addons/assets/css/iwicon.css', array(), $theme_info->get('Version'));
        wp_register_script('iw-main', plugins_url() . '/iw_composer_addons/assets/js/iw-main.js', array('jquery'), $theme_info->get('Version'), true);
        wp_enqueue_script('iw-server-location', plugins_url() . '/iw_composer_addons/assets/js/iw-server-location.js', array('jquery'), $theme_info->get('Version'), true);
        wp_enqueue_style('iw-main', plugins_url() . '/iw_composer_addons/assets/css/iw-main.css', array(), $theme_info->get('Version'));
        //wp_enqueue_script('select2-script', plugins_url() . '/iw_composer_addons/assets/js/select2.min.js', array('jquery'), $theme_info->get('Version'), true);
        //wp_enqueue_style('select2-style', plugins_url() . '/iw_composer_addons/assets/css/select2.min.css', array(), $theme_info->get('Version'));
        wp_localize_script('iw-main', 'iwConfig', array('ajaxUrl' => admin_url('admin-ajax.php'), 'siteUrl' => site_url(),'homeUrl'=>get_home_url(), 'whmcs_pageid' => get_option("cc_whmcs_bridge_pages")));
        wp_enqueue_script('iw-main');
        wp_enqueue_script('jquery-ui-draggable');
        wp_enqueue_script('jquery-ui-droppable');
    }

    function inwave_select($settings, $value) {
        $name = $settings['param_name'];
        $datas = $settings['data'];
        $multi = $settings['multiple'];
        $type = isset($settings['type']) ? $settings['type'] : '';
        $class = $settings['class'] ? $settings['class'] : '';
        $class .= ' wpb_vc_param_value ' . $name . " " . $type;
        return getInwaveSelect($name, $value, $datas, $multi, $class);
    }

    function iwcourses_categories($settings, $value) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $type = isset($settings['type']) ? $settings['type'] : '';
        $class = isset($settings['class']) ? $settings['class'] : '';
        $class = "wpb_vc_param_value " . $param_name . " " . $type . " " . $class;
        return getIwCourseCategories($param_name, $value, $class);
    }

    function iw_server_location($settings, $value) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $type = isset($settings['type']) ? $settings['type'] : '';
        $class = isset($settings['class']) ? $settings['class'] : '';
        $class = "wpb_vc_param_value " . $param_name . " " . $type . " " . $class;
        return getIwServerLoactionHtml($param_name, $value, $class);
    }

    function iw_range_skillbar($settings, $value) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $type = isset($settings['type']) ? $settings['type'] : '';
        $class = isset($settings['class']) ? $settings['class'] : '';
        $class = "wpb_vc_param_value " . $param_name . " " . $type . " " . $class;
        //return '<input class="skillbar_input '.$class.'" value="'.$value.'" type="range" min="0" max="100" step="1" name="'.$param_name.'"/>';
        return getIwRangeSkillbar($param_name, $value, $class);
    }

}

new InwaveVC_Support();
