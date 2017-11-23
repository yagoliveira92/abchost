<?php
/**
 * The default template for displaying content gallery
 * @package inhost
 */
global $authordata, $smof_data;
$showContent = false;
if (is_single() || !get_post_gallery()) {
    $showContent = true;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="post-item">
        <div class="featured-image post-gallery">
            <?php if (!$showContent) {
                echo get_post_gallery();
            }
            ?>
        </div>
        <div class="post-content">
            <div class="post-content-left">
                <div class="post-icon theme-bg">
                    <i class="fa fa-th-large"></i>
                </div>
                <?php if ($smof_data['social_sharing_box_category']): ?>
                    <div class="post-share-buttons">
                        <?php
                        inwave_social_sharing(get_permalink(), InwaveHelper::substrword(get_the_excerpt(), 10), get_the_title());
                        ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="post-content-right">
                <h3 class="post-title">
                    <a class="theme-color" href="<?php the_permalink(); ?>"><?php the_title('', ''); ?></a>
                </h3>

                <div class="post-info">
                    <div class="post-info-date"><i class="fa fa-calendar-o"></i> <?php echo get_the_date(); ?></div>
                    <?php
                    if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
                        echo '<div class="post-info-comment"><i class="fa fa-comments"></i><span class="comments-link">';
                        comments_popup_link(__('Leave a comment', 'inwavethemes'), __('1 Comment', 'inwavethemes'), __('% Comments', 'inwavethemes'));
                        echo '</span></div>';
                    }
                    ?>
                    <?php if($smof_data['blog_category_title_listing']): ?>
                        <div class="post-info-category"><i class="fa fa-folder"></i><?php the_category(', ') ?></div>
                    <?php endif; ?>
                </div>
                <div class="post-text">
                    <?php /* translators: %s: Name of current post */
                    if ($showContent) {
                        the_content(__('Read more', 'inwavethemes'));
                    } else {
                        the_excerpt();
                        echo '<a class="more-link" href="' . get_the_permalink() . '#more-' . get_the_ID() . '">' . __('Read more', 'inwavethemes') . '</a>';
                    }
                    wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'inwavethemes') . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>'));
                    ?>
                </div>
                <div style="clear:both;"></div>
                <?php if ($smof_data['entry_footer_category']): ?>
                    <?php inwave_entry_footer(); ?>
                <?php endif ?>
            </div>

        </div>
        <?php //inwave_entry_footer(); ?>
    </div>

</article><!-- #post-## -->