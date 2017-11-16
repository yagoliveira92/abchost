<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package inhost
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
$comment_count = get_comment_count(get_the_ID());
$totalComment = $comment_count['total_comments'];
?>
<div id="comments" class="comments">
    <div class="comments-content">
        <?php if (have_comments()) : ?>
            <div class="commentList">
                <div class="comments-title">
                    <h5><?php printf(_n('Post has %s comment', 'Post has %s comments', $totalComment, 'inwavethemes'), $totalComment); ?></h5>
                </div>
                <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>
                    <nav id="comment-nav-above" class="comment-navigation" role="navigation">
                        <div
                            class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'inwavethemes')); ?></div>
                        <div
                            class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'inwavethemes')); ?></div>
                    </nav><!-- #comment-nav-above -->
                <?php endif; // check for comment navigation ?>
                <ul class="comment_list">
                    <?php
                    wp_list_comments(array(
                        'callback' => 'inwave_comment',
                        'short_ping' => true,
                    ));
                    ?>
                </ul>
                <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>
                    <nav id="comment-nav-bellow" class="comment-navigation" role="navigation">
                        <div
                            class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'inwavethemes')); ?></div>
                        <div
                            class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'inwavethemes')); ?></div>
                    </nav><!-- #comment-nav-below -->
                <?php endif; // check for comment navigation ?>

            </div>
        <?php endif; // have_comments() ?>

        <?php
        // If comments are closed and there are comments, let's leave a little note, shall we?
        if (!comments_open() && '0' != get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
            ?>
            <p class="no-comments"><?php _e('Comments are closed.', 'inwavethemes'); ?></p>
        <?php endif; ?>
        <div class="form-comment">

            <?php comment_form(array(

                $fields = array(
                    'author' => '<div class="row"><div class="col-md-4 col-sm-12 col-xs-12 commentFormField"><input id="author" class="input-text" name="author" placeholder="' . __('Name', 'inwavethemes') . '" type="text" value="" size="30" /></div>',
                    'email' => '<div class="col-md-4 col-sm-6 col-xs-12 commentFormField"><input id="email" class="input-text" name="email" placeholder="' . __('Email', 'inwavethemes') . '" type="email" value="" size="30" /></div>',
                    'url' => '<div class="col-md-4 col-sm-12 col-xs-12 commentFormField"><input id="url" class="input-text" name="url" placeholder="' . __('Website', 'inwavethemes') . '" type="url" value="" size="30" /></div></div>',
                ),
                'fields' => apply_filters('comment_form_default_fields', $fields),
                'comment_field' => '<div class="row"><div class="col-xs-12 commentFormField"><textarea id="comment" class="control" placeholder="' . _x('Comment', 'noun','inwavethemes') . '" name="comment" cols="45" rows="8" aria-describedby="form-allowed-tags" aria-required="true"></textarea></div></div>',
                'class_submit' => 'btn-submit button'
            )); ?>
        </div>
    </div>
    <!-- #comments -->
</div><!-- #comments -->
