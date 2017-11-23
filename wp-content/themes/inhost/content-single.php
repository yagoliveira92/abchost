<?php
/**
 * @package inhost
 */
global $authordata, $smof_data;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="post-item fit-video">
        <div class="featured-image">
            <?php
            $post_format = get_post_format();
            $contents = get_the_content();
            $str_regux = '';
            switch ($post_format) {
                case 'video':
                    $video = inwave_getElementsByTag('embed', $contents);
                    $str_regux = $video[0];
                    if ($video) {
                        echo apply_filters('the_content', $video[0]);
                    }
                    break;

                default:
                    if ($smof_data['featured_images_single']) {
                        the_post_thumbnail();
                    }
                    break;
            }
            ?>
        </div>
        <div class="post-content">
            <div class="post-content-left">
                <div class="post-icon theme-bg">
                    <i class="fa fa-pencil"></i>
                </div>
            </div>
            <div class="post-content-right">
                <?php if ($smof_data['blog_post_title']): ?>
                    <h3 class="post-title">
                        <a class="theme-color" href="<?php the_permalink(); ?>"><?php the_title('', ''); ?></a>
                    </h3>
                <?php endif; ?>
                <div class="post-info">
                    <div class="post-info-date"><i class="fa fa-calendar-o"></i><?php echo get_the_date(); ?></div>
                    <?php if ( comments_open()): ?>
                    <div class="post-info-comment"><i class="fa fa-comments"></i>
                        <?php
                            echo '<span class="comments-link">';
                            comments_popup_link( __( 'Leave a comment', 'inwavethemes' ), __( '1 Comment', 'inwavethemes' ), __( '% Comments', 'inwavethemes' ) );
                            echo '</span>';
                        ?>
                    </div>
                    <?php endif; ?>
                    <?php if ($smof_data['blog_category_title'] && has_category()): ?>
                        <div class="post-info-category"><i class="fa fa-folder"></i><?php the_category(', ') ?></div>
                    <?php endif; ?>
                </div>
                <div class="post-text">
                    <?php echo apply_filters('the_content', str_replace($str_regux, '', get_the_content())); ?>
                    <?php
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . __('Pages:', 'inwavethemes'),
                        'after' => '</div>',
                    ));
                    ?>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>

        <?php if ($smof_data['entry_footer']): ?>
            <footer class="entry-footer">
                <?php inwave_entry_footer(); ?>
            </footer>
        <?php endif ?>
        <!-- .entry-footer -->

        <?php if ($smof_data['social_sharing_box']): ?>
            <div class="share">
                <div class="share-title">
                    <h5><?php echo __('Share This Post', 'inwavethemes'); ?></h5>
                </div>
                <div class="social-icon">
                    <?php
                    inwave_social_sharing(get_permalink(), InwaveHelper::substrword(get_the_excerpt(), 10), get_the_title());
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($smof_data['author_info']): ?>
            <div class="blog-author">
                <div class="authorAvt">
                    <?php echo get_avatar(get_the_author_meta('email'), 90) ?>
                </div>
                <div class="authorDetails">
                    <div class="author-title">
                        <a href="<?php echo esc_url(get_author_posts_url($authordata->ID, $authordata->user_nicename)); ?>"><?php echo esc_html($authordata->display_name); ?></a>
                    </div>
                    <?php if (get_the_author_meta('description')) { ?>
                        <div class="caption-desc">
                            <?php echo get_the_author_meta('description'); ?>
                        </div>
                    <?php } ?>
                </div>
                <div style="clear:both;"></div>
            </div>
        <?php endif ?>


        <?php if ($smof_data['related_posts']): ?>
            <div class="related-post">
                <?php include(inwave_get_file_path('blocks/related-posts')); ?>
            </div>
        <?php endif ?>
    </div>
</article><!-- #post-## -->