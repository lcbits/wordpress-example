<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Troi
 * @since Troi 1.0
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<div class="search-element">
				<!-- Search input form -->
				<div class="input-group mb-3">
					<form method="get" action="<?php echo home_url();?>">
					<input type="text" value="" name="s" id="s" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon2">				
					<div class="input-group-append">
						<input type="submit" id="searchsubmit" value="Search">
					</div>
					</form>
				</div>
				
				<header class="page-header">
					<h1 class="page-title">
						<?php _e( 'Search results for: ', 'troi' ); ?>
						<span class="page-description"><?php echo get_search_query(); ?></span>
					</h1>
				</header><!-- .page-header -->

			<?php if ( have_posts() ) : ?>


				<?php
				// Start the Loop.
				while ( have_posts() ) :
					the_post();

					/*
					* Include the Post-Format-specific template for the content.
					* If you want to override this in a child theme, then include a file
					* called content-___.php (where ___ is the Post Format name) and that
					* will be used instead.
					*/
					get_template_part( 'template-parts/search', 'excerpt' );

				// End the loop.
				endwhile;

				// Previous/next page navigation.
				troi_the_posts_navigation();

			// If no content, include the "No posts found" template.
			else :
				echo '<div class="empty-search-result"><h2>'.__('Oops! No search results found.', 'troi').'</h2></div>';

			endif;
			?>
			</div>
		</main> <!-- #main -->
	</div> <!-- #primary -->

<?php
get_footer();
