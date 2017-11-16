<?php
/*
 * @package Inwave Inhost
 * @version 1.0.0
 * @created Apr 10, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */
/**
 * Description of inhost_checkdomain
 *
 * @developer duongca
 */
if (!class_exists('Inhost_Checkdomain')) {

    class Inhost_Checkdomain {

        private $domains;
        private $params;
        private $scripts;
        private $whoisservers;
        private $whmcs_link;

        function __construct() {
            $this->initParams();
            add_action('vc_before_init', array($this, 'heading_init'));
            add_shortcode('inhost_checkdomain', array($this, 'inhost_checkdomain_shortcode'));
            add_action('wp_enqueue_scripts', array($this, 'inwave_check_domain_scripts'));
            //add ajax action domain lookup
            add_action('wp_ajax_nopriv_domainLookup', array($this, 'domainLookup'));
            add_action('wp_ajax_domainLookup', array($this, 'domainLookup'));
        }

        function initParams() {
            global $iw_shortcodes;

            $this->scripts = array(
                'scripts' => array(
                    'custombox' => plugins_url('iw_composer_addons/assets/js/custombox.min.js'),
                    'inwave-check-domain' => plugins_url('iw_composer_addons/assets/js/inwave-check-domain.js')
                ),
                'styles' => array(
                    'custombox' => plugins_url('iw_composer_addons/assets/css/custombox.css'),
                    'inwave-check-domain' => plugins_url('iw_composer_addons/assets/css/inwave-check-domain.css')
                )
            );

            $this->params = array(
                'name' => 'Domain Checking',
                'description' => __('Create a block for checking domain', 'inwavethemes'),
                'base' => 'inhost_checkdomain',
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
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("WHMCS Link", "inwavethemes"),
                        "value" => "",
                        'description' => __('This is required field if you don\'t use whmpress/whmcs bridge plugins', 'inwavethemes'),
                        "param_name" => "whmcs_link"
                    ),
                    array(
                        'type' => 'textarea',
                        "holder" => "div",
                        "heading" => __("Description", "inwavethemes"),
                        "param_name" => "description"
                    ),
                    array(
                        "type" => "textarea",
                        "heading" => __("Domain list", "inwavethemes"),
                        "param_name" => "domain_type",
                        "value" => ".com\n.net\n.org\n.info\n.co\n.biz",
                        "text" => 'Select Domains',
                        "description" => __('Domains to check, each domain put in new line. <strong>Important: </strong>Domain need enable in whmcs to can check.', "inwavethemes")
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
                            "Style 3 - Use Select 2" => "style3"
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    )
                )
            );
            $iw_shortcodes['inhost_checkdomain'] = $this->params;
            $iw_shortcodes['inhost_checkdomain_script'] = $this->scripts;
        }

        function heading_init() {
            if (function_exists('vc_map')) {
                // Add banner addon
                vc_map($this->params);
            }
        }

        function inhost_checkdomain_shortcode($atts, $content = null) {
            extract(shortcode_atts(array(
                'title' => '',
                'whmcs_link' => '',
                'description' => '',
                'domain_type' => ".com\n.net\n.org\n.info\n.co\n.biz",
                'style' => 'style1',
                'class' => ''
                            ), $atts));
            $this->whmcs_link = $whmcs_link;
            return $this->htmlBoxRender($style, $title, $description, $domain_type, $class);
        }

        function htmlBoxRender($style, $title, $description, $domain_type, $class) {
            $domain_type = str_replace('<br />', "\n", $domain_type);
            $domain_type = explode("\n", $domain_type);
            $this->domains = array();
            $class .= ' ' . $style;
            foreach ($domain_type as $domain) {
                if ($domain) {
                    $this->domains[] = $domain;
                }
            }
            ob_start();
            ?>
            <div class="inwave-domain-check <?php echo $class; ?>">
                <div class="domain-check-inner">
                    <div class="ajax-spinner iw-hidden">
                        <div class="spinner">
                            <div class="rect1"></div>
                            <div class="rect2"></div>
                            <div class="rect3"></div>
                            <div class="rect4"></div>
                            <div class="rect5"></div>
                        </div>
                    </div>
                    <?php
                    switch ($style) {
                        case 'style1':
                            ?>
                            <div class="input-search-box">
                                <div class="search-input">
                                    <div class="left-col theme-bg">
                                        <input type="text" name="input_domain"/>

                                        <div class="list-domain-check">
                                            <ul class="domain-list">
                                                <?php
                                                foreach ($this->domains as $domain) {
                                                    echo '<li>'
                                                    . '<input name="domains[]" type="checkbox" value="' . $domain . '">'
                                                    . '<span class="inwave-checkbox"><i class="fa fa-square-o"></i></span>'
                                                    . $domain
                                                    . '</li>';
                                                }
                                                ?>
                                            </ul>
                                            <div class="output-error-msg theme-color">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="right-col">
                                        <a data-cartlink="<?php echo esc_url($this->getWhmcsLink('cart', 'a=add&domain=register&domainoption=register')); ?>" data-morelink="<?php echo esc_url($this->getWhmcsLink('domainchecker')); ?>" class="theme-bg ibutton ibutton1 ibutton-large"
                                           href="#"><span><?php _e('Search', 'inwavethemes') ?></span></a>
                                        <span class="button-link theme-color"><i class="fa fa-th-list"></i><a
                                                style="text-decoration: none;"
                                                href="<?php echo esc_url($this->getWhmcsLink('domainchecker', 'search=bulkregister')); ?>"> <?php _e('Bulk Domain Search', 'inwavethemes'); ?></a></span>
                                    </div>
                                    <div style="clear: both;"></div>
                                </div>
                            </div>
                            <div class="output-search-box">
                                <div class="list-domain-checked">
                                </div>
                            </div>
                            <?php
                            break;
                        case 'style2':
                            ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="heading-block">
                                        <h3 class="theme-color"><?php echo $title ?></h3>
                                        <p><?php echo $description ?></p>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="list-domain-check">
                                        <div class="input-search-box">
                                            <input type="text" name="input_domain"/>
                                            <div class="domain-select-list">
                                                <ul class="domain-list">
                                                    <?php
                                                    foreach ($this->domains as $k => $domain) {
                                                        if ($k == 0) {
                                                            $slect = $domain;
                                                        }
                                                        echo '<li>'
                                                        . '<input name="domains[]" type="checkbox" value="' . $domain . '" ' . ($k == 0 ? 'checked="checked"' : '') . '>'
                                                        . '<span class="inwave-checkbox"><i class="fa fa-check"></i></span>'
                                                        . $domain
                                                        . '</li>';
                                                    }
                                                    ?>
                                                </ul>
                                                <span class="theme-color select-domain"><i class="fa fa-check"></i> <?php echo $slect; ?></span>
                                            </div>
                                            <button data-cartlink="<?php echo esc_url($this->getWhmcsLink('cart', 'a=add&domain=register&domainoption=register')); ?>" data-morelink="<?php echo esc_url($this->getWhmcsLink('domainchecker')); ?>" type="submit" class="theme-bg ibutton ibutton1" name="seach_domain"><span><?php _e('Search', 'inwavethemes') ?></span></button>
                                        </div>
                                        <div class="domain-link">
                                            <a class="inherit-color" href="<?php echo esc_url($this->getWhmcsLink('domainchecker', '') . '#domain-pricing'); ?>"> <?php _e('View Domain Price List', 'inwavethemes'); ?></a> | 
                                            <a class="inherit-color" href="<?php echo esc_url($this->getWhmcsLink('domainchecker', 'search=bulkregister')); ?>"> <?php _e('Bulk Domain Search', 'inwavethemes'); ?></a> | 
                                            <a class="inherit-color" href="<?php echo esc_url($this->getWhmcsLink('domainchecker', 'transfer=transfer')); ?>"> <?php _e('Transfer Domain', 'inwavethemes'); ?></a>
                                        </div>
                                        <div class="output-error-msg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="output-search-box">
                                <div class="list-domain-checked">
                                </div>
                            </div>
                            <?php
                            break;
                        case 'style3':
                            wp_enqueue_script('select2');
                            wp_enqueue_style('select2');
                            ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="heading-block">
                                        <h3 class="theme-color"><?php echo $title ?></h3>
                                        <p><?php echo $description ?></p>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="list-domain-check">
                                        <div class="input-search-box">
                                            <input type="text" name="input_domain"/>
                                            <div class="domain-select-list">
                                                <select id="domains" class="select-domain theme-color" name="domains[]">
                                                    <?php
                                                    foreach ($this->domains as $k => $domain) {
                                                        echo '<option value="' . $domain . '">' . $domain . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <script type="text/javascript">
                                                    (function ($) {
                                                        $(document).ready(function () {
                                                            $("#domains").select2({
                                                                placeholder: "",
                                                                allowClear: true
                                                            });
                                                        });
                                                    })(jQuery);
                                                </script>
                                            </div>
                                            <button data-cartlink="<?php echo esc_url($this->getWhmcsLink('cart', 'a=add&domain=register&domainoption=register')); ?>" data-morelink="<?php echo esc_url($this->getWhmcsLink('domainchecker')); ?>" type="submit" class="theme-bg ibutton ibutton1" name="seach_domain"><span><?php _e('Search', 'inwavethemes') ?></span></button>
                                        </div>
                                        <div class="domain-link">
                                            <a class="inherit-color" href="<?php echo esc_url($this->getWhmcsLink('domainchecker', '') . '#domain-pricing'); ?>"> <?php _e('View Domain Price List', 'inwavethemes'); ?></a> | 
                                            <a class="inherit-color" href="<?php echo esc_url($this->getWhmcsLink('domainchecker', 'search=bulkregister')); ?>"> <?php _e('Bulk Domain Search', 'inwavethemes'); ?></a> | 
                                            <a class="inherit-color" href="<?php echo esc_url($this->getWhmcsLink('domainchecker', 'transfer=transfer')); ?>"> <?php _e('Transfer Domain', 'inwavethemes'); ?></a>
                                        </div>
                                        <div class="output-error-msg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="output-search-box">
                                <div class="list-domain-checked">
                                </div>
                            </div>
                            <?php
                            break;
                    }
                    echo '</div>';
                    echo '</div>';
                    $html = ob_get_contents();
                    ob_end_clean();
                    return $html;
                }

                function inwave_check_domain_scripts() {
                    $theme_info = wp_get_theme();
                    wp_enqueue_style('custombox', plugins_url('iw_composer_addons/assets/css/custombox.css'), array(), $theme_info->get('Version'));
                    wp_register_style('select2', plugins_url('iw_composer_addons/assets/css/select2.min.css'), array(), $theme_info->get('Version'));
                    wp_enqueue_script('custombox', plugins_url('iw_composer_addons/assets/js/custombox.min.js'), array('jquery'), $theme_info->get('Version'), true);
                    wp_register_script('select2', plugins_url('iw_composer_addons/assets/js/select2.min.js'), array('jquery'), $theme_info->get('Version'), true);
                    wp_enqueue_style('inwave-check-domain', plugins_url('iw_composer_addons/assets/css/inwave-check-domain.css'), array(), $theme_info->get('Version'));
                    wp_register_script('inwave-check-domain', plugins_url('iw_composer_addons/assets/js/inwave-check-domain.js'), array('jquery'), $theme_info->get('Version'), true);
                    $iwConfig = array(
                        'ajaxUrl' => admin_url('admin-ajax.php'),
                        'siteUrl' => site_url(),
                        'msg_suggest' => __('Please enter the domain name you want to register!', 'inwavethemes'),
                        'msg_available' => __(' Congrats, %d is available!', 'inwavethemes'),
                        'msg_unavailable' => __('%d is not available!', 'inwavethemes')
                    );
//                    $iwConfig['whmcs_cart_page'] = $this->getWhmcsLink('cart', 'a=add&domain=register&domainoption=register');
//                    $iwConfig['whmcs_morelink_page'] = $this->getWhmcsLink('domainchecker');
                    wp_localize_script('inwave-check-domain', 'iwConfig', $iwConfig);
                    wp_enqueue_script('inwave-check-domain');
                }

                function domainLookup() {
                    $domain = trim($_POST['domain']);
                    $username = get_option('cc_whmcs_bridge_admin_login');
                    $password = get_option('cc_whmcs_bridge_admin_password');
                    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    if ($username && $password && is_plugin_active('whmcs-bridge-sso/sso.php')) {
                        echo $this->whmcsDomainLookup($domain);
                    } else {
                        echo $this->noWhmcsDomainLookup($domain);
                    }
                    exit();
                }

                function whmcsDomainLookup($domain) {
                    $return = array('success' => FALSE, 'msg' => '', 'data' => '');
                    $url = get_option('cc_whmcs_bridge_url') . '/includes/api.php'; # URL to WHMCS API file
                    $username = get_option('cc_whmcs_bridge_admin_login'); # Admin username goes here
                    $password = get_option('cc_whmcs_bridge_admin_password'); # Admin password goes here
                    $postfields = array();
                    $postfields["username"] = $username;
                    $postfields["password"] = md5($password);
                    $postfields["action"] = "domainwhois";
                    $postfields["domain"] = $domain;
                    $postfields["responsetype"] = "json";
                    $query_string = "";
                    foreach ($postfields AS $k => $v)
                        $query_string .= "$k=" . urlencode($v) . "&";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    $jsondata = curl_exec($ch);
                    if (curl_error($ch)) {
                        $return['msg'] = "Connection Error: " . curl_errno($ch) . ' - ' . curl_error($ch);
                        curl_close($ch);
                    } else {
                        $arr = json_decode($jsondata); # Decode JSON String
                        if (is_object($arr)) {
                            $return['success'] = $arr->result == 'success' ? true : false;
                            if (!$return['success']) {
                                $return['msg'] = $arr->message;
                            } else {
                                $return['msg'] = $arr->status;
                                $return['data'] = $arr->whois;
                            }
                        } else {
                            $return['msg'] = $jsondata;
                        }
                    }
                    return json_encode($return);
                }

                function noWhmcsDomainLookup($domain) {

                    // For the full list of TLDs/Whois servers see http://www.iana.org/domains/root/db/ and http://www.whois365.com/en/listtld/
                    $this->whoisservers = json_decode(file_get_contents(ABSPATH . PLUGINDIR . '/iw_composer_addons/inc/whois.servers.json'), true);
                    $return = array('success' => FALSE, 'msg' => '', 'data' => '');
                    if (preg_match('/^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)*[a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?$/i', $domain) != 1) {
                        $return['msg'] = __('Invalid domain (letters, numbers and hyphens only)', 'inwavethemes');
                    } else {
                        preg_match('@^(http://www\.|http://|www\.)?([^/]+)@i', $domain, $preg_metch_result);
                        $f_result = '';

                        $domain = $preg_metch_result[2];
                        $domain_name_array = explode('.', $domain);
                        $domain_domain = null;
                        for ($i = 1; $i < count($domain_name_array); $i++) {
                            if ($domain_domain) {
                                $domain_domain .= '.' . $domain_name_array[$i];
                            } else {
                                $domain_domain .= $domain_name_array[$i];
                            }
                        }

                        $ext_in_list = false;

                        if (array_key_exists($domain_domain, $this->whoisservers)) {
                            $ext_in_list = true;
                        }else{
							$domain_domain = end($domain_name_array);
							if (array_key_exists($domain_domain, $this->whoisservers)) {
								$ext_in_list = true;
							}
						}
						

                        if (strlen($domain) > 0 && $ext_in_list) {
                            $server = '';

                            $server = $this->whoisservers[$domain_domain][0];
                            $lookup_result = gethostbyname($server);

                            if ($lookup_result == $server) {
                                $return['msg'] = sprintf(__('Error: Invalid extension - %s. / server has outgoing connections blocked to %s.', 'inwavethemes'), $domain_domain, $server);
                            } else {

                                $fs = fsockopen($server, 43, $errno, $errstr, 10);
                                if (!$fs || ($errstr != "")) {
                                    $return['msg'] = sprintf(__('Error: (%s) %s (%s)', 'inwavethemes'), $server, $errstr, $errno);
                                } else {

                                    fputs($fs, "$domain\r\n");
                                    while (!feof($fs)) {
                                        $f_result .= fgets($fs, 128);
                                    }

                                    fclose($fs);

                                    if ($domain_domain == 'org') {
                                        nl2br($f_result);
                                    }

                                    $return['success'] = true;
                                    if (preg_match('/' . $this->whoisservers[$domain_domain][1] . '/i', $f_result)) {
                                        $return['msg'] = 'available';
                                    } else {
                                        $return['data'] = '<pre>' . $f_result . '</pre>';
                                        $return['msg'] = 'unavailable';
                                    }
                                }
                            }
                        } else {
                            $return['msg'] = __('Invalid Domain and/or TLD server entry does not exist.', 'inwavethemes');
                        }
                    }
                    return json_encode($return);
                }

                public function getWhmcsLink($page, $action = '') {
                    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    $link = '#';

                    if ($this->whmcs_link) {
                        $link = rtrim($this->whmcs_link, '/');
                        $link .= '/' . $page . '.php';
                        if ($action) {
                            $link .= '?' . $action;
                        }
                    } else if (is_plugin_active('whmcs-bridge/bridge.php') && function_exists('cc_whmcs_bridge_mainpage')) {
                        $link = get_the_permalink(cc_whmcs_bridge_mainpage());
                        if ($this->check_permarklink($link)) {
                            $link.= '&ccce=' . $page;
                        } else {
                            $link.= '?ccce=' . $page;
                        }
                        if ($action) {
                            $link .= '&' . $action;
                        }
                    } elseif (is_plugin_active('whmpress/whmpress.php') && get_option('client_area_page_url')) {
                        $link = get_the_permalink(get_option('client_area_page_url'));
                        if ($this->check_permarklink($link)) {
                            $link.= '&whmpca=' . $page;
                        } else {
                            $link.= '?whmpca=' . $page;
                        }
                        if ($action) {
                            $link .= '&' . $action;
                        }
                    } elseif (is_plugin_active('WHMCS_Client_Area/index.php') && get_option('client_area_page_url')) {
                        $link = get_the_permalink(get_option('client_area_page_url'));
                        if ($this->check_permarklink($link)) {
                            $link.= '&whmpca=' . $page;
                        } else {
                            $link.= '?whmpca=' . $page;
                        }
                        if ($action) {
                            $link .= '&' . $action;
                        }
                    } elseif (is_plugin_active('WHMpress_Client_Area/client-area.php') && get_option('client_area_page_url')) {
                        $link = get_the_permalink(get_option('client_area_page_url'));
                        if ($this->check_permarklink($link)) {
                            $link.= '&whmpca=' . $page;
                        } else {
                            $link.= '?whmpca=' . $page;
                        }
                        if ($action) {
                            $link .= '&' . $action;
                        }
                    } else {
                        $link .= $page . '.php';
                        if ($action) {
                            $link .= '?' . $action;
                        }
                    }
                    return $link;
                }

                function check_permarklink($link) {
                    $permarlink = true;
                    $count = count(explode('?', $link));
                    if ($count == 1) {
                        $permarlink = false;
                    }
                    return $permarlink;
                }

            }

        }
        new Inhost_Checkdomain();
        if (class_exists('WPBakeryShortCode')) {

            class WPBakeryShortCode_Inhost_Checkdomain extends WPBakeryShortCode {
                
            }

        }