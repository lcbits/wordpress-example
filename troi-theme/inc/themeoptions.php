<?php


class ASTRA_Options {

    public static $instance;

    /**
	 * Returns an instance of the plugin object
	 *
	 * @return PHMAIL Main instance
	 *
	 */
	public static function instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof ASTRA_Options ) ) {
			self::$instance = new ASTRA_Options;

		}

		return self::$instance;
	}

	/**
	 * Construct method contains site connection details.
	 *
	 * @param boolean $helpers [description]
	 */
	public function init() {

        add_action('customize_register', [$this, 'customize_register']); 

        // Output custom CSS to live site
        add_action( 'wp_head' , array( $this , 'update_style_colors' ) );
	}

    public function customize_register($wp_customize ) {
        // global $wp_customize;

        
        $wp_customize->add_section( 'troi_theme_settings' , array(
            'title'      => __( 'TROI color options', 'troi' ),
            'priority'   => 30,
            ) );
        
        $colorconfigs = $this->get_color_configs();
        
        foreach ($colorconfigs as $key => $setting) {
            
            $wp_customize->add_setting( $setting['name'], ['default' => $setting['default'] ] );

            $wp_customize->add_control( 

                new WP_Customize_Color_Control( $wp_customize, $setting['name'],
                    array(
                        'label' => $setting['label'],
                        'section' => 'troi_theme_settings',
                        'settings' => $setting['name'],  
                        'default' => $setting['default']                      
                    ) 
                ) 
            );
        }         
    }

    /**
     * Update style colors.
     */
    public function update_style_colors() {

        $style = '';
        $colorconfigs = $this->get_color_configs();
        foreach ($colorconfigs as $key => $setting ) {
            $value = get_theme_mod($setting['name']);
            if (!empty($value)) {
                $style .= $setting['cssprop'].': '. $value.';'; 
            }
        }
        // $styles = 
        ?>
        <!--Customizer CSS--> 
        <style type="text/css">
            :root {
                <?php echo $style; ?>
            }
        </style> 
        <!--/Customizer CSS-->
        <?php
    }

    public function live_preview() {
        wp_enqueue_script( 
            'troi_theme_settings',
            get_template_directory_uri().'/assets/js/scripts.js', 
            array( 'jquery', 'customize-preview' ),
            '',
            true
      );
    }

    /**
     * Get color configs.
     */
    public function get_color_configs() {

        $list = [

            'color_primary' => [
                'name' => 'primary_color',
                'label' => __('Primary Color', 'troi'),
                'cssprop' => '--color_primary',
                'default' => '#3c9cfd'
            ],
            'color_web_background' => [
                'name' => 'web_background',
                'label' => __('Background Color', 'troi'),
                'cssprop' => '--color_web_bg',
                'default' => '#070707'
            ],
            'color_cta_block' => [
                'name' => 'cta_block_background',
                'label' => __('CTA Block background', 'troi'),
                'cssprop' => '--color_black_approx',
                'default' => '#131316'
            ],
            'color_footer_background' => [
                'name' => 'footer_background',
                'label' => __('Footer background', 'troi'),
                'cssprop' => '--color_footer_bg',
                'default' => '#1c1d21'
            ],     
            'color_button_active' => [
                'name' => 'button_active',
                'label' => __('Button active color', 'troi'),
                'cssprop' => '--color_button_active',
                'default' => '#0152a1'
            ],     
            'color_button_hover' => [
                'name' => 'button_hover',
                'label' => __('Button hover color', 'troi'),
                'cssprop' => '--color_button_hover',
                'default' => '#027af2'
            ],            
         
        ];
        return $list;
    }



    

}




/**
 * Create Main class object.
 *
 * @return PHMAIL_Main object
 */
function astra_options() {

	return ASTRA_Options::instance();
}

// Initialize the plugin intial function to register actions.
astra_options()->init();

?>