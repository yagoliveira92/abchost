<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package inhost
 */

get_header(); ?>
<?php if ($inwave_cfg['show-pageheading']) { ?>
    <div class="page-heading">
        <div class="container">
            <div class="page-title">
                <h1><?php _e('Oops! That page can&rsquo;t be found.', 'inwavethemes'); ?></h1>
            </div>
        </div>
    </div>
<?php } ?>
<div class="page-content">
    <div class="container">
        <div class="error-404 not-found">
            <p><?php _e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'inwavethemes'); ?></p>
            <?php get_search_form(); ?>
        </div>
        <!-- .error-404 -->
    </div>
</div><!-- .page-content -->
<?php get_footer(); ?>
