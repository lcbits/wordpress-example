<?php

namespace TROIWidgets\Widgets;

use Elementor\Repeater;

use Elementor\Widget_Base;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Counter extends \TROIWidgets\Widgets\Module {

    public function get_name() { return 'troi-coounter'; }

	public function get_title() { return __('Troi Counter ', self::$slug); }

	public function get_icon() { return 'fa fa-sort-numeric-asc'; }

	// public function get_categories() { return [ 'general' ]; }

    public function _register_controls() {
        // Start control section.
        $this->start_section( 'config_section', 'Content settings' );

        $options = ['white' => __('White', self::$slug), 'black' => __('Black', self::$slug) ];

        $this->control_select( 'backgroundtype', __('Background Type', self::$slug), $options, 'white' );

        $this->set_repeater();

        $styles = [
            'style1' => 'Simple',
            'style2' => 'Simple Circle',
            'style3' => 'Background Circle',
            'style4' => 'SVG Circle'
        ];

        $this->control_select('countstyle', __('Counter Style', parent::$slug), $styles, 'style1' );

        $this->controler->add_control(
			'duration',
			[
				'label' => __( 'Speed in seconds', 'troi' ),
				'type' => Controls_Manager::SLIDER,
				// 'size_units' => [ 's', '%' ],
				'range' => [
					's' => [
						'min' => 10,
						'max' => 50,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 's',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .box' => 'data-duration="{{SIZE}}{{UNIT}};"',
				]
			]
		);

        $this->control_text('startvalue', __( 'Start value', parent::$slug ), '', __( 'Init value', parent::$slug) );

        $this->control_text('endvalue', __( 'End value', parent::$slug ), '', __( '', parent::$slug) );

        $this->control_text('caption', __( 'Caption', parent::$slug ), '', __('Counter Caption', self::$slug) );

        $this->add_repeat_fields('counters', __('Counters', self::$slug) );
        // End controls.
        $this->end_controls_section();

        // $this->animation_controls();
    }

    public function custom_scripts() {
        // Register Widget Scripts
		// add_action( 'elementor/frontend/after_register_scripts', [ $this, 'animation_widget_scripts' ] );
    }

    public function render() {
        $animationin = $this->get_result('animation_in');
        $counters = $this->get_result('counters');
        $html = '';

        // Counter Module -->
        ?>
        <div class="counter-element counter-widget">
            <div class="container">

            <?php foreach($counters as $key => $count) :
                    $style = $this->get_option($count, 'countstyle');
                    $caption = $this->get_option($count, 'caption');
                    $startvalue = $this->get_option($count, 'startvalue');
                    $endvalue = $this->get_option($count, 'endvalue');
                    $duration = $this->get_option($count, 'duration');
                    $startvalue = (empty($startvalue)) ? 0 : $startvalue;
                    $endvalue = (empty($endvalue)) ? 0 : $endvalue;
                    $styles = [
                        'style1' => 'simple-counter',
                        'style2' => 'circle-block',
                        'style3' => 'bg-circle',
                        'style4' => 'svg-circle-border'
                    ];
                    $styleclass = ( !empty($style) && isset($styles[$style])) ? $styles[$style] : 'simple-counter';
                ?>
                <div class="counter-block <?php echo $styleclass; ?> " data-duration="<?php echo $duration['size'];?>" data-style="<?php echo $style; ?>" data-startvalue="<?php echo $startvalue; ?>" data-endvalue="<?php echo $endvalue; ?>" >
                <?php if ($style == 'style4') { ?>
                    <svg class="count-circle" version="1.1" id="graphycs" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="auto" height="560px"
                        viewBox="0 0 600 560" enable-background="new 0 0 1140 800" xml:space="preserve">
                        <linearGradient id="linearColors1" x1="1" y1="0.5" x2="1" y2="1" >
                            <stop offset="0%" stop-color="#3c9cfd"></stop>
                            <stop offset="100%" stop-color="rgba(193, 206, 220, .2)"></stop>
                        </linearGradient>
                        <linearGradient id="linearColors2" x1="0.5" y1="0" x2="0" y2="0">
                            <stop offset="0%" stop-color="rgba(193, 206, 220, .2)"></stop>
                            <stop offset="100%" stop-color="#3c9cfd"></stop>
                        </linearGradient>
                        <linearGradient id="linearColors3" x1="1.5" y1="0" x2="1" y2="1">
                            <stop offset="0%" stop-color="rgba(193, 206, 220, .2)"></stop>
                            <stop offset="100%" stop-color="#3c9cfd"></stop>
                        </linearGradient>
                        <linearGradient id="linearColors4" x1="0.5" y1="0.5" x2=".5" y2="1">
                            <stop offset="0%" stop-color="rgba(193, 206, 220, .2)"></stop>
                            <stop offset="100%" stop-color="#3c9cfd"></stop>
                        </linearGradient>
                        <linearGradient id="linearColors5" x1="1" y1="0" x2="0.5" y2="0.5">
                            <stop offset="0%" stop-color="#3c9cfd"></stop>
                            <stop offset="100%" stop-color="rgba(193, 206, 220, .2)"></stop>
                        </linearGradient>
                        <linearGradient id="linearColors6" x1="0" y1="0" x2="1" y2="0">
                            <stop offset="100%" stop-color="#3c9cfd"></stop>
                            <stop offset="0%" stop-color="rgba(193, 206, 220, .2)"></stop>
                        </linearGradient>
                        <g id="group">
                            <path class="circlepath" d="M253.9230 70 a120 120 0 0 1 0 120" fill="none" stroke="url(#linearColors1)" stroke-width=".5" />
                            <path class="circlepath" d="M253.9230 190 a120 120 0 0 1 -103.9230 60" fill="none" stroke="url(#linearColors2)" stroke-width=".5" />
                            <path class="circlepath" d="M150 250 a120 120 0 0 1 -103.9230 -60" fill="none" stroke="url(#linearColors3)" stroke-width=".5" />
                            <path class="circlepath" d="M46.077 190 a120 120 0 0 1 0 -120" fill="none" stroke="url(#linearColors4)" stroke-width=".5" />
                            <path class="circlepath" d="M46.077 70 a120 120 0 0 1 103.9230 -60" fill="none" stroke="url(#linearColors5)" stroke-width=".5" />
                            <path class="circlepath" d="M150 10 a120 120 0 0 1 103.9230 60 " fill="none" stroke="url(#linearColors6)" stroke-width=".5" />
                            <g>
                                <clipPath id="SVGID_2_">
                                <use xlink:href="#SVGID_1_"  overflow="visible"/>
                                </clipPath>
                                <path clip-path="url(#SVGID_2_)" id="linepath" fill="none" stroke="#51BBE3" stroke-width=".5" stroke-miterlimit="10" d="M253.9230,1v391.111" />
                            </g>
                        </g>
                    </svg>
                <?php } ?>
                    <div class="content-block">
                        <!-- Number of Daily Users -->
                        <h1 class="counter-value"></h1>
                        <!-- Title -->
                        <p><?php echo $caption;?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- End of Counter Module-->
        <?php
    }
}