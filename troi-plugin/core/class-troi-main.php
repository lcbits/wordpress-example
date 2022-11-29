<?php

/**
 * Troi Widgets main class.
 */

namespace TROIWidgets\main;

use Elementor\Plugin;

final class TROIWidgets_Main {
    
    const MINIMUM_ELEMENTOR_VERSION = "3.0";
	
    const MINIMUM_PHP_VERSION = "5.0";

    /**
     * class instance;
     * @var object
     */
    private static $instance;

    public $wwwroot;

    public $dirroot;

    public static function instance() {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof TROIWidgets_Main ) ) {
			self::$instance = new TROIWidgets_Main;
		}

		return self::$instance;
    }

    public function __construct() {

        $this->dirroot = TROIWIDGETS_PATH;

        $this->wwwroot = plugins_url( 'troi-widgets/' );
    }

    public function on_plugins_loaded() {

		add_action('wp_enqueue_scripts', array($this, 'frontstyles' ) );
        // if ( $this->is_compatible() ) {
			add_action( 'elementor/init', [ $this, 'register_actions' ] );
		// }
    }

	public function is_compatible() {
		return true;
        // Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
            $message = sprintf(
                /* translators: 1: Plugin name 2: Elementor */
                esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'troi-widgets' ),
                '<strong>' . esc_html__( 'Troi Widgets', 'troi-widgets' ) . '</strong>',
                '<strong>' . esc_html__( 'Elementor', 'troi-widgets' ) . '</strong>'
            );
			$this->set_admin_notices('error', __( $message ) );
			return false;
		}

        // Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            $message = sprintf(
                /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
                esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-extension' ),
                '<strong>' . esc_html__( 'Troi widgets', 'troi-widgets' ) . '</strong>',
                '<strong>' . esc_html__( 'Elementor', 'troi-widgets' ) . '</strong>',
                 self::MINIMUM_ELEMENTOR_VERSION
            );
            $this->set_admin_notices('error', __( $message ) );
			return false;
		}

		return true;
    }

	public function init() {
		add_action( 'plugins_loaded', [ $this, 'on_plugins_loaded' ] );
        load_plugin_textdomain( 'troi-widgets' );
		add_action('admin_notices', array($this, 'display_admin_notices') );
		// Add Plugin actions
		// add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );
    }
	
	public function register_actions() {
		add_action( 'elementor/elements/categories_registered', array($this, 'troi_create_widget_categories') );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
		add_action( 'elementor/frontend/after_enqueue_scripts', array( $this, 'js_scripts' ) );
		add_action( "wp_ajax_form_send_mail", [ $this, "form_send_mail"] ); 
		add_action( "wp_ajax_nopriv_form_send_mail", [ $this, "form_send_mail"] );
	}

	public function troi_create_widget_categories( $elements_manager ) {
		$elements_manager->add_category(
			'troi-widgets',
			[
				'title' => __( 'Troi Widgets', 'troi-widgets' ),
				'icon' => 'fa fa-plug',
			]
		);		
	}

	public function includes() {
        require_once( $this->dirroot.'/widgets/widget.php' );
		require_once( $this->dirroot.'/widgets/class-widget-icon-box.php' );
		require_once( $this->dirroot.'/widgets/class-widget-paragraph.php' );
		require_once( $this->dirroot.'/widgets/class-widget-team-gallery.php' );
		require_once( $this->dirroot.'/widgets/class-widget-bildtext-gallery.php' );
		require_once( $this->dirroot.'/widgets/class-widget-circle-cta.php' );
		require_once( $this->dirroot.'/widgets/class-widget-counter.php' );
		require_once( $this->dirroot.'/widgets/class-widget-switch-box.php' );
		require_once( $this->dirroot.'/widgets/class-widget-workflow-box.php' );
		require_once( $this->dirroot.'/widgets/class-widget-linear-flow.php' );
		require_once( $this->dirroot.'/widgets/class-widget-testimonial.php' );
		require_once( $this->dirroot.'/widgets/class-widget-blogs.php' );
		require_once( $this->dirroot.'/widgets/class-widget-circle.php' );
		require_once( $this->dirroot.'/widgets/class-widget-form.php' );
		require_once( $this->dirroot.'/widgets/class-widget-form-popup.php' );
		require_once( $this->dirroot.'/widgets/class-widget-table.php' );
		require_once( $this->dirroot.'/widgets/class-widget-imagetext-box.php' );
		// require_once( $this->dirroot.'/widgets/class-widget-imagetext-video.php' );
    }

	public function register_widgets() {

		$this->includes();

		$search_widget =	new \TROIWidgets\Widgets\Icon_box();
		Plugin::instance()->widgets_manager->register_widget_type( $search_widget );

		// Paragraph module.
		$paragraph_widget =	new \TROIWidgets\Widgets\Paragraph();
		Plugin::instance()->widgets_manager->register_widget_type( $paragraph_widget );

		// Team gallery module.
		$team_gallery =	new \TROIWidgets\Widgets\Team_gallery();
		Plugin::instance()->widgets_manager->register_widget_type( $team_gallery );

		// Bild text gallery module.
		$bildtext_gallery =	new \TROIWidgets\Widgets\BildText_gallery();
		Plugin::instance()->widgets_manager->register_widget_type( $bildtext_gallery );

		// Bild text gallery module.
		$circle_cta =	new \TROIWidgets\Widgets\Circle_CTA();
		Plugin::instance()->widgets_manager->register_widget_type( $circle_cta );

		// Counter module.
		$counter_cta =	new \TROIWidgets\Widgets\Counter();
		Plugin::instance()->widgets_manager->register_widget_type( $counter_cta );

		// Switch BOX module.
		$switch_box =	new \TROIWidgets\Widgets\Switch_box();
		Plugin::instance()->widgets_manager->register_widget_type( $switch_box );

		// Workflow BOX module.
		$workflow_box =	new \TROIWidgets\Widgets\Workflow_box();
		Plugin::instance()->widgets_manager->register_widget_type( $workflow_box );

		// Linear Flow Module.
		$linear_flow =	new \TROIWidgets\Widgets\Linear_flow();
		Plugin::instance()->widgets_manager->register_widget_type( $linear_flow );

		// Testimonial Module.
		$testimonial =	new \TROIWidgets\Widgets\Testimonial();
		Plugin::instance()->widgets_manager->register_widget_type( $testimonial );

		// Blog Module.
		$blogs =	new \TROIWidgets\Widgets\Blogs();
		Plugin::instance()->widgets_manager->register_widget_type( $blogs );

		// Circle Module.
		$circle =	new \TROIWidgets\Widgets\Circle();
		Plugin::instance()->widgets_manager->register_widget_type( $circle );

		// Form Module.
		$form =	new \TROIWidgets\Widgets\Form();
		Plugin::instance()->widgets_manager->register_widget_type( $form );

		// Form Module.
		$form_popup =	new \TROIWidgets\Widgets\Form_popup();
		Plugin::instance()->widgets_manager->register_widget_type( $form_popup );

		$table =	new \TROIWidgets\Widgets\Table();
		Plugin::instance()->widgets_manager->register_widget_type( $table );

		// Bild text gallery module.
		$Imagetext_box =	new \TROIWidgets\Widgets\Imagetext_box();
		Plugin::instance()->widgets_manager->register_widget_type( $Imagetext_box );

		// Bild text gallery module.
		// $Imagetext_gallery =	new \TROIWidgets\Widgets\ImageText_video();
		// Plugin::instance()->widgets_manager->register_widget_type( $Imagetext_gallery );
	}

	public function js_scripts() {

		wp_enqueue_script('troi-scroll-magic-scripts', $this->wwwroot . 'scripts/ScrollMagic.js');
		wp_enqueue_script('troi-animation-gsap', $this->wwwroot . 'scripts/animation.gsap.js');
		wp_enqueue_script('troi-scroll-magic-indicators', $this->wwwroot . 'scripts/TweenMax.min.js');
		
		wp_enqueue_script('troi-gsap', $this->wwwroot . 'scripts/gsap/gsap.min.js');
		wp_enqueue_script('troi-gsap-tween-max', $this->wwwroot . 'scripts/gsap/ScrollTrigger.min.js');
		wp_enqueue_script('troi-gsap-scroll-to', $this->wwwroot . 'scripts/gsap/ScrollToPlugin.min.js');
		wp_enqueue_script('troi-gsap-css', $this->wwwroot . 'scripts/gsap/CSSRulePlugin.min.js');
		wp_enqueue_script('troi-circle-animation-scripts', $this->wwwroot . 'scripts/circle-animation.js', array('jquery'));
		wp_enqueue_script('troi-circle-cta-animation-scripts', $this->wwwroot . 'scripts/circle-cta-animation.js', array('jquery'));
		wp_enqueue_script('troi-cideobackground', $this->wwwroot . 'scripts/videobackground.js', array('jquery'));
		wp_enqueue_script('troi-admin-scripts', $this->wwwroot . 'scripts/animate.js', array('jquery'));
		
		
		$jsdata = array(
			'admin_ajax_url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('troi_form_send_mail'),
			'loaderurl' => admin_url('images/loading.gif'),
		);
		// Pass data to javascript.
		wp_localize_script('troi-admin-scripts', 'troi_widgets_jsdata', $jsdata );
		
		// $jsdata = array(
		// 	'admin_ajax_url' => admin_url('admin-ajax.php'),
		// 	// 'nonce' => wp_create_nonce(NONCEKEY),
		// 	'loaderurl' => admin_url('images/loading.gif'),
		// );
		// // Pass data to javascript.
		// wp_localize_script( 'troi-widgets-animation', 'troi_widgets_jsdata', $jsdata );



		// all

		// echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.0/gsap.min.js"></script>
        // <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.0/ScrollTrigger.min.js"></script>';
	}

	public function frontstyles() {
		wp_register_style( 'troi-widgets', $this->wwwroot.'style/animate.css' , false, '');
		wp_enqueue_style( 'troi-widgets' );
		
		wp_enqueue_style( 'troi-widgets-style', $this->wwwroot.'style/style.css' , false, '');
	}



	public function form_send_mail() {
		if ( ! wp_verify_nonce( $_REQUEST['nonce'], "troi_form_send_mail" ) ) {
			exit(" No naughty business please ");
		}
		$fields = $_REQUEST['formdata'];
		// $to = $_REQUEST['sendemail'];
		if (!empty($fields)) {
			$html = 'New data submitted <br>';
			foreach ( $fields as $key => $field ) {
				if ($field['name'] == 'sendmail') {
					$to = $field['value'];
				} else {
					$html .= $field['name'] .': '. $field['value'].'<br>';
				}
			}			
			if (isset($to) && !empty($to)) {
				if ( wp_mail( $to, __('Troi - New user data submitted', 'troi-widgets'), $html ) ) {					
					echo $html;
				} else {
					echo json_encode(['error' => true, 'message' => "Mail not send"]);
				}
			}
		}
	}

	

    /**
	 * Display session flash notices to admin.
	 *
	 * @return null.
	 */
	public function display_admin_notices() {
		global $_SESSION;

		if ( !isset($_SESSION['troi_admin_flash']) ) {
			$_SESSION['troi_admin_flash'] = array();
		}

		$flash_message = $_SESSION['troi_admin_flash'];

		apply_filters( 'troi_admin_notices', $flash_message );

		foreach ($flash_message as $key => $message) {

			if ( $message['type'] == 'error' ) {
				?>
				<div class="notice notice-error is-dismissible">
					<p> <?php echo $message['message']; ?> </p>
				</div>
				<?php
			} else {
				?>
				<div class="notice notice-success is-dismissible">
					<p> <?php echo $message['message']; ?> </p>
				</div>
				<?php
			}
			unset($_SESSION['troi_admin_flash'][$key]);
		}
	}

	/**
	 * Set admin notice using session.
	 * @param [string] $type  error or sucess
	 * @param [string] $message Message to display on notice
	 */
	public function set_admin_notices($type, $message) {
		global $_SESSION;

		if ( !isset($_SESSION['troi_admin_flash']) ) {
			$_SESSION['troi_admin_flash'] = array();
		}

		$_SESSION['troi_admin_flash'][] = array( 'type' => $type, 'message' => $message );
	}
}

/**
 * Create Main class object.
 *
 * @return IOPH_Main object
 */
function troiwidgets_main() {

	return TROIWidgets_Main::instance();
}

// add_action('init', function() { 
troiwidgets_main()->init(); 
// } );