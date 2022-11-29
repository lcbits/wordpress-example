<?php

namespace TROIWidgets\Widgets;

use Elementor\Repeater;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Linear_flow extends \TROIWidgets\Widgets\Module {

    public function get_name() { return 'troi-linear-flow'; }

	public function get_title() { return __('Troi Linear Flow ', self::$slug); }

	public function get_icon() { return 'fa fa-project-diagram'; }

    protected function _register_controls() {
        // Start control section.
        $this->start_section( 'config_section', 'Content settings' );

        $options = ['white' => __('White', self::$slug), 'black' => __('Black', self::$slug) ];

        $this->control_select( 'backgroundtype', __('Background Type', self::$slug), $options, 'white' );

        $this->control_select( 'headtag', 'Head Level', $this->headtags(), 'h1' );

        $this->set_repeater();

        $styles = [ 'style1' => 'AUTO', 'style2' => 'TEXT', 'style3' => 'ICON' ];

        $this->control_select('style', __( ' Flow Circle Style', parent::$slug ), $styles, 'style1' );

        $iconcontition = [
            //'relation' => 'or',
            'terms' => [
                ['name' => 'style', 'operator' => 'in', 'value' => ['style3'] ]
            ]
        ];

        $textcondition = [
            //'relation' => 'or',
            'terms' => [
                ['name' => 'style', 'operator' => 'in', 'value' => ['style2'] ]
            ]
        ];

        $this->control_media('flowicon', __( 'Flow icon', self::$slug ), [], __('Flow circle icon', self::$slug), $iconcontition );

        $this->control_text('flowtext', __( 'Flow Text', parent::$slug ), '', __('Flow circle text', self::$slug), $textcondition );        

        $this->control_text('flowcaption', __( 'Flow Caption', parent::$slug ), '', __('Flow Caption', self::$slug) );                

        $this->control_textarea('description', __( 'Flow Description', parent::$slug ), '', __('', parent::$slug) );

        $this->add_repeat_fields('boxes', __('boxes', self::$slug) );
        // End controls.
        $this->end_controls_section();

        // $this->animation_controls();
    }

    protected function render() { 
        $headtag = $this->get_result('headtag');
        $boxes = $this->get_result('boxes'); 
        
        $bg = $this->get_background();
        
        $html = '<div class="linear-flow linear-flow-animation '.$bg.'">';

        
        $html .= '<div class="container">';
        
        $html .= '<div class="linear-scroll-line"></div>';       

        $flowcount = 0;
        foreach ($boxes as $key => $box) {            
            $description = $this->get_option($box, 'description');
            $caption = $this->get_option($box, 'flowcaption');
            $image_html = $this->render_image($box, 'flowicon');
            $flowtext = $this->get_option($box, 'flowtext');            
            $style = $this->get_option($box, 'style');
            $styleclass = [
                'style3' => 'ICON', 
                'style2' => 'TEXT',
                'style1' => 'AUTO'
            ];
            $boxstyle = isset($styleclass[$style]) ? $styleclass[$style] : 'text-top';    
            $flowcount += 1;
            // <!-- Icon block -->
            $html .= '<div class="linear-block">';
            // <!-- LEFT block -->
            $html .= '<div class="left-block gsap-animate-fadeindown">';               
          
            // <!-- Image block -->
            if ( $style == 'style3' && !empty($box['flowicon']['url']) ) {                   
                $html .= '<div class="img-block gsap-animate-fadeinup flowcaption">';
                $html .= $image_html;
                $html .= '</div>';
            } else if ($style == 'style2' && !empty($flowtext) ) {
                $html .= '<h2 class="gsap-animate-fadeinup flowcaption" >'.$flowtext.'</h2>';
            } else {
                $html .= '<h2 class="gsap-animate-fadeinup flowcaption" >'.$flowcount.'</h2>';
            }
            $html .= '</div>';
            // <!-- End of img block -->
            $html .= '<div class="content-block">';
            if ($caption) {
                $html .= '<' . $headtag. ' class="gsap-animate-fadeindown" >'.$caption.'</' . $headtag. '>';
            }
            if ($description) {
                $html .= '<p class="flowdescription gsap-animate-fadeinup" >'.$description.'</p>';
            }            
            // <!-- End of img block -->
            $html .= '</div>';
            // <!-- End of content block -->
            $html .= '</div>';
        
           
        }     
        // $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        echo $html;
    }

    
}

?>