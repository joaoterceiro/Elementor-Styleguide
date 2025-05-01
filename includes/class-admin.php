<?php
/**
 * Admin functionality for Elementor Styleguide
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Elementor_Styleguide_Admin {
    /**
     * @var Elementor_Styleguide_Settings Settings instance
     */
    private $settings;
    
    /**
     * Constructor
     */
    public function __construct($settings) {
        $this->settings = $settings;
        
        // Não registramos o menu aqui para evitar problemas
        // O menu será registrado diretamente pela classe principal
        
        add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
        add_action('admin_notices', array($this, 'admin_notices'));
    }
    
    /**
     * Enqueue admin scripts and styles
     */
    public function admin_scripts($hook) {
        // Ajustado para capturar todas as possíveis páginas do plugin
        if (strpos($hook, 'elementor-styleguide') === false && strpos($hook, 'styleguide') === false) {
            return;
        }

        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        
        // Register custom admin CSS
        $admin_css = '
            .elementor-styleguide-wrap .color-field {
                display: flex;
                align-items: center;
                margin-bottom: 10px;
            }
            .elementor-styleguide-wrap .color-picker-hex {
                margin: 0 5px;
                width: 80px;
            }
            .elementor-styleguide-wrap .color-preview {
                display: inline-block;
                width: 24px;
                height: 24px;
                margin-left: 5px;
                vertical-align: middle;
                border: 1px solid #ddd;
                border-radius: 3px;
            }
            .elementor-styleguide-wrap .tab-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
            }
            .elementor-styleguide-wrap .section-description {
                color: #666;
                font-style: italic;
                margin-top: -5px;
                margin-bottom: 15px;
            }
            .elementor-styleguide-wrap .tab-content {
                margin-top: 20px;
                padding-top: 10px;
            }
            .elementor-styleguide-wrap .active-tab {
                display: block;
            }
            .elementor-styleguide-wrap code {
                background: #f5f5f5;
                padding: 2px 5px;
                border-radius: 3px;
                font-size: 13px;
            }
        ';
        
        wp_add_inline_style('wp-color-picker', $admin_css);
        
        // Enqueue plugin scripts
        wp_enqueue_script(
            'elementor-styleguide-admin',
            ELEMENTOR_STYLEGUIDE_URL . 'assets/js/admin.js',
            array('jquery', 'wp-color-picker'),
            ELEMENTOR_STYLEGUIDE_VERSION,
            true
        );
        
        wp_localize_script('elementor-styleguide-admin', 'elementorStyleguide', array(
            'resetConfirm' => __('Are you sure you want to reset all colors to default?', 'elementor-styleguide'),
            'resetAllButtonText' => __('Reset All Colors', 'elementor-styleguide'),
            'exportButtonText' => __('Export Settings', 'elementor-styleguide'),
            'importButtonText' => __('Import Settings', 'elementor-styleguide'),
            'defaultColors' => Elementor_Styleguide_Settings::DEFAULT_COLORS
        ));
    }

    /**
     * Add admin notices
     */
    public function admin_notices() {
        if (isset($_GET['settings-updated']) && $_GET['settings-updated']) {
            echo '<div class="notice notice-success is-dismissible"><p>' . 
                 esc_html__('Settings saved successfully.', 'elementor-styleguide') . 
                 '</p></div>';
        }
        
        // Check if Elementor is active
        if (!class_exists('\\Elementor\\Plugin')) {
            echo '<div class="notice notice-warning is-dismissible"><p>' . 
                 esc_html__('Elementor Styleguide works best with Elementor. Please install and activate Elementor.', 'elementor-styleguide') . 
                 '</p></div>';
        }
        
        // Check if necessary directories exist and are writable
        $upload_dir = wp_upload_dir();
        if (!is_writable($upload_dir['basedir'])) {
            echo '<div class="notice notice-error is-dismissible"><p>' . 
                 esc_html__('The uploads directory is not writable. This may cause issues with the Styleguide plugin.', 'elementor-styleguide') . 
                 '</p></div>';
        }
    }

    /**
     * Settings page with tabs
     */
    public function settings_page() {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.', 'elementor-styleguide'));
        }
        
        // Include the admin template
        include ELEMENTOR_STYLEGUIDE_PATH . 'templates/admin-settings.php';
    }
    
    /**
     * Display color palette preview
     */
    public function display_color_palette_preview() {
        $options = $this->settings->get_colors();
        ?>
        <div class="color-palette-preview" style="margin: 20px 0; padding: 20px; background: #fff; border: 1px solid #ccd0d4;">
            <h3><?php _e('Color Palette Preview', 'elementor-styleguide'); ?></h3>
            <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 15px;">
                <?php 
                // Group colors by type
                $color_groups = array(
                    'primary' => array('primary_color', 'primary_light', 'primary_dark'),
                    'secondary' => array('secondary_color', 'secondary_light', 'secondary_dark'),
                    'accent' => array('accent_color', 'accent_light', 'accent_dark'),
                    'status' => array('success_color', 'danger_color', 'warning_color', 'info_color'),
                    'grayscale' => array('gray_100', 'gray_300', 'gray_500', 'gray_700', 'gray_900')
                );
                
                foreach ($color_groups as $group => $colors) {
                    echo '<div class="color-group" style="margin-right: 30px;">';
                    echo '<h4 style="margin-top: 0; text-transform: capitalize;">' . esc_html($group) . '</h4>';
                    echo '<div style="display: flex; flex-direction: column; gap: 10px;">';
                    
                    foreach ($colors as $key) {
                        if (isset($options[$key])) {
                            echo '<div style="display: flex; align-items: center;">';
                            echo '<div style="width: 24px; height: 24px; background-color: ' . esc_attr($options[$key]) . '; margin-right: 8px; border-radius: 3px; border: 1px solid #ddd;"></div>';
                            echo '<div>';
                            echo '<div style="font-size: 12px; font-weight: 600;">' . esc_html(str_replace('_', ' ', $key)) . '</div>';
                            echo '<div style="font-size: 11px; color: #666;">' . esc_html($options[$key]) . '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        <?php
    }
    
    /**
     * Display typography preview
     */
    public function display_typography_preview() {
        $typography = $this->settings->get_typography();
        
        $base_size = intval($typography['base_font_size']);
        $ratio = floatval($typography['scale_ratio']);
        
        // Calculate sizes based on type scale
        $sizes = array();
        $sizes['text-sm'] = floor($base_size * pow($ratio, -1)) . 'px';
        $sizes['text-md'] = floor($base_size * pow($ratio, -0.5)) . 'px';
        $sizes['text-lg'] = $base_size . 'px';
        $sizes['text-xl'] = floor($base_size * pow($ratio, 0.5)) . 'px';
        $sizes['h6'] = floor($base_size * pow($ratio, 1)) . 'px';
        $sizes['h5'] = floor($base_size * pow($ratio, 1.5)) . 'px';
        $sizes['h4'] = floor($base_size * pow($ratio, 2)) . 'px';
        $sizes['h3'] = floor($base_size * pow($ratio, 2.5)) . 'px';
        $sizes['h2'] = floor($base_size * pow($ratio, 3)) . 'px';
        $sizes['h1'] = floor($base_size * pow($ratio, 3.5)) . 'px';
        
        ?>
        <div class="typography-preview" style="margin: 20px 0; padding: 20px; background: #fff; border: 1px solid #ccd0d4;">
            <h3><?php _e('Typography Preview', 'elementor-styleguide'); ?></h3>
            
            <div style="margin-top: 20px;">
                <div style="margin-bottom: 30px;">
                    <h4 style="margin-top: 0;"><?php _e('Type Scale', 'elementor-styleguide'); ?></h4>
                    <p><?php _e('Base size', 'elementor-styleguide'); ?>: <?php echo esc_html($typography['base_font_size']); ?> | 
                       <?php _e('Scale ratio', 'elementor-styleguide'); ?>: <?php echo esc_html($typography['scale_ratio']); ?></p>
                    
                    <div style="display: flex; flex-direction: column; gap: 5px;">
                        <div style="font-family: <?php echo esc_attr($typography['heading_font']); ?>; font-size: <?php echo esc_attr($sizes['h1']); ?>; line-height: 1.2;">
                            Heading 1 (<?php echo esc_html($sizes['h1']); ?>)
                        </div>
                        <div style="font-family: <?php echo esc_attr($typography['heading_font']); ?>; font-size: <?php echo esc_attr($sizes['h2']); ?>; line-height: 1.2;">
                            Heading 2 (<?php echo esc_html($sizes['h2']); ?>)
                        </div>
                        <div style="font-family: <?php echo esc_attr($typography['heading_font']); ?>; font-size: <?php echo esc_attr($sizes['h3']); ?>; line-height: 1.2;">
                            Heading 3 (<?php echo esc_html($sizes['h3']); ?>)
                        </div>
                        <div style="font-family: <?php echo esc_attr($typography['heading_font']); ?>; font-size: <?php echo esc_attr($sizes['h4']); ?>; line-height: 1.2;">
                            Heading 4 (<?php echo esc_html($sizes['h4']); ?>)
                        </div>
                        <div style="font-family: <?php echo esc_attr($typography['heading_font']); ?>; font-size: <?php echo esc_attr($sizes['h5']); ?>; line-height: 1.2;">
                            Heading 5 (<?php echo esc_html($sizes['h5']); ?>)
                        </div>
                        <div style="font-family: <?php echo esc_attr($typography['heading_font']); ?>; font-size: <?php echo esc_attr($sizes['h6']); ?>; line-height: 1.2;">
                            Heading 6 (<?php echo esc_html($sizes['h6']); ?>)
                        </div>
                    </div>
                </div>
                
                <div>
                    <h4 style="margin-top: 0;"><?php _e('Text Sizes', 'elementor-styleguide'); ?></h4>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <div style="font-family: <?php echo esc_attr($typography['body_font']); ?>; font-size: <?php echo esc_attr($sizes['text-xl']); ?>; line-height: 1.5;">
                            <strong>Text XL</strong> (<?php echo esc_html($sizes['text-xl']); ?>) - Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio.
                        </div>
                        <div style="font-family: <?php echo esc_attr($typography['body_font']); ?>; font-size: <?php echo esc_attr($sizes['text-lg']); ?>; line-height: 1.5;">
                            <strong>Text LG</strong> (<?php echo esc_html($sizes['text-lg']); ?>) - Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio.
                        </div>
                        <div style="font-family: <?php echo esc_attr($typography['body_font']); ?>; font-size: <?php echo esc_attr($sizes['text-md']); ?>; line-height: 1.5;">
                            <strong>Text MD</strong> (<?php echo esc_html($sizes['text-md']); ?>) - Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio.
                        </div>
                        <div style="font-family: <?php echo esc_attr($typography['body_font']); ?>; font-size: <?php echo esc_attr($sizes['text-sm']); ?>; line-height: 1.5;">
                            <strong>Text SM</strong> (<?php echo esc_html($sizes['text-sm']); ?>) - Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Add export/import functionality
     */
    public function display_export_import() {
        ?>
        <div class="export-import-section" style="margin-top: 20px; padding: 20px; background: #fff; border: 1px solid #ccd0d4;">
            <h3><?php _e('Export Settings', 'elementor-styleguide'); ?></h3>
            <p><?php _e('Export your current color and typography settings to use on another website.', 'elementor-styleguide'); ?></p>
            
            <div style="margin-bottom: 20px;">
                <button type="button" id="export-settings" class="button button-primary">
                    <?php _e('Export Settings', 'elementor-styleguide'); ?>
                </button>
                
                <div id="export-result" style="display: none; margin-top: 15px;">
                    <textarea id="export-data" rows="5" style="width: 100%;" readonly></textarea>
                    <p class="description"><?php _e('Copy this text to save your settings. You can import it later on another site.', 'elementor-styleguide'); ?></p>
                </div>
            </div>
            
            <hr>
            
            <h3><?php _e('Import Settings', 'elementor-styleguide'); ?></h3>
            <p><?php _e('Import settings from another Elementor Styleguide installation.', 'elementor-styleguide'); ?></p>
            
            <div>
                <div style="margin-bottom: 10px;">
                    <textarea id="import-data" rows="5" style="width: 100%;" placeholder="<?php esc_attr_e('Paste exported settings here', 'elementor-styleguide'); ?>"></textarea>
                </div>
                
                <button type="button" id="process-import" class="button button-primary">
                    <?php _e('Import Settings', 'elementor-styleguide'); ?>
                </button>
            </div>
        </div>
        <?php
    }
    
    /**
     * Display usage guide in user's language
     */
    public function display_usage_guide() {
        $current_language = get_locale();
        
        if (strpos($current_language, 'pt') === 0) {
            $this->display_portuguese_guide();
        } else {
            $this->display_english_guide();
        }
    }

    /**
     * Display guide in English
     */
    private function display_english_guide() {
        include ELEMENTOR_STYLEGUIDE_PATH . 'templates/usage-guide-en.php';
    }

    /**
     * Display guide in Portuguese
     */
    private function display_portuguese_guide() {
        include ELEMENTOR_STYLEGUIDE_PATH . 'templates/usage-guide-pt.php';
    }
}