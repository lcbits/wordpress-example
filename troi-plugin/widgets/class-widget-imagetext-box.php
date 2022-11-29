<?php

namespace TROIWidgets\Widgets;

use Elementor\Controls_Manager;

use Elementor\Plugin;

use Elementor\Repeater;

use Elementor\Widget_Base;

use Elementor\Widget_Video;

use Elementor\Utils;

use Elementor\Embed;

use Elementor\Group_Control_Image_Size;

use Elementor\Group_Control_Css_Filter;

use Elementor\Group_Control_Text_Shadow;

use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor video widget.
 *
 * Elementor widget that displays a video player.
 *
 * @since 1.0.0
 */
class Imagetext_box extends \TROIWidgets\Widgets\Module {

	/**
	 * Get widget name.
	 *
	 * Retrieve video widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'troi-imagetext-box';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve video widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Troi Image Text Box', parent::$slug );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve video widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-youtube';
	}

	

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'video', 'player', 'embed', 'youtube', 'vimeo', 'dailymotion' ];
	}

	/**
	 * Register video widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {

		// Start control section.
        $this->start_section( 'config_section', 'Content settings' );

        $options = ['white' => __('White', self::$slug), 'black' => __('Black', self::$slug) ];

        $this->control_select( 'backgroundtype', __('Background Type', self::$slug), $options, 'white' );

        $options = [
            'style1' => __('Item Lists', self::$slug), 
            'style2' => __('Full Width', self::$slug),
            'style3' => __('Multiple images', self::$slug) 
        ];

		$paralaxcondition = [ 
            'terms' => [
                [ 'name' => 'style', 'operator' => 'in', 'value' => ['style2'] ]
            ]   
        ];
		
		$this->control_select( 'style', __('Background Type', self::$slug), $options, 'style1' );

		$this->add_control(
			'parallax',
			[
				'label' => __( 'Parallax', parent::$slug ),
				'type' => Controls_Manager::SWITCHER,
				'frontend_available' => true,
				'conditions' => $paralaxcondition
			],
		);

		$this->add_control(
			'backgroundmodal',
			[
				'label' => __( 'Parallax', parent::$slug ),
				'type' => Controls_Manager::SELECT,				
				'conditions' => $paralaxcondition,
				'options' => [ 'image' => 'Image', 'video' => 'Video' ]
			],
		);

		$videocondition = [ 
			'relation' => 'and',
            'terms' => [
                [ 'name' => 'style', 'operator' => 'in', 'value' => ['style2'] ],
				[ 'name' => 'backgroundmodal', 'operator' => 'in', 'value' => ['video'] ]
            ]   
        ];

		$imagecondition = [ 
			'relation' => 'and',
            'terms' => [
                [ 'name' => 'style', 'operator' => 'in', 'value' => ['style2'] ],
				[ 'name' => 'backgroundmodal', 'operator' => 'in', 'value' => ['image'] ]
            ]   
        ];

		$this->add_control(
			'imagedescription',
			[
				'label' => __( 'Note', parent::$slug ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,				
				'conditions' => $imagecondition,
				'raw' => __('Add your image in background image section on advanced tab.'),
				'separator' => 'before'
			],
		);
		
        
        $this->set_repeater();

        $this->controler->add_responsive_control(
			'content_alignment',
			[
				'label' => __( 'Content Style', self::$slug ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
                    'center-block' => [
                        'title' => __( 'Center', 'elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right-block' => [
                        'title' => __( 'Right', 'elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'left-block' => [
                        'title' => __( 'Left', 'elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],                 
				],
				// 'conditions' => $paralaxcondition
                
            ],
		);

        $placecondition = [ 
            'terms' => [
                [ 'name' => 'style', 'operator' => 'in', 'value' => ['style1'] ]
            ]   
        ];

        
        // $placecondition = [];

        $placement = ['image-top' => 'top-image', 'image-bottom' => 'Bottom Image', 'image-left' => 'Left Image', 'image-right' => 'Right Image'];

        $this->control_select('content_placement', __('Content Placement', self::$slug), $placement, 'left' );

        $this->control_select('headtag', __( 'Head Level', self::$slug ) , $this->headtags(), 'h3' );

        $this->control_textarea('heading', __( 'Box Heading', self::$slug ) , '', __('Box heading') );       

        $this->control_textarea('description', __( 'Bild Description', parent::$slug ), '', __('', parent::$slug) );

        $this->control_cta_button();

        $this->control_media('image', __( 'Box Image', self::$slug ), [], __( 'Box Image', self::$slug ) );

	/* 	$this->controler->add_control(
            'imagewidth',
            [
                'label' => __('Media file width', self::$slug),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'placeholder' => __('Width', self::$slug),
                'conditions' => $conditions
            ]
        );

        $this->controler->add_control(
			'imageheight',
            [
                'label' => __('Media file height', self::$slug),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'placeholder' => __('Height', self::$slug),
                'conditions' => $conditions
            ]
        );
 */
        $this->add_repeat_fields('imagetexts', __('Image Texts', self::$slug ) );
        // End controls.
        $this->end_controls_section();

        /************************************* Video controls *************************************/
        /******************************************************************************************/


		$this->start_controls_section(
			'section_video',
			[
				'label' => __( 'Video', 'elementor' ),
				'conditions' => $videocondition
			]

		);

		$this->add_control(
			'video_type',
			[
				'label' => __( 'Source', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'youtube',
				'options' => [
					'0' => __('None', parent::$slug),
					'youtube' => __( 'YouTube', 'elementor' ),
					'vimeo' => __( 'Vimeo', 'elementor' ),					
					'hosted' => __( 'Self Hosted', 'elementor' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'youtube_url',
			[
				'label' => __( 'Link', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					],
				],
				'placeholder' => __( 'Enter your URL', 'elementor' ) . ' (YouTube)',
				'default' => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
				'label_block' => true,
				'condition' => [
					'video_type' => 'youtube',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'vimeo_url',
			[
				'label' => __( 'Link', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					],
				],
				'placeholder' => __( 'Enter your URL', 'elementor' ) . ' (Vimeo)',
				'default' => 'https://vimeo.com/235215203',
				'label_block' => true,
				'condition' => [
					'video_type' => 'vimeo',
				],
			]
		);

		$this->add_control(
			'dailymotion_url',
			[
				'label' => __( 'Link', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					],
				],
				'placeholder' => __( 'Enter your URL', 'elementor' ) . ' (Dailymotion)',
				'default' => 'https://www.dailymotion.com/video/x6tqhqb',
				'label_block' => true,
				'condition' => [
					'video_type' => 'dailymotion',
				],
			]
		);

		$this->add_control(
			'insert_url',
			[
				'label' => __( 'External URL', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'video_type' => 'hosted',
				],
			]
		);

		$this->add_control(
			'hosted_url',
			[
				'label' => __( 'Choose File', 'elementor' ),
				'type' => Controls_Manager::MEDIA,				
				'media_type' => 'video',
				'condition' => [
					'video_type' => 'hosted',
					'insert_url' => '',
				],
			]
		);

		$this->add_control(
			'external_url',
			[
				'label' => __( 'URL', 'elementor' ),
				'type' => Controls_Manager::URL,
				'autocomplete' => false,
				'options' => false,
				'label_block' => true,
				'show_label' => false,
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					],
				],
				'media_type' => 'video',
				'placeholder' => __( 'Enter your URL', 'elementor' ),
				'condition' => [
					'video_type' => 'hosted',
					'insert_url' => 'yes',
				],
			]
		);

		// $this->add_control(
		// 	'start',
		// 	[
		// 		'label' => __( 'Start Time', 'elementor' ),
		// 		'type' => Controls_Manager::NUMBER,
		// 		'description' => __( 'Specify a start time (in seconds)', 'elementor' ),
		// 		'frontend_available' => true,
		// 	]
		// );

		// $this->add_control(
		// 	'end',
		// 	[
		// 		'label' => __( 'End Time', 'elementor' ),
		// 		'type' => Controls_Manager::NUMBER,
		// 		'description' => __( 'Specify an end time (in seconds)', 'elementor' ),
		// 		'condition' => [
		// 			'video_type' => [ 'youtube', 'hosted' ],
		// 		],
		// 		'frontend_available' => true,
		// 	]
		// );

		$this->add_control(
			'video_options',
			[
				'label' => __( 'Video Options', 'elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'play_on_mobile',
			[
				'label' => __( 'Play On Mobile', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'autoplay' => 'yes',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'mute',
			[
				'label' => __( 'Mute', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'loop',
			[
				'label' => __( 'Loop', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'video_type!' => 'dailymotion',
				],
				'frontend_available' => true,
			]
		);

		// $this->add_control(
		// 	'controls',
		// 	[
		// 		'label' => __( 'Player Controls', 'elementor' ),
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'label_off' => __( 'Hide', 'elementor' ),
		// 		'label_on' => __( 'Show', 'elementor' ),
		// 		'default' => 'yes',
		// 		'condition' => [
		// 			'video_type!' => 'vimeo',
		// 		],
		// 		'frontend_available' => true,
		// 	]
		// );

		$this->add_control(
			'showinfo',
			[
				'label' => __( 'Video Info', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'default' => 'yes',
				'condition' => [
					'video_type' => [ 'dailymotion' ],
				],
			]
		);

		$this->add_control(
			'modestbranding',
			[
				'label' => __( 'Modest Branding', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'video_type' => [ 'youtube' ],
					'controls' => 'yes',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'logo',
			[
				'label' => __( 'Logo', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'default' => 'yes',
				'condition' => [
					'video_type' => [ 'dailymotion' ],
				],
			]
		);

		// YouTube.
		$this->add_control(
			'yt_privacy',
			[
				'label' => __( 'Privacy Mode', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'description' => __( 'When you turn on privacy mode, YouTube won\'t store information about visitors on your website unless they play the video.', 'elementor' ),
				'condition' => [
					'video_type' => 'youtube',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'rel',
			[
				'label' => __( 'Suggested Videos', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'Current Video Channel', 'elementor' ),
					'yes' => __( 'Any Video', 'elementor' ),
				],
				'condition' => [
					'video_type' => 'youtube',
				],
			]
		);

		// Vimeo.
		$this->add_control(
			'vimeo_title',
			[
				'label' => __( 'Intro Title', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'default' => 'yes',
				'condition' => [
					'video_type' => 'vimeo',
				],
			]
		);

		$this->add_control(
			'vimeo_portrait',
			[
				'label' => __( 'Intro Portrait', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'default' => 'yes',
				'condition' => [
					'video_type' => 'vimeo',
				],
			]
		);

		$this->add_control(
			'vimeo_byline',
			[
				'label' => __( 'Intro Byline', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'default' => 'yes',
				'condition' => [
					'video_type' => 'vimeo',
				],
			]
		);

		$this->add_control(
			'color',
			[
				'label' => __( 'Controls Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'video_type' => [ 'vimeo', 'dailymotion' ],
				],
			]
		);

		$this->add_control(
			'download_button',
			[
				'label' => __( 'Download Button', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'condition' => [
					'video_type' => 'hosted',
				],
			]
		);

		$this->add_control(
			'poster',
			[
				'label' => __( 'Poster', 'elementor' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'video_type' => 'hosted',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'elementor' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'youtube',
			]
		);

		$this->end_controls_section();

		

		$this->start_controls_section(
			'section_video_style',
			[
				'label' => __( 'Video', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'aspect_ratio',
			[
				'label' => __( 'Aspect Ratio', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'16:9' => '16:9',
					'21:9' => '21:9',
					'4:3' => '4:3',
					'3:2' => '3:2',
					'1:1' => '1:1',
					'9:16' => '9:16',
				],
				'default' => '16:9',
				'prefix_class' => 'elementor-aspect-ratio-',
				'frontend_available' => true,
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .elementor-wrapper',
			]
		);

		$this->add_control(
			'play_icon_title',
			[
				'label' => __( 'Play Icon', 'elementor' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'show_image_overlay' => 'yes',
					'show_play_icon' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'play_icon_color',
			[
				'label' => __( 'Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-custom-embed-play i' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_image_overlay' => 'yes',
					'show_play_icon' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'play_icon_size',
			[
				'label' => __( 'Size', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-custom-embed-play i' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'show_image_overlay' => 'yes',
					'show_play_icon' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'play_icon_text_shadow',
				'selector' => '{{WRAPPER}} .elementor-custom-embed-play i',
				'fields_options' => [
					'text_shadow_type' => [
						'label' => _x( 'Shadow', 'Text Shadow Control', 'elementor' ),
					],
				],
				'condition' => [
					'show_image_overlay' => 'yes',
					'show_play_icon' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		
	}

	/**
	 * Render video widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
        $style = $this->get_result('style');
		$parallax = $this->get_result('parallax');
		$background = $this->get_background();
    ?>
        <div class="troi-widget image-text-element <?php echo $background; ?> <?php echo ($style == 'style1' ) ? 'item-lists' : ''; ?> <?php echo ($style == 'style2' ) ? 'full-width-block' : ''; ?> <?php echo ($style == 'style3' ) ? 'multiple-images' : ''; ?> " style="" data-parallax="<?php echo $parallax; ?>" >
			<?php if ($style == 'style2') {
				echo '<div class="troi-video-animation">';
					$this->get_video_content();
				echo '</div>';
			} ?>
			<div class="container">
            <?php            
            if ($style == 'style2') {
				// $this->get_video_content();

				$images = $this->get_result('imagetexts');
				foreach ( $images as $key => $image ) :
					$imagehtml = $this->render_image($image, 'image');
					$contentalignment = $this->get_option($image, 'content_alignment');
					$headtag = $this->get_option($image, 'headtag');
					$heading = $this->get_option($image, 'heading');
					// $caption = $this->get_option($image, 'caption');
					$description = $this->get_option($image, 'description');
					$buttontext = $this->get_option($image, 'buttontext');
					$buttonurl = $this->get_option($image, 'buttonurl');
					if ( ! empty( $buttonurl['url'] ) ) {
						$this->add_link_attributes( 'buttonurl', $image['buttonurl'] );
					}	
                ?>
                
					<div class="image-text-bg <?php echo $contentalignment; ?>">	
						<div class="image-text-block ">
							<!-- Image block -->
							<?php if ( isset($image['image']['url']) && !empty($image['image']['url']) ) { ?>
							<div class="img-block">
								<?php echo $imagehtml; ?>
							</div>
							<?php } ?>
							<!-- Content block -->
							<div class="content-block">
								<?php echo '<'.$headtag.'>'. $heading .'</'.$headtag.'>'; ?> <!-- Title block -->
								<p><?php echo $description; ?></p>
								<!-- button block -->
								<?php if ( !empty($buttonurl['url']) ) { ?>
								<div class="btn-block">
									<a class="btn" <?php echo $this->get_render_attribute_string( 'buttonurl' );?> > <?php echo $buttontext; ?></a>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
                </div>
            <?php } else if ($style == 'style3') { 
				$images = $this->get_result('imagetexts');
				foreach ( $images as $key => $image ) :
					$imagehtml = $this->render_image($image, 'image');					
				?> <!-- Multiple image style -->                
					<div class="image-text-block image-element"> 
						<!-- Image block -->
						<?php if ( isset($image['image']['url']) && !empty($image['image']['url']) ) { ?>
						<div class="img-block">
							<?php echo $imagehtml; ?>
						</div>
						<?php } ?>
					</div>
				<?php endforeach; ?>
            <?php } else { 
				$images = $this->get_result('imagetexts');
				foreach ( $images as $key => $image ) :
					$imagehtml = $this->render_image($image, 'image');
					$contentplacement = $this->get_option($image, 'content_placement');
					$headtag = $this->get_option($image, 'headtag');
					$heading = $this->get_option($image, 'heading');
					// $caption = $this->get_option($image, 'caption');
					$description = $this->get_option($image, 'description');
					$buttontext = $this->get_option($image, 'buttontext');
					$buttonurl = $this->get_option($image, 'buttonurl');
					if ( ! empty( $buttonurl['url'] ) ) {
						$this->add_link_attributes( 'buttonurl', $image['buttonurl'] );
					}	

			?>
                <div class="image-text-block <?php echo $contentplacement; ?>">
					
					<?php if ($contentplacement != 'image-right' ) : ?>
                    <!-- Image block -->
                    <div class="img-block">
						<?php echo $imagehtml; ?>
                    </div>
					<?php endif; ?>
                    <!-- Content block -->
                    <div class="content-block">
                        <?php echo '<'.$headtag.'>'. $heading .'</'.$headtag.'>'; ?> <!-- Title block -->
                        <p><?php echo $description; ?></p>
                        <!-- button block -->
						<?php if (!empty( $buttonurl['url'] ) ) { ?>
                        <div class="btn-block">
							<a class="btn" <?php echo $this->get_render_attribute_string( 'buttonurl' );?> > <?php echo $buttontext; ?></a>
                        </div>
						<?php } ?>
                    </div>
					<?php if ($contentplacement == 'image-right' || $contentplacement == 'image-bottom'  ) : ?>
						<!-- Image block -->
						<div class="img-block">
							<?php echo $imagehtml; ?>
                    	</div>
					<?php endif; ?>

                </div>
				<?php endforeach; ?>
            <?php } ?>
            </div>
        </div>
        <?php
	}

	/**
	 * Render video widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function get_video_content() {

		$settings = $this->get_settings_for_display();

		if ($settings['video_type'] == 0) {
			return '';
		}

		$video_url = $settings[ $settings['video_type'] . '_url' ];

		if ( 'hosted' === $settings['video_type'] ) {
			$video_url = $this->get_hosted_video_url();
		} else {
			$embed_params = $this->get_embed_params();
			$embed_options = $this->get_embed_options();
		}

		if ( empty( $video_url ) ) {
			return;
		}

		if ( 'youtube' === $settings['video_type'] ) {
			$video_html = '<div class="elementor-video"></div>';
		}

		if ( 'hosted' === $settings['video_type'] ) {
			$this->add_render_attribute( 'video-wrapper', 'class', 'e-hosted-video' );

			ob_start();

			$this->render_hosted_video();

			$video_html = ob_get_clean();
		} else {
			$is_static_render_mode = Plugin::$instance->frontend->is_static_render_mode();
			$post_id = get_queried_object_id();

			if ( $is_static_render_mode ) {
				$video_html = Embed::get_embed_thumbnail_html( $video_url, $post_id );
				// YouTube API requires a different markup which was set above.
			} else if ( 'youtube' !== $settings['video_type'] ) {
				$video_html = Embed::get_embed_html( $video_url, $embed_params, $embed_options );
			}
		}

		if ( empty( $video_html ) ) {
			echo esc_url( $video_url );
			return;
		}

		// $this->add_render_attribute( 'video-wrapper', 'class', 'elementor-wrapper' );
	
		// $this->add_render_attribute( 'video-wrapper', 'class', 'elementor-fit-aspect-ratio' );		
		?>
		<!-- <div <?php //echo $this->get_render_attribute_string( 'video-wrapper' ); ?>> -->
			<?php
				echo $video_html; // XSS ok.			
			?>
		<!-- </div> -->
		<?php
	}

	/**
	 * Render video widget as plain content.
	 *
	 * Override the default behavior, by printing the video URL insted of rendering it.
	 *
	 * @since 1.4.5
	 * @access public
	 */
	public function render_plain_content() {
		$settings = $this->get_settings_for_display();

		if ( 'hosted' !== $settings['video_type'] ) {
			$url = $settings[ $settings['video_type'] . '_url' ];
		} else {
			$url = $this->get_hosted_video_url();
		}

		echo esc_url( $url );
	}

	/**
	 * Get embed params.
	 *
	 * Retrieve video widget embed parameters.
	 *
	 * @since 1.5.0
	 * @access public
	 *
	 * @return array Video embed parameters.
	 */
	public function get_embed_params() {
		$settings = $this->get_settings_for_display();

		$params = [];

		if ( $settings['autoplay'] && ! $this->has_image_overlay() ) {
			$params['autoplay'] = '1';

			if ( $settings['play_on_mobile'] ) {
				$params['playsinline'] = '1';
			}
		}

		$params_dictionary = [];

		if ( 'youtube' === $settings['video_type'] ) {
			$params_dictionary = [
				'loop',				
				'mute',
				'rel',
				'modestbranding',
			];

			if ( $settings['loop'] ) {
				$video_properties = Embed::get_video_properties( $settings['youtube_url'] );

				$params['playlist'] = $video_properties['video_id'];
			}
			

			$params['wmode'] = 'opaque';
		} elseif ( 'vimeo' === $settings['video_type'] ) {
			$params_dictionary = [
				'loop',
				'mute' => 'muted',
				'vimeo_title' => 'title',
				'vimeo_portrait' => 'portrait',
				'vimeo_byline' => 'byline',
			];

			$params['color'] = str_replace( '#', '', $settings['color'] );

			$params['autopause'] = '0';
		} elseif ( 'dailymotion' === $settings['video_type'] ) {
			$params_dictionary = [				
				'mute',
				'showinfo' => 'ui-start-screen-info',
				'logo' => 'ui-logo',
			];

			$params['ui-highlight'] = str_replace( '#', '', $settings['color'] );

			// $params['start'] = $settings['start'];

			$params['endscreen-enable'] = '0';
		}

		foreach ( $params_dictionary as $key => $param_name ) {
			$setting_name = $param_name;

			if ( is_string( $key ) ) {
				$setting_name = $key;
			}

			$setting_value = $settings[ $setting_name ] ? '1' : '0';

			$params[ $param_name ] = $setting_value;
		}

		return $params;
	}

	/**
	 * Whether the video widget has an overlay image or not.
	 *
	 * Used to determine whether an overlay image was set for the video.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @return bool Whether an image overlay was set for the video.
	 */
	protected function has_image_overlay() {
		$settings = $this->get_settings_for_display();

		return ! empty( $settings['image_overlay']['url'] ) && 'yes' === $settings['show_image_overlay'];
	}

	/**
	 * @since 2.1.0
	 * @access private
	 */
	private function get_embed_options() {
		$settings = $this->get_settings_for_display();

		$embed_options = [];

		if ( 'youtube' === $settings['video_type'] ) {
			$embed_options['privacy'] = $settings['yt_privacy'];
		} elseif ( 'vimeo' === $settings['video_type'] ) {
			// $embed_options['start'] = $settings['start'];
		}

		$embed_options['lazy_load'] = ! empty( $settings['lazy_load'] );

		return $embed_options;
	}

	/**
	 * @since 2.1.0
	 * @access private
	 */
	private function get_hosted_params() {
		$settings = $this->get_settings_for_display();

		$video_params = [];

		foreach ( [ 'autoplay', 'loop' ] as $option_name ) {
			if ( $settings[ $option_name ] ) {
				$video_params[ $option_name ] = '';
			}
		}

		if ( $settings['mute'] ) {
			$video_params['muted'] = 'muted';
		}

		if ( $settings['play_on_mobile'] ) {
			$video_params['playsinline'] = '';
		}

		if ( ! $settings['download_button'] ) {
			$video_params['controlsList'] = 'nodownload';
		}

		if ( $settings['poster']['url'] ) {
			$video_params['poster'] = $settings['poster']['url'];
		}

		return $video_params;
	}

	/**
	 * @param bool $from_media
	 *
	 * @return string
	 * @since 2.1.0
	 * @access private
	 */
	private function get_hosted_video_url() {
		$settings = $this->get_settings_for_display();

		if ( ! empty( $settings['insert_url'] ) ) {
			$video_url = $settings['external_url']['url'];
		} else {
			$video_url = $settings['hosted_url']['url'];
		}

		if ( empty( $video_url ) ) {
			return '';
		}

		// if ( $settings['start'] || $settings['end'] ) {
		// 	$video_url .= '#t=';
		// }

		// if ( $settings['start'] ) {
		// 	$video_url .= $settings['start'];
		// }

		// if ( $settings['end'] ) {
		// 	$video_url .= ',' . $settings['end'];
		// }

		return $video_url;
	}

	/**
	 *
	 * @since 2.1.0
	 * @access private
	 */
	private function render_hosted_video() {
		$video_url = $this->get_hosted_video_url();
		if ( empty( $video_url ) ) {
			return;
		}

		$video_params = $this->get_hosted_params();
		?>
		<video class="elementor-video" src="<?php echo esc_url( $video_url ); ?>" <?php echo Utils::render_html_attributes( $video_params ); ?>></video>
		<?php
	}
}
