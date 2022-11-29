<?php

namespace TROIWidgets\Widgets;

use Elementor\Repeater;

use Elementor\Widget_Base;

abstract class Module extends Widget_Base {

    public static $slug = 'troi-widgets';

    public $result = [];

    public $controler;

    public $wwwroot;
    
    abstract function get_name();
    
    public function __construct( $data = [], $args = null ) {
        
        parent::__construct( $data, $args );
        
        $this->controler = $this;

        $this->wwwroot = plugins_url( 'troi-widgets/' );
    }

    public function get_categories() { 
		return [ 'troi-widgets' ]; 
	}
    
    public function animation_controls() {
      

        $this->start_controls_section(

			'animation_section',
			[
				'label' => __( 'Animation Effects', self::$slug ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'animation_in',
			[
				'label' => __( 'Element IN animation', self::$slug ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $this->animations(),
				'placeholder' => __( 'Option Contents', self::$slug ),
			]
		);

        $this->add_control(
			'duration',
			[
				'label' => __( 'Animation Duration', self::$slug ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => '2',
				'placeholder' => __( 'Animation Duration', self::$slug ),
			]
		);

        // $this->add_control(
		// 	'animation_out',
		// 	[
		// 		'label' => __( 'Element OUT animation', self::$slug ),
		// 		'type' => \Elementor\Controls_Manager::SELECT,
		// 		'options' => $this->animations(),
		// 		'placeholder' => __( 'Option Contents', self::$slug ),
		// 	]
		// );

        $this->end_controls_section();
    }

    public function get_result($key, $array=false) {
        if (empty($this->result)) {
            $this->result = $this->get_settings_for_display();
        }
        if (is_array($this->result)) {
            $value = isset($this->result[$key]) ? $this->result[$key] : (($array) ? [] : false);
            return $value;
        }
        
        return ($array) ? [] : false;
    }

    public function get_option($options, $key) {
        if (is_array($options)) {
            $value = isset($options[$key]) ? $options[$key] : '';
            return $value;
        }
        return false;
    }

    public function get_background($key='backgroundtype') {
        $style = $this->get_result('backgroundtype');
        $bgcolorclass = ($style == 'black') ? 'troi-transparent-bg' : 'troi-white-bg';
        return $bgcolorclass;
    }

    public function itemstatus($item) {
        $status = $this->get_option($item, 'itemstatus');
        return ($status == 'yes') ? true : false;
    }

    public function remove_disabled($items) {
        $items = array_filter($items, function($item) {            
            return $this->itemstatus($item);            
        });        
        return $items;
    }

    public function set_repeater() {
        // Use the repeater to define one one set of the items we want to repeat look like
        $this->controler = new Repeater();
    }

    public function set_controler() {
        // Use the repeater to define one one set of the items we want to repeat look like
        $this->controler = $this;
    }

    public function add_repeat_fields($name, $label, $default = []) {
        $this->add_control(
			$name,
			[
				'label' => __( $label, self::$slug ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $this->controler->get_controls(),				
                'default' => $default
			]
		);

        $this->set_controler();
    }

    /**
     * Start controls section wrapper.
     */
    public function start_section($name, $label) {

        $this->start_controls_section(
			$name,
			[
				'label' => __( $label, self::$slug ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
    }

    public function control_background($default='black') {

        $options = [ 'white' => __('White', self::$slug), 'black' => __('Black', self::$slug) ];
        
        $this->control_select( 'backgroundtype', __('Background Type', self::$slug), $options, $default );               
    }

    public function control_itemstatus($name="enable") {

        $this->controler->add_control(
			'itemstatus',
			[
				'label' => __( 'Enable', self::$slug ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes'				
			]
		);
    }

    public function control_cta_button($text='', $condition=[]) {
        // CTA button text.
        $this->control_text('buttontext', 'CTA Button Text', '', 'Enter button text', $condition );
        // Paragraph CTA Button URL
        $this->control_url('buttonurl', 'CTA Button URL', ['url' => ''], '', $condition);    
    }

    public function control_checkbox( $name, $field, $default='' ) {

    }

    public function control_text( $name, $label, $default='', $placeholder='', $conditions =[] ) {
        $this->controler->add_control(
			$name,
			[
				'label' => __( $label, self::$slug ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => $default,
				'placeholder' => __( $placeholder, self::$slug ),
                'conditions' => $conditions
			]
		);
    }

    public function control_url( $name, $label, $default=[ 'url' => '' ], $placeholder='', $conditions=[] ) {
        
        $this->controler->add_control(
			$name,
			[
				'label' => __( $label, self::$slug ),
				'type' => \Elementor\Controls_Manager::URL,
				'default' => $default,
				'placeholder' => __( $placeholder, self::$slug ),
                'conditions' => $conditions
			]
		);
    }

    public function control_textarea( $name, $label, $default='', $placeholder='', $condition=[], $editor=false ) {

        $this->controler->add_control(
			$name,
			[
				'label' => __( $label, self::$slug ),
				'type' => ($editor) ? \Elementor\Controls_Manager::WYSIWYG : \Elementor\Controls_Manager::TEXTAREA,
				'default' => $default,
				'placeholder' => __( $placeholder, self::$slug ),
                'conditions' => $condition

			]
		);
    }

    public function control_duration( $name, $label, $default=10, $condition=[], $min = 10, $max = 50, $step = 5 ) {
       
        $this->controler->add_control(
			$name,
			[
				'label' => __( $label, self::$slug ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					's' => [
						'min' => $min,
						'max' => $max,
						'step' => $step,
					],
				],
				'default' => [
					'unit' => 's',
					'size' => $default,
				],
				'selectors' => [
					'{{WRAPPER}} .box' => 'data-duration="{{SIZE}}{{UNIT}};"',
				],
                'condition' => $condition
			]
		);
    }

    public function control_select( $name, $label, $options, $default='', $condition=[] ) {
       
        $this->controler->add_control(
            $name,
            [
                'label' => __( $label, self::$slug ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $options,
                'default' => $default,
                'placeholder' => __( 'Option Contents', self::$slug ),
                'conditions' => $condition
            ]
        );
    }

    public function control_media( $name, $label, $default=[], $placeholder = '', $conditions = [] ) {
        $this->controler->add_control(
			$name,
			[
				'label' => __( $label, self::$slug ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => $default,
				'placeholder' => __( $placeholder, self::$slug ),
                'conditions' => $conditions
			]
		);

        $this->controler->add_control(
            $name.'_customsize',
            [
                'label' => __('Custom media file size', self::$slug),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'placeholder' => __('Width', self::$slug),
                'conditions' => $conditions
            ]
        );
        
        $this->controler->add_control(
            $name.'_width',
            [
                'label' => __('Media file width', self::$slug),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'placeholder' => __('Width', self::$slug),
                'condition' => [$name.'_customsize' => 'yes']
            ]
        );

        $this->controler->add_control(
            $name."_height",
            [
                'label' => __('Media file height', self::$slug),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'placeholder' => __('Height', self::$slug),
                'condition' => [$name.'_customsize' => 'yes']
            ]
        );

    }

    public function render_image($settings, $key) {
        if (isset($settings[$key])) {
            // print_object($settings[$key]);
            $this->add_render_attribute( $key, [
                'src' => isset($settings[$key]['url']) ? $settings[$key]['url'] : '',
                'alt' => \Elementor\Control_Media::get_image_alt( $settings[$key] ),
                'title' => \Elementor\Control_Media::get_image_title( $settings[$key] ),
            ]);
            if ( isset($settings[$key.'_customsize']) && $settings[$key.'_customsize'] == 'yes') {
                $style = '';
                $this->add_render_attribute($key, 'class', 'manual-size');
                if (isset($settings[$key.'_height']) && !empty($settings[$key.'_height']) ) {
                    // $style .= '--'.$key.'_height: '.$settings[$key.'_height'].'px;';
                    $style .= 'height: '.$settings[$key.'_height'].'px !important;';

                    // $this->add_render_attribute($key, 'height', $settings[$key.'_height']);
                }
                
                if (isset($settings[$key.'_width']) && !empty($settings[$key.'_width']) ) {
                    // $style .= '--'.$key.'_width: '.$settings[$key.'_width'].'px;';
                    $style .= 'width: '.$settings[$key.'_width'].'px !important;';

                    // $this->add_render_attribute($key, 'width', $settings[$key.'_width']);
                }
                // $style .= '}';
                $this->add_render_attribute($key, 'style', $style);
            }

            $image_html = '<img '.$this->get_render_attribute_string($key).'>';
            $this->remove_render_attribute($key);
            // $image_html = \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', $key );
            return $image_html;
        }
    }

    /**
	 * Get attachment image HTML.
	 *
	 * Retrieve the attachment image HTML code.
	 *
	 * Note that some widgets use the same key for the media control that allows
	 * the image selection and for the image size control that allows the user
	 * to select the image size, in this case the third parameter should be null
	 * or the same as the second parameter. But when the widget uses different
	 * keys for the media control and the image size control, when calling this
	 * method you should pass the keys.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @param array  $settings       Control settings.
	 * @param string $image_size_key Optional. Settings key for image size.
	 *                               Default is `image`.
	 * @param string $image_key      Optional. Settings key for image. Default
	 *                               is null. If not defined uses image size key
	 *                               as the image key.
	 *
	 * @return string Image HTML.
	 */
	public static function get_attachment_image_html( $settings, $image_size_key = 'image', $image_key = null ) {
		if ( ! $image_key ) {
			$image_key = $image_size_key;
		}

		$image = $settings[ $image_key ];

		// Old version of image settings.
		if ( ! isset( $settings[ $image_size_key . '_size' ] ) ) {
			$settings[ $image_size_key . '_size' ] = '';
		}

		$size = $settings[ $image_size_key . '_size' ];

		$image_class = ! empty( $settings['hover_animation'] ) ? 'elementor-animation-' . $settings['hover_animation'] : '';

		$html = '';

		// If is the new version - with image size.
		$image_sizes = get_intermediate_image_sizes();

		$image_sizes[] = 'full';

		if ( ! empty( $image['id'] ) && ! wp_attachment_is_image( $image['id'] ) ) {
			$image['id'] = '';
		}

		$is_static_render_mode = Plugin::$instance->frontend->is_static_render_mode();

		// On static mode don't use WP responsive images.
		if ( ! empty( $image['id'] ) && in_array( $size, $image_sizes ) && ! $is_static_render_mode ) {
			$image_class .= " attachment-$size size-$size";
			$image_attr = [
				'class' => trim( $image_class ),
			];

			$html .= wp_get_attachment_image( $image['id'], $size, false, $image_attr );
		} else {
			$image_src = self::get_attachment_image_src( $image['id'], $image_size_key, $settings );

			if ( ! $image_src && isset( $image['url'] ) ) {
				$image_src = $image['url'];
			}

			if ( ! empty( $image_src ) ) {
				$image_class_html = ! empty( $image_class ) ? ' class="' . $image_class . '"' : '';

				$html .= sprintf( '<img src="%s" title="%s" alt="%s"%s />', esc_attr( $image_src ), Control_Media::get_image_title( $image ), Control_Media::get_image_alt( $image ), $image_class_html );
			}
		}

		/**
		 * Get Attachment Image HTML
		 *
		 * Filters the Attachment Image HTML
		 *
		 * @since 2.4.0
		 * @param string $html the attachment image HTML string
		 * @param array  $settings       Control settings.
		 * @param string $image_size_key Optional. Settings key for image size.
		 *                               Default is `image`.
		 * @param string $image_key      Optional. Settings key for image. Default
		 *                               is null. If not defined uses image size key
		 *                               as the image key.
		 */
		return apply_filters( 'elementor/image_size/get_attachment_image_html', $html, $settings, $image_size_key, $image_key );
	}

    public function headtags() {
        foreach (range(1, 6) as $val) {
            $tag['h'.$val] = 'Heading '.$val;
        }
        return $tag;
    }

    public function animations() {

        return [
            'none' => __( 'None', 'troi-widgets' ),
            'fadeIn' => __( 'Fade In', 'troi-widgets' ),
            'fadeInLeft' => __( 'Fade In Left', 'troi-widgets' ),
            'fadeInRight' => __( 'Fade In Right', 'troi-widgets' ),
            'fadeInUp' => __( 'Fade In Up', 'troi-widgets' ),
            'zoomIn' => __( 'Zoom In', 'troi-widgets'),
            'zoomInDown' => __( 'Zoom In Down', 'troi-widgets' ),
            'zoomInLeft' => __( 'Zoom In Left', 'troi-widgets' ),
            'zoomInRight' => __( 'Zoom In Right', 'troi-widgets' ),
            'zoomInUp' => __( 'Zoom In Up', 'troi-widgets' ),
            'slideInDown' => __( 'Slide In Down', 'troi-widgets' ),
            'slideInLeft' => __( 'Slide In Left', 'troi-widgets' ),
            'slideInRight' => __( 'Slide In Right', 'troi-widgets' ),
            'slideInUp' => __( 'Slide In Up', 'troi-widgets' ),
        ];
        return [            
            "none" => __('no'),
            "flash" => __('flash', 'troi-widgets'),
            "bounceIn" => __('bounceIn', 'troi-widgets'),
            "bounceInDown" => __('bounceInDown', 'troi-widgets'),
            "bounceInLeft" => __('bounceInLeft', 'troi-widgets'),
            "bounceInRight" => __('bounceInRight', 'troi-widgets'),
            "bounceInUp" => __('bounceInUp', 'troi-widgets'),
            "fadeIn" => __('fadeIn', 'troi-widgets'),
            "fadeInDown" => __('fadeInDown', 'troi-widgets'),
            "fadeInDownBig" => __('fadeInDownBig', 'troi-widgets'),
            "fadeInLeft" => __('fadeInLeft', 'troi-widgets'),
            "fadeInLeftBig" => __('fadeInLeftBig', 'troi-widgets'),
            "fadeInRight" => __('fadeInRight', 'troi-widgets'),
            "fadeInRightBig" => __('fadeInRightBig', 'troi-widgets'),
            "fadeInUp" => __('fadeInUp', 'troi-widgets'),
            "fadeInUpBig" => __('fadeInUpBig', 'troi-widgets'),
            "fadeOut" => __('fadeOut', 'troi-widgets'),
            "flip" => __('flip', 'troi-widgets'),
            "flipInX" => __('flipInX', 'troi-widgets'),
            "flipInY" => __('flipInY', 'troi-widgets'),
            "flipOutX" => __('flipOutX', 'troi-widgets'),
            "flipOutY" => __('flipOutY', 'troi-widgets'),
            "lightSpeedIn" => __('lightSpeedIn', 'troi-widgets'),
            "rotateIn" => __('rotateIn', 'troi-widgets'),
            "rotateInDownLeft" => __('rotateInDownLeft', 'troi-widgets'),
            "rotateInDownRight" => __('rotateInDownRight', 'troi-widgets'),
            "rotateInUpLeft" => __('rotateInUpLeft', 'troi-widgets'),
            "rotateInUpRight" => __('rotateInUpRight', 'troi-widgets'),
            "slideInUp" => __('slideInUp', 'troi-widgets'),
            "slideInDown" => __('slideInDown', 'troi-widgets'),
            "slideInLeft" => __('slideInLeft', 'troi-widgets'),
            "slideInRight" => __('slideInRight', 'troi-widgets'),
            "zoomIn" => __('zoom-In1', 'troi-widgets'),
            "zoomInDown" => __('zoomInDown', 'troi-widgets'),
            "zoomInLeft" => __('zoomInLeft', 'troi-widgets'),
            "zoomInRight" => __('zoomInRight', 'troi-widgets'),
            "zoomInUp" => __('zoomInUp', 'troi-widgets'),
            "hinge" => __('hinge', 'troi-widgets'),
            "rollIn" => __('rollIn', 'troi-widgets'),            
        ];
    }
}