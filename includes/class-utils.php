<?php
/**
 * Utility functions for Elementor Styleguide
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Elementor_Styleguide_Utils {
    /**
     * Get CSS variable name from color key
     */
    public static function get_var_name($base, $variant) {
        $suffix = $variant;
        if ($variant === 'color') $suffix = '';
        
        return sprintf('--%s%s%s', 
            $base,
            $suffix ? '-' : '', 
            $suffix
        );
    }

    /**
     * Get class name from color type, base and variant
     */
    public static function get_class_name($type, $base, $variant) {
        $suffix = $variant;
        if ($variant === 'color') $suffix = '';
        
        return sprintf('%s-%s%s%s', 
            $type, 
            $base,
            $suffix ? '-' : '', 
            $suffix
        );
    }
}