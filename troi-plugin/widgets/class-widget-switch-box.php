<?php

namespace TROIWidgets\Widgets;

use Elementor\Repeater;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Switch_box extends \TROIWidgets\Widgets\Module {

    public function get_name() { return 'troi-switch-box'; }

	public function get_title() { return __('Troi Switch BOX ', self::$slug); }

	public function get_icon() { return 'fa fa-paragraph'; }

	// public function get_categories() { return [ 'general' ]; }

    protected function _register_controls() {
        // Start control section.
        $this->start_section( 'config_section', 'Content settings' );

        $options = ['white' => __('White', self::$slug), 'black' => __('Black', self::$slug) ];

        // $this->control_select( 'backgroundtype', __('Background Type', self::$slug), $options, 'white' );

        $this->set_repeater();

        $styles = ['style1' => 'Style1', 'style2' => 'Style2', 'style3' => 'Style 3', 'style4' => 'Style 4' ];

        $this->control_select('boxstyle', __('BOX Style', parent::$slug), $styles, 'style1' );

        $this->control_media('switchicon', __('Switch icon', self::$slug), [], __('Switch box Icon', self::$slug) );

        $this->control_text('switchcaption', __( 'Switch Caption', parent::$slug ), '', __('Switch Caption', self::$slug) );        

        $this->control_textarea('description', __( 'BOX Description', parent::$slug ), '', __('', parent::$slug) );

        $this->control_cta_button();

        $this->control_media('boximage', __('Box image', self::$slug), [], __('Box Image', self::$slug) );

        $this->add_repeat_fields('boxes', __('Boxes', self::$slug) );       
        // End controls.
        $this->end_controls_section();

        // $this->animation_controls();
    }

    public function build_switch_icons($boxes) {
        if (!empty($boxes)) {
            $html = '<ul class="nav nav-tabs" id="myTab" role="tablist">';
            foreach ($boxes as $key => $box) {
                $icon = $this->get_option($box, 'switchicon');
                $caption = $this->get_option($box, 'switchcaption');
                $id = $this->get_id();
                $image_html = $this->render_image($box, 'switchicon');
                $active = ($key == 0)  ? 'active' : '';
                $html .= '<li class="nav-item">';
                $html .= '<a class="nav-link '.$active.'" id="switch-tab-'.$key.'-'.$id.'" data-toggle="tab" href="#switch-content-'.$key.'-'.$id.'" role="tab" aria-controls="'.$caption.'" aria-selected="true"><span>'.$caption.'</span>';
                $html .= '<div class="img-block">';
                $html .= $image_html;
                $html .= '</div>';
                $html .= '</a>';
                $html .= '</li>';
            }
            $html .= '</ul>';
            return $html;
        }
    }

    protected function render() { 

        $boxes = $this->get_result('boxes');

        $html = '<div class="switch-box-element switch-box-parallax">';

        $html .= $this->build_switch_icons($boxes); // TAB Icons.
        
        $html .= '<div class="tab-content container" id="myTabContent">';

        foreach ($boxes as $key => $box) {
            $description = $this->get_option($box, 'description');
            $id = 'switch-content-'.$key.'-'.$this->get_id();
            $style = $this->get_option($box, 'boxstyle');
            $image_html = $this->render_image($box, 'boximage');
            $buttontext = $this->get_option($box, 'buttontext');
            if ( ! empty( $box['link']['url'] ) ) {
                $this->add_link_attributes( 'link', $box['link'] );
            }
            $styleclass = [
                'style1' => 'text-top', 
                'style2' => 'text-bottom', 
                'style3' => 'text-left', 
                'style4' => 'text-right' 
            ];
            $boxstyle = isset($styleclass[$style]) ? $styleclass[$style] : 'text-top';
            if ($key == 0) {
                $boxstyle .= ' show active';
            }
        
           //  <!-- Switch box block (image bottom)-->
            $html .= '<div class="tab-pane fade '.$boxstyle.' " id="'.$id.'" role="tabpanel" aria-labelledby="menu1-tab">';
            $html .= '<div class="content-block">';
            // <!-- content block -->
            if ($style == 'style2') {
                $html .= '<div class="bottom-block">'; 
                // <!-- image block -->
                if (!empty($box['boximage']['url'])) {
                    $html .= '<div class="img-block">';
                    $html .= $image_html;
                    $html .= '</div>';
                }
                // <!-- button block -->
                if (!empty($box['link']['url'])) {
                    $html .= '<div class="btn-block">';
                    $html .= '<a class="btn" ' . $this->get_render_attribute_string( 'link' ) . '>'.$buttontext.'</a>';
                    $html .= '</div>';
                }
                $html .= '<p>'.$description.'</p>';
                $html .= '</div>'; // End of bottom block.  

            } else if ($style == 'style3') {

                $html .= '<div class="left-block">'; 
                $html .= '<p>'.$description.'</p>';
                // <!-- button block -->
                if (!empty($box['link']['url'])) {
                    $html .= '<div class="btn-block">';
                    $html .= '<a class="btn" ' . $this->get_render_attribute_string( 'link' ) . '>'.$buttontext.'</a>';
                    $html .= '</div>';
                }
                $html .= '</div>'; // End of left block.

                $html .= '<div class="bottom-block right-block">'; 
                // <!-- image block -->
                if (!empty($box['boximage']['url'])) {
                    $html .= '<div class="img-block">';
                    $html .= $image_html;
                    $html .= '</div>';
                }                
                $html .= '</div>'; // End of bottom block.  
            } else if ($style == 'style4') {               

                $html .= '<div class="bottom-block right-block">'; 
                // <!-- image block -->
                if (!empty($box['boximage']['url'])) {
                    $html .= '<div class="img-block">';
                    $html .= $image_html;
                    $html .= '</div>';
                }                
                $html .= '</div>'; // End of bottom block. 
                $html .= '<div class="left-block">'; 
                $html .= '<p>'.$description.'</p>';
                // <!-- button block -->
                if (!empty($box['link']['url'])) {
                    $html .= '<div class="btn-block">';
                    $html .= '<a class="btn" ' . $this->get_render_attribute_string( 'link' ) . '>'.$buttontext.'</a>';
                    $html .= '</div>';
                }
                $html .= '</div>'; // End of left block.

            } else { // Style 1 or default.
                $html .= '<p>'.$description.'</p>';
                $html .= '<div class="bottom-block">'; 
                // <!-- image block -->
                if (!empty($box['boximage']['url'])) {
                    $html .= '<div class="img-block">';
                    $html .= $image_html;
                    $html .= '</div>';
                }
                // <!-- button block -->
                if (!empty($box['link']['url'])) {
                    $html .= '<div class="btn-block">';
                    $html .= '<a class="btn" ' . $this->get_render_attribute_string( 'link' ) . '>'.$buttontext.'</a>';
                    $html .= '</div>';
                }
                $html .= '</div>'; // End of bottom block. 
            }
            $html .= '</div>'; // End of content bloxk.
            $html .= '</div>'; // End of tab pane.       
        }
        $html .= '<div class="switch-parallax-background" style="" > </div> ';
        $html .= '</div>';
        $html .= '</div>';

        echo $html;
    }

    
}

?>