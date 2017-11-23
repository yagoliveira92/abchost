<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
$verified = wc_review_is_from_verified_owner( $comment->comment_ID );

?>
<li itemprop="reviews" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

	<div id="comment-<?php comment_ID(); ?>" class="comment_container">
	
		<div class="woo-comment-avt">
			<?php echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '93' ), '', get_comment_author_email( $comment->comment_ID ) ); ?>
		</div>
		<div class="woo-comment-detail">

			
			<?php do_action( 'woocommerce_review_before_comment_meta', $comment ); ?>
			<?php if ( $comment->comment_approved == '0' ) : ?>

				<div class="meta"><em><?php _e( 'Your comment is awaiting approval', 'woocommerce' ); ?></em></div>

			<?php else : ?>

				<div class="woo-comment-head">
					<span class="woo-comment-author" itemprop="author"><?php comment_author(); ?></span> <?php

						if ( get_option( 'woocommerce_review_rating_verification_label' ) === 'yes' )
							if ( $verified )
								echo '<em class="verified">(' . __( 'verified owner', 'woocommerce' ) . ')</em> ';

					?><time class="woo-comment-date" itemprop="datePublished" datetime="<?php echo esc_attr(get_comment_date( 'c' )); ?>"><?php echo get_comment_date( __( get_option( 'date_format' ), 'woocommerce' ) ); ?></time>
				</div>

			<?php endif; ?>
			
			<?php do_action( 'woocommerce_review_before_comment_text', $comment ); ?>
			
			<div itemprop="description" class="description"><?php comment_text(); ?></div>
			
			<?php do_action( 'woocommerce_review_after_comment_text', $comment ); ?>
			
			<?php if ( $rating && get_option( 'woocommerce_enable_review_rating' ) == 'yes' ) : ?>
				<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf( __( 'Rated %d out of 5', 'woocommerce' ), $rating ) ?>">
					<span style="width:<?php echo ( $rating / 5 ) * 100; ?>%"><strong itemprop="ratingValue"><?php echo intval($rating); ?></strong> <?php _e( 'out of 5', 'woocommerce' ); ?></span>
				</div>
			<?php endif; ?>
		</div>
		<div style="clear:both;"></div>
	</div>
	
