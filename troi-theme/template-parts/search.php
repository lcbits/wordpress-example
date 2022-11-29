<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Troi
 * @since Troi 1.0
 */

?>

<div class="search-block">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php troi_post_thumbnail(); ?>
		<!-- Content block -->
		<div class="content-block">
			<div class="title-block">
				<header class="entry-header">
					<?php
					if ( is_sticky() && is_home() && ! is_paged() ) {
						printf( '<span class="sticky-post">%s</span>', _x( 'Featured', 'post', 'twentynineteen' ) );
					}
					if ( is_singular() ) :
						the_title( '<h1 class="entry-title">', '</h1>' );
					else :
						the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
					endif;
					?>
				</header> <!-- .entry-header -->
			</div>
		</div>

		<footer class="entry-footer">
			<?php troi_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	</article><!-- #post-<?php the_ID(); ?> -->
</div>
