<?php
/**
 * The default template for displaying content quote
 * @package inhost
 */
global $authordata,$smof_data;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="post-item post-item-quote">
        <div class="featured-image">
            <?php the_post_thumbnail(); ?>
            <?php $featured_image = get_the_post_thumbnail(); ?>
        </div>
        <?php if($featured_image):?>
        <div class="post-quote-overlay theme-bg"></div>
        <?php endif; ?>
        <div class="post-content <?php if(!$featured_image) echo 'post-quote-nobg'; ?>">
            <?php if(!$featured_image):?>
                <div class="post-quote-overlay theme-bg"></div>
            <?php endif; ?>
            <div class="quote-char"><i class="fa fa-quote-left fa-2x"></i></div>
            <div class="quote-text">
                <?php
                $post = get_post();
                $quote = inwave_getElementsByTag('blockquote', $post->post_content, 3);
                $text = $quote[2];
                $text = ltrim($text, '"');
                $text = rtrim($text, '"');
                echo '<a href="' . get_the_permalink() . '">' . $text . '</a>';
                ?>
            </div>
            <div class="name-blog-author">
              -  <?php the_author(); ?> -
            </div>
        </div>
    </div>
    <?php if ($smof_data['entry_footer_category']): ?>
        <?php inwave_entry_footer(); ?>
    <?php endif ?>
</article><!-- #post-## -->