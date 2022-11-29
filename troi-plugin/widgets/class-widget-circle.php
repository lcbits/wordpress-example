<?php

namespace TROIWidgets\Widgets;

use Elementor\Repeater;

use Elementor\Widget_Base;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Circle extends \TROIWidgets\Widgets\Module {

    public $styles = [
        'style0' => 'circle-block',
        'style1' => 'Loading Circle + Text',
        'style2' => 'Loading Circle + Text + Counter',
        'style3' => 'Get Together',
        'style4' => 'Pulsing Circle',
        'style5' => 'Growing outside the circle',
        'style6' => 'Rotatin Arrows Circle',
        'style7' => 'Multi circle growing outside',
        'style8' => 'Clock circle',
        'style9' => 'Growing Text',
        'style10' => 'Combined circle',
        // 'style10' => 'Combined circle'
    ];

    public $styleclass = [
        'style0' => 'circle-block',
        'style1' => 'circle-progress-element',
        'style2' => 'circle-border-block',
        'style3' => 'border-circle-block',
        'style4' => 'circle-border-block',
        'style5' => 'outer-circle-bg',
        'style6' => 'Rotatin Arrows Circle',
        'style7' => 'circle-icon-block',
        'style8' => 'Clock circle',
        'style9' => 'circle-growing-dotted',
        'style10' => 'combined-circle'
    ];

    public $animationclass = [
        'style0' => 'plain-circle-text',
        'style1' => 'progress-text-circle',
        'style2' => 'counter-text-circle',
        'style3' => 'get-together',
        'style4' => 'pulsing-circle',
        'style5' => 'growing-outside-circle',
        'style6' => 'rotatin-arrows-circle',
        'style7' => 'multi-circle-growing-outside',
        'style8' => 'clock-circle',
        'style9' => 'growing-text',
        'style10' => 'combined'
    ];

    public function get_name() { return 'troi-circle'; }

	public function get_title() { return __('Troi Circle ', self::$slug); }

	public function get_icon() { return 'fa fa-circle'; }

	// public function get_categories() { return [ 'general' ]; }    

    public function _register_controls() {
        // Start control section.
        $this->start_section( 'config_section', 'Content settings' );

        $options = ['white' => __('White', self::$slug), 'black' => __('Black', self::$slug) ];

        $this->control_select( 'backgroundtype', __('Background Type', self::$slug), $options, 'white' );
        
        // $this->control_duration('blockminheight', 'Minimum block height', 1, [], 300, 870, 10);

        $this->controler->add_control(
			'blockminheight',
			[
				'label' => __( 'Minimum block height', self::$slug ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 300,
						'max' => 1200,
						'step' => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 650,
				],
				'selectors' => [
					'{{WRAPPER}} .circle-element' => 'min-height: {{SIZE}}{{UNIT}};',
				]
                
			]
		);
                
        $this->controler->add_control(
			'videotype',
			[
				'label' => __( 'Display as Video', parent::$slug ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
                'description' => __( 'Display all the circle items in same position looks like a Video effect', parent::$slug )
			]
		);

        $this->controler->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay animation', parent::$slug ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
                'description' => __( 'Display the animation effects automatically on elements scrolled to viewport.', parent::$slug ),
                'condition' => ['videotype' => 'yes']
			]
		);

        

        $this->controler->add_control(
			'scrollbase',
			[
				'label' => __( 'Scrollbased animation', parent::$slug ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
                'description' => __( 'Play the animation based on the scroll.', parent::$slug ),
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        ['name' => 'autoplay', 'operator' => '==', 'value' => '' ],
                        ['name' => 'videotype', 'operator' => '==', 'value' => '' ]
                    ]  
                ]
			]
		);

        $this->control_duration('delaynext', 'Delay between circle animation', 1, ['videotype' => 'yes'], 0.0, 10, 0.2);


        // Multiple circle items repeater
        $this->set_repeater();
        // Circle style.
        $this->control_select('style', __( 'Style', parent::$slug ), $this->styles, 'style1' );
              
        $this->control_textarea('description', __( 'Circle Description', parent::$slug ), '', __('', parent::$slug) );

        $this->control_duration('animationdelay', 'Animation Completion Time', 1, [], 0.0, 10, 0.2);
        
        // Style 1. - Loading Text - branches.
        $branchcircle = [  'terms' => [ ['name' => 'style', 'operator' => '==', 'value' => 'style1' ]  ] ];

        $counts = array_combine(range(1, 10), range(1, 10));

        $this->control_select('branchcount', __( 'Branch count', parent::$slug ), $counts, '2', $branchcircle );

        foreach (range(1, 10) as $key) {

            $branchcondition = [
                'relation' => 'and',
                'terms' => [
                    ['name' => 'branchcount', 'operator' => '>=', 'value' => $key],
                    ['name' => 'style', 'operator' => '==', 'value' => 'style1' ] 
                ]
            ];

            $this->control_text('branch['.$key.'][x]', __( 'X Position', parent::$slug ), '', __( '', parent::$slug), $branchcondition );            
            $this->control_text('branch['.$key.'][y]', __( 'Y Position', parent::$slug ), '', __( '', parent::$slug), $branchcondition );
            $this->control_text('branch['.$key.'][text]', __('Branch Text', self::$slug), '', __('Branch Text', self::$slug), $branchcondition );
        }

        $captioncondition = [
            //'relation' => 'or',
            'terms' => [
                ['name' => 'style', 'operator' => 'in', 'value' => ['style3', 'style7', 'style10'] ]
            ]           
        ];
        $this->control_text('caption', __( 'Caption', parent::$slug ), '', __('', parent::$slug), $captioncondition );

        $caption2condition = [
            //'relation' => 'or',
            'terms' => [
                ['name' => 'style', 'operator' => 'in', 'value' => ['style10'] ]
            ]           
        ];
        $this->control_text('caption2', __( 'Second Caption ', parent::$slug ), '', __('', parent::$slug), $caption2condition );

        // Counter circle control condition.
        $countercondition = [
            //'relation' => 'or',
            'terms' => [
                ['name' => 'style', 'operator' => 'in', 'value' => ['style2', 'style8'] ]
            ]            
        ];

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
				],
                'conditions' => $countercondition
			]
		);
        $this->control_text('startvalue', __( 'Start value', parent::$slug ), '', __( 'Init value', parent::$slug), $countercondition );
        $this->control_text('endvalue', __( 'End value', parent::$slug ), '', __( '', parent::$slug), $countercondition );
        $this->control_text('symbol', __( 'Symbols', parent::$slug ), '', __( '%', parent::$slug), $countercondition );

        // Style 5 - Growing circle outside.
        $outsidecondition = [
            //'relation' => 'or',
            'terms' => [
                ['name' => 'style', 'operator' => 'in', 'value' => ['style5'] ]
            ]            
        ];
        $this->control_media('blockicon', __('Block icon', self::$slug), [], __('Box Image', self::$slug), $outsidecondition );

        // Style 8. - Multiple icons conditoins.
        $multicircle = [  'terms' => [ ['name' => 'style', 'operator' => '==', 'value' => 'style7' ]  ] ];

        $this->control_text('value', __( 'Value', parent::$slug ), '', __( 'Init value', parent::$slug), $multicircle );
       
        $counts = array_combine(range(1, 10), range(1, 10));

        $this->control_select('iconcount', __( 'Icon count', parent::$slug ), $counts, '2', $multicircle );

        foreach (range(1, 10) as $key) {

            $iconcondition = [
                'relation' => 'and',
                'terms' => [
                    ['name' => 'iconcount', 'operator' => '>=', 'value' => $key],
                    ['name' => 'style', 'operator' => '==', 'value' => 'style7' ] 
                ]
            ];

            
            $this->control_text('icon['.$key.'][x]', __( 'X Position', parent::$slug ), '', __( '', parent::$slug), $iconcondition );
            
            $this->control_text('icon['.$key.'][y]', __( 'Y Position', parent::$slug ), '', __( '', parent::$slug), $iconcondition );

            $this->control_media('icon['.$key.'][img]', __('Box image', self::$slug), [], __('Box Image', self::$slug), $iconcondition );

        }
        // $this->control_cta_button();

        // $this->control_media('itemimage', __('Block ICON', self::$slug), [], __('Service Icon', self::$slug) );

        $this->add_repeat_fields('circles', __('Circle ', self::$slug) );  
        
        // End controls.
        $this->end_controls_section();

        // $this->animation_controls();
    }



    public function render() {       
        include( TROIWIDGETS_PATH.'templates/circle_widget.php' );
    }
}

