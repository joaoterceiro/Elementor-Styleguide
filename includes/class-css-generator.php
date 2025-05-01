<?php
/**
 * CSS Generator for Elementor Styleguide
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Elementor_Styleguide_CSS_Generator {
    /**
     * @var Elementor_Styleguide_Settings Settings instance
     */
    private $settings;
    
    /**
     * Constructor
     */
    public function __construct($settings) {
        $this->settings = $settings;
    }
    
    /**
     * Generate color CSS variables with improved specificity
     */
    public function generate_color_variables() {
        $options = $this->settings->get_colors();
        
        $css = ['/* Elementor Styleguide CSS Variables */'];
        $css[] = ':root {';
        
        foreach ($options as $key => $value) {
            if ($value) {
                $css[] = sprintf('  --%s: %s !important;', str_replace('_', '-', $key), esc_attr($value));
            }
        }
        $css[] = '}';
        
        // Adicionar variáveis com !important para elementos específicos do Elementor
        $css[] = '.elementor-element, .elementor-widget, .elementor-widget-container, .elementor-column, .elementor-section {';
        foreach ($options as $key => $value) {
            if ($value) {
                $css[] = sprintf('  --%s: %s !important;', str_replace('_', '-', $key), esc_attr($value));
            }
        }
        $css[] = '}';
        
        return implode("\n", $css);
    }
    
    /**
     * Generate color utility classes with enhanced specificity
     */
    public function generate_color_classes() {
        $options = $this->settings->get_colors();
        $css = [];
        
        // Define color types
        $color_types = [
            'primary' => ['color', 'light', 'dark'],
            'secondary' => ['color', 'light', 'dark'],
            'accent' => ['color', 'light', 'dark'],
            'success' => ['color'],
            'danger' => ['color'],
            'warning' => ['color'],
            'info' => ['color'],
            'gray' => ['100', '300', '500', '700', '900']
        ];

        // Text colors with increased specificity
        $css[] = '/* Text Colors */';
        foreach ($color_types as $base => $variants) {
            foreach ($variants as $variant) {
                $var_name = Elementor_Styleguide_Utils::get_var_name($base, $variant);
                $class_name = Elementor_Styleguide_Utils::get_class_name('color', $base, $variant);
                
                // Aumentar especificidade para evitar anulação pelo Elementor
                $css[] = sprintf('.elementor-section .elementor-container .elementor-row .elementor-column .elementor-column-wrap .elementor-widget-wrap .elementor-element.%s *, 
                                 .elementor .elementor-element.%s *, 
                                 .elementor .elementor-element .elementor-widget-container.%s *, 
                                 .elementor-section.%s *, 
                                 .elementor-column.%s *, 
                                 .elementor-widget.%s *,
                                 .elementor .%s, 
                                 .elementor .%s * { 
                                    color: var(%s) !important; 
                                 }',
                    $class_name, $class_name, $class_name, $class_name, $class_name, $class_name, $class_name, $class_name, $var_name
                );
            }
        }
        
        // Background colors with increased specificity
        $css[] = '/* Background Colors */';
        foreach ($color_types as $base => $variants) {
            foreach ($variants as $variant) {
                $var_name = Elementor_Styleguide_Utils::get_var_name($base, $variant);
                $class_name = Elementor_Styleguide_Utils::get_class_name('bg', $base, $variant);
                
                // Aumentar especificidade para evitar anulação pelo Elementor
                $css[] = sprintf('.elementor-section .elementor-container .elementor-row .elementor-column .elementor-column-wrap .elementor-widget-wrap .elementor-element.%s, 
                                 .elementor .elementor-element.%s, 
                                 .elementor .elementor-element .elementor-widget-container.%s, 
                                 .elementor-section.%s, 
                                 .elementor-column.%s, 
                                 .elementor-widget.%s,
                                 .elementor .%s { 
                                    background-color: var(%s) !important; 
                                 }',
                    $class_name, $class_name, $class_name, $class_name, $class_name, $class_name, $class_name, $var_name
                );
            }
        }
        
        // Border colors with increased specificity
        $css[] = '/* Border Colors */';
        foreach ($color_types as $base => $variants) {
            foreach ($variants as $variant) {
                $var_name = Elementor_Styleguide_Utils::get_var_name($base, $variant);
                $class_name = Elementor_Styleguide_Utils::get_class_name('border', $base, $variant);
                
                // Aumentar especificidade para evitar anulação pelo Elementor
                $css[] = sprintf('.elementor-section .elementor-container .elementor-row .elementor-column .elementor-column-wrap .elementor-widget-wrap .elementor-element.%s, 
                                 .elementor .elementor-element.%s, 
                                 .elementor .elementor-element .elementor-widget-container.%s, 
                                 .elementor-section.%s, 
                                 .elementor-column.%s, 
                                 .elementor-widget.%s,
                                 .elementor .%s { 
                                    border-color: var(%s) !important; 
                                 }',
                    $class_name, $class_name, $class_name, $class_name, $class_name, $class_name, $class_name, $var_name
                );
            }
        }
        
        return implode("\n", $css);
    }
    
    /**
     * Generate typography CSS with improved specificity
     */
    public function generate_typography_css() {
        $typography = $this->settings->get_typography();
        
        $base_size = intval($typography['base_font_size']);
        $ratio = floatval($typography['scale_ratio']);
        
        // Build Typography CSS with enhanced specificity
        $css = '/* Typography System */
        :root {
            --font-size-base: ' . esc_attr($typography['base_font_size']) . ';
            --font-scale-ratio: ' . esc_attr($typography['scale_ratio']) . ';
            --font-size-sm: ' . floor($base_size * pow($ratio, -1)) . 'px;
            --font-size-md: ' . floor($base_size * pow($ratio, -0.5)) . 'px;
            --font-size-lg: ' . $base_size . 'px;
            --font-size-xl: ' . floor($base_size * pow($ratio, 0.5)) . 'px;
            --font-size-h6: ' . floor($base_size * pow($ratio, 1)) . 'px;
            --font-size-h5: ' . floor($base_size * pow($ratio, 1.5)) . 'px;
            --font-size-h4: ' . floor($base_size * pow($ratio, 2)) . 'px;
            --font-size-h3: ' . floor($base_size * pow($ratio, 2.5)) . 'px;
            --font-size-h2: ' . floor($base_size * pow($ratio, 3)) . 'px;
            --font-size-h1: ' . floor($base_size * pow($ratio, 3.5)) . 'px;
            --font-size-display-small: ' . floor($base_size * pow($ratio, 4)) . 'px;
            --font-size-display-large: ' . floor($base_size * pow($ratio, 4.5)) . 'px;
            
            --line-height-display: 1.2;
            --line-height-heading: 1.3;
            --line-height-body: 1.5;
            --line-height-loose: 1.8;
            
            --font-weight-regular: 400;
            --font-weight-medium: 500;
            --font-weight-semibold: 600;
            --font-weight-bold: 700;
            
            --heading-font: ' . esc_attr($typography['heading_font']) . ';
            --body-font: ' . esc_attr($typography['body_font']) . ';
        }
        
        /* Font Family Classes with increased specificity */
        .elementor .font-heading, 
        .elementor .font-heading *, 
        .elementor-element.font-heading, 
        .elementor-element.font-heading *,
        .elementor-widget.font-heading,
        .elementor-widget.font-heading * { 
            font-family: var(--heading-font) !important; 
        }
        
        .elementor .font-body, 
        .elementor .font-body *, 
        .elementor-element.font-body, 
        .elementor-element.font-body *,
        .elementor-widget.font-body,
        .elementor-widget.font-body * { 
            font-family: var(--body-font) !important; 
        }
        
        /* Font Size Classes with increased specificity */
        .elementor .display-large, 
        .elementor .display-large *, 
        .elementor-element.display-large, 
        .elementor-element.display-large *,
        .elementor-widget.display-large,
        .elementor-widget.display-large * { 
            font-size: var(--font-size-display-large) !important; 
            line-height: var(--line-height-display) !important; 
        }
        
        .elementor .display-small, 
        .elementor .display-small *, 
        .elementor-element.display-small, 
        .elementor-element.display-small *,
        .elementor-widget.display-small,
        .elementor-widget.display-small * { 
            font-size: var(--font-size-display-small) !important; 
            line-height: var(--line-height-display) !important; 
        }
        
        .elementor .heading-h1, 
        .elementor .heading-h1 *, 
        .elementor-element.heading-h1, 
        .elementor-element.heading-h1 *,
        .elementor-widget.heading-h1,
        .elementor-widget.heading-h1 * { 
            font-size: var(--font-size-h1) !important; 
            line-height: var(--line-height-heading) !important; 
        }
        
        .elementor .heading-h2, 
        .elementor .heading-h2 *, 
        .elementor-element.heading-h2, 
        .elementor-element.heading-h2 *,
        .elementor-widget.heading-h2,
        .elementor-widget.heading-h2 * { 
            font-size: var(--font-size-h2) !important; 
            line-height: var(--line-height-heading) !important; 
        }
        
        .elementor .heading-h3, 
        .elementor .heading-h3 *, 
        .elementor-element.heading-h3, 
        .elementor-element.heading-h3 *,
        .elementor-widget.heading-h3,
        .elementor-widget.heading-h3 * { 
            font-size: var(--font-size-h3) !important; 
            line-height: var(--line-height-heading) !important; 
        }
        
        .elementor .heading-h4, 
        .elementor .heading-h4 *, 
        .elementor-element.heading-h4, 
        .elementor-element.heading-h4 *,
        .elementor-widget.heading-h4,
        .elementor-widget.heading-h4 * { 
            font-size: var(--font-size-h4) !important; 
            line-height: var(--line-height-heading) !important; 
        }
        
        .elementor .heading-h5, 
        .elementor .heading-h5 *, 
        .elementor-element.heading-h5, 
        .elementor-element.heading-h5 *,
        .elementor-widget.heading-h5,
        .elementor-widget.heading-h5 * { 
            font-size: var(--font-size-h5) !important; 
            line-height: var(--line-height-heading) !important; 
        }
        
        .elementor .heading-h6, 
        .elementor .heading-h6 *, 
        .elementor-element.heading-h6, 
        .elementor-element.heading-h6 *,
        .elementor-widget.heading-h6,
        .elementor-widget.heading-h6 * { 
            font-size: var(--font-size-h6) !important; 
            line-height: var(--line-height-heading) !important; 
        }
        
        .elementor .text-xl, 
        .elementor .text-xl *, 
        .elementor-element.text-xl, 
        .elementor-element.text-xl *,
        .elementor-widget.text-xl,
        .elementor-widget.text-xl * { 
            font-size: var(--font-size-xl) !important; 
            line-height: var(--line-height-body) !important; 
        }
        
        .elementor .text-lg, 
        .elementor .text-lg *, 
        .elementor-element.text-lg, 
        .elementor-element.text-lg *,
        .elementor-widget.text-lg,
        .elementor-widget.text-lg * { 
            font-size: var(--font-size-lg) !important; 
            line-height: var(--line-height-body) !important; 
        }
        
        .elementor .text-md, 
        .elementor .text-md *, 
        .elementor-element.text-md, 
        .elementor-element.text-md *,
        .elementor-widget.text-md,
        .elementor-widget.text-md * { 
            font-size: var(--font-size-md) !important; 
            line-height: var(--line-height-body) !important; 
        }
        
        .elementor .text-sm, 
        .elementor .text-sm *, 
        .elementor-element.text-sm, 
        .elementor-element.text-sm *,
        .elementor-widget.text-sm,
        .elementor-widget.text-sm * { 
            font-size: var(--font-size-sm) !important; 
            line-height: var(--line-height-body) !important; 
        }

        /* Font Weight Classes with increased specificity */
        .elementor .font-regular, 
        .elementor .font-regular *, 
        .elementor-element.font-regular, 
        .elementor-element.font-regular *,
        .elementor-widget.font-regular,
        .elementor-widget.font-regular * { 
            font-weight: var(--font-weight-regular) !important; 
        }
        
        .elementor .font-medium, 
        .elementor .font-medium *, 
        .elementor-element.font-medium, 
        .elementor-element.font-medium *,
        .elementor-widget.font-medium,
        .elementor-widget.font-medium * { 
            font-weight: var(--font-weight-medium) !important; 
        }
        
        .elementor .font-semibold, 
        .elementor .font-semibold *, 
        .elementor-element.font-semibold, 
        .elementor-element.font-semibold *,
        .elementor-widget.font-semibold,
        .elementor-widget.font-semibold * { 
            font-weight: var(--font-weight-semibold) !important; 
        }
        
        .elementor .font-bold, 
        .elementor .font-bold *, 
        .elementor-element.font-bold, 
        .elementor-element.font-bold *,
        .elementor-widget.font-bold,
        .elementor-widget.font-bold * { 
            font-weight: var(--font-weight-bold) !important; 
        }
        
        /* Text Alignment Classes with increased specificity */
        .elementor .text-left, 
        .elementor-element.text-left,
        .elementor-widget.text-left { 
            text-align: left !important; 
        }
        
        .elementor .text-center, 
        .elementor-element.text-center,
        .elementor-widget.text-center { 
            text-align: center !important; 
        }
        
        .elementor .text-right, 
        .elementor-element.text-right,
        .elementor-widget.text-right { 
            text-align: right !important; 
        }
        
        .elementor .text-justify, 
        .elementor-element.text-justify,
        .elementor-widget.text-justify { 
            text-align: justify !important; 
        }
        
        /* Line Height Classes with increased specificity */
        .elementor .lh-tight, 
        .elementor .lh-tight *, 
        .elementor-element.lh-tight, 
        .elementor-element.lh-tight *,
        .elementor-widget.lh-tight,
        .elementor-widget.lh-tight * { 
            line-height: var(--line-height-display) !important; 
        }
        
        .elementor .lh-normal, 
        .elementor .lh-normal *, 
        .elementor-element.lh-normal, 
        .elementor-element.lh-normal *,
        .elementor-widget.lh-normal,
        .elementor-widget.lh-normal * { 
            line-height: var(--line-height-body) !important; 
        }
        
        .elementor .lh-loose, 
        .elementor .lh-loose *, 
        .elementor-element.lh-loose, 
        .elementor-element.lh-loose *,
        .elementor-widget.lh-loose,
        .elementor-widget.lh-loose * { 
            line-height: var(--line-height-loose) !important; 
        }

        /* Letter Spacing Classes with increased specificity */
        .elementor .ls-tight, 
        .elementor .ls-tight *, 
        .elementor-element.ls-tight, 
        .elementor-element.ls-tight *,
        .elementor-widget.ls-tight,
        .elementor-widget.ls-tight * { 
            letter-spacing: -0.05em !important; 
        }
        
        .elementor .ls-normal, 
        .elementor .ls-normal *, 
        .elementor-element.ls-normal, 
        .elementor-element.ls-normal *,
        .elementor-widget.ls-normal,
        .elementor-widget.ls-normal * { 
            letter-spacing: normal !important; 
        }
        
        .elementor .ls-wide, 
        .elementor .ls-wide *, 
        .elementor-element.ls-wide, 
        .elementor-element.ls-wide *,
        .elementor-widget.ls-wide,
        .elementor-widget.ls-wide * { 
            letter-spacing: 0.05em !important; 
        }
        
        .elementor .ls-wider, 
        .elementor .ls-wider *, 
        .elementor-element.ls-wider, 
        .elementor-element.ls-wider *,
        .elementor-widget.ls-wider,
        .elementor-widget.ls-wider * { 
            letter-spacing: 0.1em !important; 
        }

        /* Responsive Typography - aumentado com !important para garantir que as regras sejam aplicadas */
        @media (max-width: 1024px) {
            :root {
                --font-size-display-large: ' . floor($base_size * pow($ratio, 4)) . 'px !important;
                --font-size-display-small: ' . floor($base_size * pow($ratio, 3.5)) . 'px !important;
                --font-size-h1: ' . floor($base_size * pow($ratio, 3)) . 'px !important;
                --font-size-h2: ' . floor($base_size * pow($ratio, 2.5)) . 'px !important;
                --font-size-h3: ' . floor($base_size * pow($ratio, 2)) . 'px !important;
                --font-size-h4: ' . floor($base_size * pow($ratio, 1.5)) . 'px !important;
                --font-size-h5: ' . floor($base_size * pow($ratio, 1)) . 'px !important;
            }
        }

        @media (max-width: 767px) {
            :root {
                --font-size-display-large: ' . floor($base_size * pow($ratio, 3.5)) . 'px !important;
                --font-size-display-small: ' . floor($base_size * pow($ratio, 3)) . 'px !important;
                --font-size-h1: ' . floor($base_size * pow($ratio, 2.5)) . 'px !important;
                --font-size-h2: ' . floor($base_size * pow($ratio, 2)) . 'px !important;
                --font-size-h3: ' . floor($base_size * pow($ratio, 1.5)) . 'px !important;
                --font-size-h4: ' . floor($base_size * pow($ratio, 1)) . 'px !important;
                --font-size-h5: ' . floor($base_size * pow($ratio, 0.5)) . 'px !important;
            }
        }';
        
        return $css;
    }
    
    /**
     * Get Google Fonts URLs based on selected fonts
     */
    public function get_google_fonts_urls() {
        $typography = $this->settings->get_typography();
        $urls = array();
        
        // Check heading font
        if ($typography['heading_font'] !== 'inherit' && strpos($typography['heading_font'], ',') !== false) {
            $font_name = explode(',', $typography['heading_font'])[0];
            if (!in_array($font_name, array('Arial', 'Helvetica', 'Georgia', 'Tahoma', 'Verdana', 'Times New Roman', 'Trebuchet MS', 'Courier New', 'Impact', 'Lucida Sans Unicode', 'Comic Sans MS', 'Arial Black', 'Palatino Linotype', 'system-ui'))) {
                $font_name = str_replace(' ', '+', $font_name);
                $urls['heading'] = 'https://fonts.googleapis.com/css?family=' . $font_name . ':400,500,600,700&display=swap';
            }
        }
        
        // Check body font
        if ($typography['body_font'] !== 'inherit' && $typography['body_font'] !== $typography['heading_font'] && strpos($typography['body_font'], ',') !== false) {
            $font_name = explode(',', $typography['body_font'])[0];
            if (!in_array($font_name, array('Arial', 'Helvetica', 'Georgia', 'Tahoma', 'Verdana', 'Times New Roman', 'Trebuchet MS', 'Courier New', 'Impact', 'Lucida Sans Unicode', 'Comic Sans MS', 'Arial Black', 'Palatino Linotype', 'system-ui'))) {
                $font_name = str_replace(' ', '+', $font_name);
                $urls['body'] = 'https://fonts.googleapis.com/css?family=' . $font_name . ':400,500,600,700&display=swap';
            }
        }
        
        return $urls;
    }
}