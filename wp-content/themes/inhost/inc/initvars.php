<?php
/***********
 * LOAD THEME CONFIGURATION FILE
 */

global $inwave_cfg,$smof_data;

// Declare variables
$postId = get_the_ID();
// woo commerce shop ID
if( function_exists('is_shop') ) {
	if( is_shop() ) {
		$postId = get_option('woocommerce_shop_page_id');
	}
}

// get revolution slider-id from post meta
if(function_exists('putRevSlider')){
    $inwave_cfg['slide-id'] = get_post_meta( $postId, 'inwave_slider', true );
}else{
    $inwave_cfg['slide-id'] = 0;
}

// get show or hide heading from post meta
$inwave_cfg['show-pageheading']= get_post_meta( $postId, 'inwave_show_pageheading', true );
if(!$inwave_cfg['show-pageheading']){
	$inwave_cfg['show-pageheading'] = $smof_data['show_page_heading'];
}

if($inwave_cfg['show-pageheading'] =='no' || empty($inwave_cfg['show-pageheading'])){
    $inwave_cfg['show-pageheading']= 0;
}
else{
    $inwave_cfg['show-pageheading']= 1;
}

// get heading background
$inwave_cfg['pageheading_bg'] = get_post_meta( $postId, 'inwave_pageheading_bg', true );
if($inwave_cfg['pageheading_bg']){
    $inwave_cfg['pageheading_bg']= wp_get_attachment_image_src($inwave_cfg['pageheading_bg'],'large');
    $inwave_cfg['pageheading_bg']= $inwave_cfg['pageheading_bg'][0];
}
$inwave_cfg['sidebar-position'] = $smof_data['sidebar_position'];

if(!$inwave_cfg['sidebar-position']){
    $inwave_cfg['sidebar-position'] = 'right';
}
// get sidebar position from post meta
$sliderbarPos= get_post_meta( $postId, 'inwave_sidebar_position',true);
if($sliderbarPos){
    $inwave_cfg['sidebar-position'] = $sliderbarPos;
}
if($inwave_cfg['sidebar-position']=='none'){
    $inwave_cfg['sidebar-position'] = '';
}

$inwave_cfg['sidebar-name'] = '';
if(!isset($inwave_cfg['page-classes'])){
	$inwave_cfg['page-classes'] = '';
}
if (class_exists('WooCommerce') && (is_cart() || is_checkout())) {
    $inwave_cfg['page-classes'] .= ' page-product';
    $inwave_cfg['sidebar-name'] = 'woocommerce';
}
// get sidebar name
if(get_post_meta( $postId, 'inwave_sidebar_name',true)){
    $inwave_cfg['sidebar-name'] = get_post_meta( $postId, 'inwave_sidebar_name',true);
}

// get Page Class from post meta
if(!isset($inwave_cfg['page-classes'])) {
    $inwave_cfg['page-classes'] = '';
}
$inwave_cfg['page-classes'] .= get_post_meta($postId, 'inwave_page_class', true);

// header layout
if($smof_data['header_layout']){
    $inwave_cfg['header-option'] = $smof_data['header_layout'];
}
$headerOption = get_post_meta( $postId, 'inwave_header_option',true );
if($headerOption){
    $inwave_cfg['header-option'] = $headerOption;
}
if(!isset($inwave_cfg['header-option']) || $inwave_cfg['header-option']==''){
    $inwave_cfg['header-option'] = 'default';
}

// footer layout
if(!isset($inwave_cfg['footer-option'])){
	$inwave_cfg['footer-option'] = '';
}
if($smof_data['footer_option']){
	$inwave_cfg['footer-option'] = $smof_data['footer_option'];
}
$footerOption = get_post_meta( $postId, 'inwave_footer_option',true );
if($footerOption){
	$inwave_cfg['footer-option'] = $footerOption;
}


/** defined primary theme menu */
$inwave_cfg['theme-menu'] = 'primary';
$inwave_cfg['theme-menu-id'] = get_post_meta( $postId, 'inwave_primary_menu',true );

/* Logo */
if(!substr_count($smof_data['logo'],'http://') && !substr_count($smof_data['logo'],'https://')){
    $smof_data['logo'] = site_url() .'/'.$smof_data['logo'];
}
if(get_post_meta( $postId, 'inwave_logo',true )){
    $smof_data['logo'] = wp_get_attachment_image_src(get_post_meta( $postId, 'inwave_logo',true ),'large');
    $smof_data['logo'] = $smof_data['logo'][0];
}
if($smof_data['footer-logo'] && !substr_count($smof_data['footer-logo'],'http://') && !substr_count($smof_data['footer-logo'],'https://')){
    $smof_data['footer-logo'] = site_url() .'/'.$smof_data['footer-logo'];
}
if(!$smof_data['footer-logo']){
    $smof_data['footer-logo'] = $smof_data['logo'];
}

/* add body class: support white color and boxed layout */
add_filter( 'body_class','inwave_add_body_class');
function inwave_add_body_class($classes){
    global $inwave_cfg,$smof_data;
    $themeStyle = get_post_meta( get_the_ID(), 'inwave_theme_style',true );
    $waypoints = get_post_meta( get_the_ID(), 'inwave_waypoints',true );
    if(!$themeStyle){
        $themeStyle = $inwave_cfg['panel-settings']->themeStyle;
    }
    if($waypoints 
		&& !(isset($smof_data['force_disable_waypoints']) && $smof_data['force_disable_waypoints'])
		&& (!(isset($_REQUEST['vc_editable']) && $_REQUEST['vc_editable']))){
        $classes[] = 'waypoints';
    }
    if($inwave_cfg['page-classes']){
        $classes[] = $inwave_cfg['page-classes'];
    }
    if($themeStyle == 'dark'){
        $classes[] = 'index-dark';
    }
    if($inwave_cfg['panel-settings']->layout=='boxed'){
        $classes[] = 'body-boxed';
    }

    return $classes;
}