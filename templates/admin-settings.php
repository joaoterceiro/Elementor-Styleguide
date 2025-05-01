<?php
/**
 * Admin settings page template
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<div class="wrap elementor-styleguide-wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <div class="nav-tab-wrapper">
        <a href="#colors-tab" class="nav-tab nav-tab-active"><?php _e('Colors', 'elementor-styleguide'); ?></a>
        <a href="#typography-tab" class="nav-tab"><?php _e('Typography', 'elementor-styleguide'); ?></a>
        <a href="#usage-tab" class="nav-tab"><?php _e('Usage Guide', 'elementor-styleguide'); ?></a>
        <a href="#export-import-tab" class="nav-tab"><?php _e('Export/Import', 'elementor-styleguide'); ?></a>
    </div>
    
    <form method="post" action="options.php">
        <?php settings_fields('elementor_styleguide_options'); ?>
        <?php wp_nonce_field('elementor_styleguide_update_settings', 'elementor_styleguide_nonce'); ?>
        
        <div id="colors-tab" class="tab-content active-tab">
            <div class="tab-header">
                <h2><?php _e('Color Settings', 'elementor-styleguide'); ?></h2>
                <button type="button" id="reset-all-colors" class="button button-secondary">
                    <?php _e('Reset All Colors', 'elementor-styleguide'); ?>
                </button>
            </div>
            
            <?php do_settings_sections('elementor-styleguide'); ?>
            <?php $this->display_color_palette_preview(); ?>
        </div>
        
        <div id="typography-tab" class="tab-content" style="display: none;">
            <h2><?php _e('Typography Settings', 'elementor-styleguide'); ?></h2>
            <?php do_settings_sections('elementor-styleguide-typography'); ?>
            <?php $this->display_typography_preview(); ?>
        </div>
        
        <div id="usage-tab" class="tab-content" style="display: none;">
            <h2><?php _e('Usage Guide', 'elementor-styleguide'); ?></h2>
            <?php $this->display_usage_guide(); ?>
        </div>
        
        <div id="export-import-tab" class="tab-content" style="display: none;">
            <h2><?php _e('Export/Import Settings', 'elementor-styleguide'); ?></h2>
            <?php $this->display_export_import(); ?>
        </div>
        
        <?php submit_button(); ?>
    </form>
</div>