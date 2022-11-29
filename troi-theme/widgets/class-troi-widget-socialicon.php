<?php

// Creating the widget
class troi_socialicon_widget extends WP_Widget {

	// The construct part
	function __construct() {

		parent::__construct(

		// Base ID of your widget.
		'troi_socialicon_widget',

		// Widget name will appear in UI
		__('TROI - Social Icon widget', 'troi'),

		// Widget description
		array( 'description' => __( 'Social Icon Widget', 'troi' ), )
		);
	}

	// Creating widget front-end
	public function widget( $args, $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$facebook = ! empty( $instance['facebook'] ) ? $instance['facebook'] : '';
		$linkedin = ! empty( $instance['linkedin'] ) ? $instance['linkedin'] : '';
        $xing = ! empty( $instance['xing'] ) ? $instance['xing'] : '';
		$twitter = ! empty( $instance['twitter'] ) ? $instance['twitter'] : '';
		$google_plus = ! empty( $instance['google_plus'] ) ? $instance['google_plus'] : '';
		$instagram = ! empty( $instance['instagram'] ) ? $instance['instagram'] : '';
		$pinterest = ! empty( $instance['pinterest'] ) ? $instance['pinterest'] : '';
		$flickr = ! empty( $instance['flickr'] ) ? $instance['flickr'] : '';
		$tumblr = ! empty( $instance['tumblr'] ) ? $instance['tumblr'] : '';
		$vimeo = ! empty( $instance['vimeo'] ) ? $instance['vimeo'] : '';
		$youtube = ! empty( $instance['youtube'] ) ? $instance['youtube'] : '';
		$rss = ! empty( $instance['rss'] ) ? $instance['rss'] : '';
		$email = ! empty( $instance['email'] ) ? $instance['email'] : '';
		$whatsapp = ! empty( $instance['whatsapp'] ) ? $instance['whatsapp'] : '';
		$troi_social_widget_id = 'troi-social-icons';

	?>
		<div class="social-block">
			<ul>
				<?php if($facebook) { ?>
					<li><a href="<?php echo esc_url($facebook); ?>" class="social-media-link-<?php echo $troi_social_widget_id; ?>">
						<i class='fa fa-facebook' aria-hidden='true'></i>
					</a></li>
				<?php } ?>
				<?php if($twitter) { ?>
					<li><a href="<?php echo esc_url($twitter); ?>" class="social-media-link-<?php echo $troi_social_widget_id; ?>">
						<i class='fa fa-twitter' aria-hidden='true'></i>
					</a></li>
				<?php } ?>
				<?php if($google_plus) { ?>
					<li><a href="<?php echo esc_url($google_plus); ?>" class="social-media-link-<?php echo $troi_social_widget_id; ?>">
						<i class='fa fa-google-plus' aria-hidden='true'></i>
					</a></li>
				<?php } ?>
				<?php if($linkedin) { ?>
					<li><a href="<?php echo esc_url($linkedin); ?>" class="social-media-link-<?php echo $troi_social_widget_id; ?>">
						<i class='fa fa-linkedin' aria-hidden='true'></i>
					</a></li>
				<?php } ?>
                <?php if($xing) { ?>
					<li><a href="<?php echo esc_url($xing); ?>" class="social-media-link-<?php echo $troi_social_widget_id; ?>">
						<i class='fa fa-xing' aria-hidden='true'></i>
					</a></li>
				<?php } ?>
				<?php if($instagram) { ?>
					<li><a href="<?php echo esc_url($instagram); ?>" class="social-media-link-<?php echo $troi_social_widget_id; ?>">
						<i class='fa fa-instagram' aria-hidden='true'></i>
					</a></li>
				<?php } ?>
				<?php if($pinterest) { ?>
					<li><a href="<?php echo esc_url($pinterest); ?>" class="social-media-link-<?php echo $troi_social_widget_id; ?>">
						<i class='fa fa-pinterest' aria-hidden='true'></i>
					</a></li>
				<?php } ?>
				<?php if($flickr) { ?>
					<li><a href="<?php echo esc_url($flickr); ?>" class="social-media-link-<?php echo $troi_social_widget_id; ?>">
						<i class='fa fa-flickr' aria-hidden='true'></i>
					</a></li>
				<?php } ?>
				<?php if($tumblr) { ?>
					<li><a href="<?php echo esc_url($tumblr); ?>" class="social-media-link-<?php echo $troi_social_widget_id; ?>">
						<i class='fa fa-tumblr' aria-hidden='true'></i>
					</a></li>
				<?php } ?>
				<?php if($vimeo) { ?>
					<li><a href="<?php echo esc_url($vimeo); ?>" class="social-media-link-<?php echo $troi_social_widget_id; ?>">
						<i class='fa fa-vimeo' aria-hidden='true'></i>
					</a></li>
				<?php } ?>
				<?php if($youtube) { ?>
					<li><a href="<?php echo esc_url($youtube); ?>" class="social-media-link-<?php echo $troi_social_widget_id; ?>">
						<i class='fa fa-youtube' aria-hidden='true'></i>
					</a></li>
				<?php } ?>
				<?php if($rss) { ?>
					<li><a href="<?php echo esc_url($rss); ?>" class="social-media-link-<?php echo $troi_social_widget_id; ?>">
						<i class='fa fa-rss' aria-hidden='true'></i>
					</a></li>
				<?php } ?>
				<?php if($email) { ?>
					<li><a href="<?php echo esc_url($email); ?>" class="social-media-link-<?php echo $troi_social_widget_id; ?>">
						<i class='fa fa-email' aria-hidden='true'></i>
					</a></li>
				<?php } ?>
				<?php if($whatsapp) { ?>
					<li><a href="<?php echo esc_url($whatsapp); ?>" class="social-media-link-<?php echo $troi_social_widget_id; ?>">
						<i class='fa fa-whatsapp' aria-hidden='true'></i>
					</a></li>
				<?php } ?>

			</ul>
		</div>
	<?php
		// echo $args['after_widget'];
	}

	// Creating widget Backend
	public function form( $instance ) {

		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$facebook = ! empty( $instance['facebook'] ) ? $instance['facebook'] : '';
		$twitter = ! empty( $instance['twitter'] ) ? $instance['twitter'] : '';
		$google_plus = ! empty( $instance['google_plus'] ) ? $instance['google_plus'] : '';
		$linkedin = ! empty( $instance['linkedin'] ) ? $instance['linkedin'] : '';
		$xing = ! empty( $instance['xing'] ) ? $instance['xing'] : '';
		$instagram = ! empty( $instance['instagram'] ) ? $instance['instagram'] : '';
		$pinterest = ! empty( $instance['pinterest'] ) ? $instance['pinterest'] : '';
		$flickr = ! empty( $instance['flickr'] ) ? $instance['flickr'] : '';
		$tumblr = ! empty( $instance['tumblr'] ) ? $instance['tumblr'] : '';
		$vimeo = ! empty( $instance['vimeo'] ) ? $instance['vimeo'] : '';
		$youtube = ! empty( $instance['youtube'] ) ? $instance['youtube'] : '';
		$rss = ! empty( $instance['rss'] ) ? $instance['rss'] : '';
		$email = ! empty( $instance['email'] ) ? $instance['email'] : '';
		$whatsapp = ! empty( $instance['whatsapp'] ) ? $instance['whatsapp'] : '';
		// Widget admin form
		?>
		<?php $pos = 1;?>
		<div id="social-media-urls-<?php echo $nsmw_widget_id; ?>" tyle="display: none;">
			<hr>
			<p>
				<label><?php _e( 'Facebook :', 'troi' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'facebook' ) ); ?>" type="text" value="<?php echo esc_attr( $facebook ); ?>">
				<input id="pos[]" name="pos[]" type="hidden" value="<?php echo $pos++; ?>">
			</p>
			<p>
				<label><?php _e( 'Twitter :', 'troi' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitter' ) ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>">
				<input id="pos[]" name="pos[]" type="hidden" value="<?php echo $pos++; ?>">
			</p>
			<p>
				<label><?php _e( 'Google-Plus :', 'troi' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'google_plus' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'google_plus' ) ); ?>" type="text" value="<?php echo esc_attr( $google_plus ); ?>">
				<input id="pos[]" name="pos[]" type="hidden" value="<?php echo $pos++; ?>">
			</p>
			<p>
				<label><?php _e( 'Linkedin :', 'troi' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'linkedin' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'linkedin' ) ); ?>" type="text" value="<?php echo esc_attr( $linkedin ); ?>">
				<input id="pos[]" name="pos[]" type="hidden" value="<?php echo $pos++; ?>">
			</p>
            <p>
				<label><?php _e( 'Xing :', 'troi' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'xing' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'xing' ) ); ?>" type="text" value="<?php echo esc_attr( $xing ); ?>">
				<input id="pos[]" name="pos[]" type="hidden" value="<?php echo $pos++; ?>">
			</p>
			<p>
				<label><?php _e( 'Instagram :', 'troi' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'instagram' ) ); ?>" type="text" value="<?php echo esc_attr( $instagram ); ?>">
				<input id="pos[]" name="pos[]" type="hidden" value="<?php echo $pos++; ?>">
			</p>
			<p>
				<label><?php _e( 'Pinterest :', 'troi' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'pinterest' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'pinterest' ) ); ?>" type="text" value="<?php echo esc_attr( $pinterest ); ?>">
				<input id="pos[]" name="pos[]" type="hidden" value="<?php echo $pos++; ?>">
			</p>
			<p>
				<label><?php _e( 'Flickr :', 'troi' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'flickr' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'flickr' ) ); ?>" type="text" value="<?php echo esc_attr( $flickr ); ?>">
				<input id="pos[]" name="pos[]" type="hidden" value="<?php echo $pos++; ?>">
			</p>
			<p>
				<label><?php _e( 'Tumblr :', 'troi' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tumblr' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tumblr' ) ); ?>" type="text" value="<?php echo esc_attr( $tumblr ); ?>">
				<input id="pos[]" name="pos[]" type="hidden" value="<?php echo $pos++; ?>">
			</p>
			<p>
				<label><?php _e( 'Vimeo :', 'troi' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'vimeo' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'vimeo' ) ); ?>" type="text" value="<?php echo esc_attr( $vimeo ); ?>">
				<input id="pos[]" name="pos[]" type="hidden" value="<?php echo $pos++; ?>">
			</p>
			<p>
				<label><?php _e( 'Youtube :', 'troi' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'youtube' ) ); ?>" type="text" value="<?php echo esc_attr( $youtube ); ?>">
				<input id="pos[]" name="pos[]" type="hidden" value="<?php echo $pos++; ?>">
			</p>
			<p>
				<label><?php _e( 'Rss Feed:', 'troi' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'rss' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'rss' ) ); ?>" type="text" value="<?php echo esc_attr( $rss ); ?>">
				<input id="pos[]" name="pos[]" type="hidden" value="<?php echo $pos++; ?>">
			</p>
			<p>
				<label><?php _e( 'Whatsapp:', 'troi' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'whatsapp' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'whatsapp' ) ); ?>" type="text" value="<?php echo esc_attr( $whatsapp ); ?>">
				<input id="pos[]" name="pos[]" type="hidden" value="<?php echo $pos++; ?>">
			</p>
			<p>
				<label><?php _e( 'Email :', 'troi' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" type="text" value="<?php echo esc_attr( $email ); ?>">
				<input id="pos[]" name="pos[]" type="hidden" value="<?php echo $pos++; ?>">
			</p>
		</div>
		<?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : 'Follow Us';
		$instance['facebook'] = ( ! empty( $new_instance['facebook'] ) ) ? strip_tags( $new_instance['facebook'] ) : '';
		$instance['twitter'] = ( ! empty( $new_instance['twitter'] ) ) ? strip_tags( $new_instance['twitter'] ) : '';
		$instance['google_plus'] = ( ! empty( $new_instance['google_plus'] ) ) ? strip_tags( $new_instance['google_plus'] ) : '';
		$instance['linkedin'] = ( ! empty( $new_instance['linkedin'] ) ) ? strip_tags( $new_instance['linkedin'] ) : '';
		$instance['xing'] = ( ! empty( $new_instance['xing'] ) ) ? strip_tags( $new_instance['xing'] ) : '';
        $instance['instagram'] = ( ! empty( $new_instance['instagram'] ) ) ? strip_tags( $new_instance['instagram'] ) : '';
		$instance['pinterest'] = ( ! empty( $new_instance['pinterest'] ) ) ? strip_tags( $new_instance['pinterest'] ) : '';
		$instance['flickr'] = ( ! empty( $new_instance['flickr'] ) ) ? strip_tags( $new_instance['flickr'] ) : '';
		$instance['tumblr'] = ( ! empty( $new_instance['tumblr'] ) ) ? strip_tags( $new_instance['tumblr'] ) : '';
		$instance['vimeo'] = ( ! empty( $new_instance['vimeo'] ) ) ? strip_tags( $new_instance['vimeo'] ) : '';
		$instance['youtube'] = ( ! empty( $new_instance['youtube'] ) ) ? strip_tags( $new_instance['youtube'] ) : '';
		$instance['rss'] = ( ! empty( $new_instance['rss'] ) ) ? strip_tags( $new_instance['rss'] ) : '';
		$instance['email'] = ( ! empty( $new_instance['email'] ) ) ? strip_tags( $new_instance['email'] ) : '';
		$instance['whatsapp'] = ( ! empty( $new_instance['whatsapp'] ) ) ? strip_tags( $new_instance['whatsapp'] ) : '';

		return $instance;
	}

// Class wpb_widget ends here
}

