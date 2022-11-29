<?php

/**
 * Plugin Name: Troi Elementor Elements
 * Plugin URI: ''
 * Description: This plugin creates custom elementor widgets.
 * Author: cbl-media Charles Bradley Logan
 * Version: 0.02
 **/

// namespace TROIWidgets;

// use Elementor\Plugin;

// Denied the file exection, If this file called directly.
if ( ! defined( 'WPINC' ) ) {
    die( 'No direct Access!' );
}
// ?

if ( !class_exists('TROIWidgets_Main') ) {
    
    define('TROIWIDGETS_TEXT', 'troi-widgets');

	define('TROIWIDGETS_PATH', plugin_dir_path(__FILE__) );

    require_once( TROIWIDGETS_PATH . 'core/class-troi-main.php' );

    function troi_get_configvalue($stack, $key) {
        if (is_array($stack)) {
            $value = isset($stack[$key]) ? $stack[$key] : '';
            return $value;
        }
    }
}

// echo function_exists('TROIWidgets\troi_get_configvalue'); 

// exit;