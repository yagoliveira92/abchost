<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package inhost
 */

if ( ! is_active_sidebar( 'sidebar-faq' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-faq' ); ?>
</div><!-- #secondary -->
