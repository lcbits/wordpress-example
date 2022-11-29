<?php

namespace TROIWidgets\Widgets;

use Elementor\Repeater;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Paragraph extends \TROIWidgets\Widgets\Module {

    public function get_name() { return 'troi-paragraph'; }

	public function get_title() { return __('Troi Paragraph Module', self::$slug); }

	public function get_icon() { return 'fa fa-paragraph'; }

    protected function _register_controls() {

        // Start control section.
        $this->start_section( 'config_section', 'Content settings' );

        $options = ['white' => __( 'White', self::$slug ), 'black' => __( 'Black', self::$slug ) ];

        $this->control_select( 'backgroundtype', __('Background color', self::$slug), $options, 'white' );

        $this->control_select( 'headtag', 'Head Level', $this->headtags(), 'h1' );

        $this->control_text( 'heading', 'Heading', '', 'Enter paragraph heading' );


        
        $this->control_cta_button();
        // Paragraph description.
        $this->control_textarea( 'description', 'Description', '', 'Enter Paragraph description content', [], true );        
        // End controls.

        $this->controler->add_control(
			'content_alignment',
			[
				'label' => __( 'Content Style', self::$slug ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
                    'troi-text-center' => [
                        'title' => __( 'Center', 'elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'troi-text-right' => [
                        'title' => __( 'Right', 'elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'troi-text-left' => [
                        'title' => __( 'Left', 'elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],                 
				],
				// 'conditions' => $paralaxcondition
                
            ],
		);
        
        $this->controler->add_control(
			'nexticon',
			[
				'label' => __( 'Show goto next icon', parent::$slug ),
				'type' => \Elementor\Controls_Manager::SWITCHER,				
                'description' => __( 'Display the goto next icon end of the paragraph content.', parent::$slug )
			]
		);

        $this->end_controls_section();

        $this->animation_controls();
    }

    protected function render() {        
        $headtag = $this->get_result('headtag');
        $heading = $this->get_result('heading');
        $buttontext = $this->get_result('buttontext');
        $buttonurl = $this->get_result('buttonurl');
        $description = $this->get_result('description');
        $animationin = $this->get_result('animation_in');
        $style = $this->get_result('backgroundcolor');
        $bgcolorclass = $this->get_background();
        $content_alignment = $this->get_result('content_alignment');
        $shownext = $this->get_result('nexticon');
        ?>
        <!-- Paragraph Module -->
        <div class="troi-paragraph paragraph-mod-element animate-border-circle-out <?php echo $bgcolorclass; ?> <?php echo ' '.$content_alignment; ?>"  >
            <div class="container">
                <?php if ($heading != '') { ?>
                <div class="title-block">
                    <?php echo '<'.$headtag.' class="troi-animation animate__animated" data-animation="'.$animationin.'" >'. $heading.'</'.$headtag.'>'; ?>
                </div>
                <?php } ?>
                <div class="content-block">
                    <?php if (!empty($description)) { ?>
                    <p class="troi-animation animate__animated" data-animation="<?php echo $animationin; ?>" ><?php echo $description; ?></p>
                    <?php } 
                    if ( $buttontext != '' || $buttonurl['url'] !=  '' ) {
                    ?>
                    <div class="btn-block troi-animation animate__animated" data-animation="<?php echo $animationin; ?>">
                        <a href="<?php echo ($buttonurl['url']) ? $buttonurl['url'] : '#' ?>" class="btn"> <?php echo $buttontext; ?> </a>
                    </div>
                    <?php } ?>
                </div>
                <?php if ($shownext == 'yes') { ?>
                    <div class="goto-next-icon">
                        <i class="flaticon-058-down-2"></i>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- End of Paragraph Module -->
        <?php
    }

}