<?php
/**
 * Settings management for Elementor Styleguide
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Elementor_Styleguide_Settings {
    /** @var array Default color values */
    const DEFAULT_COLORS = [
        'primary_color' => '#007bff',
        'primary_light' => '#4da3ff',
        'primary_dark' => '#0056b3',
        'secondary_color' => '#6c757d',
        'secondary_light' => '#949ba1',
        'secondary_dark' => '#494f54',
        'accent_color' => '#fd7e14', // Add accent color
        'accent_light' => '#ff9f4d',
        'accent_dark' => '#c86100',
        'success_color' => '#28a745', // Add success color
        'danger_color' => '#dc3545',  // Add danger/error color
        'warning_color' => '#ffc107', // Add warning color
        'info_color' => '#17a2b8',    // Add info color
        'gray_100' => '#f8f9fa',
        'gray_300' => '#dee2e6',
        'gray_500' => '#adb5bd',
        'gray_700' => '#495057',
        'gray_900' => '#212529',
    ];
    
    /** @var array Default typography values */
    const DEFAULT_TYPOGRAPHY = [
        'base_font_size' => '16px',
        'heading_font' => 'inherit',
        'body_font' => 'inherit',
        'scale_ratio' => '1.2'
    ];
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('admin_init', array($this, 'register_settings'));
    }
    
    /**
     * Get color settings
     * 
     * @return array Color settings
     */
    public function get_colors() {
        return get_option('elementor_styleguide_colors', self::DEFAULT_COLORS);
    }
    
    /**
     * Get typography settings
     * 
     * @return array Typography settings
     */
    public function get_typography() {
        return get_option('elementor_styleguide_typography', self::DEFAULT_TYPOGRAPHY);
    }
    
    /**
     * Register plugin settings
     */
    public function register_settings() {
        register_setting(
            'elementor_styleguide_options', 
            'elementor_styleguide_colors',
            array(
                'sanitize_callback' => array($this, 'sanitize_colors'),
                'default' => self::DEFAULT_COLORS
            )
        );
        
        register_setting(
            'elementor_styleguide_options',
            'elementor_styleguide_typography',
            array(
                'sanitize_callback' => array($this, 'sanitize_typography'),
                'default' => self::DEFAULT_TYPOGRAPHY
            )
        );
        
        // Primary Colors
        add_settings_section('primary_colors', 'Primary Colors', array($this, 'section_description_callback'), 'elementor-styleguide');
        add_settings_field('primary_color', 'Primary Color', array($this, 'color_field_callback'), 'elementor-styleguide', 'primary_colors', array('field' => 'primary_color', 'description' => 'Main brand color'));
        add_settings_field('primary_light', 'Primary Light', array($this, 'color_field_callback'), 'elementor-styleguide', 'primary_colors', array('field' => 'primary_light', 'description' => 'Lighter version for hover states'));
        add_settings_field('primary_dark', 'Primary Dark', array($this, 'color_field_callback'), 'elementor-styleguide', 'primary_colors', array('field' => 'primary_dark', 'description' => 'Darker version for active states'));

        // Secondary Colors
        add_settings_section('secondary_colors', 'Secondary Colors', array($this, 'section_description_callback'), 'elementor-styleguide');
        add_settings_field('secondary_color', 'Secondary Color', array($this, 'color_field_callback'), 'elementor-styleguide', 'secondary_colors', array('field' => 'secondary_color', 'description' => 'Secondary brand color'));
        add_settings_field('secondary_light', 'Secondary Light', array($this, 'color_field_callback'), 'elementor-styleguide', 'secondary_colors', array('field' => 'secondary_light', 'description' => 'Lighter version of secondary'));
        add_settings_field('secondary_dark', 'Secondary Dark', array($this, 'color_field_callback'), 'elementor-styleguide', 'secondary_colors', array('field' => 'secondary_dark', 'description' => 'Darker version of secondary'));
        
        // Accent Colors
        add_settings_section('accent_colors', 'Accent Colors', array($this, 'section_description_callback'), 'elementor-styleguide');
        add_settings_field('accent_color', 'Accent Color', array($this, 'color_field_callback'), 'elementor-styleguide', 'accent_colors', array('field' => 'accent_color', 'description' => 'Highlight or call-to-action color'));
        add_settings_field('accent_light', 'Accent Light', array($this, 'color_field_callback'), 'elementor-styleguide', 'accent_colors', array('field' => 'accent_light', 'description' => 'Lighter version of accent'));
        add_settings_field('accent_dark', 'Accent Dark', array($this, 'color_field_callback'), 'elementor-styleguide', 'accent_colors', array('field' => 'accent_dark', 'description' => 'Darker version of accent'));
        
        // Status Colors
        add_settings_section('status_colors', 'Status Colors', array($this, 'section_description_callback'), 'elementor-styleguide');
        add_settings_field('success_color', 'Success Color', array($this, 'color_field_callback'), 'elementor-styleguide', 'status_colors', array('field' => 'success_color', 'description' => 'For success messages and positive statuses'));
        add_settings_field('danger_color', 'Danger Color', array($this, 'color_field_callback'), 'elementor-styleguide', 'status_colors', array('field' => 'danger_color', 'description' => 'For error messages and negative statuses'));
        add_settings_field('warning_color', 'Warning Color', array($this, 'color_field_callback'), 'elementor-styleguide', 'status_colors', array('field' => 'warning_color', 'description' => 'For warning messages and cautions'));
        add_settings_field('info_color', 'Info Color', array($this, 'color_field_callback'), 'elementor-styleguide', 'status_colors', array('field' => 'info_color', 'description' => 'For informational messages'));

        // Grayscale Colors
        add_settings_section('grayscale_colors', 'Grayscale', array($this, 'section_description_callback'), 'elementor-styleguide');
        add_settings_field('gray_100', 'Gray 100 (Lightest)', array($this, 'color_field_callback'), 'elementor-styleguide', 'grayscale_colors', array('field' => 'gray_100', 'description' => 'Lightest gray, almost white'));
        add_settings_field('gray_300', 'Gray 300', array($this, 'color_field_callback'), 'elementor-styleguide', 'grayscale_colors', array('field' => 'gray_300', 'description' => 'Light gray, for subtle backgrounds'));
        add_settings_field('gray_500', 'Gray 500', array($this, 'color_field_callback'), 'elementor-styleguide', 'grayscale_colors', array('field' => 'gray_500', 'description' => 'Medium gray, for disabled elements'));
        add_settings_field('gray_700', 'Gray 700', array($this, 'color_field_callback'), 'elementor-styleguide', 'grayscale_colors', array('field' => 'gray_700', 'description' => 'Dark gray, for body text'));
        add_settings_field('gray_900', 'Gray 900 (Darkest)', array($this, 'color_field_callback'), 'elementor-styleguide', 'grayscale_colors', array('field' => 'gray_900', 'description' => 'Darkest gray, for headings'));
        
        // Typography Settings
        add_settings_section('typography_settings', 'Typography Settings', array($this, 'section_description_callback'), 'elementor-styleguide');
        add_settings_field('base_font_size', 'Base Font Size', array($this, 'text_field_callback'), 'elementor-styleguide', 'typography_settings', array('field' => 'base_font_size', 'group' => 'typography', 'description' => 'Default font size (e.g., 16px)'));
        add_settings_field('heading_font', 'Heading Font', array($this, 'font_select_callback'), 'elementor-styleguide', 'typography_settings', array('field' => 'heading_font', 'group' => 'typography', 'description' => 'Font family for headings'));
        add_settings_field('body_font', 'Body Font', array($this, 'font_select_callback'), 'elementor-styleguide', 'typography_settings', array('field' => 'body_font', 'group' => 'typography', 'description' => 'Font family for body text'));
        add_settings_field('scale_ratio', 'Type Scale Ratio', array($this, 'select_field_callback'), 'elementor-styleguide', 'typography_settings', array('field' => 'scale_ratio', 'group' => 'typography', 'description' => 'Ratio for type scaling', 'options' => array(
            '1.125' => 'Minor Third (1.125)',
            '1.2' => 'Major Third (1.2)',
            '1.25' => 'Perfect Fourth (1.25)',
            '1.333' => 'Perfect Fifth (1.333)',
            '1.5' => 'Golden Ratio (1.5)'
        )));
    }

    /**
     * Sanitize color values
     */
    public function sanitize_colors($input) {
        $output = array();
        foreach (self::DEFAULT_COLORS as $key => $default) {
            if (isset($input[$key])) {
                $color = sanitize_hex_color($input[$key]);
                $output[$key] = $color ? $color : $default;
            } else {
                $output[$key] = $default;
            }
        }
        return $output;
    }
    
    /**
     * Sanitize typography values
     */
    public function sanitize_typography($input) {
        $defaults = self::DEFAULT_TYPOGRAPHY;
        
        $output = array();
        
        // Base font size
        if (isset($input['base_font_size'])) {
            // Make sure it's a valid size with px unit
            if (preg_match('/^\d+px$/', $input['base_font_size'])) {
                $output['base_font_size'] = sanitize_text_field($input['base_font_size']);
            } else {
                $output['base_font_size'] = $defaults['base_font_size'];
            }
        } else {
            $output['base_font_size'] = $defaults['base_font_size'];
        }
        
        // Heading font
        if (isset($input['heading_font'])) {
            $output['heading_font'] = sanitize_text_field($input['heading_font']);
        } else {
            $output['heading_font'] = $defaults['heading_font'];
        }
        
        // Body font
        if (isset($input['body_font'])) {
            $output['body_font'] = sanitize_text_field($input['body_font']);
        } else {
            $output['body_font'] = $defaults['body_font'];
        }
        
        // Scale ratio
        if (isset($input['scale_ratio']) && in_array($input['scale_ratio'], array('1.125', '1.2', '1.25', '1.333', '1.5'))) {
            $output['scale_ratio'] = $input['scale_ratio'];
        } else {
            $output['scale_ratio'] = $defaults['scale_ratio'];
        }
        
        return $output;
    }
    
    /**
     * Section description callback
     */
    public function section_description_callback($args) {
        $sections = [
            'primary_colors' => __('These colors define your main brand identity and are used for primary elements and actions.', 'elementor-styleguide'),
            'secondary_colors' => __('Secondary colors complement your primary colors and are used for secondary elements.', 'elementor-styleguide'),
            'accent_colors' => __('Accent colors provide emphasis to specific elements and call-to-actions.', 'elementor-styleguide'),
            'status_colors' => __('Status colors convey success, warning, danger, or information messages.', 'elementor-styleguide'),
            'grayscale_colors' => __('Grayscale colors provide hierarchy and contrast in your design.', 'elementor-styleguide'),
            'typography_settings' => __('Configure the typography system for consistent text styling.', 'elementor-styleguide')
        ];
        
        if (isset($sections[$args['id']])) {
            echo '<p class="section-description">' . esc_html($sections[$args['id']]) . '</p>';
        }
    }

    /**
     * Color field callback
     */
    public function color_field_callback($args) {
        $options = $this->get_colors();
        $field = $args['field'];
        $value = isset($options[$field]) ? $options[$field] : self::DEFAULT_COLORS[$field];
        $description = isset($args['description']) ? $args['description'] : '';
        
        echo '<div class="color-field">';
        echo '<input type="color" 
                   id="' . esc_attr($field) . '" 
                   name="elementor_styleguide_colors[' . esc_attr($field) . ']" 
                   value="' . esc_attr($value) . '" 
                   class="color-picker" />';
        echo '<input type="text" 
                   value="' . esc_attr($value) . '" 
                   class="color-picker-hex" 
                   pattern="^#[0-9A-F]{6}$" 
                   title="' . esc_attr__('Please enter a valid hex color code', 'elementor-styleguide') . '"/>';
        
        // Add color preview
        echo '<span class="color-preview" style="background-color:' . esc_attr($value) . ';"></span>';
        
        // Add reset button
        echo '<button type="button" class="button button-small reset-color" data-default="' . esc_attr(self::DEFAULT_COLORS[$field]) . '" style="margin-left:5px;">' . 
             esc_html__('Reset', 'elementor-styleguide') . 
             '</button>';
        
        if ($description) {
            echo '<p class="description">' . esc_html($description) . '</p>';
        }
        
        echo '</div>';
    }
    
    /**
     * Text field callback
     */
    public function text_field_callback($args) {
        $options = $this->get_typography();
        
        $field = $args['field'];
        $group = $args['group'];
        $value = isset($options[$field]) ? $options[$field] : '';
        $description = isset($args['description']) ? $args['description'] : '';
        
        echo '<div class="field-container">';
        echo '<input type="text" 
                   id="' . esc_attr($field) . '" 
                   name="elementor_styleguide_' . esc_attr($group) . '[' . esc_attr($field) . ']" 
                   value="' . esc_attr($value) . '" 
                   class="regular-text" />';
        
        if ($description) {
            echo '<p class="description">' . esc_html($description) . '</p>';
        }
        
        echo '</div>';
    }
    
    /**
     * Select field callback
     */
    public function select_field_callback($args) {
        $options = get_option('elementor_styleguide_' . $args['group'], array());
        $field = $args['field'];
        $value = isset($options[$field]) ? $options[$field] : '';
        $description = isset($args['description']) ? $args['description'] : '';
        $select_options = isset($args['options']) ? $args['options'] : array();
        
        echo '<div class="field-container">';
        echo '<select id="' . esc_attr($field) . '" 
                      name="elementor_styleguide_' . esc_attr($args['group']) . '[' . esc_attr($field) . ']" 
                      class="regular-text">';
        
        foreach ($select_options as $option_value => $option_label) {
            echo '<option value="' . esc_attr($option_value) . '" ' . selected($value, $option_value, false) . '>' . 
                 esc_html($option_label) . 
                 '</option>';
        }
        
        echo '</select>';
        
        if ($description) {
            echo '<p class="description">' . esc_html($description) . '</p>';
        }
        
        echo '</div>';
    }
    
    /**
     * Font select callback
     */
    public function font_select_callback($args) {
        $options = get_option('elementor_styleguide_' . $args['group'], array());
        $field = $args['field'];
        $value = isset($options[$field]) ? $options[$field] : '';
        $description = isset($args['description']) ? $args['description'] : '';
        
        // Get available system fonts and Google Fonts
        $system_fonts = array(
            'inherit' => 'Theme Default',
            'Arial, sans-serif' => 'Arial',
            'Helvetica, Arial, sans-serif' => 'Helvetica',
            'Georgia, serif' => 'Georgia',
            'Tahoma, Geneva, sans-serif' => 'Tahoma',
            'Verdana, Geneva, sans-serif' => 'Verdana',
            'Times New Roman, Times, serif' => 'Times New Roman',
            'Trebuchet MS, Helvetica, sans-serif' => 'Trebuchet MS',
            'Courier New, Courier, monospace' => 'Courier New',
            'Impact, Charcoal, sans-serif' => 'Impact',
            'Lucida Sans Unicode, Lucida Grande, sans-serif' => 'Lucida Sans',
            'Comic Sans MS, cursive, sans-serif' => 'Comic Sans MS',
            'Arial Black, Gadget, sans-serif' => 'Arial Black',
            'Palatino Linotype, Book Antiqua, Palatino, serif' => 'Palatino Linotype',
            'system-ui, -apple-system, BlinkMacSystemFont, sans-serif' => 'System UI'
        );
        
        // Top Google Fonts
        $google_fonts = array(
            'Roboto, sans-serif' => 'Roboto',
            'Open Sans, sans-serif' => 'Open Sans',
            'Lato, sans-serif' => 'Lato',
            'Montserrat, sans-serif' => 'Montserrat',
            'Raleway, sans-serif' => 'Raleway',
            'Poppins, sans-serif' => 'Poppins',
            'Nunito, sans-serif' => 'Nunito',
            'Playfair Display, serif' => 'Playfair Display',
            'Merriweather, serif' => 'Merriweather',
            'Source Sans Pro, sans-serif' => 'Source Sans Pro'
        );
        
        echo '<div class="field-container">';
        echo '<select id="' . esc_attr($field) . '" 
                      name="elementor_styleguide_' . esc_attr($args['group']) . '[' . esc_attr($field) . ']" 
                      class="regular-text font-select">';
        
        echo '<optgroup label="' . esc_attr__('System Fonts', 'elementor-styleguide') . '">';
        foreach ($system_fonts as $font_family => $font_name) {
            echo '<option value="' . esc_attr($font_family) . '" ' . selected($value, $font_family, false) . '>' . 
                 esc_html($font_name) . 
                 '</option>';
        }
        echo '</optgroup>';
        
        echo '<optgroup label="' . esc_attr__('Google Fonts', 'elementor-styleguide') . '">';
        foreach ($google_fonts as $font_family => $font_name) {
            echo '<option value="' . esc_attr($font_family) . '" ' . selected($value, $font_family, false) . '>' . 
                 esc_html($font_name) . 
                 '</option>';
        }
        echo '</optgroup>';
        
        echo '</select>';
        
        if ($description) {
            echo '<p class="description">' . esc_html($description) . '</p>';
        }
        
        echo '</div>';
    }
    
    /**
     * Sync with Elementor's global colors
     */
    public function sync_with_elementor_globals() {
        $options = $this->get_colors();
        
        // Get Elementor's global colors
        $elementor_scheme_colors = get_option('elementor_scheme_color');
        
        if ($elementor_scheme_colors) {
            // Define the mapping between Elementor color slots and our colors
            $color_mapping = array(
                '1' => 'primary_color',
                '2' => 'secondary_color',
                '3' => 'accent_color',
                '4' => 'gray_700'
            );
            
            // Update our colors based on Elementor's globals
            foreach ($color_mapping as $elementor_key => $our_key) {
                if (isset($elementor_scheme_colors[$elementor_key]) && !empty($elementor_scheme_colors[$elementor_key])) {
                    $options[$our_key] = $elementor_scheme_colors[$elementor_key];
                }
            }
            
            // Save the updated colors
            update_option('elementor_styleguide_colors', $options);
        }
    }
}