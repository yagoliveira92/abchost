<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package inhost
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'inwavethemes' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<footer class="entry-footer ">
        <div class="container">
		    <?php edit_post_link( __( 'Edit', 'inwavethemes' ), '<span class="edit-link">', '</span>' ,get_the_ID()); ?>
        </div>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
