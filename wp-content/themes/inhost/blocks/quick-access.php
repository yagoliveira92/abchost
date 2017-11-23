<?php
/**
 * The template part for displaying quick access block. Including cart & search widgets
 * @package inhost
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
global $smof_data;

$whmcs_home = '';
$isloggedin = is_user_logged_in();
$loginUrl = wp_login_url(get_permalink());
$cartUrl = '';
$loginIcon = 'fa fa-unlock';
$redirectLink = get_permalink();
$cartTotal = 0;
$formAction = '';
$sef = get_option('permalink_structure');

/** WHMCS Bridge */
if (is_plugin_active('whmcs-bridge-sso/sso.php') && get_option('cc_whmcs_bridge_sso_singlesignon') == 'checked') {
    $whmcs_home = get_the_permalink(cc_whmcs_bridge_mainpage()) . ($sef ? '?' : '&') . 'ccce=';
    $loginUrl = $whmcs_home . 'clientarea';
    $cartUrl = $whmcs_home . 'cart&a=view';
    $resetPass = $whmcs_home . 'pwreset';
    $createAccount = $whmcs_home . 'register';
    if ($isloggedin) {
        $loginUrl = $whmcs_home . 'clientarea&action=details';
    }
}

/** WHMPress */
if (is_plugin_active('WHMpress_Client_Area/client-area.php') || is_plugin_active('WHMCS_Client_Area/index.php')) {
    $isloggedin = do_shortcode("[whmpress_whmcs_if_loggedin]logged[/whmpress_whmcs_if_loggedin]") == 'logged';
    $whmcs_home = get_the_permalink(get_option('client_area_page_url')) . ($sef ? '' : '&whmpca=');
    $cartTotal = str_replace(array('(', ')'), '', strip_tags(do_shortcode('[whmpress_whmcs_cart link_text=" "]')));

    $loginUrl = $whmcs_home . 'clientarea';
    $cartUrl = $whmcs_home . 'cart' . ($sef ? '/a/view' : '&a=view');
    $resetPass = $whmcs_home . 'pwreset';
    $createAccount = $whmcs_home . 'register';
    if ($isloggedin) {
        $loginUrl = $whmcs_home . 'clientarea' . ($sef ? '/action/details' : '&action=details');
    }
    $formAction = $whmcs_home . 'dologin';
}


if (!$whmcs_home) {
    if (get_option('woocommerce_myaccount_page_id') && function_exists('WC')) {
        $loginUrl = get_the_permalink(get_option('woocommerce_myaccount_page_id'));
    } else {
        $loginUrl = get_edit_user_link();
    }
    if (function_exists('WC')) {
        $cartUrl = WC()->cart->get_cart_url();
        $cartTotal = WC()->cart->cart_contents_count;
    }
}
if ($isloggedin) {
    $loginIcon = 'fa fa-user';
}
?>
<div class="head-login">
    <a href="<?php echo esc_url($loginUrl) ?>" class="login-icon"><span class="inner-icon ibutton-effect3"><i class="<?php echo esc_attr($loginIcon) ?>"></i></span></a>
    <?php if ($smof_data['woocommerce_cart_top_nav'] && $cartUrl): ?>
        <a href="<?php echo esc_url($cartUrl); ?>" class="cart-icon">
            <span class="inner-icon ibutton-effect3"><i class="fa fa-shopping-cart"></i></span>
            <span class="cart-product-number"><?php echo $cartTotal; ?></span>
        </a>
    <?php endif ?>
</div>

<?php if (!$isloggedin): ?>
    <div id="iw-login-form" class="iw-login-form">
        <?php if ($formAction) : ?>
            <!-- WHMCS Login form -->
            <form action="<?php echo esc_url($formAction) ?>" method="post">
                <h3><?php _e('LOG IN', 'inwavethemes') ?></h3>
                <div class="iw-login-content">
                    <div class="login-close-btn"><i class="fa fa-times"></i></div>
                    <div class="control-group">
                        <label for="username" class="control-label"><?php _e('Email Address:', 'inwavethemes') ?></label>
                        <div class="controls">
                            <input type="text" id="username" name="username" class="input-xlarge">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="password" class="control-label"><?php _e('Password:', 'inwavethemes') ?></label>
                        <div class="controls">
                            <input type="password" id="password" name="password" class="input-xlarge">
                        </div>
                    </div>

                    <div class="loginbtn"><button type="submit" class="ibutton ibutton1 ibutton-small ibutton-effect3" ><i class="fa fa-lock"></i><span><?php _e('LOGIN', 'inwavethemes') ?></span></button></div>
                    <div class="rememberme"><input type="checkbox" name="rememberme"> &nbsp; <label><?php _e('Remember Me', 'inwavethemes') ?></label></div>

                </div>
                <div class="iw-login-footer">
                    <ul>
                        <li><a href="<?php echo esc_url($createAccount); ?>"><?php _e('Create a account', 'inwavethemes') ?></a></li>
                        <li><a href="<?php echo esc_url($resetPass); ?>"><?php _e('Forgot password', 'inwavethemes') ?></a></li>
                    </ul>
                </div>
            </form>
        <?php else: ?>
            <!-- Wordpress Login form -->
            <form method="post" action="<?php echo esc_url(wp_login_url(get_permalink())); ?>" name="loginform">
                <h3><?php _e('LOG IN', 'inwavethemes') ?></h3>
                <div class="iw-login-content">
                    <div class="login-close-btn"><i class="fa fa-times"></i></div>
                    <div class="control-group">
                        <label for="username" class="control-label"><?php _e('Username:', 'inwavethemes') ?></label>
                        <div class="controls">
                            <input type="text" id="username" name="log" class="input-xlarge">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="password" class="control-label"><?php _e('Password:', 'inwavethemes') ?></label>
                        <div class="controls">
                            <input type="password" id="password" name="pwd" class="input-xlarge">
                        </div>
                    </div>

                    <div class="loginbtn"><button type="submit" class="ibutton ibutton1 ibutton-small ibutton-effect3" ><i class="fa fa-lock"></i><span><?php _e('LOGIN', 'inwavethemes') ?></span></button></div>
                    <div class="rememberme"><input type="checkbox" value="forever" id="rememberme" name="rememberme"> &nbsp; <label><?php _e('Remember Me', 'inwavethemes') ?></label></div>
                    <input type="hidden" value="<?php echo esc_url($redirectLink); ?>" name="redirect_to">
                    <input type="hidden" value="Log In" name="wp-submit">
                </div>
                <div class="iw-login-footer">
                    <ul>
                        <?php if (is_plugin_active('whmcs-bridge-sso/sso.php') && get_option('cc_whmcs_bridge_sso_singlesignon') == 'checked') : ?>
                            <li><a href="<?php echo esc_url($createAccount); ?>"><?php _e('Create a account', 'inwavethemes') ?></a></li>
                            <li><a href="<?php echo esc_url($resetPass); ?>"><?php _e('Forgot password', 'inwavethemes') ?></a></li>
                        <?php else: ?>
                            <li><a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php _e('Forgot password', 'inwavethemes') ?></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </form>
        <?php endif ?>
    </div>
<?php endif ?>

