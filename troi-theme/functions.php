<?php
/**
 * Troi theme functions and definitaions.
 *
 * @package Wordpress
 * @subpackage Troi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Theme customizer options include.
require_once( plugin_dir_path(__FILE__).'inc/themeoptions.php' );

// Added title support
add_theme_support( 'title-tag' );

/*Register style*/
function load_stylesheets() {
	wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), false, 'all');
	wp_enqueue_style('bootstrap');

	wp_register_style('style', get_template_directory_uri() . '/style.css', array(), false, 'all');
	wp_enqueue_style('style');

	wp_register_style('fontawesome', get_template_directory_uri() . '/css/fontawesome.css', array(), false, 'all');
	wp_enqueue_style('fontawesome');

	wp_register_style('flaticon', get_template_directory_uri() . '/css/flaticon.css', array(), false, 'all');
	wp_enqueue_style('flaticon');

	wp_register_style('flaticon1', get_template_directory_uri() . '/css/flaticon1.css', array(), false, 'all');
	wp_enqueue_style('flaticon1');


}
add_action('wp_enqueue_scripts', 'load_stylesheets');

/*Register JS*/
function loadjs() {

	// wp_enqueue_script('jQuery-js', 'http://code.jquery.com/jquery.js', array(), '1.0', true);

	wp_register_script('bootstrapjs', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), false, 'all');
	wp_enqueue_script('bootstrapjs');

	/* wp_register_script('customjs', get_template_directory_uri() . '/js/scripts.js', '', 1, true);
	wp_enqueue_script('customjs'); */
}
add_action('wp_enqueue_scripts', 'loadjs');

/*Register Logo*/
function mytheme_setup() {
    add_theme_support('custom-logo');
}

add_action('after_setup_theme', 'mytheme_setup');

/*Register Menus */

add_theme_support('menus');

register_nav_menus(
	array(
		'top_menu' => __('Top Menu', 'theme'),
		'footer_menu' => __('Footer Menu', 'theme'),
	)
);




// Register Troi widgets.
function troi_register_widgets() {
    $widgets = [
        'address' => 'addressblock_widget',
        'socialicon' => 'troi_socialicon_widget',
		'button' => 'troi_button_widget'
    ];

    foreach ($widgets as $file => $widget) {
        require_once( plugin_dir_path(__FILE__).'/widgets/class-troi-widget-'.$file.'.php' );
        register_widget( $widget );
    }
}


//Register Footer
function troi_header_footer_widgets() {

	register_sidebar( array(
		'name' => 'Header ',
		'id' => 'troi-header-1',
		'description' => 'Appears in the header area',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => 'Footer Sidebar 1',
		'id' => 'troi-footer-sidebar-1',
		'description' => 'Appears in the footer area',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => 'Footer Sidebar 2',
		'id' => 'troi-footer-sidebar-2',
		'description' => 'Appears in the footer area',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => 'Footer Sidebar 3',
		'id' => 'troi-footer-sidebar-3',
		'description' => 'Appears in the footer area',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => 'Footer Sidebar 4',
		'id' => 'troi-footer-sidebar-4',
		'description' => 'Appears in the footer area',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

    register_sidebar(array(
        'name' => 'Footer Copyright section',
        'id' => 'copyright',
        'before_widget' => '<div class = "widgetizedArea">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

    troi_register_widgets();
}

// Register sidebars by running on the footer widgets hook.
add_action( 'widgets_init', 'troi_header_footer_widgets' );


if ( ! function_exists( 'troi_the_posts_navigation' ) ) :
	/**
	 * Troi posts navigation.
	 */
	function troi_the_posts_navigation() {
		the_posts_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => sprintf(
					'%s <span class="nav-prev-text">%s</span>',
					'<i class="fa fa-chevron-left"></i>',
					__( 'Neuere Beiträge', 'troi' )
				),
				'next_text' => sprintf(
					'<span class="nav-next-text">%s</span> %s',
					__( 'Ältere Beiträge', 'troi' ),
					'<i class="fa fa-chevron-right"></i>'
				),
			)
		);
	}
endif;

if ( ! function_exists( 'troi_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function troi_post_thumbnail() {

		if ( is_singular() ) :
			?>

			<figure class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</figure><!-- .post-thumbnail -->

			<?php
		else :
			?>

		<figure class="post-thumbnail">
			<a class="post-thumbnail-inner" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php the_post_thumbnail( 'post-thumbnail' ); ?>
			</a>
		</figure>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'troi_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function troi_entry_footer() {

		// Hide author, post date, category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			// Posted by.
			troi_posted_by();

			// Posted on.
			// troi_posted_on();

			/* translators: Used between list items, there is a space after the comma. */
			$categories_list = get_the_category_list( __( ', ', 'troi' ) );
			if ( $categories_list ) {
				printf(
					/* translators: 1: SVG icon. 2: Posted in label, only visible to screen readers. 3: List of categories. */
					'<span class="cat-links">%1$s<span class="screen-reader-text">%2$s</span>%3$s</span>',
					'<i class="fa fa-archive"></i>',
					__( 'Posted in', 'troi' ),
					$categories_list
				); // WPCS: XSS OK.
			}

			/* translators: Used between list items, there is a space after the comma. */
			$tags_list = get_the_tag_list( '', __( ', ', 'troi' ) );
			if ( $tags_list && ! is_wp_error( $tags_list ) ) {
				printf(
					/* translators: 1: SVG icon. 2: Posted in label, only visible to screen readers. 3: List of tags. */
					'<span class="tags-links">%1$s<span class="screen-reader-text">%2$s </span>%3$s</span>',
					'<i class="fa fa-tags"></i>',
					__( 'Tags:', 'troi' ),
					$tags_list
				); // WPCS: XSS OK.
			}
		}

		// Comment count.
		if ( ! is_singular() ) {
			troi_comment_count();
		}

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
			'<span class="edit-link"><i class="fa fa-edit"></i></span>'
		);
	}
endif;

if ( ! function_exists( 'troi_comment_count' ) ) :
	/**
	 * Prints HTML with the comment count for the current post.
	 */
	function troi_comment_count() {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			// echo troi_get_icon_svg( 'comment', 16 );

			/* translators: %s: Post title. Only visible to screen readers. */
			comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'troi' ), get_the_title() ) );

			echo '</span>';
		}
	}
endif;


/**
 * Custom template tags for this theme
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

if ( ! function_exists( 'troi_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function troi_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		// if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		// 	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		// }
		
		setlocale(LC_ALL, 'de_DE');
		switch_to_locale('de_DE');

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( strftime( '%d.%m.%Y', get_the_date('U') ) ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		printf(
			'<span class="posted-on"><a href="%1$s" rel="bookmark">%2$s</a></span>',
			esc_url( get_permalink() ), $time_string
		);
	}
endif;

if ( ! function_exists( 'troi_posted_by' ) ) :
	/**
	 * Prints HTML with meta information about theme author.
	 */
	function troi_posted_by() {
		printf(
			/* translators: 1: SVG icon. 2: Post author, only visible to screen readers. 3: Author link. */
			'<span class="byline">%1$s<span class="screen-reader-text">%2$s</span><span class="author vcard"><a class="url fn n" href="%3$s">%4$s</a></span></span>',
			'<i class="fa fa-person"></i>',
			__( 'Posted by', 'troi' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
	}
endif;
