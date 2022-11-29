<?php

/**
 * The Footer template file.
 *
 * @link https://codex.wordpress.org/footer
 *
 * @package Troi
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_footer();

?>

<?php if ( is_active_sidebar( 'home_right_1' ) ) : ?>
	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
		<?php dynamic_sidebar( 'home_right_1' ); ?>
	</div><!-- #primary-sidebar -->
<?php endif; ?>

<!-- Footer block -->
<footer class="footer-element">

	<!-- Footer top content block -->
	<div class="footer-block">
		<div class="container">
			<div class="row">
				<!-- Footer First block -->
				<div class="col-md-2 col-sm-6">
					<!-- Footer logo image -->
					<div class="footer-logo">
						<?php
							// if ( function_exists( 'the_custom_logo' ) ) {
							// 	the_custom_logo();
							// }
						?>
						<?php
						if (is_active_sidebar('troi-footer-sidebar-1')) {
							dynamic_sidebar('troi-footer-sidebar-1');
						}
						
					?>	
					</div>
				</div>
				<!-- End of Footer First block -->

				<!-- Footer Second block -->
				<div class="col-md-4 col-sm-6">
					<!-- Contact block -->
					<div class="contact-block">
					<?php
						if (is_active_sidebar('troi-footer-sidebar-2')) {
							dynamic_sidebar('troi-footer-sidebar-2');
						}
					?>						
					</div>
				</div>
				<!-- End of Footer Second block -->

				<!-- Footer Third block -->
				<div class="col-md-3 col-sm-6">
					<!-- Footer section Link 1 -->
					<?php
						if (is_active_sidebar('troi-footer-sidebar-3')) {
							dynamic_sidebar('troi-footer-sidebar-3');
						}
					?>
				</div>
				<!-- End of Footer Third block -->

				<!-- Footer Fourth block -->
				<div class="col-md-3 col-sm-6">
					<!-- Footer section Link 2 -->
					<?php
						if (is_active_sidebar('troi-footer-sidebar-4')) {
							dynamic_sidebar('troi-footer-sidebar-4');
						}
					?>
				</div>
				<!-- End of Footer Fourth block -->
			</div>
		</div>
	</div>
	<!-- End of Footer top content block -->

	<!-- Footer bottom content block -->
	<div class="footer-bottom">
		<div class="container">
			<div class="row">
				<!-- Empty First block -->
				<div class="col-md-2">
					
				</div>
				<!-- End of Empty First block -->

				<!-- Content Second block -->
				<div class="col-md-7">					
					<?php wp_nav_menu (
							array (
								'theme_location' => 'footer_menu',
								'menu_class' => 'quick-links'
							)
						)
					?>
				</div>
				<!-- End of Content Second block -->

				<!-- Content Third block -->
				<div class="col-md-3">
					<div class="copyrights">
						<!-- <p> &#169; 2019-2020 Troi GmbH </p>						 -->
						<?php 
						if (is_active_sidebar('copyright')) {
							dynamic_sidebar('copyright'); 
						}
						?>
					</div>
				</div>
				<!-- End of Content Third block -->

			</div>
		</div>
	</div>
</footer>
<!-- End of Footer block -->

</body>
</html>