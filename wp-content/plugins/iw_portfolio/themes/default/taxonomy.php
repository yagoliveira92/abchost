<?php
/*
 * @package Portfolios Manager
 * @version 1.0.0
 * @created Mar 17, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of list_teacher
 *
 * @developer duongca
 */
get_header();
$get_term = get_term_by('slug', get_query_var('iwp_category'), 'iwp_category');
?>
<?php if ($inwave_cfg['show-pageheading']) { ?>
    <div class="page-heading">
        <div class="container">
            <div class="page-title">
                <h1><?php echo single_cat_title(); ?></h1>
                <?php include(get_template_directory() . '/blocks/breadcrumb.php'); ?>
            </div>
        </div>
    </div>
<?php } ?>
<div class="page-content" style="padding-top: 0;">
    <!-- End Breadcrumbs -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <!-- End Breadcrumbs -->
                <?php echo do_shortcode('[iw_portfolio_list cats=' . $get_term->term_taxonomy_id . ' show_filter_bar="0"]'); ?>
                <!-- End Athlete Class -->
            </div>
        </div>
    </div>
</div>
<!-- End Page content Class -->
<?php
get_footer();
