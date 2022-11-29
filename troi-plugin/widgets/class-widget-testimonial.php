<?php

namespace TROIWidgets\Widgets;

use Elementor\Repeater;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Testimonial extends \TROIWidgets\Widgets\Module {

    public function get_name() { return 'troi-testimonial'; }

	public function get_title() { return __('Troi Testimonial ', self::$slug); }

	public function get_icon() { return 'fa fa-user'; }

	// public function get_categories() { return [ 'general' ]; }

    /**
     * Register controls.
     */
    protected function _register_controls() {
        // Start control section.
        $this->start_section( 'config_section', 'Content settings' );

        $options = [ 'white' => __('White', self::$slug), 'black' => __('Black', self::$slug) ];

        $this->control_select( 'backgroundtype', __( 'Background Type', self::$slug ), $options, 'white' );

        // $this->controler->add_control(  );

        $this->set_repeater();
             
        $this->control_media('userimage', __( 'User Image', self::$slug ), [], __('User image', self::$slug) );
        
        $this->control_text('username', __( 'User Name', parent::$slug ), '', __('Username', self::$slug) );        
        
        $this->control_text('userposition', __( 'User position', parent::$slug ), '', __('User Position', self::$slug) );                
        
        $this->control_textarea('tmonialdescription', __( 'Testimonial Description', parent::$slug ), '', __('', parent::$slug) );

        $this->add_repeat_fields('testimonials', __( 'Testimonials', self::$slug ) );
        // End controls.
        $this->end_controls_section();

        // $this->animation_controls();
    }

    protected function render() { 
        $tmonials = $this->get_result('testimonials');
        $id = 'tmonialcarousel-'.$this->get_id();
        ?> 
        <div class="testimonial-element">
            <!--Testimonial block Carousel-->
            <div id="<?php echo $id; ?>" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <?php 
                    if ( !empty($tmonials) ) :
                        foreach ( $tmonials as $key => $value ) : 
                            $username = $this->get_option( $value, 'username' );
                            $userimage = $this->render_image( $value, 'userimage' );
                            $userposition = $this->get_option( $value, 'userposition' );
                            $usertmonial = $this->get_option( $value, 'tmonialdescription' );
                    ?>
                            <div class="carousel-item <?php echo ($key == 0) ? 'active' : '' ; ?> ">
                                <!--Testimonial block -->
                                <div class="testimonial-block popup-tmonial">
                                    <!--user image block -->
                                    <?php if ($this->get_option($value, 'userimage')['url'] != '') { ?>
                                    <div class="img-block popup-tmonial">
                                        <?php echo $userimage; ?>
                                    </div>
                                    <?php } ?>

                                    <!--user content block -->
                                    <div class="content-block popup-tmonial">
                                        <p class="popup-tmonial"><?php echo $usertmonial; ?></p>

                                        <!--user detail block -->
                                        <div class="testimonial-details">
                                            <p class="user-name popup-tmonial"><?php echo $username; ?></p>
                                            <p class="user-position popup-tmonial"><?php echo $userposition; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        endforeach;
                    endif;
                    ?>                    
                </div>

                <!-- Testimonial block carousel previous arrow-->
                <a class="carousel-control-prev" href="#<?php echo $id; ?>" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
                </a>

                <!-- Testimonial block carousel next arrow-->
                <a class="carousel-control-next" href="#<?php echo $id; ?>" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
                </a>
            </div>
            <!-- End of Testimonial block carousel -->
        </div>

    <?php
    }    
}

?>