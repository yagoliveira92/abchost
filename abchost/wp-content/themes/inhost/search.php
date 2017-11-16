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
                <h1><?php printf( __( 'Search Results for: %s', 'inwavethemes' ), get_search_query() ); ?></h1>
                <?php include(inwave_get_file_path('blocks/breadcrumb')); ?>
            </div>
        </div>
    </div>
<?php } ?>
<div class="page-content">
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="<?php echo esc_attr(inwave_get_classes('container',$inwave_cfg['sidebar-position']))?> search-content">
                    <?php if ( have_posts() ) : ?>
                        <?php /* Start the Loop */ ?>
                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php
                            /**
                             * Run the loop for the search to output the results.
                             * If you want to overload this in a child theme then include a file
                             * called content-search.php and that will be used instead.
                             */
                            get_template_part( 'content', 'search' );
                            ?>
                        <?php endwhile; ?>
                        <?php get_template_part( '/blocks/paging'); ?>
                    <?php else : ?>
                        <?php get_template_part( 'content', 'none' ); ?>
                    <?php endif; ?>
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
