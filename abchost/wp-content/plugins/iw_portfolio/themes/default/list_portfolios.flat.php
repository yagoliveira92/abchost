<section class="classes" id="classes">
    <?php
    if ($show_filter_bar) {
        $cat_array = explode(',', $cats);
        if (in_array('0', $cat_array)) {
            $categories = get_terms('iwp_category', 'hide_empty=1');
        } else {
            $categories = get_terms('iwp_category', array('hide_empty' => '1', 'include' => $cat_array));
        }
        ?>
        <div class="categories">
            <div class="filters button-group" id="filters">
                <?php
                if (!empty($categories)) {
                    echo '<button class="filter is-checked" data-filter="*">' . __('All Categories', 'inwavethemes') . '</button>';
                    foreach ($categories as $cat) {
                        echo '<button class="filter" data-filter=".' . $cat->slug . '">' . $cat->name . '</button>';
                    }
                }
                ?>
            </div>
        </div>
    <?php } ?>
    <div class="our-class-main">
        <div class="row">
            <div class="classes-athlete">
                <div class="classes-inner">
                    <div class="classes-content" id="filtering-demo">
                        <section class="isotope portfolio-relate" id="our-class-main" style="">
                            <?php
                            while ($query->have_posts()) :
                                $query->the_post();
                                //$post_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'iw_portfolio-thumb');
                                $terms = wp_get_post_terms(get_the_ID(), 'iwp_category');
                                if (!empty($terms)) {
                                    $data_cat = $terms[0]->slug;
                                    $class = array();
                                    foreach ($terms as $cat) {
                                        $class[] = $cat->slug;
                                    }
                                }
                                ?>
                                <div data-category="<?php echo $data_cat ? $data_cat : ''; ?>" class="<?php echo $class ? implode(' ', $class) : ''; ?> mix element-item col-sm-<?php echo 12 / (($number_column - 1) > 0 ? $number_column - 1 : 1); ?> col-md-<?php echo 12 / $number_column; ?> post_item duongca" style="">
                                    <?php $images = unserialize(get_post_meta(get_the_ID(), 'iw_portfolio_image_gallery', true)); ?>
                                    <div class="item-info">
                                        <div class="image">
                                            <?php
                                            $img = wp_get_attachment_image_src($images[0], 'iw_portfolio-thumb');
                                            echo '<img src="' . $img[0] . '" alt=""/>';
                                            ?>
                                            <div class="control-overlay">
                                                <span data-id="<?php echo get_the_ID(); ?>" class="info"><i class="fa fa-info"></i></span>
                                                <span data-id="<?php echo get_the_ID(); ?>" class="preview"><i class="fa fa-search"></i><i class="fa fa-spin fa-spinner" style="display: none;"></i></span>
                                            </div>
                                        </div>
                                        <div class="port_title"><a href="<?php echo get_permalink(); ?>"><?php echo $utility->prepareLabelText(get_the_title()); ?></a></div>
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
                                            $img = wp_get_attachment_image_src($value, 'iw_portfolio-large');
                                            ?>
                                            <div class="item<?php echo $k == 0 ? ' active' : ''; ?>">
                                                <img alt="" src="<?php echo $img[0]; ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php
                            endwhile;
                            ?>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="load-product">
        <?php
        $rs = $utility->portfolio_display_pagination_none($query);
        if ($rs['success']) {
            echo '<button class="load-more load-portfolio" id="load-more-class"><span class="ajax-loading-icon" style="margin-right: 10px; display: none;"><i class="fa fa-spinner fa-spin fa-2x"></i></span>' . $utility->prepareLabelText(__('Load More', 'inwavethemes')) . '</button>';
            echo $rs['data'];
        } else {
            if (defined('DOING_AJAX') && DOING_AJAX) {
                echo '<button class="load-more load-portfolio all-loaded" id="load-more-class"><span class="ajax-loading-icon" style="margin-right: 10px; display: none;"><i class="fa fa-spinner fa-spin fa-2x"></i></span>' . $utility->prepareLabelText(__('All loaded', 'inwavethemes')) . '</button>';
            }
        }
        wp_reset_postdata();
        ?>
    </div>
</section>
<!-- End Athlete Class -->