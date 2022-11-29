<?php

// Creating the widget
class troi_button_widget extends WP_Widget {

	// The construct part
	function __construct() {

        parent::__construct(
            // Base ID of your widget.
            'troi_button_widget',

            // Widget name will appear in UI
            __(' TROI - Button', 'troi'),

            // Widget description
            array( 'description' => __( 'Add button menu in your widgets', 'troi' ), )
		);
	}

	// Creating widget front-end
	public function widget( $args, $instance ) {

        // $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $sitelink = !empty( $instance['sitelink'] ) ? $instance['sitelink'] : '';
        $text = !empty( $instance['text'] ) ? $instance['text'] : '';
        $newtab = (isset($instance['newtab']) && !empty($instance['newtab']) ) ? 'target="_blank"' : '';
        // $sitelink = ! empty( $instance['sitelink'] ) ? $instance['sitelink'] : '';
        // $address = str_replace("\n", '<br>', $address);
		if (!empty($sitelink) || !empty($text)) {
            echo ' <div class="btn-block">';
            echo '<a '.$newtab.' href="'.$sitelink.'" class="btn" > '.$text.' </a>';
            echo '<div>';
        }
	}

	// Creating widget Backend
	public function form( $instance ) {

        // $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $sitelink = !empty( $instance['sitelink'] ) ? $instance['sitelink'] : '';
        $text = !empty( $instance['text'] ) ? $instance['text'] : '';
        $newtab = (!empty($instance['newtab'])) ? $instance['newtab'] : '';
        

        // $id = "expirationErrorMessage";
        // $name = 'expirationErrorMessage';
        // $content = esc_textarea( stripslashes( "SDFasdf" ) );
        // $settings = array('tinymce' => true, 'textarea_name' => "expirationErrorMessage");
        // wp_editor($content, $id, $settings);
    ?>
        <div class="button-form" >

            <div>
                <label><?php _e( 'Button LINK :', 'troi' ); ?></label>
                <input class="sitelink" id="<?php echo esc_attr( $this->get_field_id( 'sitelink' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sitelink' ) ); ?>" type="text" value="<?php echo esc_attr( $sitelink ); ?>">                
            </div>
            <p>
                <label><?php _e( 'Button Text :', 'troi' ); ?></label>
                <input class="text" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>">
            </p>
            <p>
                <label><?php _e( 'Open link in new tab :', 'troi' ); ?></label>
                <input class="newtab" id="<?php echo esc_attr( $this->get_field_id( 'newtab' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'newtab' ) ); ?>" type="checkbox" value="1" <?php echo ($newtab) ? 'checked="checked"' : ''; ?>>
            </p>
            
        </div>
    <?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
        $instance = array();
        // print_object($new_instance);exit;
	    $instance['sitelink'] = ( ! empty( $new_instance['sitelink'] ) ) ? strip_tags( $new_instance['sitelink'] ) : '';
        $instance['text'] = ( ! empty( $new_instance['text'] ) ) ? strip_tags( $new_instance['text'] ) : '';
        $instance['newtab'] = ( ! empty( $new_instance['newtab'] ) ) ? strip_tags( $new_instance['newtab'] ) : '';        
        return $instance;
	}

// Class wpb_widget ends here
}

