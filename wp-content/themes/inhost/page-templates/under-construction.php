<?php
/**
 * Template Name: Under Construction
 * This is the template that is used for the contact page, about page ...
 */
global $smof_data, $inwave_cfg;
include(inwave_get_file_path('inc/initvars'));
?>
    <!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php esc_url(bloginfo('pingback_url')); ?>">
    <?php if ($smof_data['favicon']) { ?>
        <link rel="shortcut icon" href="<?php echo esc_url($smof_data['favicon']); ?>" type="image/x-icon"/>
    <?php } else { ?>
        <link rel="shortcut icon" href="<?php echo esc_url(get_template_directory_uri()); ?>/images/favicon.ico"
              type="image/x-icon"/>
    <?php } ?>
    <style>
        .entry-footer {
            display: none;
        }
    </style>
    <?php wp_head(); ?>
</head>
<body id="page-top" class="page" data-offset="90" data-target=".navigation" data-spy="scroll">
<div class="wrapper coming-soon">
    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('content', 'page'); ?>
    <?php endwhile; // end of the loop. ?>
</div>
<?php wp_footer(); ?>
</body>
</html>
