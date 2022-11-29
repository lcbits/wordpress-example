<?php

namespace TROIWidgets\Widgets;

use Elementor\Repeater;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Icon_box extends \TROIWidgets\Widgets\Module {

    public static $slug = 'troi-widgets';

	public function get_name() {
		return 'troi-icon';
	}

	public function get_title() {
		return __('Troi Icon Box', self::$slug);
	}

	public function get_icon() {
		return 'fa fa-box';
	}

    protected function _register_controls() {

        $this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Options', self::$slug ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$options = [ 'white' => __('White', self::$slug), 'black' => __('Black', self::$slug) ];

		$this->add_control(
            'backgroundtype',
            [
                'label' => __( 'Background Type', parent::$slug ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $options,
                'default' => 'white',
                'placeholder' => __( 'Option Contents', self::$slug ),
            ]
        );
		// Use the repeater to define one one set of the items we want to repeat look like
		$repeater = new Repeater();

		$repeater->add_control(
			'box_heading',
			[
				'label' => __( 'Heading', self::$slug ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => __( 'Heading for the icon box', self::$slug ),
			]
		);

		$repeater->add_control(
			'box_button_text',
			[
				'label' => __( 'CTA Button Text', self::$slug ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',// __( "Company Name", self::$slug ),
				'placeholder' => __( 'Button text.', self::$slug ),
			]
		);

		$repeater->add_control(
			'box_button_url',
			[
				'label' => __( 'CTA Button URL', self::$slug ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',//__( "The Option's Contents", self::$slug ),
				'placeholder' => __( 'URL to redirect', self::$slug ),
			]
		);

        $repeater->add_control(
			'box_icon',
			[
				'label' => __( 'Icon', self::$slug ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [],
				// 'placeholder' => __( '', self::$slug ),
			]
		);
		$repeater->add_control(
        	'box_icon_customsize',
            [
                'label' => __('Custom media file size', self::$slug),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'placeholder' => __('Width', self::$slug),
            ]
        );
		$repeater->add_control(
           'box_icon_width',
            [
                'label' => __('Media file width', self::$slug),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'placeholder' => __('Width', self::$slug),
                'condition' => ['box_icon_customsize' => 'yes']
            ]
        );

        $repeater->add_control(
            "box_icon_height",
            [
                'label' => __('Media file height', self::$slug),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'placeholder' => __('Height', self::$slug),
				'condition' => ['box_icon_customsize' => 'yes']
            ]
        );

        $repeater->add_control(
			'box_description',
			[
				'label' => __( 'Capture', self::$slug ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => '',
				'placeholder' => __( 'Description content', self::$slug ),
			]
		);

        $this->add_control(
			'options_list',
			[
				'label' => __( 'Repeater List', self::$slug ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[]
				],
			]
		);

        $this->end_controls_section();

        $this->animation_controls();
    }

    protected function render() {
        include( TROIWIDGETS_PATH.'templates/icon_box.php' );
    }
}