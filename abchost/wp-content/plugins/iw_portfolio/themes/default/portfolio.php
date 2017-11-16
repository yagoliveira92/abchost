<?php
/*
 * @package Portfolios Manager
 * @version 1.0.0
 * @created Mar 18, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of portfolio
 *
 * @developer duongca
 */
require_once (ABSPATH . 'wp-content/plugins/iw_portfolio/includes/utility.php');
get_header();
$utility = new iwcUtility();
wp_enqueue_script('iwc-js');
?>
<?php if ($inwave_cfg['show-pageheading']) { ?>
    <div class="page-heading">
        <div class="container">
            <div class="page-title">
                <h1><?php echo the_title(); ?></h1>
                <?php include(get_template_directory() . '/blocks/breadcrumb.php'); ?>
            </div>
        </div>
    </div>
<?php } ?>
<div class="page-content">
    <!-- Main Content -->
    <div class="main-content class-detail">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-12 col-xs-12">
                    <!-- Banner Content -->
                    <?php
                    $image_gallery_data = get_post_meta($post->ID, 'iw_portfolio_image_gallery', true);
                    $image_gallery = unserialize($image_gallery_data);
                    if (!empty($image_gallery)):
                        ?>
                        <section class="banner-details">
                            <div class="portfolio-slider">											
                                <!-- Wrapper for slides -->
                                <?php
                                for ($i = 0; $i < count($image_gallery); $i++):
                                    $img = wp_get_attachment_image_src($image_gallery[$i], 'iw_portfolio-large');
                                    ?>
                                    <div class="item<?php echo $i == 0 ? ' active' : ''; ?>">
                                        <img alt="" src="<?php echo $img[0]; ?>">
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </section>
                    <?php endif; ?>
                    <!-- End Banner Content -->

                    <!--  Desc -->
                    <div class="content-page">
                        <section class="class-details">
                            <div class="details-desc-title">
                                <?php if ($utility->getPortfolioOption('enable_voting', '0') == 1): ?>
                                    <div class="btp-detail-voting">
                                        <?php
                                        if ($utility->getPortfolioOption('enable_voting', '0') == 1):
                                            $results = $wpdb->get_row($wpdb->prepare('SELECT COUNT(id) as vote_count, SUM(vote) as vote_sum FROM ' . $wpdb->prefix . 'iw_portfolio_vote WHERE item_id=%d', get_the_ID()));
                                            $voteSum = $results->vote_sum;
                                            $voteCount = $results->vote_count;
                                            echo $utility->getAthleteRatingPanel(get_the_ID(), $voteSum, $voteCount);
                                        endif;
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php the_content(); ?>
                        </section>
                    </div>
                    <!-- End Desc -->

                    <!--  Comments -->
                    <?php if (comments_open()) : ?>
                        <section class="comments">
                            <?php comments_template(); ?> 
                        </section>
                    <?php endif; ?>
                    <!-- End Comments -->	

                </div>		
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <section class="class-info">
                        <div class="project-information">
                            <div class="class-info-title">
                                <h4><?php echo __('Project Information', 'inwavethemes'); ?></h4>
                            </div>
                            <div class="iwp-ifo-item">
                                <label class="fname"><?php _e('Project name', 'inwavethemes'); ?>: </label>
                                <label class="ftext"><?php the_title(); ?></label>
                            </div>
                            <div class="iwp-ifo-item">
                                <label class="fname"><?php _e('Category', 'inwavethemes'); ?>: </label>
                                <label class="ftext"><?php
                                    $portCategories = get_the_terms(get_the_ID(), 'iwp_category');
                                    $cats = array();
                                    $catid = array();
                                    foreach ($portCategories as $ck => $cat) {
                                        $catid[] = $cat->term_id;
                                        $cats[] = '<a href="'.  get_term_link($cat).'"><span>' . $cat->name . '</span></a>';
                                        if ($ck == 1) {
                                            break;
                                        }
                                    }
                                    echo implode(', ', $cats);
                                    ?></label>
                            </div>
                            <?php
                            $extrafiels_data = $wpdb->get_results($wpdb->prepare("SELECT b.name, a.value, b.type FROM " . $wpdb->prefix . "iw_portfolio_extrafields_value as a INNER JOIN " . $wpdb->prefix . "iw_portfolio_extrafields as b ON a.extrafields_id = b.id WHERE a.portfolio_id=%d", get_the_ID()));
                            if ($extrafiels_data):
                                foreach ($extrafiels_data as $field):
                                    $name = $field->name;
                                    $value = $field->value;
                                    ?>
                                    <?php
                                    switch ($field->type):
                                        case 'link':
                                            $link_data = unserialize(html_entity_decode($value));
                                            if ($link_data['link_value_link']):
                                                ?>
                                                <div class="iwp-ifo-item">
                                                    <label class="fname"><?php echo $name; ?>: </label>
                                                    <label class="ftext">
                                                        <a href="<?php echo $link_data['link_value_link']; ?>"target="<?php echo $link_data['link_value_target']; ?>"><?php echo $link_data['link_value_text']; ?></a>
                                                    </label>
                                                </div>
                                                <?php
                                            endif;
                                            break;
                                        case 'image':
                                            if ($value):
                                                ?>
                                                <div class="iwp-ifo-item">
                                                    <span class="fname"><?php echo $name; ?>: </span>
                                                    <span class="ftext">
                                                        <img src="<?php echo $value ?>" width="150px" />
                                                    </span>
                                                </div>
                                                <?php
                                            endif;
                                            break;
                                        case 'measurement':
                                            $measurement_data = unserialize(html_entity_decode($value));
                                            if ($measurement_data['measurement_value']):
                                                ?>
                                                <div class="iwp-ifo-item">
                                                    <label class="fname"><?php echo $name; ?>: </label>
                                                    <label class="ftext">
                                                        <?php echo $measurement_data['measurement_value'] . ' ' . $measurement_data['measurement_unit']; ?>
                                                    </label>
                                                </div>
                                                <?php
                                            endif;
                                            break;
                                        case 'dropdown_list':
                                            $drop_data = unserialize(html_entity_decode($value));
                                            if (!empty($drop_data)):
                                                ?>
                                                <div class="iwp-ifo-item">
                                                    <label class="fname"><?php echo $name; ?>: </label>
                                                    <label class="ftext">
                                                        <?php echo implode(', ', $drop_data); ?>
                                                    </label>
                                                </div>
                                                <?php
                                            endif;
                                            break;
                                        default:
                                            if ($value):
                                                ?>
                                                <div class="iwp-ifo-item">
                                                    <label class="fname"><?php echo stripslashes(($name)); ?>: </label>
                                                    <label class="ftext">
                                                        <?php echo htmlentities($value); ?>
                                                    </label>
                                                </div>
                                                <?php
                                            endif;
                                            break;
                                    endswitch;
                                    ?>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                            <div class="share">
                                <div class="share-title">
                                    <h5><?php echo __('Share This', 'inwavethemes'); ?></h5>										
                                </div>
                                <div class="social-icon">
                                    <?php inwave_social_sharing(get_permalink(), $utility->truncateString(get_the_excerpt(), 10), get_the_title()); ?>
                                </div>
                            </div>
                        </div>
						<?php
							$portfolio_url = get_post_meta(get_the_ID(), 'iw_portfolio_url', TRUE);
							if($portfolio_url){
							?>
							<div class="visit-project">
                            <a target="_blank" href='<?php echo $portfolio_url; ?>'><span><?php echo __('Visit our work', 'inwavethemes'); ?></span></a>
							</div>
						<?php } ?>
                        
						<?php
							$quote = get_post_meta(get_the_ID(), 'iw_portfolio_quote', TRUE); 
							if($quote){
							?>
							<div class="project-quote">
								<?php echo $quote ?>
							</div>
						<?php } ?>
                    </section>
                </div>	
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <?php echo do_shortcode('[iwp_relate col=3 title="Your may also <span>Like</span> this" sub_title="Relate Projects" category=' . implode(',', $catid) . ' number=3]'); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content -->
</div>

<?php
get_footer();
