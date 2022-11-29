<?php

$options = $this->get_settings_for_display();
$boxes = isset($options['options_list']) && !empty($options['options_list']) ?  $options['options_list'] : [];
$bg = $this->get_background();
$animationin = troi_get_configvalue($options, 'animation_in');
// $animationout = troi_get_configvalue($options, 'animation_out');

?>
<!-- Icon Box Module -->
<div class="icon-box-elements troi-icon-box <?php echo $bg; ?>">
	<div class="container">
		<div class="row justify-content-center">

        <?php
        foreach ($boxes as $key => $box) :
            $iconimage = $this->render_image($box, 'box_icon');
            $icon = isset($box['box_icon']) ? $box['box_icon'] : '';
            $iconurl = isset($icon['url']) ? $icon['url'] : '';
            $iconalt = ( isset($icon['alt']) && !empty($icon['alt']) )  ? $icon['alt'] : '';
            $heading = ( isset($box['box_heading']) && !empty($box['box_heading']) )  ? $box['box_heading'] : '';
            $buttontext = ( isset($box['box_button_text']) && !empty($box['box_button_text']) )  ? $box['box_button_text'] : '';
            $buttonurl = ( isset($box['box_button_url']) && !empty($box['box_button_url']) )  ? $box['box_button_url'] : '';
            $description = ( isset($box['box_description']) && !empty($box['box_description']) )  ? $box['box_description'] : '';

        ?>
			<!--icon box element-->
			<div class="col-md-4">
				<div class="icon-mod">
					<!--icon box image-->
                    <?php if (!empty($iconurl)) { ?>
					<div class="img-block">
						<?php echo $iconimage; ?>
					</div>
                    <?php } ?>
					<!--icon box content-->
					<div class="content-block">
						<?php if ( !empty($heading) ) { ?>
                        <h2 class="troi-animation animate__animated" data-animation="<?php echo $animationin; ?>" ><?php echo $heading; ?></h2>
                        <?php } ?>
                        <?php if ( !empty($description) ) {
                            echo '<p class="icon-box-description">'. $description .'</p>';
                        }

                        if ( !empty($buttonurl) || !empty($buttontext) ) {
                        ?>
                        <div class="btn-block">
                            <a href="<?php echo $buttonurl; ?>" class="btn"> <?php echo $buttontext; ?> </a>
                        </div>
                        <?php } ?>
					</div>
				</div>
			</div>
        <?php endforeach; ?>

		</div>
	</div>
</div>
<!-- End of Icon Box Module -->