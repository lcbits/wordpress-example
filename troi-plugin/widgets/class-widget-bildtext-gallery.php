<?php

namespace TROIWidgets\Widgets;

use Elementor\Repeater;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class BildText_gallery extends \TROIWidgets\Widgets\Module {

    public function get_name() { return 'troi-bildtext-gallery'; }

    public function get_title() { return __('Bild Text Gallery ', parent::$slug); }

    public function get_icon() { return 'eicon-toggle'; }

    public function _register_controls() {
        // Start control section.
        $this->start_section( 'config_section', 'Content settings' );

        $options = ['white' => __('White', self::$slug), 'black' => __('Black', self::$slug) ];

        $this->control_select( 'backgroundtype', __('Background Type', self::$slug), $options, 'white' );


        $this->controler->add_responsive_control(
            'heading_style',
            [
                'label' => __( 'Heading Style', self::$slug ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    // 'center' => [
                        //  'title' => __( 'Center', 'elementor' ),
                        //  'icon' => 'eicon-text-align-center',
                        // ],
                        'right' => [
                            'title' => __( 'Right', 'elementor' ),
                            'icon' => 'eicon-text-align-right',
                        ],
                        'left' => [
                            'title' => __( 'Left', 'elementor' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        // 'justify' => [
                            //  'title' => __( 'Justified', 'elementor' ),
                    //  'icon' => 'eicon-text-align-justify',
                    // ],
                    ]
                    // 'selectors' => [
                //  '{{WRAPPER}} .elementor-image-box-wrapper' => 'text-align: {{VALUE}};',
                // ],
                ]
        );

        $this->set_repeater();

        $this->control_select('headtag', __( 'Head Level', self::$slug ) , $this->headtags(), 'h3' );

        $this->control_textarea('heading', __( 'Bild Heading', self::$slug ) , '', __('Bild heading') );

        $this->control_text('caption', __( 'Caption', parent::$slug ), '', __('Bild image Caption', self::$slug) );

        $this->control_textarea('description', __( 'Bild Description', parent::$slug ), '', __('', parent::$slug) );

        $this->control_url('pdfurl', __('PDF download URL'),  ['url' => ''] );

        $this->control_cta_button();

        $this->control_media('bildimage', __('Bild Image', self::$slug), [], __('Bild Image') );

        $this->add_repeat_fields('bilds', __('bild-gallery') );
        // End controls.
        $this->end_controls_section();

        $this->animation_controls();
    }

    public function custom_scripts() {
        // Register Widget Scripts
        // add_action( 'elementor/frontend/after_register_scripts', [ $this, 'animation_widget_scripts' ] );
    }

    public function render() {

        $bilds = $this->get_result('bilds', true);
        $backgroundtype = $this->get_result('backgroundtype');
        $animationin = $this->get_result('animation_in');
        $heading_style = $this->get_result('heading_style');


        // <!-- Image Gallery Module -->
        $html = $paginationli = '';
        $html .= '<div class="image-gallery-elements bild-text-gallery">';
        $html .= '<div class="container">';
        $bildschuck = array_chunk($bilds, 5);

        $i = 1;
        $html .= '<div class="gsap-pagination"> ';
        foreach ($bildschuck as $k => $bilds) :

            $html .= '<div class="pagination-content" id="bildpage-'.($k+1).'" style="'.(($k >= 1) ? "display:none;" : '').'" > ';
            foreach ($bilds as $key => $bild) {
                $headtag = $this->get_option($bild, 'headtag');
                $head = $this->get_option($bild, 'heading');
                $first =  $last = '';
                $exp = explode(' ', $head, 2);
                if (isset($exp[1])) {
                    list($first, $last) = $exp;
                }
                $heading = $first . '<br><span>'.$last.'</span>';
                $caption = $this->get_option($bild, 'caption');
                $description = $this->get_option($bild, 'description');
                $bildimage = $this->render_image($bild, 'bildimage');
            
            /*  $bildimage = $this->get_option($bild, 'bildimage');
                $bildimageurl = $this->get_option($bildimage, 'url');
                $bildimagealt = $this->get_option($bildimage, 'alt'); */
                $bildurl = $this->get_option($bild, 'buttonurl');
                $left = ($i % 2 == 0);

                $bildpdfurl = $this->get_option($bild, 'pdfurl');
                $pdftarget = $bildpdfurl['is_external'] ? ' target="_blank"' : '';
                $pdfnofollow = $bildpdfurl['nofollow'] ? ' rel="nofollow"' : '';

                if ($heading_style == 'left') {
                    $html .= '<div class="image-gallery-block">';
                    $html .= '<div class="row">';
                    if ($left) {
                        $html .= '<div class="col-md-3"></div> ';
                    }
                    // <!-- Image Gallery image -->
                    $html .= '<div class="col-md-3 troi-animation-zoom ">';
                    if ($bildimage['url']) {
                        $html .= '<div class="img-block">';
                        $html .= $bildimage;
                        $html .= '</div>';
                    }
                    $html .= '</div>';
                    // <!-- Image Gallery content -->
                    $html .= '<div class="'.(($left) ? "col-md-6" : "col-md-9").'">'; // Col-md-6
                        $html .= '<div class="troi-animation animate__animated" data-animation="'.$animationin.'" >';
                        $html .= '<div class="title-block">';
                            $html .= '<'.$headtag.'>'.$heading.'</'.$headtag.'>';
                            $html .= '<h6>'.$caption.'</h6>';
                        $html .= '</div>';
                        $html .= '</div>';
                        $html .= '<div class="content-block">';
                            $html .= '<p>'.$description.'</p>';
                            // <!-- Button block -->
                            $html .= '<div class="btn-block">';
                            if ($bildpdfurl['url']) {
                                $html .= '<a href="'.$bildpdfurl['url'].'"'.$pdftarget.$pdfnofollow.'><i class="glyph-icon flaticon-download-2"></i></a>';
                            }
                            if ($bildurl['url']) {
                                $html .= '<a href="'.$bildurl['url'].'"><i class="glyph-icon flaticon-055-right-2"></i></a>';
                            }
                            $html .= '</div>';
                        $html .= '</div>';
                    $html .= '</div>'; // End of column content block.

                    $html .= '</div>';
                    $html .= '</div>';
                } else {
                    $html .= '<div class="image-gallery-block split-content'.(($left) ? ' gallery-block' : '' ).' ">';
                    $html .= '<div class="row">';
                    // <!-- Image Gallery Title -->
                    $html .= '<div class="'.(($left) ? "col-md-3" : "col-md-4").'" >';
                        $html .= '<div class="troi-animation animate__animated" data-animation="'.$animationin.'" >';
                        $html .= '<div class="title-block">';
                            $html .= '<'.$headtag.'>'.$heading.'</'.$headtag.'>';
                            $html .= '<h6>'.$caption.'</h6>';
                        $html .= '</div>';
                        $html .= '</div>';

                    $html .= '</div>';

                    // <!-- Image Gallery image -->
                    $html .= '<div class="col-md-3 troi-animation-zoom ">';
                    if ($bild['bildimage']['url']) {
                        $html .= '<div class="img-block">';
                        $html .= $bildimage;
                        $html .= '</div>';
                    }
                    $html .= '</div>';

                    // <!-- Image Gallery Content -->
                    $html .= '<div class="'.(($left) ? "col-md-6" : "col-md-5").'">';
                        $html .= '<div class="content-block">';
                            $html .= '<p>'.$description.'</p>';
                            // <!-- Button block -->
                            $html .= '<div class="btn-block">';
                            if ($bildpdfurl['url']) {
                                $html .= '<a href="'.$bildpdfurl['url'].'"'.$pdftarget.$pdfnofollow.'><i class="glyph-icon flaticon-download-2"></i></a>';
                            }
                            if ($bildurl['url']) {
                                $html .= '<a href="'.$bildurl['url'].'"><i class="glyph-icon flaticon-055-right-2"></i></a>';
                            }
                            $html .= '</div>';
                        $html .= '</div>';
                    $html .= '</div>';

                    $html .= '</div>';
                    $html .= '</div>';
                }
                $i++;
            }
            $html .= '</div>';
            $paginationli .= '<li class="page-item"><a class="page-link btn" href="#bildpage-'.($k+1).'">'.($k+1).'</a></li>';
        endforeach;

        if ( count($bildschuck) > 1 ) {
            $html .= '<nav aria-label="Page navigation example">
                    <ul class="gsap-pagination-nav pagination">';
            $html .= $paginationli;
            $html .= '</ul> </nav>';
        }
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        echo $html;
    }
}

