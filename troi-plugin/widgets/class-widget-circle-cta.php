<?php

namespace TROIWidgets\Widgets;

use Elementor\Repeater;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Circle_CTA extends \TROIWidgets\Widgets\Module {

    public function get_name() { return 'troi-circle-cta'; }

	public function get_title() { return __('Troi Circle CTA ', self::$slug); }

	public function get_icon() { return 'fa fa-image'; }

	// public function get_categories() { return [ 'general' ]; }

    public function _register_controls() {
        // Start control section.
        $this->start_section( 'config_section', 'Content settings' );

        $options = ['white' => __('White', self::$slug), 'black' => __('Black', self::$slug) ];

        $this->control_select( 'backgroundtype', __('Background Type', self::$slug), $options, 'white' );

        $this->set_repeater();

        $this->control_text('caption', __( 'Caption', parent::$slug ), '', __('Service Item Caption', self::$slug) );

        $this->control_textarea('description', __( 'Bild Description', parent::$slug ), '', __('', parent::$slug) );

        $this->control_cta_button();

        $this->control_media('itemimage', __('Block ICON', self::$slug), [], __('Service Icon', self::$slug) );

        $this->add_repeat_fields('services', __('services', self::$slug) );
        // End controls.
        $this->end_controls_section();

        $this->animation_controls();
    }

    public function custom_scripts() {
        // Register Widget Scripts
		// add_action( 'elementor/frontend/after_register_scripts', [ $this, 'animation_widget_scripts' ] );
    }

    public function render() {
        $animationin = $this->get_result('animation_in');
        $services = $this->get_result('services');
        $bg = '';//$this->get_background();
        $html = '';
        // <!-- Circle CTA Module -->
        $html .= '<div class="circle-mod-elements circle-cta-block '. $bg .'">';
        $html .= '<div class="circle-mod">';

            foreach ($services as $key => $service) {
                $caption = $this->get_option($service, 'caption');
                $description = $this->get_option($service, 'description');
                $button = $this->get_option($service, 'buttonurl');
                $buttontext = $this->get_option($service, 'buttontext');
                // $image = $this->render_image($service, 'itemimage');
                $image = $this->get_option($service, 'itemimage');
                $imageurl = $this->get_option($image, 'url');
                $imagealt = $this->get_option($image, 'alt');
                $style = 'background-image: url( '.$imageurl.');';

                $customsize = $this->get_option($service, 'itemimage_customsize');
                $class = 'content-block block-item';
                if ($customsize == 'yes') {
                    $width = $this->get_option($service, 'itemimage_width');
                    $height = $this->get_option($service, 'itemimage_height');
                    $style .= 'background-size: '.$width.'px '.$height.'px;';
                    // $style .= '--itemimage_height: '.$height.'px;';
                    $class .= 'manual-size';
                }
                // <!-- Circle CTA block 1 -->
                // $html .= '<div class="cta-item" > ';

                    $html .= '<div class="'.$class.'" style="'.$style.'" >';
                        // <!-- Circle Title block -->
                        $html .= '<h3>'.$caption.'</h3>';
                        // <!-- Circle content block -->
                        $html .= '<div class="description-block">';
                        if ($description) {
                            $html .= '<p class="description troi-animatio animate__animate" data-animation="'.$animationin.'">'.$description.'</p>';
                        }
                        if ($button['url']) {
                            // <!-- Circle CTA block -->
                            $html .= '<div class="btn-block">';
                                $html .= '<a href="'.$button['url'].'" class="btn">'.$buttontext.'</a>';
                            $html .= '</div>';
                        }
                        $html .= '</div>';
                    $html .= '</div>';
                // $html .= '</div>';

            }

        $html .= '</div>';
        $html .= '</div>';
        //<!-- Circle CTA Module -->
        echo $html;
    }
}

