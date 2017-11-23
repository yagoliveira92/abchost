<?php
/*
  Plugin Name: Portfolios Manager
  Plugin URI: http://inwavethemes.com
  Description: Portfolios Manager for inHost theme
  Version: 1.3.3
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

// translate plugin
add_action('plugins_loaded', 'iw_portfolio_load_textdomain');
function iw_portfolio_load_textdomain() {
    load_plugin_textdomain( 'inwavethemes', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}

//start session
if(session_id() == '' && !headers_sent()){session_start();}

include_once 'includes/functions.admin.php';
include_once 'includes/functions.front.php';


register_activation_hook(__FILE__, 'iw_portfolio_install');
register_uninstall_hook(__FILE__, 'iw_portfolio_uninstall');

add_action('init', 'iw_portfolio_add_post_types_portfolio');

add_action('init', 'iw_portfolio_add_taxonomy_class');

if (is_admin()) {
    add_action('load-post.php', 'addPortfoliosBox');
    add_action('load-post-new.php', 'addPortfoliosBox');
    add_action('delete_post', 'iwc_post_delete', 10);
}

// Add the fields to the "Class" taxonomy, using our callback function  
add_action('iwp_category_add_form_fields', 'class_metabox_add', 10, 1);
add_action('iwp_category_edit_form_fields', 'class_metabox_edit', 10, 2);

// Save the changes made on the "Class" taxonomy, using our callback function  
add_action('edited_iwp_category', 'save_class_taxonomy_iw_portfolio', 10, 2);
add_action('created_iwp_category', 'save_class_taxonomy_iw_portfolio', 10, 2);


add_action('init', 'iwcAddImageSize');


add_action('admin_enqueue_scripts', 'portfolioAdminAddScript');

function iwcAddAdminMenu() {
    add_options_page(__('Portfolio Settings', 'inwavethemes'), __('Portfolio Settings', 'inwavethemes'), 'manage_options', 'iw_portfolio_settings', 'optionRenderPage');
    add_submenu_page('edit.php?post_type=iw_portfolio', __('Extra Fields', 'inwavethemes'), __('Extra Fields', 'inwavethemes'), 'manage_options', 'extra-field', 'iwcExtrafieldRenderPage');
    add_submenu_page(null, null, __('Add Extra Field', 'inwavethemes'), 'manage_options', 'iwp-add-extra-field', 'iwcAddExtrafieldRenderPage');
    add_submenu_page('edit.php?post_type=iw_portfolio', __('Portfolio Settings', 'inwavethemes'), __('Settings', 'inwavethemes'), 'manage_options', 'settings', 'optionRenderPage');
}

add_action('admin_menu', 'iwcAddAdminMenu');

add_action('admin_post_iw_portfolio_setting', 'saveSetting');
add_action('admin_post_iw_portfolio_extrafield', 'saveIwPortfolioExtraField');
add_action('admin_post_iw_portfolio_extrafields_delete', 'deleteExtraFields');
add_action('admin_post_delete_extrafield', 'deleteExtraField');


/**
 * Add sort page.
 *
 * @since 1.0.0
 */
add_action('wp_ajax_iw_portfolio_sort', 'iw_portfolio_sort');



/* ----------------------------------------------------------------------------------
  FRONTEND FUNCTIONS
  ---------------------------------------------------------------------------------- */

/**
 * Register and enqueue scripts and styles for frontend.
 *
 * @since 1.0.0
 */
function iw_portfolio_front_scripts_styles() {
    /* Scripts */
    wp_enqueue_script('jquery');
    wp_enqueue_style('iwc-css', plugin_dir_url(__FILE__) . 'assets/css/iw_portfolio.css');
    wp_enqueue_style('owl-carousel', plugin_dir_url(__FILE__) . 'assets/css/owl.carousel.css');
    wp_enqueue_style('custombox', plugin_dir_url(__FILE__) . 'assets/css/custombox.min.css');
    wp_enqueue_style('owl-theme', plugin_dir_url(__FILE__) . 'assets/css/owl.theme.css');
    wp_register_script('owl-carousel', plugin_dir_url(__FILE__) . 'assets/js/owl.carousel.min.js', array('jquery'), '1.0.0', true);
    wp_register_script('custombox', plugin_dir_url(__FILE__) . 'assets/js/custombox.min.js', array('jquery'), '1.0.0', true);
    wp_register_script('iwc-js', plugin_dir_url(__FILE__) . 'assets/js/iwp_fe_script.js', array(), '1.0.0', true);
    wp_register_script('iwc-filtering', plugin_dir_url(__FILE__) . 'assets/js/filtering.js', array(), '1.0.0', true);
    wp_register_script('isotope', plugin_dir_url(__FILE__) . 'assets/js/isotope.pkgd.min.js', array(), '1.0.0', true);
    wp_localize_script('iwc-js', 'iwcCfg', array('siteUrl' => admin_url(), 'baseUrl' => site_url(), 'ajaxUrl' => admin_url('admin-ajax.php')));

    /* Styles */
}

add_action('wp_enqueue_scripts', 'iw_portfolio_front_scripts_styles');

/**
 * Set excerpt length.
 *
 * @since 1.0.0
 */
function iw_portfolio_excerpt_length($length) {

    global $post;

    if ($post->post_type == 'iw_portfolio')
        return 20;
    else
        return $length;
}

add_filter('excerpt_length', 'iw_portfolio_excerpt_length');

/**
 * Set excerpt more.
 */
function iw_portfolio_excerpt_more($more) {
    global $post;

    if ($post->post_type == 'iw_portfolio')
        return ' ...';
    else
        return $more;
}

add_filter('excerpt_more', 'iw_portfolio_excerpt_more');

// Add Shortcode
function iw_portfolio_list_shortcode($atts) {
    $bt_options = get_option('iw_portfolio_settings');
    // Attributes
    extract(shortcode_atts(
            array(
                'theme' => ($bt_options['theme']) ? $bt_options['theme'] : 'default',
                'cats' => '0',
                'order_by' => 'date',
                'order_dir' => 'desc',
                'number_column' => '3',
                'show_filter_bar' => '0',
                'item_per_page' => $bt_options['port_limit'] ? $bt_options['port_limit'] : '6',
            ), $atts)
    );

    // Code
    ob_start();
    iwPortfolioListHtmlPage($theme, $cats, $order_by, $order_dir, $item_per_page, $show_filter_bar, $number_column);
    $html = ob_get_contents();
    ob_end_clean();
    return $html;
}


add_shortcode('iw_portfolio_list', 'iw_portfolio_list_shortcode');
add_shortcode('iwp_relate', 'iw_portfolio_relate');

/**
 * Make embeds more generic by setting parameters to remove
 * related videos, set neutral colors, reduce branding, etc.
 *
 * @since 1.0.0
 * @link http://marquex.es/763/removing-youtube-embed-title-in-wordpress-automatically
 *
 * @param string $embed Embed HTML code
 * @return string Modified embed HTML code
 */
function iw_portfolio_generic_embeds($embed) {

// YouTube
    if (strpos($embed, 'youtu.be') !== false || strpos($embed, 'youtube.com') !== false) {

        return preg_replace("@src=(['\"])?([^'\">\s]*)@", "src=$1$2&showinfo=0&rel=0&hd=1", $embed);
    }
// Vimeo
    elseif (strpos($embed, 'vimeo.com') !== false) {

        return preg_replace("@src=(['\"])?([^'\">\s]*)@", "src=$1$2?title=0&byline=0", $embed);
    }
    return $embed;
}

add_filter('embed_oembed_html', 'iw_portfolio_generic_embeds');


//add ajax action iwcLoadPortfoliosPosts
add_action('wp_ajax_nopriv_iwcLoadPortfoliosPosts', 'iwcLoadPortfoliosPosts');
add_action('wp_ajax_iwcLoadPortfoliosPosts', 'iwcLoadPortfoliosPosts');
