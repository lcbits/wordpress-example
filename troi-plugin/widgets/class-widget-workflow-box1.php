<?php

namespace TROIWidgets\Widgets;

use Elementor\Repeater;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Workflow_box extends \TROIWidgets\Widgets\Module {

    public function get_name() { return 'troi-workflow-box'; }

	public function get_title() { return __('Troi WorkFlow BOX ', self::$slug); }

	public function get_icon() { return 'fa fa-project-diagram'; }

	public function get_categories() { return [ 'general' ]; }

    protected function _register_controls() {
        // Start control section.
        $this->start_section( 'config_section', 'Content settings' );

        $options = ['white' => __('White', self::$slug), 'black' => __('Black', self::$slug) ];

        // $this->control_select( 'backgroundtype', __('Background Type', self::$slug), $options, 'white' );

        
        $styles = ['style1' => 'Style1', 'style2' => 'Style2'];
        
        $this->control_select('style', __( 'BOX Style', parent::$slug ), $styles, 'style1' );
        
        $this->control_textarea('description', __( 'Box Description', parent::$slug ), '', __('', parent::$slug) );
        
        $this->control_media('image', __('Box image', self::$slug), [], __('Box Image', self::$slug) );

        $this->control_cta_button();
        
        $this->set_repeater();

        $this->control_media('flowicon', __( 'Flow icon', self::$slug ), [], __('Flow box Icon', self::$slug) );

        $this->control_text('flowcaption', __( 'Flow Caption', parent::$slug ), '', __('Flow Caption', self::$slug) );        

        $this->control_textarea('description', __( 'Flow Description', parent::$slug ), '', __('', parent::$slug) );

        $this->add_repeat_fields('flows', __('flows', self::$slug) );       
        // End controls.
        $this->end_controls_section();

        // $this->animation_controls();
    }

    // public function render() {
    //     include(TROIWIDGETS_PATH. 'widgets-html/work-flow.html' );
    // }

    public function center_image_block() {
        $image_html = $this->render_image($this->result, 'image');
        $description = $this->get_result('description');
        $style = $this->get_result('style');
        $buttontext = $this->get_result('buttontext');
        if ( ! empty( $this->result['buttonurl']['url'] ) ) {
            $this->add_link_attributes( 'buttonurl', $this->result['buttonurl'] );
        }
        $styleclass = [
            'style1' => 'text-top', 
            'style2' => 'text-bottom'            
        ];
        $boxstyle = isset($styleclass[$style]) ? $styleclass[$style] : 'text-top';        
        $wwwroot = plugins_url( 'troi-widgets/' );

        $html = ' <div class="center-content">';
        
        $html .= '<div class="circle-img-block">';
		$html .= '<img src="'.$wwwroot.'assets/img/icon-circle.png" alt="">';
		$html .= '</div>';
        
        if ($style == 'style2') {

            $html .= '<div class="content-block text-top">';
            
            if ($description) {
                $html .= '<p>'.$description.'</p>';
            }
            if (!empty( $this->result['buttonurl']['url']) ) {
                $html .= '<div class="btn-block">';
                $html .= '<a class="btn" ' . $this->get_render_attribute_string( 'buttonurl' ) . '>'.$buttontext.'</a>';
                $html .= '</div>';
            }
            if (isset($this->result['image']['url']) && !empty($this->result['image']['url'])) {
                $html .= '<div class="img-block">';
                $html .= '<img src="'.$image_html.'" alt="">';
                $html .= '</div>';
            }
            $html .= '</div>';
            
        } else {

            $html .= '<div class="content-block ">';
            if (isset($this->result['image']['url']) && !empty($this->result['image']['url'])) {
                $html .= '<div class="img-block">';
                $html .= $image_html;
                $html .= '</div>';
            }
            if ($description) {
                $html .= '<p>'.$description.'</p>';
            }
            if (!empty( $this->result['buttonurl']['url']) ) {
                $html .= '<div class="btn-block">';
                $html .= '<a class="btn" ' . $this->get_render_attribute_string( 'buttonurl' ) . '>'.$buttontext.'</a>';
                $html .= '</div>';
            }
            $html .= '</div>';
        }
        $html .= '</div>';
        
        return $html;
    }

    protected function render() { 
        
        $flows = $this->get_result('flows');        
        
        $html = '<div class="workflow-element workflow-animation">';
        
        $html .= '<div class="container">';

        $html .= '<div class="workflow-block">';

        $html .= $this->center_image_block();

        foreach ($flows as $key => $box) {
            
            $description = $this->get_option($box, 'description');
            $caption = $this->get_option($box, 'flowcaption');
            $image_html = $this->render_image($box, 'flowicon');
            
             // <!-- Icon block -->
            $html .= '<div class="icon-block">';
            // <!-- Image block -->
            if (!empty($box['flowicon']['url'])) {
                $html .= '<div class="icon-img">';
                $html .= '<div class="img-block">';
                $html .= $image_html;
                $html .= '</div>';
                $html .= '</div>';
            }
            // <!-- End of img block -->
                // <!-- content block -->
            $html .= '<div class="content-block">';
            // <!-- <p>Plan resources and timing</p> -->
            if ($caption) {
                $html .= '<p>'.$caption.'</p>';
            }
           
            if ($description) {
                $html .= '<div class="content-description">';
                $html .= '<p>'.$description.'</p>';
                $html .= '</div>';
            }
            // <!-- End of img block -->
            $html .= '</div>';
            // <!-- End of content block -->
            $html .= '</div>';
        
           
        }     
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        echo $html;
    }

    
}

?>