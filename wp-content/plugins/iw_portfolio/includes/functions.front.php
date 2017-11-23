<?php

/**
 *
 * @param unknown_type $atts
 * @return string
 */
function iwPortfolioListHtmlPage($theme, $cats, $order_by, $order_dir, $item_per_page,$show_filter_bar, $number_column) {
    $themes_dir = get_template_directory();
    $btport_theme = $themes_dir . '/iw_portfolio/';
    $themes = '';
    if (file_exists($btport_theme) && is_dir($btport_theme)) {
        $themes = $btport_theme;
    } else {
        $themes = WP_PLUGIN_DIR . '/iw_portfolio/themes/' . $theme;
    }
    $iwc_theme = $themes . '/list_portfolios.php';
    if (file_exists($iwc_theme)) {
        require_once $iwc_theme;
    } else {
        echo 'No theme was found';
    }
}

function iw_portfolio_relate($atts) {
    // Attributes
    global $wpdb;
    $title = $sub_title = $category = $number = $col = '';
    $utility = new iwcUtility();
    wp_enqueue_script('custombox');
    extract(shortcode_atts(
                    array(
        'title' => '',
        'sub_title' => '',
        'category' => 0,
        'col' => 3,
        'number' => 3
                    ), $atts)
    );
    $args = array('post_type' => 'iw_portfolio');
    if ($category) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'iwp_category',
                'field' => 'term_id',
                'terms' => explode(',', $category),
                'operator' => 'IN',
            ),
        );
    }
    $args['posts_per_page'] = $number;
    $args['orderby'] = 'rand';
    $query = new WP_Query($args);
    $item_index = 0;
    ob_start();
    echo '<div class="portfolio-relate">';
    echo '<div class="sub_title">' . $sub_title . '</div>';
    echo '<div class="title">' . $title . '</div>';
    echo '<div class="post_items">';
    $colClass = 'col-md-' . round(12 / $col);

    if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
            if ($item_index % $col == 0) {
                echo '<div class="port-row row">';
            }
            ?>
            <div class="post_item <?php echo $colClass; ?>">
                <?php $images = unserialize(get_post_meta(get_the_ID(), 'iw_portfolio_image_gallery', true)); ?>
                <div class="item-info">
                    <div class="image">
                        <?php
                        $img = wp_get_attachment_image_src($images[0], 'medium');
                        echo '<img src="' . $img[0] . '" alt=""/>';
                        ?>
                        <div class="control-overlay">
                            <span data-id="<?php echo get_the_ID(); ?>" class="info info-<?php echo get_the_ID(); ?>"><i class="fa fa-info"></i></span>
                            <span data-id="<?php echo get_the_ID(); ?>" class="preview images-<?php echo get_the_ID(); ?>"><i class="fa fa-search"></i><i class="fa fa-spin fa-spinner" style="display: none;"></i></span>
                        </div>
                    </div>
                    <div class="port_title"><a href="<?php echo get_permalink();?>"><?php echo $utility->prepareLabelText(get_the_title()); ?></a></div>
                </div>
                <div id='port-info-<?php echo get_the_ID(); ?>' class="port-info" style="display: none;">
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
                                    $cats[] = '<span>' . $cat->name . '</span>';
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
                </div>
            </div>
            <div id='port-images-<?php echo get_the_ID(); ?>' class="port-images" style="display: none;">
                <div class="portfolio-slider">											
                    <!-- Wrapper for slides -->
                    <?php
                    $image_gallery = unserialize(get_post_meta(get_the_ID(), 'iw_portfolio_image_gallery', true));
                    foreach ($image_gallery as $k => $value):
                        $img = wp_get_attachment_image_src($value, 'large');
                        ?>
                        <div class="item<?php echo $k == 0 ? ' active' : ''; ?>">
                            <img alt="" src="<?php echo $img[0]; ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php
            $item_index++;
            if ($item_index % $col == 0 || $item_index == $number) {
                echo '</div>';
            }
        endwhile;
    endif;
    echo '</div>';
    echo '</div>';
    $html = ob_get_contents();
    ob_end_clean();
    return $html;
}


function iwcAjaxVote() {
    require_once 'utility.php';
    global $wpdb;
    $result = array();
    $result['success'] = true;
    $utility = new iwcUtility();
    $bt_options = get_option('iw_portfolio_settings');
    $user = get_current_user_id();
    if ($user == 0 && $utility->getPortfolioOption('allow_guest_vote', 0) == 0) {
        $result['success'] = false;
        $result['message'] = __('Only registered users can vote. Please login to cast your vote');
    } else {
        $postid = $_POST['id'];
        $rating = $_POST['rating'];

        $sqlQuery = $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "posts WHERE id=%d", $postid);
        $post = $wpdb->get_row($sqlQuery);

        // Fake submit
        if (!$post || $rating == 0 || $rating > 5) {
            die();
        }
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($user) {
            $sqlQuery = $wpdb->prepare("SELECT COUNT(*) FROM " . $wpdb->prefix . "iw_portfolio_vote WHERE item_id=%d AND user_id=%d", $postid, $user);
        } else {
            $sqlQuery = $wpdb->prepare("SELECT COUNT(*) FROM " . $wpdb->prefix . "iw_portfolio_vote WHERE item_id=%d AND ip=%s AND user_id = 0", $postid, $ip);
        }
        if ($wpdb->get_var($sqlQuery) > 0) {
            $result['success'] = false;
            $result['message'] = __('You have already voted for this item');
        } else {
            $ins = $wpdb->insert($wpdb->prefix . "iw_portfolio_vote", array('item_id' => $postid, 'user_id' => $user, 'created' => time(), 'vote' => $rating, 'ip' => $ip));

            $result['message'] = __('Thanks for voting. You rock!!! ;o');
            $result['rating_sum'] = $media_item->vote_sum + $rating;
            $result['rating_count'] = $media_item->vote_count + 1;
            $result['rating'] = $result['rating_sum'] / $result['rating_count'];
            $result['rating_text'] = sprintf(__('%d votes'), $result['rating_count']);
            $result['rating_width'] = round(15 * $result['rating']);
        }
    }
    $utility->obEndClear();
    echo json_encode($result);
    exit();
}

add_action('wp_ajax_nopriv_iwcAjaxVote', 'iwcAjaxVote');
add_action('wp_ajax_iwcAjaxVote', 'iwcAjaxVote');

//Ajax vote for Athlete theme
function iwcAthleteAjaxVote() {
    require_once 'utility.php';
    global $wpdb;
    $result = array();
    $result['success'] = true;
    $utility = new iwcUtility();
    $user = get_current_user_id();
    if ($user == 0 && $utility->getPortfolioOption('allow_guest_vote', 0) == 0) {
        $result['success'] = false;
        $result['message'] = __('Only registered users can vote. Please login to cast your vote');
    } else {
        $postid = $_POST['id'];
        $rating = $_POST['rating'];

        $sqlQuery = $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "posts WHERE id=%d", $postid);
        $post = $wpdb->get_row($sqlQuery);

        // Fake submit
        if (!$post || $rating == 0 || $rating > 5) {
            die();
        }
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($user) {
            $sqlQuery = $wpdb->prepare("SELECT COUNT(*) FROM " . $wpdb->prefix . "iw_portfolio_vote WHERE item_id=%d AND user_id=%d", $postid, $user);
        } else {
            $sqlQuery = $wpdb->prepare("SELECT COUNT(*) FROM " . $wpdb->prefix . "iw_portfolio_vote WHERE item_id=%d AND ip=%s AND user_id = 0", $postid, $ip);
        }
        if ($wpdb->get_var($sqlQuery) > 0) {
            $result['success'] = false;
            $result['message'] = __('You have already voted for this item');
        } else {
            $wpdb->insert($wpdb->prefix . "iw_portfolio_vote", array('item_id' => $postid, 'user_id' => $user, 'created' => time(), 'vote' => $rating, 'ip' => $ip));
            $vote = $wpdb->get_row($wpdb->prepare('SELECT count(id) AS vote_count, SUM(vote) as vote_sum FROM ' . $wpdb->prefix . 'iw_portfolio_vote WHERE item_id=%d', $postid));

            $result['message'] = __('Thanks for voting. You rock!!! ;o');
            $result['rating_sum'] = $vote->vote_sum;
            $result['rating_count'] = $vote->vote_count;
            $result['rating'] = $result['rating_sum'] / $result['rating_count'];
            $result['rating_text'] = sprintf(__('%d votes'), $result['rating_count']);
            $result['rating_width'] = round(20 * $result['rating']);
        }
    }
    $utility->obEndClear();
    echo json_encode($result);
    exit();
}

add_action('wp_ajax_nopriv_iwcAthleteAjaxVote', 'iwcAthleteAjaxVote');
add_action('wp_ajax_iwcAthleteAjaxVote', 'iwcAthleteAjaxVote');


add_action('wp_ajax_nopriv_iwcSendMailTakePortfolio', 'iwcSendMailTakePortfolio');
add_action('wp_ajax_iwcSendMailTakePortfolio', 'iwcSendMailTakePortfolio');

function iwcAjaxRenderImage() {
    require_once 'utility.php';
    $utility = new iwcUtility();
    $utility->getImageWatermark();
    exit();
}

add_action('wp_ajax_nopriv_iwcAjaxRenderImage', 'iwcAjaxRenderImage');
add_action('wp_ajax_iwcAjaxRenderImage', 'iwcAjaxRenderImage');
