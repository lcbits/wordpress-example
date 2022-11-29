<?php

namespace TROIWidgets\Widgets;

use Elementor\Repeater;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Form_popup extends \TROIWidgets\Widgets\Module {

    public function get_name() { return 'troi-form-popup'; }

	public function get_title() { return __('Troi Form popup', self::$slug); }

	public function get_icon() { return 'fa fa-wpforms'; }

    public function htcontactform_forms(){
        $formlist = array();
        $forms_args = array( 'posts_per_page' => -1, 'post_type'=> 'wpcf7_contact_form' );
        $forms = get_posts( $forms_args );
        if( $forms ){
            foreach ( $forms as $form ){
                $formlist[$form->ID] = $form->post_title;
            }
        }else{
            $formlist['0'] = __('Form not found','ht-contactform');
        }
        return $formlist;
    }

    protected function _register_controls() {

        // Start control section.
        $this->start_section( 'config_section', 'Content settings' );

        $options = [ 'white' => __('White', self::$slug), 'black' => __('Black', self::$slug) ];

        $this->control_select( 'headtag', 'Head Level', $this->headtags(), 'h1' );

        $this->control_text( 'blockheading', 'Heading', '', 'Enter paragraph heading' );

        $this->control_textarea('blockdescription', __( 'Block Description', parent::$slug ), '', __('', parent::$slug) );

        // $this->control_select( 'backgroundtype', __('Background Type', self::$slug), $options, 'white' );
        $this->control_media('icon', __( 'icon', self::$slug ), [], __('Flow box Icon', self::$slug) );

        $this->control_textarea('description', __( 'Form Description', parent::$slug ), '', __('', parent::$slug) );

        // End controls.
        $this->end_controls_section();

        $this->start_section('contactform7', __( 'Contact Form', 'troi' ) );

        $this->controler->add_control(
            'contactform7_id',
            [
                'label'             => __( 'Select Form', 'troi' ),
                'type'              => \Elementor\Controls_Manager::SELECT,
                'label_block'       => true,
                'options'           => $this->htcontactform_forms(),
                'default'           => '0',
            ]
        );

        $this->end_controls_section();

        $this->animation_controls();
    }

    public function render() {
        $fields = $this->get_result('form_fields');
        $id = $this->get_id();

        $bgclass = $this->get_background();
        $blockdescription = $this->get_result('blockdescription');
        // echo $blockdescription; exit;
        $blockheading = $this->get_result('blockheading');
        $blockheadtag = $this->get_result('headtag');

        $description = $this->get_result('description');
        $notification = $this->get_result('notification');
        $animationin = $this->get_result('animation_in');

        $image_html = $this->render_image($this->result, 'icon');
        $sendmail = $this->get_result('send_mail');
        // print_object($sendmail);
        $buttonurl = $this->get_result('buttonurl');
        $buttontext = $this->get_result('buttontext');
        // <!-- Form Module -->
        $html = '<div class="troi-widget form-module popup-form-block troi-form-popup-animation '.$bgclass.'">';
	    $html .= '<div class="container">';
        // Form-popup
        $html .= '<div class="form-popup-paragraph"> ';
        	// <!-- Form title block -->
		$html .= '<div class="form-content-block">';

        if ($blockheading != '') {
            $html .= '<div class="title-block">';
                $html .= '<'.$blockheadtag.' class="troi-animation animate__animated" data-animation="'.$animationin.'" >'. $blockheading.'</'.$blockheadtag.'>';
            $html .= '</div>';
        }
        $html .= ' <div class="content-block">';
            if (!empty($blockdescription)) {
                $html .= '<p class="troi-animation animate__animated" data-animation="'.$animationin.'" >'.$blockdescription.'</p>';
            }
        $html .= '</div>';
        $html .= '</div>'; // End of form content block
        $html .= '</div>';
		// <!-- Form image block -->
        $html .= '<div class="form-parent form-contianer">';

		// <!-- Form title block -->
		$html .= '<div class="form-content-block">';
        if ( isset($this->result['icon']['url']) && !empty($this->result['icon']['url']) ) {
            $html .= '<div class="img-block">';
            $html .= $image_html;
            $html .= '</div>';
        }
		$html .= '<div class="title-block">';
		$html .= '<h2>'.str_replace("\n", '<br>', $description).'</h2>';
		$html .= '</div>';

        $html .= '<div class="form-block">'; // Form-block.
        $html .= $this->get_form_content();
        $html .= '</div>'; // form-block

        $html .= '</div>'; // form-content-block

        $html .= '</div>'; // form-container.
        $html .= '</div>'; // Container
        $html .= '</div>'; // Form module.
        echo $html;
    }


   
    protected function get_form_content( $instance = [] ) {

        $settings   = $this->get_settings_for_display();
        $id         = $this->get_id();

        $this->add_render_attribute( 'htwpform_attr', 'class', 'htcontact-form-wrapper' );

        $this->add_render_attribute( 'shortcode', 'id', $settings['contactform7_id'] );
        $shortcode = sprintf( '[contact-form-7 %s]', $this->get_render_attribute_string( 'shortcode' ) );

        $html = '<div '.$this->get_render_attribute_string('htwpform_attr').'>';

        if ( !empty( $settings['contactform7_id'] ) ) {
            $html .= do_shortcode( $shortcode ); 
        } else {
            $html .= '<div class="form_no_select">' .__('Please Select contact form.','ht-contactform'). '</div>';
        }
        return $html;
    }
}