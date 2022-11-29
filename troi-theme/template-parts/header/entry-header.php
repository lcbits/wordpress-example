<?php
/**
 * Displays the post header
 *
 * @package WordPress
 * @subpackage  Troi
 * @since Troi 1.0
 */

?>

<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

<?php if ( ! is_page() ) : ?>
<div class="entry-meta">
	<?php troi_posted_by(); ?>
	<?php troi_posted_on(); ?>
	<span class="comment-count">
		<?php
		if ( ! empty( $discussion ) ) {
			troi_discussion_avatars_list( $discussion->authors );
		}
		?>
		<?php troi_comment_count(); ?>
	</span>
	<?php
		// Edit post link.
		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Post title. Only visible to screen readers. */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'troi' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link"><i class="fa fa-edit"></i>',
			'</span>'
		);
	?>
</div><!-- .entry-meta -->
<?php endif; ?>
