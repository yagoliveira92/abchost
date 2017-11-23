<?php
/**
 * Shipping Calculator
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     2.0.8
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (get_option('woocommerce_enable_shipping_calc') === 'no' || !WC()->cart->needs_shipping()) {
    return;
}
?>
<?php do_action('woocommerce_before_shipping_calculator'); ?>
<form class="woocommerce-shipping-calculator" action="<?php echo esc_url(WC()->cart->get_cart_url()); ?>" method="post">
    <div class="woo-shipping-calculator-button"><b><a href="#" class="shipping-calculator-button"><?php _e( 'Calculate Shipping', 'woocommerce' ); ?></a></b></div>
    <section class="shipping-calculator-form" style="display:none;">
    <select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state" rel="calc_shipping_state">
        <option value=""><?php _e('Select a country&hellip;', 'woocommerce'); ?></option>
        <?php
        foreach (WC()->countries->get_shipping_countries() as $key => $value)
            echo '<option value="' . esc_attr($key) . '"' . selected(WC()->customer->get_shipping_country(), esc_attr($key), false) . '>' . esc_html($value) . '</option>';
        ?>
    </select>

    <?php
    $current_cc = WC()->customer->get_shipping_country();
    $current_r = WC()->customer->get_shipping_state();
    $states = WC()->countries->get_states($current_cc);

    // Hidden Input
    if (is_array($states) && empty($states)) {
        ?><input type="hidden" name="calc_shipping_state" id="calc_shipping_state"
                 placeholder="<?php esc_attr_e('State / county', 'woocommerce'); ?>" /><?php
        // Dropdown Input
    } elseif (is_array($states)) {
        ?><span>
        <select name="calc_shipping_state" id="calc_shipping_state"
                placeholder="<?php esc_attr_e('State / county', 'woocommerce'); ?>">
            <option value=""><?php esc_attr_e('Select a state&hellip;', 'woocommerce'); ?></option>
            <?php
            foreach ($states as $ckey => $cvalue)
                echo '<option value="' . esc_attr($ckey) . '" ' . selected($current_r, $ckey, false) . '>' . __(esc_html($cvalue), 'woocommerce') . '</option>';
            ?>
        </select>
        </span><?php
        // Standard Input
    } else {
        ?><input type="text" class="input-text" value="<?php echo esc_attr($current_r); ?>"
                 placeholder="<?php esc_attr_e('State / county', 'woocommerce'); ?>" name="calc_shipping_state"
                 id="calc_shipping_state" /><?php
    }
    ?>
    <?php if (apply_filters('woocommerce_shipping_calculator_enable_city', false)) : ?>
        <input type="text" class="input-text" value="<?php echo esc_attr(WC()->customer->get_shipping_city()); ?>"
               placeholder="<?php esc_attr_e('City', 'woocommerce'); ?>" name="calc_shipping_city" id="calc_shipping_city"/>
    <?php endif; ?>
	
	<div class="calc_shipping_postcode_wap">
    <?php if (apply_filters('woocommerce_shipping_calculator_enable_postcode', true)) : ?>
        <input type="text" class="input-text" value="<?php echo esc_attr(WC()->customer->get_shipping_postcode()); ?>"
               placeholder="<?php esc_attr_e('Postcode / Zip', 'woocommerce'); ?>" name="calc_shipping_postcode"
               id="calc_shipping_postcode"/>
    <?php endif; ?>
    
        <button type="submit" name="calc_shipping" value="1"
                class="button"><em class="fa-icon"><i class="fa fa-refresh"></i></em><span><?php _e('Update Totals', 'woocommerce'); ?></span></button>
    </div>
    <?php wp_nonce_field('woocommerce-cart'); ?>
    </section>
</form>
<?php do_action('woocommerce_after_shipping_calculator'); ?>
