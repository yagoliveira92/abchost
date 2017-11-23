<?php

/**
 * $theme: name of portfolio theme
 * $cats: list of categories to show
 * show_sub: show sub category
 * show_port: show portfolio
 * $filter_bar: show or hide item filter bar
 * $item_per_page: number of item show on per page
 */
#wp_enqueue_style('default-css', plugin_dir_url(__FILE__) . 'assets/css/default.css');
#wp_register_script('default-js', plugin_dir_url(__FILE__) . 'assets/js/default.js', array('jquery'));
wp_localize_script('default-js', 'iwcCfg', array('siteUrl' => admin_url('admin-ajax.php')));
wp_enqueue_script('iwc-filtering');
wp_enqueue_script('isotope');
wp_enqueue_script('iwc-js');
global $wpdb;
$utility = new iwcUtility();
$query = $utility->getPortfoliosList($cats, $order_by, $order_dir, $item_per_page);

if ($query->have_posts()) {
    include_once 'list_portfolios.' . $utility->getPortfolioOption('cat_layout', 'flat') . '.php';
} else {
    echo __('No portfolio was found','inwavethemes');
}
