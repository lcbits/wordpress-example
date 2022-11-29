<!DOCTYPE html>
<html>
	<head>
		<?php wp_head();?>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
<body <?php body_class();?>>

	<!-- Header -->
	<header id="header" class="header sticky-top">
		<div class="container">
			<!-- Header Nav bar -->
			<nav class="navbar navbar-expand-lg navbar-light">

				<!-- Custom Logo -->
				<?php
				if ( function_exists( 'the_custom_logo' ) ) {
					the_custom_logo();
				}?>
				<!-- End Of Custom Logo -->

				<!-- Navbar toggle button -->
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span></span>
					<span></span>
					<span></span>
				</button>
				<!-- End Of Navbar toggle button -->

				<!-- Navbar Menu -->
				<div class="header-menu collapse navbar-collapse" id="navbarSupportedContent">

					<!-- Header menu links -->
					<ul class="navbar-nav mr-auto">
						<?php wp_nav_menu (
							array (
								'theme_location' => 'top_menu',
								'menu_class' => 'navigation'
							)
						)?>
					</ul>
					<!-- End of Header menu links -->
					<?php
					if (is_active_sidebar('troi-header-1')) {
						dynamic_sidebar('troi-header-1');
					}
					?>

					

				</div>
				<!-- End Of Navbar Menu -->
			</nav>
			<!-- End of Header Nav bar -->
		</div>
	</header>
	<!-- End of header -->



	<?php //include 'modules.html'; ?>

</body>
