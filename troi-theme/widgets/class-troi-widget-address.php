<?php

// Creating the widget
class addressblock_widget extends WP_Widget {

	// The construct part
	function __construct() {

        parent::__construct(
            // Base ID of your widget.
            'addressblock_widget',

            // Widget name will appear in UI
            __(' TROI - Address block Widget', 'troi'),

            // Widget description
            array( 'description' => __( 'Add your business address to display anywhere you want', 'troi' ), )
		);
	}

	// Creating widget front-end
	public function widget( $args, $instance ) {

        // $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $address = ! empty( $instance['address'] ) ? $instance['address'] : '';
        $phone = ! empty( $instance['phone'] ) ? $instance['phone'] : '';
        $email = ! empty( $instance['email'] ) ? $instance['email'] : '';
        $sitelink = ! empty( $instance['sitelink'] ) ? $instance['sitelink'] : '';
        $address = str_replace("\n", '<br>', $address);

		if ($address != '' ) {
            echo '<p class="address"> '.$address.' </p>'; // <!-- Address -->
        }
        if ($phone != '' ) {
            echo '<p class="phone">  '.$phone.'  </p>'; // Phone number.
        }
        if ($email != '' ) {
            echo '<p class="email"> '.$email.' </p>'; // Site Email.
        }
        if ($sitelink != '' ) {
            echo '<p class="site-link"> '.$sitelink.' </p>'; // Site Link.
        }
	
		// echo $args['after_widget'];
	}

	// Creating widget Backend
	public function form( $instance ) {

        // $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $address = ! empty( $instance['address'] ) ? $instance['address'] : '';
        $phone = ! empty( $instance['phone'] ) ? $instance['phone'] : '';
        $email = ! empty( $instance['email'] ) ? $instance['email'] : '';
        $sitelink = ! empty( $instance['sitelink'] ) ? $instance['sitelink'] : '';
       
        // $id = "expirationErrorMessage";
        // $name = 'expirationErrorMessage';
        // $content = esc_textarea( stripslashes( "SDFasdf" ) );
        // $settings = array('tinymce' => true, 'textarea_name' => "expirationErrorMessage");
        // wp_editor($content, $id, $settings);
    ?>
        <div class="address-form" >

            <div>
                <label><?php _e( 'Address :', 'troi' ); ?></label>
                <textarea class="address ”theEditor”" id="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'address' ) ); ?>" type="text" ><?php echo esc_attr( $address ); ?></textarea>               
            </div>
            <p>
                <label><?php _e( 'Phone :', 'troi' ); ?></label>
                <input class="phone" id="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'phone' ) ); ?>" type="text" value="<?php echo esc_attr( $phone ); ?>">            
            </p>
            <p>
                <label><?php _e( 'Email :', 'troi' ); ?></label>
                <input class="email" id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" type="text" value="<?php echo esc_attr( $email ); ?>">            
            </p>
            <p>
                <label><?php _e( 'Site Link :', 'troi' ); ?></label>
                <input class="sitelink" id="<?php echo esc_attr( $this->get_field_id( 'sitelink' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sitelink' ) ); ?>" type="text" value="<?php echo esc_attr( $sitelink ); ?>">            
            </p>
        </div>
    <?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
        $instance = array();
	    $instance['address'] = ( ! empty( $new_instance['address'] ) ) ? strip_tags( $new_instance['address'] ) : '';
        $instance['phone'] = ( ! empty( $new_instance['phone'] ) ) ? strip_tags( $new_instance['phone'] ) : '';
        $instance['email'] = ( ! empty( $new_instance['email'] ) ) ? strip_tags( $new_instance['email'] ) : '';
        $instance['sitelink'] = ( ! empty( $new_instance['sitelink'] ) ) ? strip_tags( $new_instance['sitelink'] ) : '';
        return $instance;
	}

// Class wpb_widget ends here
}

