<?php
/**
 * Template Name: Home Page - No Sidebar
 * This is the template that is used for the Home page, no sidebar
 */
global $inwave_cfg;
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
            <?php the_title('<h1>','</h1>') ?>
            <?php include(inwave_get_file_path('blocks/breadcrumb')); ?>
        </div>
    </div>
</div>
<?php } ?>
<div class="contents-main" id="contents-main">
    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('content', 'page'); ?>
    <?php endwhile; // end of the loop. ?>
</div>
<?php get_footer(); ?>
