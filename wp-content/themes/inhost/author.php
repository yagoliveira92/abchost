<?php
/**
 * The template for displaying Author archive pages
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
                <h1><?php printf( __( 'All posts by %s', 'inwavethemes' ), get_the_author() ); ?></h1>
                <?php if ( get_the_author_meta( 'description' ) ) : ?>
                    <div class="author-description"><?php the_author_meta( 'description' ); ?></div>
                <?php endif; ?>
                <?php include(inwave_get_file_path('blocks/breadcrumb')); ?>
            </div>
        </div>
    </div>
<?php } ?>
<div class="page-content">

    <?php rewind_posts(); ?>
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="<?php echo esc_attr(inwave_get_classes('container',$inwave_cfg['sidebar-position'])) ?> blog-content">
                    <?php if ( have_posts() ) : ?>
                        <?php while (have_posts()) : the_post();
                            get_template_part( 'content', get_post_format() );
                        endwhile; // end of the loop. ?>
                        <?php get_template_part( '/blocks/paging'); ?>
                    <?php else :
                        // If no content, include the "No posts found" template.
                        get_template_part( 'content', 'none' );
                    endif;?>
                </div>
                <?php if ($inwave_cfg['sidebar-position']) { ?>
                    <div class="<?php echo esc_attr(inwave_get_classes('sidebar',$inwave_cfg['sidebar-position']))?> default-sidebar">
                        <?php get_sidebar($inwave_cfg['sidebar-name']); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>

