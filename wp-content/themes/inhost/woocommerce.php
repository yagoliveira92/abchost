<?php
/**
 * The template for displaying Category pages
 * @package inhost
 */
get_header();
?>
<?php if ($inwave_cfg['slide-id']) { ?>
    <div class="slide-container <?php echo esc_attr($inwave_cfg['slide-id'])?>">
        <?php putRevSlider($inwave_cfg['slide-id']); ?>
    </div>
<?php } ?>
<?php if ($inwave_cfg['show-pageheading']) { ?>
    <div class="page-heading">
        <div class="container">
            <div class="page-title">
                <h1><?php echo woocommerce_page_title() ?></h1>
                <?php woocommerce_breadcrumb(); ?>
            </div>
        </div>
    </div>
<?php } ?>
<div class="page-content">
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="<?php echo esc_attr(inwave_get_classes('container',$inwave_cfg['sidebar-position']))?> blog-content">
                    <?php
                    if ( is_singular( 'product' ) ) {
                        while ( have_posts() ) : the_post();
                            wc_get_template_part( 'content', 'single-product' );
                        endwhile;
                    } else {
                        wc_get_template_part( 'category', 'product' );
                    }
                    ?>
                </div>
                <?php if ($inwave_cfg['sidebar-position']) { ?>
                    <div class="<?php echo esc_attr(inwave_get_classes('sidebar',$inwave_cfg['sidebar-position']))?> default-sidebar">
                        <?php get_sidebar('woocommerce'); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
