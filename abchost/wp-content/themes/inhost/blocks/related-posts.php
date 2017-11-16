<div class="related-post-title">
    <h5><?php echo __('Related Post', 'inwavethemes'); ?></h5>
</div>
<div class="related-post-list">
<div class="row">
    <?php
    $orig_post = $post;
    global $post;
    $tags = wp_get_post_tags($post->ID);
    if ($tags) {
        $tag_ids = array();
        foreach ($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
        $args = array(
            'tag__in' => $tag_ids,
            'post__not_in' => array($post->ID),
            'posts_per_page' => 3, // Number of related posts to display.
            'ignore_sticky_posts' => 1
        );

        $my_query = new wp_query($args);

        while ($my_query->have_posts()) {
            $my_query->the_post();
            ?>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<div class="related-post-item">
					<div class="related-post-thumb">
						<?php echo the_post_thumbnail(); ?>
					</div>
					<div class="related-post-title">
					<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
					</div>
					<div class="related-post-info">
						<?php printf(__('Posted %s in %s by %s','inwavethemes'),get_the_date(),get_the_time(),'<a href="'.esc_url(get_author_posts_url($authordata->ID, $authordata->user_nicename)).'">'.get_the_author().'</a>') ?>
					</div>
					<div class="related-post-content">
						<?php the_excerpt();?>
					</div>
					<div class="related-post-read-more">
						<?php echo '<a class="more-link" href="'.get_the_permalink().'#more-'.get_the_ID().'">'.__('Read more', 'inwavethemes').'</a>';?>
					</div>
				</div>
			</div>
        <?php }
    }
    $post = $orig_post;
    wp_reset_postdata();
    ?>
</div>
</div>
