<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Troi
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<?php get_header(); ?>


<?php if (get_the_content() == '') { ?>
	<header class="entry-header">
		<div class="contianer">
		<?php the_post_thumbnail(); ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		</div>
	</header>
	<?php } ?>

	<?php the_content(); ?>

</div> <!-- end content -->

<?php get_footer(); ?>