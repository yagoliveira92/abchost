<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

    <div id="tabs" class="product-collateral">
		<ul id="woo-tab-buttons">
			<?php foreach ( $tabs as $key => $tab ) : ?>

				<li class="<?php echo esc_attr($key) ?>_tab">
					<a href="#tab-<?php echo esc_attr($key) ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?></a>
				</li>

			<?php endforeach; ?>
		</ul>
		
		<div id="woo-tab-contents">
		<?php foreach ( $tabs as $key => $tab ) : ?>

			<div class="box-collateral" id="tab-<?php echo esc_attr($key) ?>">
				<?php call_user_func( $tab['callback'], $key, $tab ) ?>
			</div>

		<?php endforeach; ?>
		</div>
	</div>

<?php endif; ?>



<script type="text/javascript">
jQuery(document).ready(function($){
	$("#woo-tab-contents .box-collateral").hide(); // Initially hide all content
	$("#woo-tab-buttons li:first").attr("class","current"); // Activate first tab
	$("#woo-tab-contents .box-collateral:first").show(); // Show first tab content
    
    $('#woo-tab-buttons li a').click(function(e) {
        e.preventDefault();        
        $("#woo-tab-contents .box-collateral").hide(); //Hide all content
        $("#woo-tab-buttons li").attr("class",""); //Reset id's
        $(this).parent().attr("class","current"); // Activate this
        $($(this).attr('href')).fadeIn(); // Show content for current tab
    });
})();
</script>






