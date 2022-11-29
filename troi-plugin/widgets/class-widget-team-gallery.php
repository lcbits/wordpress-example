<?php

namespace TROIWidgets\Widgets;

use Elementor\Repeater;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Team_gallery extends \TROIWidgets\Widgets\Module {

    public function get_name() { return 'troi-team-gallery'; }

	public function get_title() { return __('Troi Team Gallery ', self::$slug); }

	public function get_icon() { return 'fa fa-image'; }

	// public function get_categories() { return [ 'general' ]; }

    public function _register_controls() {
        // Start control section.
        $this->start_section( 'config_section', 'Content settings' );

        $this->control_background('white');

        $this->set_repeater();

        $this->control_itemstatus();

        $this->control_text('username', 'User Name', '', 'First name + Last name');

        $this->control_text('position', 'User Position', '', 'User current Designation');

        $this->control_cta_button();

        $this->control_media('userimage', 'User Image', [], 'User Image');

        $this->add_repeat_fields('team', 'Team Users');       
        // End controls.
        $this->end_controls_section();

        $this->animation_controls();
    }

    public function custom_scripts() {
        // Register Widget Scripts
		// add_action( 'elementor/frontend/after_register_scripts', [ $this, 'animation_widget_scripts' ] );
    }

    public function render() {

        $teams = $this->get_result('team', true);
        $teams = $this->remove_disabled($teams);
        $teams_split = array_chunk($teams, 3);
        $backgroundtype = $this->get_background();
        $animationin = $this->get_result('animation_in');

        ?>
        <!-- Team Gallery -->
		<div class="team-gallery-element <?php echo $backgroundtype;?>">
			<div class="container">
			    <!-- Team Gallery Element -->
				<div class="gallery-element">
                    <?php foreach($teams_split as $key => $teams) :                         
                    ?>
					<div class="row justify-content-center team-animation-row" >
                        <?php foreach ( $teams as $key => $team) :                             

                            $username = $this->get_option($team, 'username');
                            $position = $this->get_option($team, 'position');
                            $image = $this->get_option($team, 'userimage');
                            
                            $buttontext = $this->get_option($team, 'buttontext');                            
                            $buttonurl = $this->get_option($team, 'buttonurl');
                            $target = $buttonurl['is_external'] ? ' target="_blank"' : '';
		                    $nofollow = $buttonurl['nofollow'] ? ' rel="nofollow"' : '';

                            $imageurl = $this->get_option($image, 'url');
                            $imagealt = $this->get_option($image, 'alt');
                           
                        ?>
						<!-- Team Gallery Block -->
						<div class="col-md-4">
							<div class="gallery-block " >
                                <div class="<?php echo ($animationin) ? "troi-animation animate__animated":'';?>" data-animation="<?php echo $animationin; ?>" >
                                    <?php if ($imageurl) { ?>
                                    <div class="img-block">                                      
                                        <?php echo $this->render_image($team, 'userimage'); ?>
                                    </div>
                                    <?php } ?>
                                    <div class="content-block">
                                        <?php if ( $username ) { ?>
                                        <h3><?php echo $username; ?></h3>
                                        <?php }
                                        if ($position) {
                                        ?>
                                        <div class="user-detail">
                                            <p><?php echo $position; ?></p>
                                        </div>
                                        <?php }
                                        if ( $buttonurl['url'] || $buttontext ) {
                                        ?>
                                        <div data-class="btn-block" class="btn-block <?php echo ($animationin) ? "troi-animation  troi-delay animate__animated":'';?>" data-animation="<?php echo $animationin; ?>" >
                                        <?php echo '<a href="'. $buttonurl['url'].'"'.$target.$nofollow.'>'; ?>
                                                <span> <?php echo $buttontext; ?> </span>
                                                <i class="glyph-icon flaticon-055-right-2 custom-circle-button"></i>
                                            </a>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
							</div>
						</div>
                        <?php endforeach; ?>						
					</div>
                    <?php endforeach; ?>
				</div>
			</div>
		</div>
		<!-- End of Team Gallery -->

        <?php
    }
}
