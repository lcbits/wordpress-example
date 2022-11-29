<?php

/**
 * The template for displaying Frontpage.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Troi
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

?>
<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<?php the_content(); ?>
	</main>
</div>
<?php get_footer();?>