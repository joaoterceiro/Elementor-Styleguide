<?php
/**
 * Frontend functionality for Elementor Styleguide
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Elementor_Styleguide_Frontend {
    /**
     * @var Elementor_Styleguide_Settings Settings instance
     */
    private $settings;
    
    /**
     * @var Elementor_Styleguide_CSS_Generator CSS Generator instance
     */
    private $css_generator;
    
    /**
     * Constructor
     */
    public function __construct($settings) {
        $this->settings = $settings;
        $this->css_generator = new Elementor_Styleguide_CSS_Generator($settings);
        
        // Aumentar a prioridade para garantir que o CSS seja carregado por último
        add_action('wp_head', array($this, 'output_custom_colors'), 999);
        
        // Use prioridade mais alta para garantir que o CSS seja carregado após o Elementor
        add_action('wp_enqueue_scripts', array($this, 'add_font_styles'), 9999);
        
        // Adicione um hook para o footer para garantir que as classes funcionem
        add_action('wp_footer', array($this, 'add_footer_script'), 9999);
        
        // Adicione classes Elementor
        add_filter('elementor/element/parse_css_classes', array($this, 'add_custom_class_suggestions'), 10, 2);
    }
    
    /**
     * Output custom colors with optimized CSS
     */
    public function output_custom_colors() {
        $color_variables = $this->css_generator->generate_color_variables();
        $color_classes = $this->css_generator->generate_color_classes();
        
        printf('<style id="elementor-styleguide-colors" data-type="elementor-styleguide-custom-css">%s</style>', $color_variables . "\n" . $color_classes);
    }
    
    /**
     * Add font styles with CSS custom properties
     */
    public function add_font_styles() {
        $typography_css = $this->css_generator->generate_typography_css();
        
        // Enqueue estilos diretamente para evitar problemas de dependência
        wp_register_style('elementor-styleguide-typography', false);
        wp_enqueue_style('elementor-styleguide-typography');
        wp_add_inline_style('elementor-styleguide-typography', $typography_css);
        
        // Enqueue Google Fonts if needed
        $google_fonts = $this->css_generator->get_google_fonts_urls();
        
        foreach ($google_fonts as $key => $url) {
            wp_enqueue_style('google-font-' . sanitize_title($key), $url, array(), ELEMENTOR_STYLEGUIDE_VERSION);
        }
    }
    
    /**
     * Adiciona script no footer para garantir que as classes sejam aplicadas
     */
    public function add_footer_script() {
        ?>
        <script type="text/javascript">
        (function() {
            // Função para garantir que as classes sejam aplicadas após o carregamento do Elementor
            function applyStyleguideClasses() {
                // Verifica se o Elementor está pronto
                if (typeof elementorFrontend !== 'undefined') {
                    // Aplicar estilos após carregamento completo
                    elementorFrontend.hooks.addAction('frontend/element_ready/global', function() {
                        // Força a re-renderização de estilos
                        var styleElement = document.getElementById('elementor-styleguide-colors');
                        if (styleElement) {
                            document.head.appendChild(styleElement.cloneNode(true));
                        }
                    });
                } else {
                    // Tentar novamente se o Elementor não estiver carregado
                    setTimeout(applyStyleguideClasses, 100);
                }
            }
            
            // Iniciar a aplicação dos estilos
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', applyStyleguideClasses);
            } else {
                applyStyleguideClasses();
            }
        })();
        </script>
        <?php
    }
    
    /**
     * Add custom class suggestions to Elementor
     */
    public function add_custom_class_suggestions($classes, $element) {
        // Add our style classes to Elementor's CSS class suggestions
        $styleguide_classes = array(
            // Color classes
            'color-primary', 'color-primary-light', 'color-primary-dark',
            'color-secondary', 'color-secondary-light', 'color-secondary-dark',
            'color-accent', 'color-accent-light', 'color-accent-dark',
            'color-success', 'color-warning', 'color-danger', 'color-info',
            'bg-primary', 'bg-primary-light', 'bg-primary-dark',
            'bg-secondary', 'bg-secondary-light', 'bg-secondary-dark',
            'bg-accent', 'bg-accent-light', 'bg-accent-dark',
            'bg-success', 'bg-warning', 'bg-danger', 'bg-info',
            'border-primary', 'border-secondary', 'border-accent',
            'border-success', 'border-warning', 'border-danger', 'border-info',
            
            // Typography classes
            'display-large', 'display-small',
            'heading-h1', 'heading-h2', 'heading-h3', 'heading-h4', 'heading-h5', 'heading-h6',
            'text-xl', 'text-lg', 'text-md', 'text-sm',
            'font-regular', 'font-medium', 'font-semibold', 'font-bold',
            'lh-tight', 'lh-normal', 'lh-loose',
            'ls-tight', 'ls-normal', 'ls-wide', 'ls-wider',
            'text-left', 'text-center', 'text-right', 'text-justify'
        );
        
        // Add grayscale classes
        for ($i = 1; $i <= 9; $i++) {
            $number = $i * 100;
            $styleguide_classes[] = 'color-gray-' . $number;
            $styleguide_classes[] = 'bg-gray-' . $number;
            $styleguide_classes[] = 'border-gray-' . $number;
        }
        
        return array_merge($classes, $styleguide_classes);
    }
}